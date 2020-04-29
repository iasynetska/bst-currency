const arrErrorMessages = new Map();

/**
 * Create and configure Datepickers in html
 * @param selectedFromDate preserve previously selected date
 * @param selectedToDate preserve previously selected date
 */
function addAndSetDatepickers(selectedFromDate, selectedToDate) {
    $('#datepickerFrom').datepicker()
        .datepicker("option", "dateFormat", "yy-mm-dd")
        .datepicker("setDate", selectedFromDate)
        .datepicker("option", "showAnim", "blind")
        .attr("autocomplete", "off")
        .attr("placeholder", "From")
        .click(function (e) {
            cleanErrorBorder(e.target);
        });
    $('#datepickerTo').datepicker()
        .datepicker("option", "dateFormat", "yy-mm-dd")
        .datepicker("setDate", selectedToDate)
        .datepicker("option", "showAnim", "blind")
        .attr("autocomplete", "off")
        .attr("placeholder", "To")
        .click(function (e) {
            cleanErrorBorder(e.target);
        });
}

/**
 * On-click function to send request to a server to load most recent currency data to database
 */
function loadDatabase() {
    const btn = $("#load-btn");

    btn.text("Database is being loaded. Please wait...");
    btn.removeClass("btn-danger");
    btn.removeClass("btn-secondary").addClass("btn-info");
    btn.prop("disabled", true);

    sentRequestToLoadDatabase(
        response => {
            btn.text(response.message);
            btn.removeClass("btn-info").addClass("btn-success");
            $(".info").text(response.actualInformation);
        },
        message => {
            isJson(message) ? btn.text(message) : btn.text("Fatal Error");
            btn.removeClass("btn-info").addClass("btn-danger");
            btn.removeAttr("disabled");
        });
}


function sentRequestToLoadDatabase(success, error) {
    $.ajax({
        url: "/api/loaddata",
        method: "post",
        dataType: "json",
        beforeSend: function () {
            $("#spinner").removeClass("d-none");
        }
    })
        .done(response => success(response))
        .fail(response => error(response.responseJSON === undefined ? response.responseText : response.responseJSON.message)
        )
        .always(function(){
            $("#spinner").addClass("d-none");
        });
}


function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


/**
 * Validate fields 'From', 'To' and 'Currency' selected in html
 * @returns {boolean} In case of 'false' the request wil be aborted
 */
function validateCurrencyRequestFields() {
    $(".error-message").remove();

    const currencySelected = $(".item-dropdown");
    const from = $("#datepickerFrom");
    const to = $("#datepickerTo");

    const currencyValid = validateCurrencySelected(currencySelected);
    const fromValid = validateFieldFrom(from);
    const toValid = validateFieldTo(to);

    let toLargerEqualFrom = true;
    if (fromValid && toValid) {
        toLargerEqualFrom = isToLargerEqualFrom(from, to);
    }

    return currencyValid && fromValid && toValid && toLargerEqualFrom;
}


function validateCurrencySelected(currencySelected) {
    const currencyCode = currencySelected.find('option').filter(":selected").val();
    if (isStringEmpty(currencyCode)) {
        currencySelected.addClass("error-field");
        addErrorMessage("currencySelectedErrorNotSelected");
        return false;
    } else if (!isCurrencyValid(currencyCode)) {
        currencySelected.addClass("error-field");
        addErrorMessage("currencyCodeErrorInvalid");
        return false;
    }
    return true;
}


function validateFieldFrom(from) {
    if (isStringEmpty(from.val())) {
        from.addClass("error-field");
        addErrorMessage("fromErrorNotSelected");
        return false;
    } else if (!isDateValid(from.val())) {
        from.addClass("error-field");
        addErrorMessage("fromErrorInvalidFormat");
        return false;
    }
    return true;
}


function validateFieldTo(to) {
    if (isStringEmpty(to.val())) {
        to.addClass("error-field");
        addErrorMessage("toErrorNotSelected");
        return false;
    } else if (!isDateValid(to.val())) {
        to.addClass("error-field");
        addErrorMessage("toErrorInvalidFormat");
        return false;
    }
    return true;
}

/**
 * Validates whether date field 'To' is larger than field 'From'
 * @param from
 * @param to
 * @returns {boolean}
 */
function isToLargerEqualFrom(from, to) {
    if (to.datepicker("getDate") < from.datepicker("getDate")) {
        from.addClass("error-field");
        addErrorMessage("periodErrorFromLargerTo");
        return false;
    }
    return true;
}


function isStringEmpty(context) {
    return context === null || context === "";
}


function isCurrencyValid(currencyCode) {
    const codeFormat = /^[A-Z]{3}$/;
    return codeFormat.test(currencyCode);
}


/**
 * Validates given date using regex pattern 'yyyy-mm-dd'
 * @param date
 * @returns {boolean}
 */
function isDateValid(date) {
    const dateFormat = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
    return dateFormat.test(date);
}


function cleanErrorBorder(element) {
    $(element).removeClass("error-field");
}


function addErrorMessage(messageName) {
    try {
        if (arrErrorMessages.has(messageName)) {
            createDivElementAndPutMessage(arrErrorMessages.get(messageName));
        } else {
            getErrorMessageFromServer(messageName,
                message => {
                    arrErrorMessages.set(messageName, message[messageName]);
                    createDivElementAndPutMessage(message[messageName]);
                },
                message => {
                    throw message.responseJSON.error;
                }
            );
        }
    } catch (exception) {
        console.error(exception);
        alert(exception);
    }
}


function getErrorMessageFromServer(messageName, success, error) {
    $.ajax({
        url: "/api/messages",
        method: "get",
        data: {"messageName": messageName},
        dataType: "json"
    })
        .done(response => success(response))
        .fail(response => error(response));
}


function createDivElementAndPutMessage(context) {
    const div = $("<div />", {
        class: "error-message",
        text: context
    });
    $("form").after(div);
}
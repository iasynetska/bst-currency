function loadDataBase()
{
    const btn = $("#load-btn");

    btn.text("Database is being loaded. Please wait...");
    btn.removeClass("btn-danger");
    btn.removeClass("btn-secondary").addClass("btn-info");
    btn.prop("disabled", true);

    sentRequestToServer(
        message => {
        btn.text(message);
        btn.removeClass("btn-info").addClass("btn-success");
    },
            message => {
        btn.text(message);
        btn.removeClass("btn-info").addClass("btn-danger");
        btn.removeAttr( "disabled" );
    });
}

function sentRequestToServer(success, error)
{
    $.ajax({
        url: "/api/loaddata",
        method: "post",
        dataType: "json"
    })
    .done(response => success(response.message))
    .fail(response => error(JSON.parse(response.responseText).message)
    );
}
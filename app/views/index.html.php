<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$title?></title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
</head>

<body>
    <div class="container d-flex flex-column">
        <button type="button" id="load-btn" class="btn btn-secondary btn-lg btn-block" onclick="loadDatabase()"><?=$loadButton?></button>

        <div class="info"><?=$actualInformation?>
            <div id="spinner" class="spinner-border  spinner-border-sm d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <form class="date-block d-flex flex-wrap justify-content-center" action="" method="post" onsubmit="return validateCurrencyRequestFields()">

            <div class="date-block__item">
                <select name="currency" class="item-dropdown" oninput="cleanErrorBorder(this)">
                    <option value = "ALL"><?=$allCurrencies?></option>
                    <?php foreach($currencyCodes as $currencyCode):
                        $select = ($currencySelectedCode === $currencyCode['currencyCode']) ? 'selected' :'';?>
                        <option value = "<?=$currencyCode['currencyCode']?>" <?=$select?>><?=$currencyCode['currencyCode']?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="d-flex flex-wrap justify-content-center">
                <div class="date-block__item"><input name="from" type="text" id="datepickerFrom" class="field"></div>
                <div class="date-block__item"><input name="to" type="text" id="datepickerTo" class="field"></div>
            </div>


            <div class="date-block__item"><button type="submit" id="showReportBtn" class="btn-sm btn btn-secondary"><?=$showReportButton?></button></div>
        </form>

        <table class="table table-striped">
            <thead class="container-fluid">
                <tr class="row">
                <?php foreach($columnNames as $columnName):?>
                    <th class="col-sm-3"><?=$columnName?></th>
                <?php endforeach;?>
                </tr>
            </thead>
            <tbody>
            <?php foreach($currencies as $currency):?>
                <tr class="row">
                    <td class="col-sm-3"><?=$currency['name']?></td>
                    <td class="col-sm-3"><?=$currency['code']?></td>
                    <td class="col-sm-3"><?=$currency['middleRate']?></td>
                    <td class="col-sm-3"><?=$currency['date']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="/js/common.js"></script>

    <script>
        $(addAndSetDatepickers("<?=$selectedFromDate;?>", "<?=$selectedToDate;?>"));
    </script>
</body>
</html>
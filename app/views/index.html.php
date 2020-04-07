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
    <div class="wrapper d-flex flex-column">
        <button type="button" class="btn btn-secondary btn-lg btn-block"><?=$loadButton?></button>

        <div class="date-block d-flex flex-wrap justify-content-center">

            <div class="date-block__item">
                <select class="item-dropdown">
                    <option value = "0">Select valute</option>
                    <?php foreach($valutes as $valute):?>
                        <option value = "<?=$valute['id']?>"><?=$valute['charCode'].' - '.$valute['id']?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="date-block__item">From: <input type="text" id="datepickerFrom" class="field"></div>
            <div class="date-block__item">To: <input type="text" id="datepickerTo" class="field"></div>
            <div class="date-block__item"><button type="button" id="showReportBtn" class="btn-sm btn btn-secondary"><?=$showReportButton?></button></div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                <?php foreach($columnNames as $columnName):?>
                    <th scope="col"><?=$columnName?></th>
                <?php endforeach;?>
                </tr>
            </thead>
            <tbody>
            <?php foreach($currencies as $currency):?>
                <tr>
                    <td class="#"><?=$currency['valuteID']?></td>
                    <td class="#"><?=$currency['numCode']?></td>
                    <td class="#"><?=$currency['сharCode']?></td>
                    <td class="#"><?=$currency['name']?></td>
                    <td class="#"><?=$currency['value']?></td>
                    <td class="#"><?=$currency['date']?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            $( "#datepickerFrom" ).datepicker();
            $( "#datepickerTo" ).datepicker();
        });
    </script>
</body>
</html>
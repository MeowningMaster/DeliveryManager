<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Панель управления менеджера курьеров</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <style>
        .modalwin { 
            width: 300px;
                background: white;
                top: 20%; /* отступ сверху */
                right: 0;
                left: 0;
                font-size: 14px; 
                margin: 0 auto;
                z-index:2; /* поверх всех */
                display: none;  /* сначала невидим */
                position: fixed; /* фиксированное позиционирование, окно стабильно при прокрутке */
                padding: 15px;
                border: 1px solid #000;
                border-radius: 6px;
            }
            #shadow { 
                position: fixed;
                width:100%;
                height:100%;
                z-index:1; /* поверх всех  кроме окна*/
                background:#000;
                opacity: 0.5; /*прозрачность*/
                left:0;
                top:0;
            }
    </style>

    <style>
        .displaynone {
            display: none;
        }
    </style>

    <script src="save_changes.js">

    <script>
        function checkSQLView() {
            var sqlstring, container, inputs, index;
            sqlstring = "INSERT INTO `deliveries` (`orderNumber`, `deliveryAddress`, `deliveryTimeLimit`, `clientName`, `clientPhoneNumber`, `clientComment`, `itemName`, `itemPrice`) VALUES ";
            container = document.getElementById('addDeliveryForm');
            inputs = container.getElementsByTagName('input');
            for (index = 0; index < inputs.length-8; index++) {
                if (index == 0) {
                    sqlstring += "(";
                }
                if (index != 0 && index % 8 == 0) {
                    sqlstring = sqlstring.slice(0, -2);
                    sqlstring += "), (";
                }
                sqlstring += "'";
                sqlstring += inputs[index].value;
                sqlstring += "'";
                sqlstring += ", ";
            }
            sqlstring = sqlstring.slice(0, -8);
            sqlstring += ");";
            alert(sqlstring);
        }
        $(document).ready(function() {
            var inputs2, container2, index2;
            $('#addDeliveryForm')
                .on('click', '.addButton', function() {
                    var $template = $('#addDeliveryTemplate'),
                    $clone        = $template
                                    .clone()
                                    .removeAttr('id')
                                    .removeClass('displaynone')
                                    .insertBefore($template);
                    container2 = document.getElementById('addDeliveryForm');
                    inputs2 = container2.getElementsByTagName('input');
                    for (index2 = 0; index2 < inputs2.length-16; index2++) {
                        if (index2 % 8 == 0) {
                            inputs2[index2].required = true;
                        }
                    }
                }
            )
            .on('click', '.removeButton', function() {
                var $row  = $(this).parents('.form-row');
                $row.remove();
            });
        });
    </script>
    <script type="text/javascript">
        function goToMainPage() {
            setTimeout(function () {
                window.location.href= 'index.php'; // the redirect goes here
            },1600);
        }
    </script>
</head>

<body>
    <!-- Upload From Excel Modal -->
    <div id="uploadExcel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uploadExcel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Импортировать доставки из excel-файла</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <b>Внимание!</b> <br />Ознакомьтесь с <a target="_blank" href="https://github.com/ivan8m8/CourierHelperWEB/wiki/%D0%9A%D0%B0%D0%BA-%D0%B8%D0%BC%D0%BF%D0%BE%D1%80%D1%82%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D1%82%D1%8C-%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BA%D0%B8-%D0%B2-%D1%81%D0%B8%D1%81%D1%82%D0%B5%D0%BC%D1%83#%D0%A2%D1%80%D0%B5%D0%B1%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5-%D0%BA-%D0%B8%D0%BC%D0%BF%D0%BE%D1%80%D1%82%D0%B8%D1%80%D1%83%D0%B5%D0%BC%D0%BE%D0%BC%D1%83-ex%D1%81el-%D1%84%D0%B0%D0%B9%D0%BB%D1%83-%D1%81-%D0%B4%D0%BE%D1%81%D1%82%D0%B0%D0%B2%D0%BA%D0%B0%D0%BC%D0%B8">требованиями к excel-файлу</a>. <br /><br />
            <form action="uploadExcel.php" method="post" enctype="multipart/form-data">
                <input type="file" name="excelFileToUpload" id="excelFileToUpload"/> <br /><br />
                <input style="background-color: #0069d9; color: #fff;" class="form-control input-sm pull-right" type="submit" name="submit" value="Загрузить" />
            </form>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div> -->
        </div>
      </div>
    </div>

    <!-- Remove all the deliveries -->
    <div id="removeAllTheDeliveries" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="removeAllTheDeliveries" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Удалить все доставки из системы</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <b>Вы уверены?</b> <br /><br />
            <form action="" method="post" enctype="multipart/form-data">
                <input style="background-color: #0069d9; color: #fff;" class="form-control input-sm pull-right" type="submit" name="removeAllTheDeliveries" value="Удалить" />
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Deliveries Modal -->
    <div id="addDeliveries" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="addDeliveries" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 1200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить доставки</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addDeliveriesFromForm.php" method="post" id="addDeliveryForm">
                        <a onclick="checkSQLView();">Посмотреть SQL</a><br />
                        <div class="form-row">
                            <div class="col">
                                <input id="order-n" type="text" class="form-control" placeholder="Номер заказа (обязательно)" name="order-number[]" required="true" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)'>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" placeholder="Адрес доставки (обязательно)" name="delivery-address[]" required="true">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Ограничения по времени" name="delivery-time-limit[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Имя" name="client-name[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Номер телефона" name="client-phone-number[]" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)'>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Комментарий" name="client-comment[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Идентификатор товара" name="item-name[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Цена товара" name="item-price[]" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)'>
                            </div>
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-secondary addButton"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="form-row displaynone" id="addDeliveryTemplate">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Номер заказа (обязательно)" name="order-number[]" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)'>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" placeholder="Адрес доставки (обязательно)" name="delivery-address[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Ограничения по времени" name="delivery-time-limit[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Имя" name="client-name[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Номер телефона" name="client-phone-number[]" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)'>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Комментарий" name="client-comment[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Идентификатор товара" name="item-name[]">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Цена товара" name="item-price[]" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)'>
                            </div>
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                        <br />
                        <div class="form-row">
                            <input style="width: 100%;" type="submit" name="sdtm" class="btn btn-primary" value="Добавить все эти доставки в базу данных" />
                        </div>
                    </form>
                </div>
            </div>
      </div>
    </div>

    <center><div class="container">
        <h2>
            <div class="d-flex">
                <div class="mr-auto p-2"><a href="/">Заказы</a></div>
                <div class="p-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Добавить</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" data-toggle="modal" href="#" data-target="#addDeliveries">Добавить вручную</a>
                            <a class="dropdown-item" data-toggle="modal" href="#" data-target="#uploadExcel">Импортировать excel</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" data-toggle="modal" href="#" data-target="#removeAllTheDeliveries">Удалить все доставки</a>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <button class="btn btn-success" onclick="save_changes()">Сохранить</button>
                </div>
            </div>
        </h2>
        <table class="table table-sm table-bordered table-hover">
        <style>td,th {text-align: center;}</style>
        <thead>
            <tr>
                <th>№ заказа</th>
                <th>Адрес доставки</th>
                <th>Ограничения</th>
                <th>Курьер</th>
            </tr>
        </thead>
        <tbody>

<?php

require_once 'config/config.php';

ini_set('error_reporting', E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

mb_internal_encoding("UTF-8");

$link = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_dbname);
if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
mysqli_set_charset($link, "utf8");

if (isset($_POST["removeAllTheDeliveries"])) {
    if (mysqli_query($link, "DELETE FROM `deliveries` WHERE 1=1")) {
        echo "SQL-запроc отпрвлен.<br /><b>Проверьте, чтобы ниже не было ошибок.</b> <br /><br />";
        echo '<script type="text/javascript">',
                'goToMainPage();',
                '</script>'
        ;
    } else {
        echo "<b>Ошибка:</b><br>" . mysqli_error($link);
    }
}

$query  = "SELECT * FROM $mysql_tablename WHERE deliveryStatus = 0 ORDER BY CASE WHEN deliveryTimeLimit = '' OR deliveryTimeLimit IS NULL THEN 2 ELSE 1 END, deliveryTimeLimit";
$couriers_query = "SELECT * FROM $mysql_courierstablename" or die('Не удалось загрузить список курьеров' . mysqli_error($link));
$result = mysqli_query($link, $query);
$couriers_result = mysqli_query($link, $couriers_query);

$couriers = [];
while ($couriers_row = mysqli_fetch_array($couriers_result)) {
    array_push($couriers, $couriers_row['name']);
}

if (!$result) {
    echo "Не удалось выполнить запрос";
}

while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo '<td>' . $row['orderNumber'] . '</td>';
    echo '<td>' . $row['deliveryAddress'] . '</td>';
    echo '<td>' . $row['deliveryTimeLimit'] . '</td>';
    echo '<td><select class="courier" name="'.$row['orderNumber'].'">';
    foreach ($couriers as &$courier) {
        if ($row['deliveryCourier'] == $courier) {
            echo '<option value="'.$courier.'" selected>'.$courier.'</option>';
        } else {
            echo '<option value="'.$courier.'">'.$courier.'</option>';
        }
    }
    echo '</select></td>';
    echo "</tr>";
}

echo "</tbody></table>\n";

mysqli_free_result($result);
mysqli_free_result($couriers_result);
mysqli_close($link);
?>

<div id="popupWin" class="modalwin">
    <h3>Загружаем данные...</h3>  
    <div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>
</div>

<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (isset($_POST["send_to_couriers"])) {
    $link = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_dbname);
    if (!$link) {
        echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
        echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    mysqli_set_charset($link, "utf8");
    foreach ($_REQUEST["choose_courier"] as $key => $value) {
        mysqli_query($link, "UPDATE $mysql_tablename SET deliveryCourier = '" . mysqli_real_escape_string($link, $value) . "' WHERE orderNumber = '" . mysqli_real_escape_string($link, $key) . "';") or die('Не удалось записать курьеров: ' . mysqli_error($link));
    }
    mysqli_close($link);
    
}
?>
      <footer class="footer"></footer>
    </div></center>
    </body>
</html>

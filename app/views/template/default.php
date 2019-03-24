<?php
    $host = 'http://'.$_SERVER['HTTP_HOST'].'/';

    $separate_method_GET = explode('?', $_SERVER['REQUEST_URI']);
    $routes = explode('/', $separate_method_GET[0]);
    if ( !empty($routes[1]) ){
        $controller_name = $routes[1];
    }
    else {
        $controller_name = "main";
    }
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="index, follow" />
		<link rel="shortcut icon" href="<?= $host; ?>images/favicon.png" type="image/png" />
		<link rel="stylesheet" href="<?= $host; ?>css/template.css" type="text/css" />
		<link rel="stylesheet" href="<?= $host; ?>css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="<?= $host; ?>css/<?= $controller_name; ?>.css" type="text/css" />
		<link rel="stylesheet" href="<?= $host; ?>css/chosen.min.css" type="text/css" />
    </head>
    <body>
        <div id="test">

        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" style="margin-bottom: 20px;">
            <div class="container">
                <a class="navbar-brand" >Test Task</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#addUserModal" style="color: #fff; cursor: pointer;">Добавить</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Регистрация нового пользователя</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="addUserModalInfo" style="margin-bottom:20px; display:none;"></div>
                        <form>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control form-control-sm" value="" id="inputNameModal" placeholder="Введите ФИО">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="email" class="form-control form-control-sm" value="" id="inputEmailModal" placeholder="Введите email">
                                </div>
                            </div>
                            <div class="email-exist alert alert-warning" style="display:none;" role="alert">
                                <h5 class="alert-heading">Email существует</h5>
                                <hr />
                                <div id="emailExistName">ФИО: <span></span></div>
                                <div id="emailExistEmail">Email: <span></span></div>
                                <div id="emailExistTerritory">Адрес: <span></span></div>
                            </div>
                            <div class="form-group row selectTerLevel_1 modal-select-hidden">
                                <div class="col-sm-12">
                                    Адрес:
                                </div>
                                <div class="col-sm-12">
                                    <select data-placeholder="..." class="chosen-select" id="selectTerLevel_1">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row selectTerLevel_2 modal-select-hidden">
                                <div class="col-sm-12">
                                    <select data-placeholder="..." class="chosen-select" id="selectTerLevel_2">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row selectTerLevel_3 modal-select-hidden">
                                <div class="col-sm-12">
                                    <select data-placeholder="..." class="chosen-select" id="selectTerLevel_3">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row selectTerLevel_4 modal-select-hidden">
                                <div class="col-sm-12">
                                    <select data-placeholder="..." class="chosen-select" id="selectTerLevel_4">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary" id="submitButtonModal">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-bottom: 30px;">
                    <?php include '../app/views/'.$content_view; ?>
                </div>
            </div>
        </div>

        <script src="<?= $host; ?>js/jquery.min.js" type="text/JavaScript"></script>
        <script src="<?= $host; ?>js/bootstrap.min.js" type="text/JavaScript"></script>
        <script src="<?= $host; ?>js/chosen.jquery.min.js" type="text/JavaScript"></script>
        <script src="<?= $host; ?>js/template.js" type="text/JavaScript"></script>
        <script src="<?= $host; ?>js/<?= $controller_name; ?>.js" type="text/JavaScript"></script>
    </body>
</html>
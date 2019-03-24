<?php
    require_once 'config/config.php';

    require_once 'app/core/model.php';
    require_once 'app/core/view.php';
    require_once 'app/core/controller.php';
    require_once 'app/core/route.php';

    require_once 'app/classes/autoloader.php';
    new autoloader;

    $checkdb = array(
        array(
            'table' => 't_koatuu_tree',
            'is_empty' => true
        ),
        array(
            'table' => 'tt_users',
            'is_empty' => false
        )
    );
    new dbcheck($checkdb);

    Route::start();

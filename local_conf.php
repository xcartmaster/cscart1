<?php

    // Включить DEBUG панель включенной всегда
     define('DEBUG_MODE', true);

    // Режим разработчика, для отображения ошибок
    define('DEVELOPMENT', true);

    // Отображение ошибок SMARTY и PHP на экран.
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    ini_set('display_startup_errors', true);

    // Выключаем PHP кэш блоков
    $config['tweaks'] = array (
        'disable_block_cache' => true, 
    );

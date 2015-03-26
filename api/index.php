<?php

require_once 'vendor/autoload.php';

define('APP_DIR', __DIR__);

session_start();

\JanStrassburg\TvIndex\App::run();

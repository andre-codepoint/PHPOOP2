<?php

include_once(__DIR__ . "/Loader/ClassLoader.php");

\Loader\ClassLoader::getInstance()->init();

\Loader\Route::getInstance()->init();
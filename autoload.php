<?php

/**
 * @author Tanseer
 * @copyright 2017
 */
function autoloadClasses($className) {
    $filename = dirname(__FILE__)."/src/" . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}
spl_autoload_register("autoloadClasses");
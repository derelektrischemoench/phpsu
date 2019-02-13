<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', (string)1);

define('PHPSU_VENDOR_PATH', __DIR__ . '/../vendor');
define('PHPSU_VENDOR_INSTALLATION', false);

// Currently phpunit's default error handling doesn't properly catch warnings / errors from data providers
// https://github.com/sebastianbergmann/phpunit/issues/2449
set_error_handler(
    function ($severity, $message, $file, $line) {
        if (!(error_reporting() & $severity)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }
        throw new ErrorException(__FILE__ . __FUNCTION__ . ': ' . $message, 0, $severity, $file, $line);
    }
);

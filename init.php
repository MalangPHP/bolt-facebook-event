<?php

namespace Bolt\Extension\MalangPHP\FacebookEvent;

define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/lib/facebook-php-sdk-v4-4.0.23/src/Facebook/');
require __DIR__ . '/lib/facebook-php-sdk-v4-4.0.23/autoload.php';

$app['extensions']->register(new Extension($app));

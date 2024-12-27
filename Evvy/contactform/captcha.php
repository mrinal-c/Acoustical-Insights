<?php
require_once('vendor/autoload.php');

echo "Hello World!";

use SimpleCaptcha\Builder;

# First, you have to instantiate it ..
$builder = new Builder;

# Now, building a captcha is easy
$builder->build();

?>
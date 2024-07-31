<?php
require_once('vendor/autoload.php');
$job = new \App\Jobs\ColorDetect('3ada3320-0ab0-44d6-8b6f-b0cbd5ad4736');
$job->handle();

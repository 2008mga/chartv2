<?php
require_once "_bootstrap.php";
if ($app->migrate()) {
	echo $app->json_response('Success!', 200);
} else {
	echo $app->json_response('Fail', 500);
}
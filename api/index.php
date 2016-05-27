<?php
include 'db.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/*
attachment
concat_attachmentnewsletter
concat_statususernewsletter
concat_usergroup
groupe
newsletter
status
users
*/

include 'User/serviceUsers.php';

/*phpinfo*/
phpinfo();

$app->run();

?>

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

include 'Webservices/serviceUsers.php';
include 'Webservices/serviceAttachment.php';
include 'Webservices/serviceConcatAttachmentNewsletter.php';
include 'Webservices/serviceConcatStatusUsersNewsletter.php';
include 'Webservices/serviceConcatUserGroup.php';
include 'Webservices/serviceGroup.php';
include 'Webservices/serviceNewsletter.php';
include 'Webservices/serviceStatus.php';

$app->run();


/*phpinfo*/
//phpinfo();

?>

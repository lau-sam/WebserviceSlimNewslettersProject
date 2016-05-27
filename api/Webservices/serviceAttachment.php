<?php
// urls
/*create*/
$app->post('/attachments','insertattachment');
/*read*/
$app->get('/attachments','getattachments');
$app->get('/attachments/:idattachment','getattachmentById');
/*update*/
$app->post('/attachments/update/:idattachment','updateattachmentById');
/*delete*/
$app->delete('/attachments/delete/:idattachment','deleteattachmentById');

/***** CREATE *****/
function insertattachment()
{
    $request = \Slim\Slim::getInstance()->request();
    $attachment = json_decode($request->getBody());
    $sql = "INSERT INTO attachment (idattachment, attachmentName, adressEmail ) VALUES (:idattachment, :attachmentName, :adressEmail)";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idattachment", $attachment->idattachment);
        $stmt->bindParam("attachmentName", $attachment->attachmentName);
        $stmt->bindParam("adressEmail",$attachment->adressEmail);
        $stmt->execute();
        $attachment->id = $db->lastInsertId();
        $db = null;
        $attachment_id= $attachment->idattachment;
        getattachmentById($attachment_id);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** READ *****/
function getattachments()
{
    $sql = "SELECT * FROM attachment";
    try {
        $db = getDB();
        $stmt = $db->query($sql);
        $attachments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"attachment": ' . json_encode($attachments) . '}';
    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getattachmentById($idattachment) // TODO
{

    $sql = "SELECT * FROM attachment WHERE idattachment=:idattachment";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idattachment", $idattachment);
        $stmt->execute();
        $attachment = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"attachment": ' . json_encode($attachment) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/***** UPDATE *****/
function updateattachmentById($idattachment)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $attachment = json_decode($request->getBody());

    $sql = "UPDATE attachment SET attachmentName=:attachmentName, adressEmail=:adressEmail WHERE idattachment=".$idattachment;
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("attachmentName", $attachment->attachmentName);
        $stmt->bindParam("adressEmail",$attachment->adressEmail);
        $stmt->execute();
        $db = null;
        getattachmentById($idattachment);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** DELETE *****/
function deleteattachmentById($idattachment) {

    $sql = "DELETE FROM attachment WHERE idattachment=:idattachment";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idattachment", $idattachment);
        $stmt->execute();
        $db = null;
        echo true;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}
?>

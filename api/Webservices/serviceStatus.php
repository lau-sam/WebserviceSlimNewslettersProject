<?php
// urls
/*create*/
//$app->post('/status','insertnewsletter');
/*read*/
//$app->get('/status','getnewsletters');
$app->get('/status/:idStatus','getStatusById');
/*update*/
$app->post('/status/update/','updateStatusById');
/*delete*/
//$app->delete('/status/delete/:idnewsletter','deletenewsletterById');


function getStatusById($id)
{
    $sql = "SELECT * FROM status WHERE idStatus=:idStatus";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idStatus", $id);
        $stmt->execute();
        $newsletter = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"status": ' . json_encode($newsletter) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function updateStatusById()
{
    $request = \Slim\Slim::getInstance()->request();
    $status = json_decode($request->getBody());
    $sql = "UPDATE status SET  DesignationStatus=:DesignationStatus WHERE idStatus=".$status->idStatus;
    try {
        var_dump($status->idStatus);
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("DesignationStatus",$status->DesignationStatus);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
<?php
// urls
/*create*/
$app->post('/status','insertnewsletter');
/*read*/
$app->get('/status','getnewsletters');
$app->get('/status/:idStatus','getStatusById');
/*update*/
$app->post('/status/update/:idnewsletter','updatenewsletterById');
/*delete*/
$app->delete('/status/delete/:idnewsletter','deletenewsletterById');


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
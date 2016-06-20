<?php
// urls
/*create*/
$app->post('/newsletters','insertnewsletter');
/*read*/
$app->get('/newsletters','getnewsletters');
$app->get('/newsletters/:idnewsletter','getnewsletterById');
/*update*/
$app->post('/newsletters/update/:idnewsletter','updatenewsletterById');
/*delete*/
$app->delete('/newsletters/delete/:idnewsletter','deletenewsletterById');

/***** CREATE *****/
function insertnewsletter()
{
    $statusID=0;
    $newsletterID=0;
    $request = \Slim\Slim::getInstance()->request();
    $newsletter = json_decode($request->getBody());

    $sql = "INSERT INTO newsletter (CampagneName, HtmlBody ) VALUES (:CampagneName, :HtmlBody)";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("CampagneName", $newsletter->CampagneName);
        $stmt->bindParam("HtmlBody",$newsletter->HtmlBody);
        $stmt->execute();
        $newsletter->id = $db->lastInsertId();
        $newsletterID = $db->lastInsertId();
        $db = null;
       // $newsletter_id= $newsletter->idnewsletter;
       // getnewsletterById($newsletter_id);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

    $sql = "INSERT INTO status(DesignationStatus) VALUES ('TBD')";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $newsletter->id = $db->lastInsertId();
        $statusID=$db->lastInsertId();
        $db = null;
        //$newsletter_id= $newsletter->idnewsletter;
        ////getnewsletterById($newsletter_id);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }


$jsonData =  json_decode(file_get_contents("http://localhost:8080/WebserviceSlimNewslettersProject/api/groups/users/".$newsletter->idUser,true));
$arrayOfGroup =  array();

foreach($jsonData->group as $mydata) {
    $sql = "INSERT INTO concat_statususernewsletter (idNewsletter,idUser, idstatus,idGroup) VALUES (".$newsletterID.",  $mydata->iduser ,"."$statusID".",:idUser)";
    try {
        var_dump($newsletter);
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idUser", $newsletter->idUser);
        $stmt->execute();
      //  $newsletter->id = $db->lastInsertId();
        $db = null;
       // $newsletter_id= $newsletter->idnewsletter;
       // getnewsletterById($newsletter_id);
    } catch(PDOException $e) {
        echo '{"error_Concat_statusUserNewsletter":{"text":'. $e->getMessage() .'}}';
    }
}


    //var_dump($arrayOfGroup);
}

/***** READ *****/
function getnewsletters()
{
    $sql = "SELECT * FROM newsletter";
    try {
        $db = getDB();
        $stmt = $db->query($sql);
        $newsletters = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"newsletter": ' . json_encode($newsletters) . '}';
    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getnewsletterById($idnewsletter) // TODO
{

    $sql = "SELECT * FROM newsletter WHERE idnewsletter=:idnewsletter";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idnewsletter", $idnewsletter);
        $stmt->execute();
        $newsletter = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"newsletter": ' . json_encode($newsletter) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/***** UPDATE *****/
function updatenewsletterById($idnewsletter)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $newsletter = json_decode($request->getBody());

    $sql = "UPDATE newsletter SET CampagneName=:CampagneName, HtmlBody=:HtmlBody WHERE idnewsletter=".$idnewsletter;
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("CampagneName", $newsletter->CampagneName);
        $stmt->bindParam("HtmlBody",$newsletter->HtmlBody);
        $stmt->execute();
        $db = null;
        getnewsletterById($idnewsletter);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** DELETE *****/
function deletenewsletterById($idnewsletter) {

    $sql = "DELETE FROM newsletter WHERE idnewsletter=:idnewsletter";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idnewsletter", $idnewsletter);
        $stmt->execute();
        $db = null;
        echo true;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}
?>

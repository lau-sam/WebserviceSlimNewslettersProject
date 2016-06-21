<?php
// urls
/*create*/
//$app->post('/serviceConcatStatusUsersNewsLetter','insertconcat_statususernewsletter');
/*read*/
//$app->get('/serviceConcatStatusUsersNewsLetter','getConcatconcat_statususernewsletterNewsletters');
//$app->get('/serviceConcatStatusUsersNewsLetter/:idgroup','getconcat_statususernewsletterByIdGroup');
$app->get('/serviceConcatStatusUsersNewsLetter/newsletters/:idNewsletter','getconcat_statususernewsletterByIdNewsletter');
/*update*/
//$app->post('/serviceConcatStatusUsersNewsLetter/update/:idconcat_statususernewsletter','updateconcat_statususernewsletterByIdUser');
$app->post('/serviceConcatStatusUsersNewsLetter/unsubscribe/:idStatus','UnsubscribeConcat_statususernewsletterByIdStatus');

/*delete*/
$app->delete('/serviceConcatStatusUsersNewsLetter/deleteUser/:iduser','deleteconcat_statususernewsletterByIdUser');
$app->delete('/serviceConcatStatusUsersNewsLetter/deleteGroup/:idgroup','deleteconcat_statususernewsletterByIdGroup');

/***** CREATE *****/
function insertconcat_statususernewsletter()
{
    $request = \Slim\Slim::getInstance()->request();
    $concat_statususernewsletter = json_decode($request->getBody());
    $sql = "INSERT INTO concat_statususernewsletter (idgroup, iduser ) VALUES (:idgroup, :iduser)";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idgroup", $concat_statususernewsletter->idgroup);
        $stmt->bindParam("iduser",$concat_statususernewsletter->iduser);
        $stmt->execute();
        $concat_statususernewsletter->id = $db->lastInsertId();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** READ *****/
function getConcatconcat_statususernewsletterNewsletters()
{
    $sql = "SELECT * FROM concat_statususernewsletter";
    try {
        $db = getDB();
        $stmt = $db->query($sql);
        $Concatconcat_statususernewsletterNewsletters = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"concat_statususernewsletter": ' . json_encode($Concatconcat_statususernewsletterNewsletters) . '}';
    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getconcat_statususernewsletterByIdGroup($idgroup) // TODO
{

    $sql = "SELECT * FROM concat_statususernewsletter WHERE idgroup=:idgroup";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idgroup", $idgroup);
        $stmt->execute();
        $concat_statususernewsletter = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"idgroup": ' . json_encode($concat_statususernewsletter) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getconcat_statususernewsletterByIdNewsletter($idNewsletter) // TODO
{
    
    $sql = "SELECT * FROM concat_statususernewsletter WHERE idNewsletter=:idNewsletter";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idNewsletter", $idNewsletter);
        $stmt->execute();
        $concat_statususernewsletter = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"concat_statususernewsletter": ' . json_encode($concat_statususernewsletter) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/***** UPDATE *****/
function updateconcat_statususernewsletterByIdGroup($idgroup)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $concat_statususernewsletter = json_decode($request->getBody());

    $sql = "UPDATE concat_statususernewsletter SET idgroup=:idgroup, iduser=:iduser WHERE idconcat_statususernewsletter=".$idgroup;
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idgroup", $concat_statususernewsletter->idgroup);
        $stmt->execute();
        $db = null;
        //getconcat_statususernewsletterById($idgroup);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function updateconcat_statususernewsletterByIdUser($iduser)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $concat_statususernewsletter = json_decode($request->getBody());

    $sql = "UPDATE concat_statususernewsletter SET idgroup=:idgroup, iduser=:iduser WHERE idconcat_statususernewsletter=".$iduser;
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("iduser",$concat_statususernewsletter->iduser);
        $stmt->execute();
        $db = null;
        // getconcat_statususernewsletterById($iduser);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** DELETE *****/
function deleteconcat_statususernewsletterByIdUser($iduser) {

    $sql = "DELETE FROM concat_statususernewsletter WHERE iduser=:iduser";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("iduser", $iduser);
        $stmt->execute();
        $db = null;
        echo true;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

function deleteconcat_statususernewsletterByIdGroup($idgroup) {

    $sql = "DELETE FROM concat_statususernewsletter WHERE idgroup=:idgroup";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idgroup", $idgroup);
        $stmt->execute();
        $db = null;
        echo true;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

function deleteconcat_statususernewsletterByIdGroupAndUser($iduser,$idgroup) {

    $sql = "DELETE FROM concat_statususernewsletter WHERE idgroup=:idgroup and iduser=:iduser";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("iduser", $iduser);
        $stmt->bindParam("idgroup", $idgroup);
        $stmt->execute();
        $db = null;
        echo true;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}


function UnsubscribeConcat_statususernewsletterByIdStatus($idStatus)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $concat_statususernewsletter = json_decode($request->getBody());

    $sql = "UPDATE concat_statususernewsletter SET enable=1 WHERE idStatus =:idStatus";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idStatus",$concat_statususernewsletter->idStatus);
        $stmt->execute();
        $db = null;
        // getconcat_statususernewsletterById($iduser);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
?>

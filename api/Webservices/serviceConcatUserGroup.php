<?php
// urls
/*create*/
$app->post('/ConcatUserGroups','insertConcatUserGroup');
/*read*/
$app->get('/ConcatUserGroups','getConcatConcatUserGroupNewsletters');
$app->get('/ConcatUserGroups/:idgroup','getConcatUserGroupByIdGroup');
$app->get('/ConcatUserGroups/:iduser','getConcatUserGroupByIdUser');
/*update*/
$app->post('/ConcatUserGroups/update/:idConcatUserGroup','updateConcatUserGroupByIdUser');
$app->post('/ConcatUserGroups/update/:idConcatUserGroup','updateConcatUserGroupByIdGroup');

/*delete*/
$app->delete('/ConcatUserGroups/deleteUser/:iduser','deleteConcatUserGroupByIdUser');
$app->delete('/ConcatUserGroups/deleteGroup/:idgroup','deleteConcatUserGroupByIdGroup');
$app->delete('/ConcatUserGroups/delete/:idgroup/:iduser','deleteConcatUserGroupById');

/***** CREATE *****/
function insertConcatUserGroup()
{
    $request = \Slim\Slim::getInstance()->request();
    $ConcatUserGroup = json_decode($request->getBody());
    $sql = "INSERT INTO concat_usergroup (idgroup, iduser ) VALUES (:idgroup, :iduser)";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idgroup", $ConcatUserGroup->idgroup);
        $stmt->bindParam("iduser",$ConcatUserGroup->iduser);
        $stmt->execute();
        $ConcatUserGroup->id = $db->lastInsertId();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** READ *****/
function getConcatConcatUserGroupNewsletters()
{
    $sql = "SELECT * FROM concat_usergroup";
    try {
        $db = getDB();
        $stmt = $db->query($sql);
        $ConcatConcatUserGroupNewsletters = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"ConcatUserGroup": ' . json_encode($ConcatConcatUserGroupNewsletters) . '}';
    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getConcatUserGroupByIdGroup($idgroup) // TODO
{

    $sql = "SELECT * FROM concat_usergroup WHERE idgroup=:idgroup";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idgroup", $idgroup);
        $stmt->execute();
        $ConcatUserGroup = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"idgroup": ' . json_encode($ConcatUserGroup) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getConcatUserGroupByIdUser($iduser) // TODO
{

    $sql = "SELECT * FROM concat_usergroup WHERE iduser=:iduser";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("iduser", $iduser);
        $stmt->execute();
        $ConcatUserGroup = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"iduser": ' . json_encode($ConcatUserGroup) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/***** UPDATE *****/
function updateConcatUserGroupByIdGroup($idgroup)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $ConcatUserGroup = json_decode($request->getBody());

    $sql = "UPDATE concat_usergroup SET idgroup=:idgroup, iduser=:iduser WHERE idConcatUserGroup=".$idgroup;
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idgroup", $ConcatUserGroup->idgroup);
        $stmt->execute();
        $db = null;
        //getConcatUserGroupById($idgroup);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function updateConcatUserGroupByIdUser($iduser)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $ConcatUserGroup = json_decode($request->getBody());

    $sql = "UPDATE concat_usergroup SET idgroup=:idgroup, iduser=:iduser WHERE idConcatUserGroup=".$iduser;
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("iduser",$ConcatUserGroup->iduser);
        $stmt->execute();
        $db = null;
       // getConcatUserGroupById($iduser);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** DELETE *****/
function deleteConcatUserGroupByIdUser($iduser) {

    $sql = "DELETE FROM concat_usergroup WHERE iduser=:iduser";
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

function deleteConcatUserGroupByIdGroup($idgroup) {

    $sql = "DELETE FROM concat_usergroup WHERE idgroup=:idgroup";
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

function deleteConcatUserGroupById($iduser,$idgroup) {

    $sql = "DELETE FROM concat_usergroup WHERE idgroup=:idgroup and iduser=:iduser";
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
?>

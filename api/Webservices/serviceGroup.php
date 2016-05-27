<?php
// urls
/*create*/
$app->post('/groups','insertGroup');
/*read*/
$app->get('/groups','getGroups');
$app->get('/groups/:idGroup','getGroupById');
/*update*/
$app->post('/groups/update/:idGroup','updateGroupById');
/*delete*/
$app->delete('/groups/delete/:idGroup','deleteGroupById');

/***** CREATE *****/        
function insertGroup()
{
    $request = \Slim\Slim::getInstance()->request();
    $group = json_decode($request->getBody());
    $sql = "INSERT INTO groupe (idGroup, GroupName, adressEmail ) VALUES (:idGroup, :GroupName, :adressEmail)";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idGroup", $group->idGroup);
        $stmt->bindParam("GroupName", $group->GroupName);
        $stmt->bindParam("adressEmail",$group->adressEmail);
        $stmt->execute();
        $group->id = $db->lastInsertId();
        $db = null;
        $group_id= $group->idGroup;
        getGroupById($group_id);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** READ *****/
function getGroups()
{
    $sql = "SELECT * FROM groupe";
    try {
        $db = getDB();
        $stmt = $db->query($sql);
        $groups = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"group": ' . json_encode($groups) . '}';
    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getGroupById($idGroup) // TODO
{

    $sql = "SELECT * FROM groupe WHERE idGroup=:idGroup";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idGroup", $idGroup);
        $stmt->execute();
        $group = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"group": ' . json_encode($group) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/***** UPDATE *****/
function updateGroupById($idGroup)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $group = json_decode($request->getBody());

    $sql = "UPDATE groupe SET GroupName=:GroupName, adressEmail=:adressEmail WHERE idGroup=".$idGroup;
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("GroupName", $group->GroupName);
        $stmt->bindParam("adressEmail",$group->adressEmail);
        $stmt->execute();
        $db = null;
        getGroupById($idGroup);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** DELETE *****/
function deleteGroupById($idGroup) {

    $sql = "DELETE FROM groupe WHERE idGroup=:idGroup";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idGroup", $idGroup);
        $stmt->execute();
        $db = null;
        echo true;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}
?>

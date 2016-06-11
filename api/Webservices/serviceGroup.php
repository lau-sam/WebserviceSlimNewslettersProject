<?php
// urls
/*create*/
$app->post('/groups','insertGroup');
/*read*/
$app->get('/groups','getGroups');

$app->get('/groups/max','getLastID');

$app->get('/groups/users/:idGroup','getUserFromGroup');


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
    $sql = "INSERT INTO groupe ( GroupName, adressEmail ) VALUES ( :GroupName, :adressEmail)";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("GroupName", $group->GroupName);
        $stmt->bindParam("adressEmail",$group->adressEmail);
        $stmt->execute();
        $db = null;
        echo  getLastID();
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/***** READ *****/
function getUserFromGroup($idGroup)
{
    $sql = "SELECT * FROM concat_usergroup WHERE idGroup=:idGroup";
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

function getLastID()
{
    $request = \Slim\Slim::getInstance()->request();
    $group = json_decode($request->getBody());
    $sql = "select MAX(idgroup) as idgroup from groupe";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $group = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $a= $group =  json_decode(json_encode($group)) ;
        return  $a[0]->idgroup;
    } catch(PDOException $e) {
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

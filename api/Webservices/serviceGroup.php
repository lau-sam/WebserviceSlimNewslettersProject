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
    $sql = "INSERT INTO group (idGroup, GroupName, adressEmail ) VALUES (:idGroup, :userGroup, :adressEmail)";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idGroup", $group->idUser);
        $stmt->bindParam("userGroup", $group->userGroup);
        $stmt->bindParam("adressEmail",$group->adressEmail);
        $stmt->execute();
        $group->id = $db->lastInsertId();
        $db = null;
        $group_id= $group->idGroup;
        getUserById($group_id);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** READ *****/
function getGroup() 
{
    $sql = "SELECT * FROM group";
    try {
        $db = getDB();
        $stmt = $db->query($sql);
        $groups = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"users": ' . json_encode($groups) . '}';
    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getGroupById($idGroup) // TODO
{

    $sql = "SELECT * FROM users WHERE idGroup=:idGroup";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idGroup", $idGroup);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"user": ' . json_encode($user) . '}';

    } catch(PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/***** UPDATE *****/
function updateGroupById($idGroup)//TODO
{
    $request = \Slim\Slim::getInstance()->request();
    $user = json_decode($request->getBody());

    $sql = "UPDATE users SET userName=:userName, userAdressEmail=:userAdressEmail WHERE idGroup=".$idGroup;
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userName", $user->userName);
        $stmt->bindParam("userAdressEmail",$user->userAdressEmail);
        $stmt->execute();
        $db = null;
        getUserById($idGroup);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/***** DELETE *****/
function deleteUserById($idUser) {

    $sql = "DELETE FROM users WHERE idGroup=:idGroup";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("idGroup", $idUser);
        $stmt->execute();
        $db = null;
        echo true;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}
?>

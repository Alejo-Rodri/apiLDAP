<?php
require '../vendor/autoload.php';
require 'Database.php';
require '../services/CreateOp.php';
require '../services/ReadOp.php';
require '../services/UpdateOp.php';
require '../services/DeleteOp.php';
require '../services/AuthOp.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Client
{
    // CRUD
    public static function createUser($uid, $cn, $sn, $mail, $psswd)
    {
        $client = new CreateOp();
        $client->addUser(uid: $uid, cn: $cn, sn: $sn, mail: $mail, psswd: $psswd);
    }

    public static function getUserById($uid)
    {
        $client = new ReadOp();
        $client->getUserById(uid: $uid);
    }

    public static function updatePassword($uid, $psswd)
    {
        $client = new UpdateOp();
        $client->updatePassword(uid: $uid, psswd: $psswd);
    }

    public static function deleteUser($uid)
    {
        $client = new DeleteOp();
        $client->deleteUser(uid: $uid);
    }

    // AUTH
    public static function authUser($uid, $psswd)
    {
        $client = new AuthOp();
        $client->authenticateUser(uid: $uid, psswd: $psswd);
    }

    // AUTH2
}
?>
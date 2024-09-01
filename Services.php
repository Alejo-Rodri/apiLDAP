<?php
include './services/CreateOp.php';
include './services/ReadOp.php';
include './services/UpdateOp.php';
include './services/DeleteOp.php';

class Services
{
    private $ldap_connection;

    public function __construct()
    {
        $this->ldap_connection = ldap_connect($_ENV['LDAP_URL']);

        ldap_set_option($this->ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);

        $ldap_bind = ldap_bind($this->ldap_connection, $_ENV['LDAP_ADMIN_DN'], $_ENV['LDAP_ADMIN_PASSWORD']);

        if ($ldap_bind) echo "Connected and bound to the LDAP server.";
        else echo "Unable to connect or bind to the LDAP server.";
    }

    // AUTH

    public function authenticate($uid, $psswd)
    {
        $user_dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];

        if (ldap_bind($this->ldap_connection, $user_dn, $psswd)) $toReturn = "200";
        else $toReturn = "404";

        return $toReturn;
    }

    // CRUD

    public function createEntry($uid, $cn, $sn, $mail, $psswd)
    {
        $client = new CreateOp();
        return $client->addUser(uid: $uid, cn: $cn, sn: $sn, mail: $mail, 
                                psswd: $psswd, ldap_connection: $this->ldap_connection);
    }

    public function readEntry($uid)
    {
        $client = new ReadOp();
        return $client->getUser(uid: $uid, ldap_connection: $this->ldap_connection);
    }

    public function updatePassword($uid, $psswd)
    {
        $client = new UpdateOp();
        return $client->updatePassword(uid: $uid, psswd: $psswd, ldap_connection: $this->ldap_connection);
    }

    public function deleteEntry($uid)
    {
        $client = new DeleteOp();
        return $client->deleteUser(uid: $uid, ldap_connection: $this->ldap_connection);
    }

    public function closeConnection()
    {
        ldap_unbind($this->ldap_connection);
    }
}
?>
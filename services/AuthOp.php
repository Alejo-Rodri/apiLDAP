<?php
class AuthOp
{
    public function authenticateUser($uid, $psswd)
    {
        $db = new Database();
        $ldap_connection = $db->getConnection();

        $user_dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];

        if (ldap_bind($ldap_connection, $user_dn, $psswd)) header('HTTP/1.1 201 OK Todo bien manito');
        else header('HTTP/1.1 404 NOT OK');
    }
}

?>
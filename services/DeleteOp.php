<?php
class DeleteOp
{
    public function deleteUser($uid)
    {
        $db = new Database();
        $ldap_connection = $db->getConnection();

        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];

        if (ldap_delete($ldap_connection, $dn)) header('HTTP/1.1 201 OK');
        else header('HTTP/1.1 404 NOT OK');
    }
}
?>
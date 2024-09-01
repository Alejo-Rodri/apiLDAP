<?php
class DeleteOp
{
    public function deleteUser($uid, $ldap_connection)
    {
        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];

        if (ldap_delete($ldap_connection, $dn)) $toReturn = "200";
        else $toReturn="404";

        return $toReturn;
    }
}
?>
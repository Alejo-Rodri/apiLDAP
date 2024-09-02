<?php
class UpdateOp
{
    public function updatePassword($uid, $psswd)
    {
        $db = new Database();
        $ldap_connection = $db->getConnection();

        $hashedPassword = "{SHA}" . base64_encode(pack("H*", sha1($psswd)));

        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];
        $attributes = array(
            "userPassword" => $hashedPassword
        );

        if (ldap_modify($ldap_connection, $dn, $attributes)) header('HTTP/1.1 201 OK');
        else header('HTTP/1.1 404 NOT OK');
    }
}
?>
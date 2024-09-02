<?php
class ReadOp
{
    public function getUserById($uid)
    {
        $db = new Database();
        $ldap_connection = $db->getConnection();

        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];
        $filter = "(objectclass=*)";
        $attributes = array("cn", "sn", "mail");

        $result = ldap_read($ldap_connection, $dn, $filter, $attributes);
        if (!is_bool($result))
        {
            $entries = ldap_get_entries($ldap_connection, $result);
            echo json_encode($entries);
            header('HTTP/1.1 201 OK');
        } else header('HTTP/1.1 404 NOT OK');
    }
}
?>
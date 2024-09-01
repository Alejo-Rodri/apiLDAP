<?php
class ReadOp
{
    public function getUser($uid, $ldap_connection)
    {
        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];
        $filter = "(objectclass=*)";
        $attributes = array("cn", "sn", "mail");

        $result = ldap_read($ldap_connection, $dn, $filter, $attributes);
        if (!is_bool($result))
        {
            $entries = ldap_get_entries($ldap_connection, $result);
            $toReturn = "200";
        } else $toReturn = "404";
        
        return [
            'status' => $toReturn,
            'userAttributes' => $entries
        ];
    }
}
?>
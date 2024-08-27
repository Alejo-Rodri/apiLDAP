<?php
class Services
{
    const URL = "ldap://192.168.1.45:389";
    const ROOT = "dc=upb,dc=company";
    const DN = "cn=admin,dc=upb,dc=company";
    const PASSWD = "fungi";
    public $ldap_connection;

    public function __construct()
    {
        $this->ldap_connection = ldap_connect(self::URL);

        ldap_set_option($this->ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);

        $ldap_bind = ldap_bind($this->ldap_connection, self::DN, self::PASSWD);

        if ($ldap_bind) echo "Connected and bound to the LDAP server.";
        else echo "Unable to connect or bind to the LDAP server.";
    }

    // AUTH

    public function authenticate($uid, $psswd)
    {
        $user_dn = "uid=" . $uid . ",ou=users," . self::ROOT;

        if (ldap_bind($this->ldap_connection, $user_dn, $psswd)) $toReturn = "200";
        else $toReturn = "404";

        return $toReturn;
    }

    // CRUD

    public function createEntry($uid, $cn, $sn, $mail, $psswd)
    {
        $hashedPassword = "{SHA}" . base64_encode(pack("H*", sha1($psswd)));

        $dn = "uid=" . $uid . ",ou=users," . self::ROOT;
        $attributes = array(
            "cn" => $cn,
            "sn" => $sn,
            "mail" => $mail,
            "userPassword" => $hashedPassword,
            "objectClass" => array("top", "shadowAccount", "inetOrgPerson")
        );

        if (ldap_add($this->ldap_connection, $dn, $attributes)) $toReturn = "200";
        else $toReturn = "404";
        
        return $toReturn;
    }

    public function readEntry($uid)
    {
        $dn = "uid=" . $uid . ",ou=users," . self::ROOT;
        $filter = "(objectclass=*)";
        $attributes = array("cn", "sn", "mail");

        $result = ldap_read($this->ldap_connection, $dn, $filter, $attributes);
        if (!is_bool($result))
        {
            $entries = ldap_get_entries($this->ldap_connection, $result);
            $toReturn = "200";
        } else $toReturn = "404";
        
        return [
            'status' => $toReturn,
            'userAttributes' => $entries
        ];
    }

    public function updatePassword($uid, $psswd)
    {
        $hashedPassword = "{SHA}" . base64_encode(pack("H*", sha1($psswd)));

        $dn = "uid=" . $uid . ",ou=users," . self::ROOT;
        $attributes = array(
            "userPassword" => $hashedPassword
        );

        if (ldap_modify($this->ldap_connection, $dn, $attributes)) $toReturn = "200";
        else $toReturn="404";

        return $toReturn;
    }

    public function deleteEntry($uid)
    {
        $dn = "uid=" . $uid . ",ou=users," . self::ROOT;

        if (ldap_delete($this->ldap_connection, $dn)) $toReturn = "200";
        else $toReturn="404";

        return $toReturn;
    }

    public function closeConnection()
    {
        ldap_unbind($this->ldap_connection);
    }
}
?>
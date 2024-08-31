<?php
class Services
{
    public $ldap_connection;

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
        $hashedPassword = "{SHA}" . base64_encode(pack("H*", sha1($psswd)));

        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];
        $attributes = array(
            "cn" => $cn,
            "sn" => $sn,
            "mail" => $mail,
            "userPassword" => $hashedPassword,
            "objectClass" => array("top", "shadowAccount", "inetOrgPerson")
        );

        if (ldap_add($this->ldap_connection, $dn, $attributes)) {
            $toReturn = "200";
            $subject="TestMail";
            $message="Hola ".$uid." nos alegra que hagas parte de esta gran aventura que es NEXUS BATTLE III";
            $headers='From: NEXUSBATTLEIII@upb.company.com'."\r\n".'Reply-To: adrox148@gmail.com';

            if (mail($mail, $subject, $message, $headers)) echo "pos si sirvío";
            else echo "paila manito";
        }
        else $toReturn = "404";
        
        return $toReturn;
    }

    public function readEntry($uid)
    {
        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];
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

        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];
        $attributes = array(
            "userPassword" => $hashedPassword
        );

        if (ldap_modify($this->ldap_connection, $dn, $attributes)) $toReturn = "200";
        else $toReturn="404";

        return $toReturn;
    }

    public function deleteEntry($uid)
    {
        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];

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
<?php
class Database 
{
    public function getConnection() {
        $ldap_connection = ldap_connect($_ENV['LDAP_URL']);

        ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3);

        $ldap_bind = ldap_bind($ldap_connection, $_ENV['LDAP_ADMIN_DN'], $_ENV['LDAP_ADMIN_PASSWORD']);

        if ($ldap_bind) echo "Connected and bound to the LDAP server.";
        else echo "Unable to connect or bind to the LDAP server.";
        return $ldap_connection;
    }
}
?>
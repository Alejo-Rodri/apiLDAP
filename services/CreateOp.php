<?php
class CreateOp
{
    public function addUser($uid, $cn, $sn, $mail, $psswd) 
    {
        $db = new Database();
        $ldap_connection = $db->getConnection();

        $hashedPassword = "{SHA}" . base64_encode(pack("H*", sha1($psswd)));

        $dn = "uid=" . $uid . "," . $_ENV['LDAP_OU'] . "," . $_ENV['LDAP_ROOT_DN'];
        $attributes = array(
            "cn" => $cn,
            "sn" => $sn,
            "mail" => $mail,
            "userPassword" => $hashedPassword,
            "objectClass" => array("top", "shadowAccount", "inetOrgPerson")
        );

        if (ldap_add($ldap_connection, $dn, $attributes)) {
            header('HTTP/1.1 201 OK');
            $subject="TestMail";
            $message="Hola ".$uid." nos alegra que hagas parte de esta gran aventura que es NEXUS BATTLE III";
            $headers='From: NEXUSBATTLEIII@upb.company.com'."\r\n".'Reply-To: adrox148@gmail.com';

            if (mail($mail, $subject, $message, $headers)) echo "pos si sirvío";
            else echo "paila manito";
        }
        else header('HTTP/1.1 404 NOT OK');
    }
}
?>
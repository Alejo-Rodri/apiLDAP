<?php
class CreateOp
{
    public function addUser($uid, $cn, $sn, $mail, $psswd, $ldap_connection) 
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

        if (ldap_add($ldap_connection, $dn, $attributes)) {
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
}
?>
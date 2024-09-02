<?php
require '../includes/Client.php';

/**
 * @OA\Post(
 *     path="/apirestldap/api/authUser.php",
 *     summary="Authenticates a user against the LDAP server.",
 *     tags={"Authentication"},
 *     @OA\Parameter(
 *         name="uid",
 *         in="query",
 *         required=true,
 *         description="The user identification",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="psswd",
 *         in="query",
 *         required=true,
 *         description="The user password",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Authentication successful"
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Authentication failed"
 *     )
 * )
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['uid']) && isset($_GET['psswd'])) {
    Client::authUser(uid: $_GET['uid'], psswd: $_GET['psswd']);
}
?>

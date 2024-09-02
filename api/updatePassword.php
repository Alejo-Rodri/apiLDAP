<?php
require '../includes/Client.php';

/**
 * @OA\Put(
 *     path="/apirestldap/api/updatePassword.php",
 *     summary="Updates the password of an existing user.",
 *     tags={"Users"},
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
 *         description="The new password",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="Password updated successfully"),
 *     @OA\Response(response="404", description="User not found"),
 *     @OA\Response(response="500", description="Internal server error")
 * )
 */
if ($_SERVER['REQUEST_METHOD'] == 'PUT' && isset($_GET['uid']) && isset($_GET['psswd']))
{
    Client::updatePassword(uid: $_GET['uid'], psswd: $_GET['psswd']);
}
?>
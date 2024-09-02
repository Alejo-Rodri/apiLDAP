<?php
require '../includes/Client.php';

/**
 * @OA\Delete(
 *     path="/apirestldap/api/deleteUser.php",
 *     summary="Deletes a user by its identification.",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="uid",
 *         in="query",
 *         required=true,
 *         description="The user identification",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="User deleted successfully"),
 *     @OA\Response(response="404", description="User not found"),
 *     @OA\Response(response="500", description="Internal server error")
 * )
 */
if ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['uid']))
{
    Client::deleteUser(uid: $_GET['uid']);
}
?>
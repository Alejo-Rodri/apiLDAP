<?php
require '../includes/Client.php';

/**
 * @OA\Get(
 *     path="/apirestldap/api/getUserById.php",
 *     summary="Gets a user by its identification.",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="uid",
 *         in="query",
 *         required=true,
 *         description="The user identification",
 *         @Oa\Schema(
 *             type="string"
 *         ),
 *     ),
 *     @OA\Response(response="200", description="Okey doki"),
 *     @OA\Response(response="404", description="Not Found"),
 *     @OA\Response(response="500", description="Internal server error")
 * )
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['uid']))
{
    Client::getUserById(uid: $_GET['uid']);
}
?>
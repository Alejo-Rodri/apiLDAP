<?php
require '../includes/Client.php';

/**
 * @OA\Post(
 *     path="/apirestldap/api/createUser.php",
 *     summary="Creates a new user.",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="uid",
 *         in="query",
 *         required=true,
 *         description="The user identification",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="cn",
 *         in="query",
 *         required=true,
 *         description="The user common name",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="sn",
 *         in="query",
 *         required=true,
 *         description="The user surname",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="mail",
 *         in="query",
 *         required=true,
 *         description="The user email address",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *         name="psswd",
 *         in="query",
 *         required=true,
 *         description="The user password",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response="200", description="User created successfully"),
 *     @OA\Response(response="400", description="Invalid input"),
 *     @OA\Response(response="500", description="Internal server error")
 * )
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST'
    && isset($_GET['uid']) && isset($_GET['cn']) && isset($_GET['sn']) && isset($_GET['mail']) && isset($_GET['psswd']))
    {
        Client::createUser(uid: $_GET['uid'], cn: $_GET['cn'], sn:$_GET['sn'], mail:$_GET['mail'], psswd:$_GET['psswd']);
    }
?>
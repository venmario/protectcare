<?php
header("Access-Control-Allow-Origin:*");

require_once 'koneksi.php';

extract($_POST);

if (isset($password)) {
    $sql = "SELECT username FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
} else {
    $sql = "SELECT name, vaccination FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
}
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $data = $res->fetch_assoc();

    $arr = ["result" => "OK", "data" => $data];
} else {
    $arr = ["result" => "error", "messages" => "Unable to login!"];
}


echo json_encode($arr);
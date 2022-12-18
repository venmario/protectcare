<?php
header("Access-Control-Allow-Origin:*");

require_once 'koneksi.php';

$conn->set_charset("utf8");

extract($_POST);

$sql = "SELECT id FROM users WHERE username = ? and checkedin = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows > 0){
    $row = $res->fetch_assoc();
    $id = $row['id'];

    $sql = "SELECT h.* , p.name FROM histories h INNER JOIN places p ON h.places_id = p.id WHERE users_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = $res->fetch_assoc();
    $arr = array("result" => "OK", "messages" => "Checked In Already", "data" => $data);
}else{
    $arr = array("result" => "NULL", "messages" => "Not yet check in");
}

echo json_encode($arr);
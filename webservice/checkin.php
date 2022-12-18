<?php
header("Access-Control-Allow-Origin:*");

require_once 'koneksi.php';

$conn->set_charset("utf8");

date_default_timezone_set("Asia/Jakarta");
$checkInDate = strtotime('now');

extract($_POST);

$sql = "SELECT * FROM places WHERE id = ? AND name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $code, $placeName);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $sql = "SELECT id, vaccination FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $dose = $row['vaccination'];
    $id = $row['id'];

    $sql = "INSERT INTO histories(users_id, places_id, checkin, doses) VALUES(?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isii", $id, $code, $checkInDate, $dose);
    $stmt->execute();

    $sql2 = "UPDATE users SET checkedin = 1 WHERE username = ?";
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $sql = "SELECT h.* , p.name FROM histories h INNER JOIN places p ON h.places_id = p.id WHERE users_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = $res->fetch_assoc();

    $arr = array("result" => "OK", "status" => "success", "messages" => "Check In successfull", "data" => $data);
} else {
    $arr = array("result" => "ERROR", "status" => "failed", "messages" => "Code does not match our database");
}


echo json_encode($arr);

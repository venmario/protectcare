<?php
header("Access-Control-Allow-Origin:*");

require_once 'koneksi.php';

$conn->set_charset("utf8");

date_default_timezone_set("Asia/Jakarta");
$checkOutDate = strtotime('now');

extract($_POST);

$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$id = $row['id'];

$sql = "UPDATE histories SET checkout = ? WHERE users_id = ? AND places_id = ? AND checkin = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisi", $checkOutDate, $id, $code, intval($checkInDate));
$stmt->execute();

$sql2 = "UPDATE users SET checkedin = 0 WHERE username = ?";
$stmt = $conn->prepare($sql2);
$stmt->bind_param("s", $username);
$stmt->execute();

$arr = array("result" => "OK", "status" => "success", "messages" => "Successfully Checked out!");

echo json_encode($arr);
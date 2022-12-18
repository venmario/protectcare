<?php
header("Access-Control-Allow-Origin:*");

require_once 'koneksi.php';

$conn->set_charset("utf8");

$sql = "SELECT * FROM places";
$res = $conn->query($sql);

$data = array();
while ($row = $res->fetch_assoc()) {
    array_push($data, $row);
}

$arr = array("result" => "OK", "status" => "success", "data" => $data);

echo json_encode($arr);
<?php 

require_once 'koneksi.php';

extract($_POST);

$sql = 'SELECT h.id, p.name as `location`, h.checkin, h.checkout,h.doses FROM histories h INNER JOIN users u on u.id = h.users_id INNER JOIN places p on h.places_id = p.id WHERE u.username = ? order by id DESC';

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while($row = $res->fetch_assoc()){
    $data[] = $row;
}

$arr = ['result'=> 'OK', 'data' => $data];
echo json_encode($arr);
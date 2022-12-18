<?php 
error_reporting(E_ERROR | E_PARSE);
$conn = new mysqli("localhost",'native_160419091','ubaya','native_160419091');
if($conn->connect_errno){
    echo json_encode([
            'result' => 'error',
            'message' => 'Failed to connect DB'
    ]
    );
}
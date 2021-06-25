<?php

require('../config.php');
require('../common.php');

// connection
$conn = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME) or die('Mysql connection error');

// sending query mysql
$sql = "SELECT * from markers";

$result = $conn->query($sql);

$markers = [];

// getting all data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($markers, $row);
    }
}

// return this data
echo json_encode($markers);


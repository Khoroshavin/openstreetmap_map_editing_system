<?php

require('../common.php');

$conn = new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);

if ($conn->connect_error) {
  die('Mysql connection error');
}

// getting variable id
$id = $_POST['id'];

//delete image
$sql = "SELECT html FROM markers WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
preg_match_all('/<img[^>]+src="(.+?)"/', $row['html'], $fndSrcRow);
if($fndSrcRow[1]) {
	foreach($fndSrcRow[1] as $src) {
		@unlink($src);
	}
}
//delete image

// sending query
$sql = "DELETE FROM markers WHERE id=".$id;

$query = query($sql);

// return data
echo json_encode($_POST);

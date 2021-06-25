<?php

require('../config.php');

$conn = new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);

if ($conn->connect_error) {
  die('Mysql connection error');
}

$html = mysqli_real_escape_string($conn, $_POST["html"]);
$latlng = $_POST["latlng"];
$id = $_POST["markerId"];

$sql = '';

if (!empty($html)) {
	//delete image
	$sql = "SELECT html FROM markers WHERE id='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	preg_match_all('/<img[^>]+src="(.+?)"/', $row['html'], $fndSrcRow);
	preg_match_all('/<img[^>]+src="(.+?)"/', str_replace('\"', '"', $html), $fndSrcHtml);
	if($fndSrcRow[1]) {
		foreach($fndSrcRow[1] as $src) {
			if(array_search($src, $fndSrcHtml[1]) === false) {
				@unlink($src);
			}
		}
	}
	//delete image
  if (!empty($latlng)) {
    $sql = "UPDATE markers SET html='$html', latlng='$latlng' WHERE id='$id'";
  } else {
    $sql = "UPDATE markers SET html='$html' WHERE id='$id'";
  }
} else {
  if (!empty($latlng)) {
    $sql = "UPDATE markers SET latlng='$latlng' WHERE id='$id'";
  }
}

$conn->query($sql);

// header("Location: editor.php");
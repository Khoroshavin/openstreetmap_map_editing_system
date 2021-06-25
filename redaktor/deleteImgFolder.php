<?php 
    $src = $_POST['url'];

    if (file_exists($src)) {
        $result = unlink($src);
        if ($result) {
            echo 'Img removed';
        }
    }
?>
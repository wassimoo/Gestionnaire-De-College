<?php
$uploaddir = 'img/pp/';

$uploadfile = $uploaddir . basename($_FILES['image']['name']);

if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
    echo "Image succesfully uploaded.";
} else {
    echo "Image uploading failed.";
}
?> 
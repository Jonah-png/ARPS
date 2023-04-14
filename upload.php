<?php
if (isset($_FILES['image'])) {
    $path = "images/" . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
        move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $_FILES['image']['name']);
    }
}

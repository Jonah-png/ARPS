<?php
if (isset($_FILES['image'])) {
    $files = glob("images/*");
    move_uploaded_file($_FILES['image']['tmp_name'], "images/".$_FILES['image']['name']);
}

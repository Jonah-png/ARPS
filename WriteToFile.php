<?php
$myfile = fopen("imageInfo.txt", "w");
fwrite($myfile, $_POST['scale']."\n");
fwrite($myfile, $_POST['x-rotation']." ");
fwrite($myfile, $_POST['y-rotation']." ");
fwrite($myfile, $_POST['z-rotation']."\n");
?>
<?php
$recovery = $_GET['recovery'];
$pcname = $_GET['pcname'];
$size = filesize("../client/recovery/".$pcname."/".$recovery);
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($recovery));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . $size);
readfile("../client/recovery/".$pcname."/".$recovery);
?>
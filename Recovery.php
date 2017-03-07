<?php
include '../include/dbinfo.php';
class Recovery {

function Inspect($id) {
global $server;
$GetRecovery = $server->prepare("SELECT recoveryFile, files From recoveries Where id = :id");
$GetRecovery->bindParam(":id", $id, PDO::PARAM_INT);
$GetRecovery->execute();
$recoveryData = $GetRecovery->fetch(PDO::FETCH_ASSOC);
$fileCount = substr_count($recoveryData['files'], "fileSpl");
return $fileCount."recoverySpl".
$recoveryData['recoveryFile']."recoverySpl".
$recoveryData['files'];
}

function Delete($id) {
global $server;
$server->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
$DeleteRecovery = $server->prepare("
DELETE From recoveries Where id = :id
SELECT files From recoveries Where id = :id
");
$DeleteRecovery->bindParam(":id", $id, PDO::PARAM_INT);
$DeleteRecovery->execute();
$server->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$GetFiles = $DeleteRecovery->fetch(PDO::FETCH_ASSOC);
$files = explode("fileSpl", str_replace($GetFiles['files'], "", $GetFiles['files']));
foreach ($files as $file) {
unlink('../client/recovery/'.$file);
}
}

}

$cmd = $_POST['cmd'];
$Recovery = new Recovery();

switch ($cmd) {
case "inspect":
$id = $_POST['id'];
echo $Recovery->Inspect($id);
break;
case "delete":
$id = $_POST['id'];
$pcname = $_POST['pcname'];
$Recovery->Delete($id, $pcname);
break;
}

?>
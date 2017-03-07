<?php
session_start();
include '../include/dbinfo.php';

//Collect variables
$username = $_POST['username'];
$password = sha1($_POST['password']);
$remember = $_POST['remember'];

//Prepare & execute sql statement
$CheckUser = $server->prepare("SELECT * From admin WHERE username = :username || email = :email && password = :password");
$CheckUser->bindParam(':username', $username, PDO::PARAM_STR);
$CheckUser->bindParam(':email', $username, PDO::PARAM_STR);
$CheckUser->bindParam(':password', $password, PDO::PARAM_STR);
$CheckUser->execute();
$user = $CheckUser->fetch(PDO::FETCH_ASSOC);

//Validate received credentials
if ($CheckUser->rowCount() > 0) {
//User was found
$_SESSION['logged'] = "1";
$_SESSION['username'] = $username;
$_SESSION['email'] = $user['email'];
$GetMailServer = $server->query("SELECT * From mailserver");
$MailServer = $GetMailServer->fetch(PDO::FETCH_ASSOC);
if ($GetMailServer->rowCount() > 0) {
if ($MailServer['host'] == "<host>") {
$_SESSION['smtpHost'] = "";
$_SESSION['smtpPort'] = "";
$_SESSION['useSSL'] = "";
$_SESSION['smtpEmail'] = "";
$_SESSION['smtpPassword'] = "";
} else {
$_SESSION['smtpHost'] = $MailServer['host'];
$_SESSION['smtpPort'] = $MailServer['port'];
$_SESSION['useSSL'] = $MailServer['useSSL'];
$_SESSION['smtpEmail'] = $MailServer['email'];
$_SESSION['smtpPassword'] = $MailServer['password'];
}
} else {
$_SESSION['smtpHost'] = "";
$_SESSION['smtpPort'] = "";
$_SESSION['useSSL'] = "";
$_SESSION['smtpEmail'] = "";
$_SESSION['smtpPassword'] = "";
}
$_SESSION['encryptionKey'] = $MailServer['encryptionKey'];
}
//User was not found
else {echo "Unrecognized username and/or password!";}

//Remember login
if ($remember == "true") {
setcookie("autoLogin", $username."|".$user['email'], 2147483647, "/");
}
?>
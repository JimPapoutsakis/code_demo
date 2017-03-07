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
	<script type="text/javascript" src="assets/js/plugins/notifications/pnotify.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<!--Responsive datatables-->
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<!--Switchery-->
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switch.min.js"></script>
	<!--Bootstrap uploader-->
	<script type="text/javascript" src="assets/js/plugins/uploaders/fileinput.min.js"></script>
	<script type="text/javascript" src="assets/js/pages/uploader_bootstrap.js"></script>
	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/components_notifications_pnotify.js"></script>
	<script type="text/javascript" src="assets/js/pages/datatables_responsive.js"></script>
	<script type="text/javascript" src="assets/js/pages/components_popups.js"></script>
<!--	<script type="text/javascript" src="assets/js/pages/form_validation.js"></script>-->
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/inputs/touchspin.min.js"></script>
    
	<!--/ theme js files-->

	<!--Custom styles-->
	<link rel = "stylesheet" type = "text/css" href = "style/custom.css">


</head>

<body>

<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">

<?php include 'navigation/sidebar.php'; ?>

<script>
$("#fileDownloader").addClass('active');
</script>

<!-- Main content -->
<div class="content-wrapper">

<!-- Content area -->
<div class="content">
<?php include 'accountManager.php'; ?>

<!--Open file downloader-->
<center>
<button type = "button" class = "btn btn-primary" id = "OpenFileDownloader">Add Download</button>
</center>

<br>

<!--Downloader begin-->
<div class = "panel panel-flat" id = "FileDownloaderPanel" style = "display:none;">
<div class = "panel-heading">
<center>
<div class = "panel-title">
<h5>New Download</h5>
</div>
</center>
</div>
<div class = "panel-body">
<form class = "form-horizontal form-validate-jquery" id = "FileDownloaderFrm">
<fieldset class = "content-group">
<!--Client-->
<div class = "form-group">
<label class = "col-lg-2 control-label">Client</label>
<div class = "col-lg-2">
<select class = "form-control" id = "targetClient">
<option id = "all">All</option>
<?php $clients = $server->query("SELECT * From clients"); while($client = $clients->fetch(PDO::FETCH_ASSOC)) { ?>
<option id = "<?php echo $client['id']; ?>"><?php echo $client['pcname']; ?></option>
<?php } ?>
</select>
</div>
</div>
<!--Method-->
<div class = "form-group">
<label class = "col-lg-2 control-label">Method</label>
<div class = "col-lg-2">
<select class = "form-control" id = "downloadMethod">
<option id = "0">Url</option>
<option id = "1">Choose file</option>
</select>
</div>
</div>
<!--Url-->
<div class = "form-group" id = "urlContainer">
<label class = "col-lg-2 control-label">Url</label>
<div class = "col-lg-10">
<input type = "text" class = "form-control" id = "urlDownload" placeholder = "Please type the direct link, including the extension e.g http://website.com/file.exe" required = "required">
</div>
</div>
<!--File-->
<div class = "form-group" id = "fileContainer" style = "display:none">
<label class = "col-lg-2 control-label">File</label>
<div class = "col-lg-10">
<input type = "file" class = "file-input" id = "fileDownload" data-show-upload = "false">
</div>
</div>
<!--Filename-->
<div class = "form-group">
<label class = "col-lg-2 control-label">Save As</label>
<div class = "col-lg-10">
<input type = "text" class = "form-control" id = "saveAs" required = "required">
</div>
</div>
<!--Execute file-->
<div class = "form-group">
<label class = "col-lg-2 control-label">Execute</label>
<div class = "col-g-2">
<div class="checkbox checkbox-switchery">
<label>
<input type="checkbox" class="switchery" id = "executeFile" checked = "checked">
</label>
</div>
</div>
</div>
<!--Process Visibility-->
<div class = "form-group">
<label class = "col-lg-2 control-label">Window Visibility</label>
<div class = "col-lg-2">
<select class = "form-control" id = "windowVisibility">
<option id = "1">Visible</option>
<option id = "0">Hidden</option>
</select>
</div>
</div>
<!--Upload progress-->
<div class="progress" id = "fileProgressContainer" style = "display:none">
<div class="progress-bar progress-bar-info progress-bar-striped active" id = "fileUploadProgressLength" style = "width: 0%">
<span id = "fileUploadProgress">0</span>%
</div>
</div>
</fieldset>
<div class = "text-right">
<button type = "button" class = "btn btn-default" id = "CloseFileDownloader">Close</button>
<button type = "submit" class = "btn btn-primary" id = "sendFileBtn">Send</button>
</div>
</form>
</div>
</div>
<!--Downloader end-->

<!--Downloads begin-->
<?php
function GetExecution($execution) {
if ($execution == true) {return "checked";} else {return "";}
}
?>

<div class = "panel panel-flat">
<div class = "panel-heading">
<div class = "panel-title"><h5>Downloads</h5></div>
</div>
<div class = "panel-body">
<table class = "table datatable-responsive" id = "downloadsTbl">
<thead>
<tr>
<th>Computer</th>
<th>File</th>
<th>Url</th>
<th>Status</th>
<th>Execution</th>
<th>Window Visibility</th>
<th>Submission Date</th>
<th>Completion Date</th>
<th>Action</th>
</tr>
</thead>
<tbody id = "downloadsHolder">
<?php
$sql = "SELECT downloads.id, downloads.clientId dlClientId, downloads.cmdId, downloads.file, downloads.url, downloads.filename, downloads.status, downloads.execution, downloads.windowVisibility, downloads.submissionDate, downloads.completionDate, clients.id clientId, clients.pcname From downloads left join clients on (downloads.clientId = clients.id)";
$downloads = $server->query($sql);

while ($download = $downloads->fetch(PDO::FETCH_ASSOC)) { ?>
<tr id = "download<?php echo $download['id']; ?>">
<!--Computer-->
<td>
<img src = "images/computer.png">
<?php if ($download['clientId'] == "") {$clientId = "all"; echo "All";} else {$clientId = $download['clientId']; echo $download['pcname'];} ?>
</td>
<!--File-->
<td><?php echo $download['file']; ?></td>
<!--Url-->
<td><?php echo $download['url']; ?></td>
<!--Status-->
<td>
<?php switch ($download['status']) {
case 0: ?>
<div class="progress" id = "fileProgressContainer">
<div class="progress-bar progress-bar-info progress-bar-striped active" id = "fileUploadProgressLength" style = "width: 100%">
<span id = "fileUploadProgress">0</span>%
</div>
</div>
<label class = "label label-info">Pending</label>
<?php
break;
case 1:
?>
<div class="progress" id = "fileProgressContainer">
<div class="progress-bar progress-bar-info progress-bar-striped" id = "fileUploadProgressLength" style = "width: 100%">
<span id = "fileUploadProgress">100</span>%
</div>
</div>
<label class = "label label-info">Complete</label>
<?php
break;
case 2: ?>
<div class="progress" id = "fileProgressContainer">
<div class="progress-bar progress-bar-info progress-bar-striped" id = "fileUploadProgressLength" style = "width: 100%">
<span id = "fileUploadProgress">0</span>%
</div>
</div>
<label class = "label label-info">Canceled</label>
<?php
break;
} ?>
</td>
<!--Execution-->
<td>
<div class = "col-g-2">
<div class="checkbox checkbox-switchery">
<label>
<input type="checkbox" class="switchery" id = "executeFile" <?php echo GetExecution($download['execution']); ?>>
</label>
</div>
</div>
</td>
<!--Window Visibility-->
<td>
<div class = "col-g-2">
<?php if ($download['windowVisibility'] == true) { ?>
<label class = "label label-info">Visibile</label>
<?php } else { ?>
<label class = "label label-info">Hidden</label>
<?php } ?>
</div>
</td>
<!--Submission Date-->
<td><?php echo $download['submissionDate']; ?></td>
<!--Completion Date-->
<td>
<?php if ($download['completionDate'] == "") { ?>
-
<?php } else { echo $download['completionDate']; } ?>
</td>
<!--Cancel download-->
<td>
<?php
switch ($download['status']) {
case 0:
?>
<a class = "btn btn-danger" href = "commands.php?clientId=<?php echo $clientId ?>">Cancel</a>
<?php
break;
case 1: ?>
<a class = "btn btn-info" href = "commands.php?clientId=<?php echo $clientId ?>">Completed</a>
<?php
break;
case 2: ?>
<a class = "btn btn-info" href = "commands.php?clientId=<?php echo $clientId ?>">Canceled</a>
<?php } ?>
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

<!--Required-->
<script src = "js/InitiateSwitchery.js"></script>
<script src = "js/FilterActivity.js"></script>

<script>
function CancelDownload(target) {
var clientId = $(target).attr('data-clientId');
var downloadId = $(target).attr('data-downloadId');
var rowElement = $("#download" + downloadId);
swal({
type: "warning",
html: true,
title: "Warning",
text: "The download will be <b>canceled</b>, proceed?",
showCancelButton: true,
cancelButtonText: "No",
showConfirmButton: true,
confirmButtonText: "Yes"},
function (confirmed) {
if (confirmed) {
$.ajax({
type: "POST",
data: {
cmd: "cancel",
downloadId: downloadId,
clientId: clientId
},
cache: false,
url: "cms/FileDownloader.php",
success: function() {
$(rowElement).effect('highlight', {color: "#263238"});
$.when($(rowElement)).done(function() {
downloadsTbl.row($(rowElement)).remove().draw();
});
}
});
}
});
}

$(document).ready(function() {
InitiateSwitcheries(".switchery");

$("#OpenFileDownloader, #CloseFileDownloader").click(function() {
$("#FileDownloaderPanel").animate({
width: "linear",
height: "toggle"}, {
duration: 250,
specialEasing: {
width: "linear",
height: "easeOutExpo"
}
});
});

//Set save as filename
$("#urlDownload").focusout(function() {
if ($("#downloadMethod option:selected").attr('id') == 0) {
saveAs = $(this).val().substring($(this).val().lastIndexOf("/") +1);
}
$("#saveAs").val(saveAs);
});

$("#fileDownload").change(function() {
saveAs = $("#fileDownload").prop("files")[0].name;
$("#saveAs").val(saveAs);
});

//Initialize datatable
downloadsTbl = $("#downloadsTbl").DataTable({
"columnDefs": [{
targets: [2]
}],
"paging":   true,
"ordering": true,
"order": [[ 2, "desc" ]],
"info":     true,
stateSave: false
});

//Choose download method
$("#downloadMethod").change(function() {
$("#FileDownloaderFrm").animate({
width: "linear",
height: "toggle"}, {
duration: 250,
specialEasing: {
width: "linear",
height: "easeOutExpo"
},
complete: function() {
if ($("#downloadMethod option:selected").attr('id') == 0) {
$("#urlContainer").css('display', '');
$("#urlDownload").attr('required', 'required');
$("#fileDownload").removeAttr('required');
$("#fileContainer").css('display', 'none');
$("#FileDownloaderFrm").data('method', 'url');
} else {
$("#fileContainer").css('display', '');
$("#fileDownload").attr('required', 'required');
$("#urlDownload").removeAttr('required');
$("#urlContainer").css('display', 'none');
$("#FileDownloaderFrm").data('method', 'file');
}
$("#FileDownloaderFrm").animate({
width: "linear",
height: "toggle"}, {
duration: 250,
specialEasing: {
width: "linear",
height: "easeOutExpo"
}
});
}
});
});

function QueueDownload() {
$.ajax({
type: "POST",
data: {
cmd: "queue",
clientId: $("#FileDownloaderFrm").data('clientId'),
urlDownload: $("#FileDownloaderFrm").data('urlDownload'),
fileDownload: $("#FileDownloaderFrm").data('uploadedFilename'),
saveAs: $("#FileDownloaderFrm").data('saveAs'),
executeFile: $("#FileDownloaderFrm").data('executeFile'),
windowVisibility: $("#FileDownloaderFrm").data('windowVisibility')
},
url: "cms/FileDownloader.php",
cache: false,
success: function(newDownload) {
location.reload();
}
});
}

function SubmitDownload() {
var fileData = new FormData();
$("#FileDownloaderFrm").data('uploadedFilename', "");

if ($("#FileDownloaderFrm").data('fileDownload').length > 0) {
//Disable submit button
$("#sendFileBtn").attr('disabled', 'true');
$("#sendFileBtn").text('Uploading...');

//Show progress
$("#fileProgressContainer").slideDown(250, "easeOutExpo");

//Wait for 'open' animation to end
$.when($("#fileProgressContainer")).done(function() {
//Set uploader options
var options = [
{
'destination': '../downloader/',
'FilterExtension': false,
'saveAs': $("#saveAs").val()
}
];

fileData.append('options', JSON.stringify(options));
fileData.append('file', $("#FileDownloaderFrm").data('fileDownload')[0]);

$.ajax({
xhr: function() {
var xhr = new window.XMLHttpRequest();
xhr.upload.addEventListener('progress', function(e) {
if (e.lengthComputable) {
var percentComplete = e.loaded / e.total;
percentComplete = parseInt(percentComplete * 100);
$("#fileUploadProgressLength").css('width', percentComplete + "%");
$("#fileUploadProgress").text(percentComplete);
if (percentComplete == 100) {
setTimeout(function() {
//Reenable upload button
$("#sendFileBtn").removeAttr('disabled');
$("#sendFileBtn").text('Submit');
//Set progress to 0
$("#fileUploadProgressLength").css('width', "0%");
$("#fileUploadProgress").text("0");
//Hide uploader
$("#fileProgressContainer").slideUp(250, "easeInExpo");
$("#FileDownloaderFrm").data('uploadedFilename', $("#FileDownloaderFrm").data('fileDownload')[0].name);
QueueDownload();
}, 1000);
}
}
}, false);
return xhr
},
cache: false,
url: "functions/UploadFile.php",
type: "POST",
data: fileData,
processData: false,
contentType: false
});
});
} else {
QueueDownload();
}
}

$("#FileDownloaderFrm").submit(function(e) {
e.preventDefault();
$("#FileDownloaderFrm").data('clientId', $("#targetClient option:selected").attr('id'));
$("#FileDownloaderFrm").data('urlDownload', $("#urlDownload").val());
$("#FileDownloaderFrm").data('fileDownload', $("#fileDownload").prop("files"));
$("#FileDownloaderFrm").data('executeFile', FilterActivity($("#executeFile").prop('checked')));
$("#FileDownloaderFrm").data('windowVisibility', $("#windowVisibility option:selected").attr('id'));
$("#FileDownloaderFrm").data('saveAs', saveAs);

if (saveAs.indexOf(".exe") < 0 && $("#FileDownloaderFrm").data('windowVisibility') == "0") {
swal({
type: "warning",
html: true,
title: "Warning",
text: "Window visibility will be set to <b>visible</b>, proceed?",
showCancelButton: true,
cancelButtonText: "No",
showConfirmButton: true,
confirmButtonText: "Yes"},
function (confirmed) {
if (confirmed) {
$("#windowVisibility option").eq(0).prop('selected', true);
SubmitDownload();
} else {return false;}
});
} else {
SubmitDownload();
}

});

});
</script>
<!--Required-->
<script src = "js/datatables/InitiatePaging.js"></script>
<script src = "js/datatables/InitiateFiltering.js"></script>
</body>
</html>
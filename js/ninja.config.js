var captchaOk = true;
$(document).ready(function() {
	
	$(".g-recaptcha").each(function(){
		var $me = $(this);
		$.get("../get.sitekey.php").done(function(data){
			var json = $.parseJSON(data);
			if (json.key.length>0) {
				$me.attr("data-sitekey",json.key);
				captchaOk = false;
			} else {
				$me.remove();
			}
		});
	});
	
	$("#btnSubmit").click(function() {
		event.preventDefault();
		$("#reply").empty().append("checking...").show();
		if (captchaOk) {
			checkOtherFields();
			return;
		}
		$.post(
			'../verify.captcha.php',$("#frmContactUs").serialize()
		).done(function (data) {
			var resp = $.parseJSON(data);
			captchaOk = resp.verified;
			if (!captchaOk) 
			{
				alert('Are you a robot?');
				$("#reply").empty().append('Are you a robot?').hide(5000);
				return;
			}
			checkOtherFields();
		});
	});
	
	// Config Settings
	if ($("#frmConfigDiv").length>0) {
		$.get('form.config.php').done(function(data){
			$("#frmConfigDiv").empty().append(data);
			$("#cfgMainWrapper").css("background-color",function(){
				return ($("#testing").val()=='Y') ? '#CD3333':'#EFEFEF';
			});
		});
	}
	$("#exampleExpDiv").hide();
	changeHeadingWidth();
	$(".tgl").click(function(){
		$("#imgDiv,#exampleExpDiv").toggle();
		changeHeadingWidth();
	});
	$("#btnConfig").click(function(){
		location="index.php";
	});
	$("#btnFormExample").click(function(){
		location="form.example.html";
	});
});
	
function checkOtherFields() {
	var validated = true;
	var objFields = {};
	$("#frmContactUs").find("select, input, textarea").each(function(){
		var attr = $(this).attr('name');
		if (typeof attr !== typeof undefined && attr !== false) {
			if ($(this).val().length==0) {
				var action = ($(this).is('select')) ? 'select':'insert';
				alert('Please '+action+' the '+$(this).attr('placeholder'));
				$("#reply").hide();
				$(this).focus();
				validated = false;
				return false;
			}
			var strField = $(this).attr('name').replace('[]', '');
			if ($(this).attr('name').indexOf('[')>-1) { 
				if (!objFields.hasOwnProperty(strField)) objFields[strField] = [];
				objFields[strField].push($(this).val());
				var strFieldDesc = strField+'_desc';
				if (!objFields.hasOwnProperty(strFieldDesc)) objFields[strFieldDesc] = [];
				objFields[strFieldDesc].push($(this).attr('placeholder'));
			} else { 
				objFields[strField] = $(this).val(); 
			}
			
		}
	});
	if (!validated) return;
	
	$("#reply").empty().append("Sending...");
	$.post(
		'../submit.contact.php',
		objFields
	).done(function (data) {
		var json = $.parseJSON(data);
		var msg = (json.errors.length>0) ? json.errors + '<br />' + json.result:json.result;
		$("#reply").empty().append(msg).show();
		$("#frmContactUs").find("select, input, textarea").each(function(){
			var attr = $(this).attr('id');
			if (typeof attr !== typeof undefined && attr !== false) {
			    if ($(this).attr('id').indexOf('btnSubmit')==-1) $(this).val('');
			} else {
				$(this).val('');
			}
		});
	});
}

// Configuration 
function newToAddressBind(){
	var $newAddress = $("#toAddressTmpl").clone(true,true).prop('id', '');
	$("#emailDiv").append($newAddress);
}
function newCCAddressBind(){
	var $newAddress = $("#ccAddressTmpl").clone(true,true).prop('id', '');
	$("#emailDiv").append($newAddress);
}
function newBCCAddressBind(){
	var $newAddress = $("#bccAddressTmpl").clone(true,true).prop('id', '');
	$("#emailDiv").append($newAddress);
}
function saveConfig() {
	$("#cfgSaveResult").empty().append('saving...').show();
	$.post('save.config.php',$("#frmConfig").serialize()).done(function(data){
		var json = $.parseJSON(data);
		$("#cfgSaveResult").empty().append(json.result);
		$.get('form.config.php').done(function(data){
			$("#frmConfigDiv").empty().append(data);
			$("#cfgMainWrapper").css("background-color",function(){
				return ($("#testing").val()=='Y') ? '#CD3333':'#EFEFEF';
			});
		});
	});
}
function changeHeadingWidth() {
	$("#mainHeadingDiv").width(function(){
		var otherEl = ($("#imgDiv").is(":visible")) ? $("#imgDiv").outerWidth() : $("#exampleExpDiv").outerWidth();
		return $("#exampleFrmDiv").outerWidth() + otherEl;
	});
	var tglSpan = ($("#imgDiv").is(":visible")) ? 'View Instructions' : 'View Example';
	$(".tgl").html(tglSpan);
}
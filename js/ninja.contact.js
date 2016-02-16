var captchaOk = true;
$(document).ready(function() {
	
	$(".g-recaptcha").each(function(){
		var $me = $(this);
		$.get("get.sitekey.php").done(function(data){
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
			'verify.captcha.php',$("#frmContactUs").serialize()
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
	
});
	
function checkOtherFields() {
	var validated = true;
	var objFields = {};
	$("#frmContactUs").find("select, input, textarea").each(function(){
		var attr = $(this).attr('name');
		if (typeof attr !== typeof undefined && attr !== false) {
			var attrP = $(this).attr('placeholder');
			if (typeof attrP !== typeof undefined && attrP !== false) {
				var dText = attrP;
			} else {
				var eid = $(this).attr('id');
				var dText = $("label[for='"+eid+"']").text();
			}
			if ($(this).val().length==0) {
				var action = ($(this).is('select')) ? 'select':'insert';
				alert('Please '+action+' the '+ dText);
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
				objFields[strFieldDesc].push(dText);
			} else { 
				objFields[strField] = $(this).val(); 
			}
			
		}
	});
	
	if (!validated) return;
	
	$("#reply").empty().append("Sending...");
	$.post(
		'submit.contact.php',
		objFields
	).done(function (data) {
		var json = $.parseJSON(data);
		console.log(json);
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
function postNewTopic() {
	$("#create").attr("disabled", "disabled");
	$.post("./?m=index&w=createNewTopic", {
		"cid": $("#talk-add #cid option:selected").val(),
		"pictures": $("#talk-add #pictureString").val(),
		"tempTid": $("#talk-add #tempTid").val(),
		"msg": $.trim($("#talk-add textarea[name=subject]").val())
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$("#create").attr("value", "创建成功，正在刷新...");
			window.setTimeout("window.location='index.php'", 1000)
		} else {
			$("#create").attr("value", data.message);
			$("#create").removeAttr("disabled");
			window.setTimeout("$(\"#create\").attr(\"value\",'创建新微文')", 1000)
		}
	})
}
function postReplyTopic() {
	$("#create").attr("disabled", "disabled");
	$.post("./?m=index&w=createNewReply", {
		"tid": $('#reply-add input[name=tid]').val(),
		"pictures": $("#reply-add #pictureString").val(),
		"msg": $.trim($('#reply-add textarea[name=subject]').val())
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$("#create").attr("value", "回复成功，正在刷新...");
			window.setTimeout("window.location='#reply-" + data.pid + "';", 1000);
			window.location.reload()
		} else {
			$("#create").attr("value", data.message);
			$("#create").removeAttr("disabled");
			window.setTimeout("$(\"#create\").attr(\"value\",'回复')", 1000)
		}
	})
}
function delTmpPicture(path, obj) {
	$.post("./?w=delTmpPicture", {
		"do": "delTmpPicture",
		"path": path
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			var newobj = $("#pictureString").val().replace(",\"" + path + "\"", "");
			var newobj = newobj.replace("\"" + path + ",\"", "");
			var newobj = newobj.replace("\"" + path + "\"", "");
			var newobj = newobj.replace("[]", "");
			$("#pictureString").val(newobj);
			$("#" + obj).hide()
		}
	})
}
function AtReply(username) {
	$("#post-newreply").show("fast");
	$("#reply-add textarea[name=subject]").focus();
	$('#reply-add textarea[name=subject]').val($('#reply-add textarea[name=subject]').val().replace("@" + username + " ", "") + "@" + username + " ");
	$('#reply-add textarea[name=subject]').focusEnd()
}
function trash(id, type) {
	$.post("./?m=admin&w=trash", {
		"tid": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			if (type == 0) {
				$("#topic-" + id).slideUp(300, function() {
					$(this).remove()
				})
			} else {
				window.location.reload()
			}
		}
	})
}
function commend(id) {
	$.post("./?m=index&w=doCommend", {
		"tid": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			window.location.reload()
		}
	})
}
function favorite(id) {
	$.post("./?m=index&w=doFavorite", {
		"tid": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			window.location.reload()
		}
	})
}
function setPassword() {
	if ($('#password-form #newPassword').val() == '' || $('#password-form #password').val() == '' || $('#password-form #reNewPassword').val() == '') {
		$("#password-form #password").focus();
		$("#password-setting-button").attr("value", "密码不能为空");
		window.setTimeout("$(\"#password-setting-button\").attr(\"value\",'保存')", 1000);
		return false
	}
	if ($('#password-form #newPassword').val() != $('#password-form #reNewPassword').val()) {
		$("#password-form #newPassword").focus();
		$("#password-setting-button").attr("value", "两次密码不一样");
		window.setTimeout("$(\"#password-setting-button\").attr(\"value\",'保存')", 1000);
		return false
	}
	$("#password-setting-button").attr("disabled", "disabled");
	$.post("./?m=setting&w=setPassword", {
		"currentPasswd": $('#password-form #password').val(),
		"userPasswd": $('#password-form #newPassword').val()
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$("#password-setting-button").attr("value", data.message);
			$('#password-setting-button').removeAttr("disabled");
			$('#password-form #password').val('');
			$('#password-form #newPassword').val('');
			$('#password-form #reNewPassword').val('');
			window.setTimeout("$(\"#password-setting-button\").attr(\"value\",'保存')", 1000)
		} else {
			$("#password-setting-button").attr("value", data.message);
			$('#password-setting-button').removeAttr("disabled");
			if (data.position == 1) {
				$("#password-form #password").focus()
			}
			if (data.position == 2) {
				$("#password-form #email").focus()
			}
			window.setTimeout("$(\"#password-setting-button\").attr(\"value\",'保存')", 1000)
		}
	})
}
function setSignature() {
	$("#signature-setting-button").attr("disabled", "disabled");
	$.post("./?m=setting&w=setSignature", {
		"signature": $("#signature-form #signature").val()
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$("#signature-setting-button").attr("value", data.message);
			$("#signature-setting-button").removeAttr("disabled");
			window.setTimeout("$(\"#signature-setting-button\").attr(\"value\",'保存')", 1000)
		} else {
			$("#signature-setting-button").attr("value", data.message);
			window.setTimeout("$(\"#signature-setting-button\").attr(\"value\",'保存')", 1000);
			$("#signature-form #signature").focus();
			$("#signature-setting-button").removeAttr("disabled")
		}
	})
}
function setEmail() {
	$("#email-setting-button").attr("disabled", "disabled");
	$.post("./?m=setting&w=setEmail", {
		"password": $('#email-form #password').val(),
		"email": $('#email-form #email').val()
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$("#email-setting-button").attr("value", data.message);
			$('#email-setting-button').removeAttr("disabled");
			$('#email-form #password').val('');
			window.setTimeout("$(\"#email-setting-button\").attr(\"value\",'保存')", 1000)
		} else {
			$("#email-setting-button").attr("value", data.message);
			$('#email-setting-button').removeAttr("disabled");
			if (data.position == 1) {
				$("#email-form #password").focus()
			}
			if (data.position == 2) {
				$("#email-form #email").focus()
			}
			window.setTimeout("$(\"#email-setting-button\").attr(\"value\",'保存')", 1000)
		}
	})
}
function follow(id) {
	$.post("./?m=user&w=doFollow", {
		"uid": id,
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$('#follow').text(data.text);
			alertMessage(data.message)
		} else {
			alertMessage(data.message)
		}
	})
}
function ban(id) {
	$.post("./?m=admin&w=ban", {
		"uid": id,
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$('#ban').text(data.text);
			$("#groupname").text(data.groupname);
			$('#groupIdImg').attr("src", "themes/default/images/" + data.now + ".gif");
			alertMessage(data.message)
		} else {
			alertMessage(data.message)
		}
	})
}
function whisper() {
	var touid = $('#touid').val(),
		content = $.trim($('#content').val());
	if (content == '') {
		$('#whisper_submit').attr("value", "内容不能为空！");
		window.setTimeout("$(\"#whisper_submit\").attr(\"value\",'发送')", 1000);
		return false
	}
	$.post("./?m=user&w=deliverWhisper", {
		"tid": touid,
		"msg": content
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$('#whisper_submit').attr("value", data.message);
			$('#content').val('');
			window.setTimeout("window.location='?m=user&w=whisper&status=2'", 1000)
		} else {
			$('#whisper_submit').attr("value", data.message);
			window.setTimeout("$(\"#whisper_submit\").attr(\"value\",'发送')", 1000)
		}
	})
}
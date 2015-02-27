function showTopicForm() {
	$("#post-newtopic").toggle('fast');
	$("#talk-add textarea[name=subject]").focus();
}
function showReplyForm() {
	$("#post-newreply").toggle('fast');
	$("#reply-add textarea[name=subject]").focus();
}
function alertMessage(msg) {
	$(".alert-messages .message .message-text").html(msg);
	$(".alert-messages").fadeIn();
	setTimeout('$(".alert-messages").fadeOut()', 2000)
}
function alertConfirm(msg) {
	$(".alert-confirms .confirm .confirm-text #confirm-it").attr("href", "javascript:closeAlert();" + msg + ";");
	$(".alert-confirms").fadeIn();
	setTimeout('$(".alert-confirms").fadeOut()', 5000)
}
function closeAlert() {
	$(".alert-confirms").fadeOut()
}
function locationHash() {
	var h = window.location.hash;
	if (h.substring(0, 6) == "#reply") {
		$("html,body").animate({
			scrollTop: $("#reply-" + h.substr(7)).offset().top - 200
		}, 1000)
	}
}
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
			alertMessage(data.message);
			$("#post-newtopic").toggle("fast");
			window.setTimeout("window.location='index.php'", 1000)
		} else {
			alertMessage(data.message);
			$("#create").removeAttr("disabled")
		}
	})
}
function postExam(){

    $.post("index.php?w=exam",
            $("#mainform").serialize()
        ,function(data){
            data = eval("(" + data + ")");
            if(data.result == "success")
            {

                var id = $("#id").val();
                //$('#eqnum').val(parseInt($('#eqnum').val())+1);
                var nexteqnum = parseInt($('#eqnum').val())+1;
                //alert(11111111);
                $("#tid").val(data["tid"]);
                $("#tdtt").val(data["tdtt"]);
                //alert(nextid);
                var url = 'index.php?w=exam&id='+ id +'&flag=next&eqnum='+nexteqnum;
                if(data["ISShowReason"]>0)
                {
                    $("#JudgeResultDiv").html(data["JudgeResult"]);
                    $("#OptionReasonDiv").html('<p><strong>解析：</strong></p><p>'+ data["OptionReason"] +'</p>');
                    $("#mainFormBtn").hide();
                    $("#mainFormNextBtn").attr("href", url).show();
                }
                else
                {
                    window.location.href = url;
                }
            }
        }
    )
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
			alertMessage(data.message);
			$("#post-newreply").toggle('fast');
			if ($("#reply-add #pictureString").val() == "") {
				$(".topicUl").append("<li id=\"reply-" + data.pid + "\" class=\"topic\"><div class=\"name\"><a class=\"avatar\" href=\"./index.php?m=user\"><img class=\"replyavatar\" src=\"" + $(".side-user .avatar").attr("src") + "\"></a></div><div class=\"post\"><div class=\"container\"><span class=\"org_box_cor\"></span><span class=\"org_box_cor_s\"></span><span class=\"author\">" + $(".side-user .avatar").attr("title") + "</span><span class=\"time\">刚刚</span><div class=\"post-info\"><span class=\"right\">楼顶</span></div><div class=\"topic-content\">" + $.trim($('#reply-add textarea[name=subject]').val()) + "</div></div></div><div class=\"clear\"></div></li>");
				$("#reply-add #pictureString").val("");
				$.trim($('#reply-add textarea[name=subject]').val(""));
				window.setTimeout("window.location='#reply-" + data.pid + "';", 1000)
			} else {
				window.setTimeout("window.location='#reply-" + data.pid + "';", 1000);
				window.location.reload()
			}
		} else {
			alertMessage(data.message);
			$("#create").removeAttr("disabled")
		}
	})
}
function editTopic(id) {
	$.post("./?m=index&w=getTopicFullContent", {
		"id": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$("#post-newtopic").show('fast');
			$("#talk-add #tempTid").val(id);
			$("#talk-add #cid option").each(function(){
			   if($(this).text() === $("#topic-"+id+" #clubname").text()){
			      $(this).attr('selected', 'selected');
			   }
			});
			$("#talk-add textarea[name=subject]").focus();
			$("#talk-add textarea[name=subject]").val(data.message);
			$("#create").html('保存');
		} else {
			alertMessage(data.message)
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
			alertMessage("删除成功");
			var newobj = $("#pictureString").val().replace(",\"" + path + "\"", "");
			var newobj = newobj.replace("\"" + path + ",\"", "");
			var newobj = newobj.replace("\"" + path + "\"", "");
			var newobj = newobj.replace("[]", "");
			$("#pictureString").val(newobj);
			$("#" + obj).hide()
		} else {
			alertMessage(data.message)
		}
	})
}
function commend(id) {
	$.post("./?m=index&w=doCommend", {
		"tid": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			if ($(".right-admin #commend").attr("class") == "commended") {
				$(".right-admin #commend").attr("class", "commend");
				$(".topicBottom img[title=" + $(".side-user .avatar").attr("title") + "]").remove()
			} else {
				$(".right-admin #commend").attr("class", "commended");
				$(".right-admin").after("<a href=\"index.php?m=user\" rel=\"nofollow\"><img src=\"" + $(".side-user .avatar").attr("src") + "\" title=\"" + $(".side-user .avatar").attr("title") + "\" alt=\"" + $(".side-user .avatar").attr("title") + "\" class=\"avatarC\"></a>")
			}
		} else {
			alertMessage(data.message)
		}
	})
}
function favorite(id) {
	$.post("./?m=index&w=doFavorite", {
		"tid": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			if ($(".right-admin #favorite").attr("class") == "favorited") {
				$(".right-admin #favorite").attr("class", "favorite")
			} else {
				$(".right-admin #favorite").attr("class", "favorited")
			}
		} else {
			alertMessage(data.message)
		}
	})
}
function trash(id, type) {
	$.post("./?m=admin&w=trash", {
		"tid": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			if (type == 0) {
				$("#topic-" + id).slideUp(300, function() {
					$(this).remove();
					alertMessage("删除成功")
				})
			} else {
				window.location.reload()
			}
		} else {
			alertMessage(data.message)
		}
	})
}
function delReply(id) {
	$.post("./?m=admin&w=delReply", {
		"pid": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			$(".close").click();
			$("#reply-" + id).slideUp(300, function() {
				$(this).remove();
				alertMessage(data.message)
			})
		} else {
			$(".close").click();
			alertMessage(data.message)
		}
	})
}
function doTop(id) {
	$.post("./?m=admin&w=doTop", {
		"tid": id
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			alertMessage(data.message);
			if ($(".right-admin #top").attr("class") == "dotop") {
				$(".right-admin #top").attr("class", "dotoped")
			} else {
				$(".right-admin #top").attr("class", "dotop")
			}
		} else {
			alertMessage(data.message)
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
	    content =$.trim($('#content').val());
	if (content == '') {
		alertMessage('内容不能为空!');
		return false;
	}
	$.post("./?m=user&w=deliverWhisper", {
		"tid": touid,
		"msg": content
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			alertMessage(data.message);
			$('#content').val('');
			window.setTimeout("window.location='?m=user&w=whisper&status=2'",1000); 
		} else {
			alertMessage(data.message);	
		}
	});
}
function AtReply(username) {
	$("#post-newreply").show("fast");
	$("#reply-add textarea[name=subject]").focus();
	$('#reply-add textarea[name=subject]').val($('#reply-add textarea[name=subject]').val().replace("@" + username + " ", "") + "@" + username + " ");
	$('#reply-add textarea[name=subject]').focusEnd()
}
function setEmail() {
	$("#email-setting-button").attr("disabled", "disabled");
	$.post("./?m=setting&w=setEmail", {
		"password": $('#email-form #password').val(),
		"email": $('#email-form #email').val()
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			alertMessage(data.message);
			$('#email-setting-button').removeAttr("disabled");
			$('#email-form #password').val('')
		} else {
			alertMessage(data.message);
			$('#email-setting-button').removeAttr("disabled");
			if (data.position == 1) {
				$("#email-form #password").focus()
			}
			if (data.position == 2) {
				$("#email-form #email").focus()
			}
		}
	})
}
function setPassword() {
	if ($('#password-form #newPassword').val() == '' || $('#password-form #password').val() == '' || $('#password-form #reNewPassword').val() == '') {
		$("#password-form #password").focus();
		alertMessage("密码不能为空");
		return false
	}
	if ($('#password-form #newPassword').val() != $('#password-form #reNewPassword').val()) {
		$("#password-form #newPassword").focus();
		alertMessage("两次密码不一样");
		return false
	}
	$("#password-setting-button").attr("disabled", "disabled");
	$.post("./?m=setting&w=setPassword", {
		"currentPasswd": $('#password-form #password').val(),
		"userPasswd": $('#password-form #newPassword').val()
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			alertMessage(data.message);
			$('#password-setting-button').removeAttr("disabled");
			$('#password-form #password').val('');
			$('#password-form #newPassword').val('');
			$('#password-form #reNewPassword').val('')
		} else {
			alertMessage(data.message);
			$('#password-setting-button').removeAttr("disabled");
			if (data.position == 1) {
				$("#password-form #password").focus()
			}
			if (data.position == 2) {
				$("#password-form #email").focus()
			}
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
			alertMessage(data.message);
			$("#signature-setting-button").removeAttr("disabled")
		} else {
			alertMessage(data.message);
			$("#signature-form #signature").focus();
			$("#signature-setting-button").removeAttr("disabled")
		}
	})
}
function addClub() {
	$.post("./?m=admin&w=addClub", {
		"cid": $("#club-form input[name=cid]").val(),
		"clubname": $("#club-form input[name=clubname]").val(),
		"position": $("#club-form input[name=position]").val(),
        "schoolid":$("#club-form input[name=schoolid]").val()
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			resetForm();
			alertMessage(data.message);
			window.setTimeout("window.location.reload()", 1000)
		} else {
			alertMessage(data.message)
		}
	})
}
function addLink() {
	$.post("./?m=admin&w=addLink", {
		"url": $("#link-form input[name=linkurl]").val(),
		"text": $("#link-form input[name=linkname]").val(),
		"position": $("#link-form input[name=linkposition]").val(),
		"exist": $("#link-form input[name=exist]").val()
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			resetForm();
			alertMessage(data.message);
			window.setTimeout("window.location.reload()", 1000)
		} else {
			alertMessage(data.message)
		}
	})
}
function editClub(cid, clubname, position) {
	$("#club-form input[name=cid]").val(cid);
	$("#club-form input[name=clubname]").val(clubname);
	$("#club-form input[name=position]").val(position);
	$("#addClub").text("保存")
}
function editLink(position, text, url) {
	$("#link-form input[name=linkposition]").val(position);
	$("#link-form input[name=linkname]").val(text);
	$("#link-form input[name=linkurl]").val(url);
	$("#link-form input[name=exist]").val("1");
	$("#addLink").text("保存")
}

function banClub(cid,position) {
	$.post("./?m=admin&w=banClub", {
		"cid": cid,
		"position": position,
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			alertMessage(data.message);
			window.setTimeout("window.location.reload()", 1000)
		} else {
			alertMessage(data.message)
		}
	})
}
function delLink(id){
	$.post("./?m=admin&w=delLink", {
		"position": id,
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			alertMessage(data.message);
			window.setTimeout("window.location.reload()", 1000)
		} else {
			alertMessage(data.message)
		}
	})
}
function moveTopic() {
	var cid = $(this).attr("data");
	$.post("./?m=admin&w=moveTopic", {
		"tid": $(".move-club").attr("topicdata"),
		"cid": cid
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			alertMessage(data.message);
			window.setTimeout("window.location.reload()", 1000);
		} else {
			alertMessage(data.message);
		}
	});
}
function topicAction() {
	$(".move-topic").hover(function() {
		$(".move-club").slideDown(150);
	}, function() {
		$(".move-club").slideUp(150);
	});
	$(".move-club li").click(moveTopic);
}
function resetForm() {
	$("#club-form input[name=cid]").val("");
	$("#club-form input[name=clubname]").val("");
	$("#club-form input[name=position]").val("");
	$("#link-form input[name=linkname]").val("");
	$("#link-form input[name=linkurl]").val("");
	$("#link-form input[name=linkposition]").val("");
	$("#link-form input[name=exist]").val("0");
	$("#addClub").text("添加")
}
function ClearCache(){
	$.post("./?m=admin&w=ClearCache", {
		"do": "template",
	}, function(data) {
		data = eval("(" + data + ")");
		if (data.result == "success") {
			alertMessage(data.message);
		} else {
			alertMessage(data.message)
		}
	})
}
function search(){
	if( $("#searchWord").val().length >= 2 && $("#searchWord").val().length <= 15) {
		window.location='?w=search&s='+$("#searchWord").val();
	} else {
		alertMessage("搜索的字符长度不能少于2大于15！");
	}
}
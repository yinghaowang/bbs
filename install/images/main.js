$(document).ready(function(e) {
	$(document).keydown(function (e) {
		var doPrevent;
		if (e.keyCode == 8) {
			var d = e.srcElement || e.target;
			if (d.tagName.toUpperCase() == 'INPUT' || d.tagName.toUpperCase() == 'TEXTAREA')
				doPrevent = d.readOnly || d.disabled;
			else
				doPrevent = true;
		}
		else doPrevent = false;
		if (doPrevent) e.preventDefault();
	}); 
    $('#no1').css({'left':$(window).width()/2-$('#no1').outerWidth()/2+'px',top:$(window).height()/2-$('#no1').outerHeight()/2+'px'}).fadeIn(300, function() {
		setTimeout(function() {
			$('#no1').fadeOut(300, function() {
				$('#no2').css({'left':$(window).width()/2-$('#no2').outerWidth()/2+'px','top':$(window).height()/2-$('#no2').outerHeight()/2+'px'}).fadeIn(300, function() {
					setTimeout(function() {
						$('#no2').animate({
							'top':'30px',
							'left':$(window).width()/2-$('#no2').outerWidth()/2+'px',
							'font-size':'37px'
						}, 300, function() {
							$('#no2').hide();
							$('#no3').show();
							$('#no3').text($('#no3').text()+'安');
							setTimeout(function() {
								$('#no3').text($('#no3').text()+'装');
								setTimeout(function() {
									$('#no3').text($('#no3').text()+'向');
									setTimeout(function() {
										$('#no3').text($('#no3').text()+'导');
										$('#license').slideDown(500);
									}, 50);
								}, 50);
							}, 50);
						});
					}, 500);
				});
			});
		}, 500);
	});
	// --- BUTTON ---
	$('.button').on('mouseenter', function() {
		$(this).css({'opacity':'.6'});
	}).on('mouseleave', function() {
		$(this).css({'opacity':'1','background-color':'#FAFAFA','color':'#333'});
	}).on('mousedown', function() {
		$(this).css({'background-color':'#333','color':'#FFF','opacity':'1'});
	}).on('mouseup', function() {
		$(this).css({'background-color':'#FAFAFA','color':'#333','opacity':'.6'});
	});
	// --- 许可协议 --- STEP 1 ---
	$('#licenseCancelBtn').on('click', function() {
		if(confirm('拒绝协议将终止安装程序，确定拒绝吗？')) {
			window.location.href='https://www.rocboss.com';
		}
	});
});

// --- 环境检测 --- STEP2 ---
var step2goon = true;
var step2LIST = ['JSON Support', 'PHP_VERSION', 'MySQLi Support', 'mysql_connect Support', 'file_get_contents Support', 'CURL Support', 'Write test of "cache" folder', 'Write test of "uploads" folder', 'Write test of "install" folder'];
function goStep2() {
	$('#license').slideUp(300, function() {
		step2Timer = setInterval(function() {
			if($('#step2cur').text()=='_') $('#step2cur').text(' ');
			else $('#step2cur').text('_');
		}, 500);
		$(document).on('keydown.step2', function(event) {
			if((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode == 32)) {
				$('#step2cur').before(String.fromCharCode(event.keyCode).toLowerCase().replace(/ /,'&nbsp;'));
			} else if(event.keyCode == 13) {
				$('#step2cur').before('<br />&gt;');
				setTimeout("$('#step2>div').scrollTop($('#step2>div')[0].scrollHeight+20)", 100);
			}
		});
		$('#step2').on('mouseenter', function(e) {
			$('#cursor').show().css({'left':e.pageX-$('#step2').offset().left+'px','top':e.pageY-$('#step2').offset().top+'px'});
		}).on('mousemove', function(e) {
			$('#cursor').css({'left':e.pageX-$('#step2').offset().left+'px','top':e.pageY-$('#step2').offset().top+'px'});
		}).on('mouseleave', function(e) {
			$('#cursor').hide();
		});
		$('#step2').on('mouseenter', 'a', function() {
			$('#cursor').hide();
		}).on('mouseleave', 'a', function() {
			$('#cursor').show();
		});
		$('#cursor').on('mousemove', function(e) {
			$(this).show().css({'left':e.pageX-$('#step2').offset().left+'px','top':e.pageY-$('#step2').offset().top+'px'});
		});
		$('#step2').fadeIn(300, function() {
			// --- 检测 LIST ---
			setTimeout('step2Check(0)', 1000);
		});
	});
}
function step2Check(k) {
	$('#step2cur').before(step2LIST[k]+'...');
	setTimeout(function() {
		$.ajax({type:'POST',url:'step2.ajax.php',cache:false,
			data: {ac: step2LIST[k]},
			success: function(j) {
				j = $.parseJSON(j);
				if(j.result != '1') step2goon = false;
				$('#step2cur').before(j.msg);
				setTimeout("$('#step2>div').scrollTop($('#step2>div')[0].scrollHeight+20)", 100);
				if(step2LIST[k+1]) {
					step2Check(k+1);
				} else {
					if(step2goon) {
						$('#step2cur').before('Loading GUI...');
						setTimeout("$('#step2>div').scrollTop($('#step2>div')[0].scrollHeight+20)", 100);
						setTimeout(function() {
							goStep3();
						}, 800);
					} else {
						$('#step2cur').before('安装向导终止，请检查错误的项目。');
					}
				}
			},
			error: function() {
				$('#step2cur').before('<br />网络连接失败，安装向导终止。');
			}
		});
	}, 50);
}
// --- 打开 GUI --- STEP3 ---
function goStep3() {
	$(document).off('keydown.step2');
	clearInterval(step2Timer);
	$('#no3').fadeOut(300);
	$('#step2').fadeOut(300, function() {
		$('#guiBgLogo').css({'left':$(window).width()/2-$('#guiBgLogo').outerWidth()/2+'px',top:$(window).height()/2-$('#guiBgLogo').outerHeight()/2+'px'}).fadeIn(300, function() {
			$('#guiBgLogo').animate({width:'300px',left:$(window).width()/2-280/2+'px'},300,function() {
				setTimeout(function() {
					$('#window').css({'left':$(window).width()/2-$('#window').outerWidth()/2+'px',top:$(window).height()/2-$('#window').outerHeight()/2+'px','opacity':'0'}).show().animate({opacity:.9},300,function() {
						$('#window').draggable({
							handle: '#windowTitle',
							containment: 'window'
						});
						// --- 下一步按钮 ---
						$('#windowControlNextBtn').on('click', function() {
							$('#window').fadeOut(300, function() {
								$('#progressBar').css({'left':$(window).width()/2-$('#progressBar').outerWidth()/2+'px',top:$('#guiBgLogo').offset().top+100+'px'}).show();
								$('#progressBarDiv').css({'width':'0%'}).animate({width:'75%'}, 2000);
								// --- 连接 MYSQL ---
								$.ajax({type:'POST',url:'step3.ajax.php',cache:false,
									data: $('#step3').find('input').serialize(),
									success: function(j) {
										j = $.parseJSON(j);
										if(j.result == '1') {
											$('#progressBarDiv').stop().animate({width:'100%'}, 300, function() {
												$('#window').fadeIn(300);
												$('#progressBar').hide();
												goStep4();
											});
										} else {
											alert(j.msg);
											$('#window').fadeIn(300);
											$('#progressBar').hide();
										}
									},
									error: function() {
										alert('网络连接失败，安装向导终止。');
									}
								});
							});
						});
						// --- 回车自动下一步 ---
						$('#step3').find('input[type="text"]').on('keypress', function(e) {
							if(e.keyCode == 13) {
								$('#windowControlNextBtn').trigger('click');
							}
						});
					});
				}, 500);
			});
		});
	});
}
// --- 准备就绪 --- STEP 4 ---
function goStep4() {
	$('#step3').hide();
	$('#step4').show();
	$('#windowControlNextBtn').val('开始安装').off('click').on('click', function() {
		$('#window').fadeOut(300, function() {
			$('#progressBar').css({'left':$(window).width()/2-$('#progressBar').outerWidth()/2+'px',top:$('#guiBgLogo').offset().top+100+'px'}).show();
			$('#progressBarDiv').css({'width':'0%'}).animate({width:'75%'}, 6000);
			setTimeout(function() {
				// --- 开始安装 ---
				$.ajax({type:'GET',url:'step4.ajax.php',cache:false,
					success: function(j) {
						j = $.parseJSON(j);
						if(j.result == '1') {
							$('#progressBarDiv').stop().animate({width:'100%'}, 1000, function() {
								$('#window').fadeIn(300);
								$('#progressBar').hide();
								goStep5();
							});
						} else {
							$('#progressBarDiv').css({'background-color':'#F00'}).stop();
							$('#progressBar').css({'border':'solid 1px #F00'});
							alert(j.msg);
							$('#progressBarDiv').animate({width:'+=10%'}, 200);
						}
					},
					error: function() {
						alert('网络连接失败，安装向导终止。');
					}
				});
			}, 2000);
		});
	});
}
// --- 信息配置 --- STEP 5 ---
function goStep5() {
	$('#step4').hide();
	$('#step5').show();
	$('#windowControlNextBtn').val('下一步').off('click').on('click', function() {
		$('#window').fadeOut(300, function() {
			$('#progressBar').css({'left':$(window).width()/2-$('#progressBar').outerWidth()/2+'px',top:$('#guiBgLogo').offset().top+100+'px'}).show();
			$('#progressBarDiv').css({'width':'0%'}).animate({width:'75%'}, 2000);
			$.ajax({type:'POST',url:'step5.ajax.php',cache:false,
				data: $('#step5').find('input').serialize(),
				success: function(j) {
					j = $.parseJSON(j);
					if(j.result == '1') {
						$('#progressBarDiv').stop().animate({width:'100%'}, 300, function() {
							$('#window').fadeIn(300);
							$('#progressBar').hide();
							goStep6();
						});
					} else {
						alert(j.msg);
						$('#window').fadeIn(300);
						$('#progressBar').hide();
					}
				},
				error: function() {
					alert('网络连接失败，安装向导终止。');
				}
			});
		});
	});
}
// --- 完成 --- STEP 5 ---
function goStep6() {
	$('#step5').hide();
	$('#step6').show();
	$('#windowControlNextBtn').val('完成安装').off('click').on('click', function() {
		window.location="../";
	});
}
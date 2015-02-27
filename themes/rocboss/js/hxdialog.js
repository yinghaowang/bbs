var _hxdialog_count = 0,_hxdialog_expando = new Date() - 0,_hxdialog_isIE6 = !('minWidth' in $('html')[0].style),
HXDialogMask ='<div class="HXDialogMask"></div>',
HXDialogDivCss = 
'<style type="text/css">' +
	'.HXDialogMask{display:none;top:0;left:0;filter:Alpha(Opacity=30);opacity:0.3;background-color:#000000;z-index:998;}' +
	'.HXDialogPop{display:none;z-index:999;border-radius:6px;border:1px solid #999999;background:#f1f1f1;}' +
	'.HXDialog{background:#f1f1f1;border-radius:6px;}' +
	'.HXDialogTitleBar{position:relative;border-bottom:1px solid #E5E5E5;}' +
	'.HXDialogTitle{color:#666;font-family:微软雅黑;font-size:20px;font-weight:bold;padding:10px;display:block;overflow:hidden;}' +
	'.HXDialogTitleBtn{right:5px;top:3px;cursor:pointer;position:absolute;}' +
	'.HXDialogColose{color:#000000;font-size:22px;width:22px;text-decoration:none;display:inline-block;font-family:tahoma,arial,宋体,sans-serif;position:relative;text-align:center;opacity:0.2;filter:alpha(opacity=20)}' +
	'.HXDialogColose:hover{color:#000000;text-decoration:none;cursor:pointer;outline:0;opacity:0.5;filter:alpha(opacity=50);}' +
	'.HXDialogCont{padding:15px;font:12px tahoma,arial,宋体,sans-serif;}' +
	'.HXDialogBtnBar{padding: 4px 8px;text-align: right;}' +
	'.HXDialogBtn{display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: normal;line-height: 1.428571429;text-align: center;white-space: nowrap;vertical-align: middle;cursor: pointer;background-image: none;border: 1px solid transparent;border-radius: 4px;}' +
	'.HXDialogBtn:hover,.HXDialogBtn:focus {color: #333333;text-decoration: none;}' +
	'.HXDialogBtn-default{color: #333333;background-color: #ffffff;border-color: #cccccc;}' +
	'.HXDialogBtn-default:hover,.HXDialogBtn-default:focus,.HXDialogBtn-default:active,.HXDialogBtn-default.active{color: #333333;background-color: #ebebeb;border-color: #adadad;}' +
	'.HXDialogBtn-success{color: #ffffff;background-color: #5cb85c;border-color: #4cae4c;}' +
	'.HXDialogBtn-success:hover,.HXDialogBtn-success:focus,.HXDialogBtn-success:active,.HXDialogBtn-success.active{color: #ffffff;background-color: #47a447;border-color: #398439;}' +
'</style>',
HXDialogDivTpl =
'<div class="HXDialogPop"><div class="HXDialog">' +
	'<div class="HXDialogTitleBar">' +
		'<div class="HXDialogTitle"></div>' +
		'<div class="HXDialogTitleBtn"><a class="HXDialogColose" href="javascript:void(0);" title="关闭" data-btnid="close">×</a></div>' +
	'</div>' +
	'<div class="HXDialogCont"></div>' +
	'<div class="HXDialogBtnBar"></div>' +
'</div></div>',
HXDialogDefaultSetting =
{
	title: '\u63d0\u793a', 
	content: '<div class="HXDialogLoad"><span><img src="http://www.houxue.com/images/loading.gif" style="vertical-align:top;"> 请等待...</span></div>',
	contentAjax: {type:'get', url:'', data:'', onsuccess:'' },
	width: 'auto',
	height: 'auto',
	left: '50%',
	top: '30%',
	mask: true,					// 是否显示底层罩
	fixed: false,				// 是否静止定位
	esc: true,					// 是否支持Esc键关闭
	show: true,					// 初始化后是否显示对话框
	time:0,						// 显示时间 秒
	zIndex: 999,				// 对话框叠加高度值
	drag: true 					// 是否允许用户拖动位置
};

var HXDialogItem = function (options){this.initialize(options);};
HXDialogItem.prototype = {
	initialize : function(options) {
		_hxdialog_count++;
		this.options = options;
		this._mask();
		this.DialogDiv = $(HXDialogDivTpl);
		this.DialogDiv.appendTo('body').css("z-index",HXDialog.defaultSetting.zIndex+_hxdialog_count);
		this.title(options.title).content(options.content).contentajax(options.contentAjax).button().time(options.time).size(options.width,options.height).position(options.left,options.top);
		this._addEvent();
		return this;
	},
	show : function() { 
		if(this.options.mask) $(".HXDialogMask").show();
		this.DialogDiv.fadeIn();
		return this;
	},
	close : function() {
		_hxdialog_count--; _hxdialog_count = _hxdialog_count>0 ? _hxdialog_count : 0;
		if(this.options.mask && _hxdialog_count<1) $(".HXDialogMask").hide();
		this.DialogDiv.remove();
		HXDialog.list[this.options.id]=undefined;
		clearInterval(this.timer);
		return this;
	},
	time : function(time) {
		var that = this;
		if(time) {																	//setTimeout(function(){that.close();},time*1000);
			var fn = function () {that.title(time + '秒后关闭'); !time && that.close(); time --;};
			this.timer = setInterval(fn, 1000); fn();
		}
		return this;
	},
	title : function(text) { 
		if( text === undefined ) return this;
		if( text === false ) {this.DialogDiv.find(".HXDialogTitleBar").hide();return this;}
		this.DialogDiv.find(".HXDialogTitle").html('&nbsp;' + text);
		return this;
	},
	content : function(text) { 
		this.DialogDiv.find(".HXDialogCont").html(text);
		return this;
	},
	contentajax : function(d) {
		if(d.url){
			var that = this;
			currentAjax = $.ajax({
				type: d.type, url: d.url,	data: d.data, cache : false,	beforeSend: function(){  },
				success: function(data){	that.content(data);	var fn = d.onsuccess;	typeof fn !== 'function' || fn.call(this) !== false ? '' : this;	},
				timeout:30000,	error: function(data){	currentAjax.abort();	alert("网络超时");	}
			});
		}
		return this;
	},
	size : function(width,height) { 
		this.DialogDiv.css({"width":width + "px", "height":height + "px"});
		return this;
	},
	button : function()
	{
		var that = this,buttons=this.options.button,html='';
		that.callbacks = {};
		if ($.isArray(buttons))
		{
			$.each(buttons, function (i, val) {
				val.id = val.id || val.name;
				that.callbacks[val.id] = val.callback;
				html +='<button type="button" data-btnid="' + val.id + '" class="HXDialogBtn '+ (val.focus ? 'HXDialogBtn-success' : 'HXDialogBtn-default') +' ">' + val.name + '</button>&nbsp;';
			 });
			this.DialogDiv.find(".HXDialogBtnBar").html(html);
		}
		return this;
	},
	focus: function()
	{
		HXDialog.defaultSetting.zIndex++;
		this.DialogDiv.css("z-index",HXDialog.defaultSetting.zIndex);
		return this;
	},
	shake: function()
	{
		box_left = this.DialogDiv.offset().left;
		for(var i=1; 4>=i; i++){
			this.DialogDiv.animate({left:box_left-(40-10*i)},50).animate({left:box_left+2*(40-10*i)},50);
		}
		return this;
	},
	position : function(left,top) {
		var isFixed = _hxdialog_isIE6 ? false : this.options.fixed,
			ie6Fixed = _hxdialog_isIE6 && this.options.fixed,
			docLeft = $(window).scrollLeft(),
			docTop = $(window).scrollTop(),
			ww = $(window).width(),
			wh = $(window).height(),
			dl = isFixed ? 0 : docLeft,
			dt = isFixed ? 0 : docTop,
			ow = this.DialogDiv.width(),
			oh = this.DialogDiv.height();

		if( left || left === 0 )
		{
			this._left = left;
			left = this._toNumber(left, ww - ow);
			if( typeof left === 'number' )
			{
				left = ie6Fixed ? (left += docLeft) : left + dl;
				left = Math.max(left,dl);
			}
			this.DialogDiv.css({"left":left + 'px'});
		}
		if( top || top === 0 )
		{
			this._top = top;
			top = this._toNumber(top, wh - oh);
			if( typeof top === 'number' )
			{
				top = ie6Fixed ? (top += docTop) : top + dt;
				top = Math.max(top,dt);
			}
			this.DialogDiv.css({"top":top + 'px'});
		}
		if( left !== undefined && top !== undefined ) this._autoPositionType();
		return this;
	},
	_toNumber: function( thisValue, maxValue )
	{
		if( isNaN(thisValue) )
		{
			if( thisValue.indexOf('%') !== -1 ) thisValue = parseInt(maxValue * thisValue.split('%')[0] / 100);else thisValue = parseInt(thisValue);	
		}
		return thisValue;
	},
	_autoPositionType : function(){
		this[this.options.fixed ? '_setFixed' : '_setAbsolute']();
	},
	_setFixed : function(){
		if( _hxdialog_isIE6 ) this._setAbsolute(); else this.DialogDiv.css({"position":"fixed"});
	},
	_setAbsolute : function(){	
		this.DialogDiv.css({"position":"absolute"});
	},
	_mask : function() { 
		if($(".HXDialogMask").length<=0) $(HXDialogMask).appendTo('body');
		if(_hxdialog_isIE6) $(".HXDialogMask").css({"position":"absolute","width":$(window).width(),"height":$(document).height()});
		 else	$(".HXDialogMask").css({"position":"fixed","width":$(window).width(),"height":$(window).height()});
	},
    _trigger: function (id) {
        var fn = this.callbacks[id];   
        return typeof fn !== 'function' || fn.call(this) !== false ? this.close() : this;
    },
	_addEvent : function(){
		var that=this;
		
		if(this.options.show) this.show();

		this.DialogDiv.click(function(event){
			that.focus();
			if ( $(event.target).data('btnid') ) that._trigger( $(event.target).data('btnid') );
		});

		if(this.options.esc)
		{
			$(window).keydown(function(event){
				if(event.keyCode==27){
					that.close();
					if (event && event.preventDefault) {//如果是FF下执行这个
						event.preventDefault();
					}else{
						window.event.returnValue = false;//如果是IE下执行这个
					} 
				}
			});
		}
		
		if(this.options.drag)
		{
			var $div = this.DialogDiv,_drag = false, dx, dy;
			$div.find(".HXDialogTitleBar").css("cursor","move").mousedown(function(e){
				_drag = true;
				that.focus();
				$div.css("opacity",0.8);
				dx = e.clientX - parseInt($div.css("left"));
				dy = e.clientY - parseInt($div.css("top"));
				$div.mousemove(function(e){
					if (_drag) {
						window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty(); // 禁止拖放对象文本被选择的方法
						document.body.setCapture && $div[0].setCapture();											// IE下鼠标超出视口仍可被监听
						
						win = $(window);
						if (e.clientX - dx < 0) {
							l = 0;
						}
						else 
							if (e.clientX - dx > win.width() - $div.width() -2) {
								l = win.width() - $div.width() -2;
							}
							else {
								l = e.clientX - dx
							}
						if (e.clientY - dy < 0) {
							t = 0;
						}
						else
							if(that.options.fixed && !_hxdialog_isIE6){
								if(e.clientY - dy > win.height()-$div.height()-2) t = win.height()-$div.height()-2;else t = e.clientY - dy;
							}
							else{
								if(e.clientY - dy > win.height() + win.scrollTop() - $div.height()-2) t = win.height() + win.scrollTop() -$div.height()-2;else t = e.clientY - dy;
							}
						$div.css({left:l,top:t});
					}
				}).mouseup(function(){
					_drag = false;
					document.body.releaseCapture && $div[0].releaseCapture();
					$div.css("opacity",1);
				});
			});
		}
		
//		if(this.options.fixed && _hxdialog_isIE6)											
//		{	
//			$(window).scroll(function() {
//				that.position(that._left,that._top);
//			});
//		}
//		$(window).resize( function(){that.position(that._left,that._top);} );	
	}

};

var HXDialog = function(options){
	options = options || {};
	options = $.extend(true, {}, HXDialog.defaultSetting, options);
	
	// 如果定义了id参数则返回存在此id的窗口对象
	options.id = options.id || (_hxdialog_expando + _hxdialog_count);
	api = HXDialog.list[options.id];
	if(api) {return api.focus();}
	
	return HXDialog.list[options.id] = new HXDialogItem( options );
};

//对象列表
HXDialog.list = {};
//默认设置
HXDialog.defaultSetting = HXDialogDefaultSetting;

document.write(HXDialogDivCss);
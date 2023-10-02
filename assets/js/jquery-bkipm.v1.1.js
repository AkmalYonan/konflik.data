/*
 * 	jQuery plugin - for BKIPM
 *	written by Gnemok (gnemok@gmail.com)
 *
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
/* Input Text In Out */
(function( $ ){
	$.fn.textinout = function( options ) {  
		var settings = {
			textDefault: 	"Search",
			openClick: 		true
		};
		var o = $.extend( settings, options );
		var elm = this;
		init();
		
		function init(){
			elm.val(o.textDefault);
			elm.parent().parent().prepend('<div class="searchbg"></div>');
			elm.focusin(function() {
				if ($(this).val()==o.textDefault){
					$(this).val("");
					$(".searchbg").html(o.textDefault);
					$(".searchbg").css("color","#ddd");
				}
				$(this).focusout(function() {
					if (elm.val().length==0){
						$(this).val(o.textDefault);
						$(".searchbg").html("");
						$(".searchbg").css("color","#fff");
					}
				});
			}).keyup(function() {
				if (elm.val().length>0){
					$(".searchbg").html("");
					$(".searchbg").css("color","#fff");
				}
				else {
					$(".searchbg").html(o.textDefault);
					$(".searchbg").css("color","#ddd");
				}
			})
		}
	}
})( jQuery );

/* Option selector */
(function( $ ){
	$.fn.opsel = function( options ) {  
		var settings = {
			textPlace: 		"#opt_text",
			valuePlace: 	"#so",
			textEmpty: 		"__________",
			speed:			"fast",
			openClick: 		true
		};
		var o = $.extend( settings, options );
		var opt = this;
		
		init();
		
		function init(){
			opt.find("ul li a").each(function() {
				if ($(this).attr("selected")!=undefined) {
					placeText($(this));	
				}
			});
			if (o.openClick) {
				outClick();
				opt.find("li > a, li > span").click(function() {
					opt.find("li ul").slideToggle(o.speed);
				});
			}
			else {
				opt.find("li").mouseover(function() {
					$(this).find("ul").show();	  
				}).mouseout(function() {
					$(this).find("ul").hide();	  
				})
				
			}
			opt.find("ul li a").click(function() {
				placeText($(this));				   
			});
		}
		
		function outClick() {
			$(document).click(function(event) { 
				if($(event.target).parents().index(opt) == -1) {
					opt.find("li ul:visible").slideUp(o.speed);
				}      
			})
		}
		
		function placeText(osel) {
			var value= osel.attr("rel");
			var text= (value)?osel.html():o.textEmpty;
			$(o.textPlace).html(text);
			$(o.valuePlace).val(value);
			$(o.valuePlace).parent().find("button").focus();
		}		
	}
})( jQuery );

/* Tabbing */
(function( $ ){
	$.fn.tabbing = function( options ) {  
		var settings = {
			loader: false,
			toggle: false,
			selected: 0,
			onShow: function(){}
		};
		var o = $.extend( settings, options );
		var tabid = '';
		var tn = this;
		var tn_content = $("#"+tn.attr('id')+"-content .tab_content");
		var tn_items = tn.find("ul li");
		var tn_count = tn_items.length;
		init();
		
		function init(){
			o.selected=(o.selected=='random')?Math.floor(Math.random()*tn_count):o.selected;
			tn_items.each(function() {
				var tab = $(this).find("a").attr("name");
				$(tab).hide();
				if ($(this).index()==o.selected) {
					var url = $(this).find("a").attr("href");
					if (o.loader) $(o.loader).css("display","block");
					$(this).addClass(tn.attr('id')+"-active");
					$(tab).load(url, function() {
						$(tab).show();
						o.onShow.call($(tab));
						if (o.loader) $(o.loader).css("display","none");
					});		 
				}
				else {
					//
				}
			})
			
			//clicked
			tn_items.click(function(event) {
				event.preventDefault(); 
				var activeTab = $(this).find("a").attr("name");
				var activeUrl = $(this).find("a").attr("href");
				if (activeTab) {
					tn_items.removeClass(tn.attr('id')+"-active");
					$(this).addClass(tn.attr('id')+"-active");
					if (activeTab==tabid) {
						if (o.toggle) {
							tn_content.hide();
							$(activeTab).hide();
							tn_items.removeClass(tn.attr('id')+"-active");
							tabid = '';
						}
					}
					else {
						//alert(tn_content.find(":visible").html());
						//tn_content.hide();
						if (o.loader) $(o.loader).css("display","block");
						$(activeTab).load(activeUrl, function() {
							$("#"+tn.attr('id')+"-content .tab_content:visible").fadeOut(function() {
								$(activeTab).show();	
								o.onShow.call($(activeTab));
								if (o.loader) $(o.loader).css("display","none");
							})
						});
						tabid = activeTab;
					}
				}
			});
		}
	}
})( jQuery );

/* Top Navigation */
(function( $ ){
	$.fn.topnav = function( options ) {  
		var settings = {
			openSpeed:		"slow",
			closeSpeed:		"fast",
			onShow: function(){}
		};
		var o = $.extend( settings, options );
		var tabid = '';
		var tn = this;
		var tn_items = tn.find("ul li");
		
		init();
		
		function init(){
			//tn.find(".text_content").hide();
			//tn.find(".text_container").hide();
			
			tn_items.click(function(event) {
				event.preventDefault(); 
				$(document).click(function(event) { 
					if($(event.target).parents().index(tn) == -1) {
						$(tabid).slideUp("fast", function() {
								tn_items.removeClass("tnactive");
								tn.find(".text_container").hide();
							});
						tabid = '';
					}  
				})
				var activeTab = $(this).find("a").attr("name");
				var activeUrl = $(this).find("a").attr("href");
				if (activeTab) {
					tn_items.removeClass("tnactive");
					$(this).addClass("tnactive");
					
					$(".text_content").slideUp();
					if (activeTab==tabid) {
						$(activeTab).slideUp(o.closeSpeed, function() {
							tn_items.removeClass("tnactive");
							tn.find(".text_container").hide();
						});
						tabid = '';
					}
					else {
						tn.find(".text_container").show();
						$(activeTab).load(activeUrl, function() {
							$(activeTab).slideDown(o.openSpeed);
							o.onShow.call($(activeTab));
						});
						tabid = activeTab;
					}
				}
			});
		}
	}
})( jQuery );

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

/* Rotator any Element (Realm) v1.02 - jQuery plugin */
(function( $ ){
	$.fn.realm = function( options ) {  
		var timer = null;
		var settings = {
			selected				: 0,
			continuous				: true,
			showData				: true,
			showNumberBar			: 1,
			dataContainer  			: false,
			onHoverStop				: true,
			slideShow				: false,
			slideInterval			: 5000,
			slideSpeed				: 100,
			slideEffect				: 'slide-horizontal',
			controlBar				: '',
			controlBarContainer  	: false,
			showControlBar			: true,
			showControlBarNum		: true,
			playAfterLoad			: true,
			showPlayPauseButton		: true,
			buttonPause				: '<img src="public/images/pause.gif" align="absmiddle">',
			buttonPlay  			: '<img src="public/images/play.gif" align="absmiddle">',
			slideEaseFunction		: "easeInOutExpo",
			onSlideEnd				: function(){}
		};
		var o = $.extend( settings, options );
		var elm = this;
		var elmID = elm.attr('id');
		var ulObj = $("ul",elm);
		var liObj = $("li",elm);
		var w = liObj.width();
		var h = liObj.height();
		var j = liObj.length;
		var controlID = elmID+'_controlbar';
		var dataID = elmID+'_data';
		var dataContainer = elm;
		init();
		function init() {
			o.selected=(o.selected=='random')?Math.floor(Math.random()*j):o.selected;
			if (j<2) {
				stoptimer();
				o.slideShow=false;
			}
			if (o.showControlBar) controlBar();
			if (o.showNumberBar) showNumberBar();
			if (o.showData) showData();
			if (o.onHoverStop) {
				elm.mouseover(function() {
					stoptimer();
				}).mouseout(function() {
					if (o.slideShow) settimer();
				})
				/*
				elm.bind("mousewheel",function(e) {
					alert(e.wheelDelta);
			   })*/
			}
			
			if (o.slideEffect=='slide-horizontal') {
				ulObj.css("width",w*j);
				liObj.css("float","left");
				setWrapper();
			}
			else if (o.slideEffect=='slide-vertical') {
				ulObj.css("height",h*j);
				//liObj.css("float","left");
				setWrapper();
			}
			else if (o.slideEffect=='fade') {
				liObj.css("position","absolute");
				liObj.hide();
				liObj.eq(o.selected).show();	
			}
			else if (o.slideEffect=='slide-open') {
				ulObj.css("position","relative");
				liObj.css({"position":"absolute","margin-left":"0px"});
				setWrapper();
			}
			else if (o.slideEffect=='slide-flip' || o.slideEffect=='slide-vertical-late') {
				ulObj.css("position","relative");
				liObj.css({"position":"absolute","margin-left":"0px"});
			}
			adjust();
		}
		
		function showData() {
			var i=0;
			var dataElm = elm.find("div.data").attr("id",dataID);

			if (o.dataContainer) {
				dataContainer=$(o.dataContainer);
				dataContainer.append(dataElm.clone());
				dataElm.remove();
			}
			dataContainer.find("div.data div").each(function() {
				if ($(this).parent().attr("id")==dataID) {
					$(this).attr("id",dataID+'_item_'+i).addClass("dataitem");
					i++;
				}
			});
			//alert(dataContainer.html())
		}
		
		function showActiveData() {
			$("#"+dataID+" div.dataitem").hide();
			//$("#"+dataID).fadeTo('slow',1);
			$("#"+dataID+'_item_'+parseInt(o.selected)).fadeIn('slow');	
		}
		function hideData() {
			
			$("#"+dataID).fadeTo('fast',0.5,function() {
				$("#"+dataID+" div.dataitem").hide();					 
			});
		}
		
		function controlBar() {
			var cbc = (o.controlBarContainer)?$(o.controlBarContainer):elm;
			cbc.append('<div id="'+controlID+'" />');
			if (cbc.is("#"+elmID)) {
				cbc.find('div#'+controlID).css({"position":"absolute","z-index":20});
			}
			liObj.each(function() {
				var buttonNumber= (o.showControlBarNum)?($(this).index()+1):"";
				cbc.find('div#'+controlID).append('<div id="'+controlID+'_item_'+$(this).index()+'" class="controlitem" style="cursor:pointer" rel="'+$(this).index()+'">'+buttonNumber+'</div>\n');
			})
			//bind event click on control item
			$("#"+controlID+" div.controlitem").click(function(){
				slide($(this).attr("rel"));
			}).hover(function(){
				$(this).toggleClass("hover");
			});
			
			if (o.showPlayPauseButton) {
				var buttonClass = (o.slideShow)?"pause":"play";
				cbc.find('div#'+controlID).append('<div id="'+controlID+'_button" class="button '+buttonClass+'">&nbsp;</div>\n');
				$("#"+controlID+" div.button").click(function(){
					if ($(this).hasClass("play")) {
						o.slideShow=true;
						if (o.slideShow) settimer();
						$(this).removeClass("play").addClass("pause");
					}
					else {
						stoptimer();
						o.slideShow=false;
						$(this).removeClass("pause").addClass("play");
					}
				});
			}
		}
		
		function showNumberBar() {
			var cbc = (o.controlBarContainer)?$(o.controlBarContainer):elm;
			cbc.append('<div id="'+controlID+'_number" class="'+controlID+'_number" />');
			if (cbc.is("#"+elmID)) {
				cbc.find('div#'+controlID+'_number').css({"position":"absolute","bottom":15,"right":25,"z-index":20});
			}
		}
		
		function updateNumberBarItem() {
			$("#"+controlID+"_number").text((parseInt(o.selected)+1)+'/'+j);
		}
		
		function setActiveControlBarItem() {
			$("#"+controlID+" div.controlitem").removeClass('active hover');
			$("#"+controlID+" div.controlitem").eq(o.selected).addClass('active');	
		}
		
		function setWrapper() {
			if(o.continuous){
				var cloneF2L = $("ul li:last-child", elm);
				var cloneL2F = $("ul li:first-child", elm);
				
				if (o.slideEffect=='slide-horizontal') {
					ulObj.prepend(cloneF2L.clone().css("margin-left","-"+ w +"px"));
					ulObj.append(cloneL2F.clone());
					ulObj.css('width',(j+1)*w);
				}
				else if (o.slideEffect=='slide-vertical') {
					ulObj.prepend(cloneF2L.clone().css("margin-top","-"+ h +"px"));
					ulObj.append(cloneL2F.clone());
					ulObj.css('height',(j+1)*h);
				}
				else if (o.slideEffect=='slide-open') {
					ulObj.prepend(cloneF2L.clone());
					ulObj.append(cloneL2F.clone());
				}
			};
		}
		
		function adjust(){
			if(o.selected>(j)) o.selected=0;		
			if(o.selected<0) o.selected=j;	
			
			//$("#te").html($("#te").html()+" => "+o.selected);
			if (o.slideEffect=='slide-horizontal') {
				ulObj.css("margin-left",(-w*o.selected));
			}
			else if (o.slideEffect=='slide-vertical') {
				ulObj.css("margin-top",(-h*o.selected));
			}
			else if (o.slideEffect=='slide-open') {
				liObj.hide();
				var next = parseInt(o.selected)+1;
				if(o.selected==(j-1)) next=0;		
				liObj.eq(o.selected).show();
				liObj.eq(o.selected).css({"z-index":10,"margin-left":0});
				liObj.eq(next).show();
				liObj.eq(next).css({"z-index":0,"margin-left":0});
			}
			else if (o.slideEffect=='slide-flip' || o.slideEffect=='slide-vertical-late') {
				liObj.hide();
				var next = parseInt(o.selected)+1;
				if(o.selected==(j-1)) next=0;		
				liObj.eq(o.selected).show();
				liObj.eq(o.selected).css({"z-index":5,"margin-top":0});
				if (j>1) {
				liObj.eq(next).show();
				liObj.eq(next).css({"z-index":10,"margin-top":h});
				}
			}

			if (o.showControlBar) setActiveControlBarItem();
			if (o.showNumberBar) updateNumberBarItem();
			if (o.showData) showActiveData();
			
			if (j>1)  {
				if (o.slideShow) settimer();
			}
			o.onSlideEnd.call(elm);
		};
		
		function slide(nSelected) {
			var idx = (nSelected)?nSelected:parseInt(o.selected)+1;
			if(!o.continuous){
				idx = (idx>=j)?0:idx;
			}

			if (o.showControlBar) {
				$("#"+controlID+" div.controlitem").eq((idx>(j-1))?0:idx).addClass('hover');	
			}
			//linxObj.eq(aniactive).addClass('nextactive');
			var f = Math.abs(o.selected-idx);
			var s = o.slideSpeed*j;
			var speed = s-(o.slideSpeed*(f-2));
			
			if (o.slideEffect=='slide-horizontal') {
				var p = -w*idx;
				var a = (idx<o.selected)?-50:50;
				ulObj.animate({ "margin-left": parseInt(ulObj.css("margin-left"))+a },{ queue:false, duration:100, easing:'easeOutQuad', complete: function() {
				   			ulObj.animate({ "margin-left": p+(-a) },{ queue:false, duration:speed, easing:o.slideEaseFunction, complete: function() {
							ulObj.animate({ "margin-left": p },{ queue:false, duration:100, easing:'easeOutQuad', complete:adjust } );
																																			 }} );
					   }
				   } 
			   );
				//ulObj.animate({ "margin-left": p },{ queue:false, duration:speed, easing:o.slideEaseFunction, complete:adjust } );
			}
			else if (o.slideEffect=='slide-vertical') {
				var p = -h*idx;
				ulObj.animate({ "margin-top": p },{ queue:false, duration:speed, easing:o.slideEaseFunction, complete:adjust } );
			}
			else if (o.slideEffect=='fade') {
				if(idx>(j-1)) idx=0;		
				if(idx<0) idx=j;	
				
				liObj.fadeOut('fast');
				liObj.eq(idx).fadeToggle(s*4, function() {
					adjust();
				});	
			}
			else if (o.slideEffect=='slide-open') {
				var p = (idx<o.selected)?w:-w;
				
				liObj.eq(idx).show();
				liObj.eq(idx).css({"z-index":5,"margin-left":0});
				
				liObj.eq(parseInt(o.selected)).animate(
					{ "margin-left": p },
					{ queue:false, duration:speed, easing:o.slideEaseFunction, complete:adjust} );
			}
			else if (o.slideEffect=='slide-flip') {
				if (idx>(j-1)) idx=0;
				liObj.eq(idx).show();
				liObj.eq(idx).css({"z-index":10,"margin-top":h});
				
				liObj.eq(idx).animate(
					{ "margin-top": 0 },
					{ queue:false, duration:o.slideSpeed*5, easing:o.slideEaseFunction/*, complete:adjust*/} 
				);
				
				liObj.eq(parseInt(o.selected)).animate(
					{ "margin-top": h },
					{ queue:false, duration:o.slideSpeed*5, easing:o.slideEaseFunction, complete:adjust} 
				);
				
			}
			else if (o.slideEffect=='slide-vertical-late') {
				if (idx>(j-1)) idx=0;
				liObj.eq(idx).show();
				liObj.eq(idx).css({"z-index":10,"margin-top":h});
				
				liObj.eq(idx).animate(
					{ "margin-top": 0 },
					{ queue:false, duration:o.slideSpeed*5, easing:o.slideEaseFunction/*, complete:adjust*/} 
				);
				
				liObj.eq(parseInt(o.selected)).animate(
					{ "margin-top": -h },
					{ queue:false, duration:o.slideSpeed*8, easing:o.slideEaseFunction, complete:adjust} 
				);
				
			}
			o.selected=idx;
		}
		
		function settimer() {				
			if(timer != null) clearTimeout(timer);
			timer = setTimeout(
			  function(){ slide(); }, o.slideInterval
			);
			$("#pp").html("Playing");
		}
		
		function stoptimer() {
			if(timer != null) {
				clearTimeout(timer);
			}
			$("#pp").html("Paused");
		}
		
		function sleepSlideShow() {
			stoptimer();
		}
		
		function wakeSlideshow() {
			if (o.slideShow) settimer();
		}
		return this;
	};
})( jQuery );

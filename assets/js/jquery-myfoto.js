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
	$.fn.myfoto = function( options ) {  
		var timer = null;
		var settings = {
			selected				: 'random',
			fotoContainer			: '#foto-container',
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
			onSlideStart			: function(){},
			onSlideEnd				: function(){}
		};
		var o = $.extend( settings, options );
		var elm = this;
		var elmID = elm.attr('id');
		var fotoContainer = $(o.fotoContainer);
		var thumbs = $("ul > li",elm);
		var j = thumbs.length;
		var allImages={};
		init();
		
		function init() {
			o.selected=(o.selected=='random')?Math.floor(Math.random()*j):o.selected;
			if (j<2) {
				stoptimer();
				o.slideShow=false;
			}
			fotoContainer.find("div.img").remove();
			thumbnailsBar();


			displayImage();
			$("#fnext").click(function() {
				nextItem();						
			});
			$("#fprev").click(function() {
				prevItem();						
			});
			$(".buttoncontrol").mouseleave(function() {
				$(this).fadeOut();								
			})
		}

		function thumbnailsBar() {
			thumbs.each(function() {
				var id = $(this).find("a").attr("rel");
				var title = $(this).find("a").attr("title");
				var image = $(this).find("a").attr("href");
				var caption = $(this).find(".caption").html();
				var hash  = "img_"+$(this).index();
				fotoContainer.append('<div id="'+hash+'" class="img" style="position:absolute; display:none"></div>');
				
				var imageData = {
					id:id,
					title:title,
					image:image,
					caption:caption,
					hash:hash
				};
				
				allImages[hash]=imageData;
				
				$(this).css("background","#fff");
				$(this).mouseenter(function() {
					var title =$(this).attr("rel");
					$("#foto-title").html("Title: "+title);
				}).mouseleave(function() {
					$("#foto-title").html("&nbsp;");
				}).click(function(e) {
					var title =$(this).attr("rel");
					o.selected=$(this).index();
					displayImage(hash);
					e.preventDefault();
				});
			});
		}
		
		function displayImage(hash){
			var hash = (hash)?hash:allImages["img_"+o.selected]['hash'];
			
			if ($("#"+hash).is(":hidden")) {
				o.onSlideStart.call(allImages[hash]);	
				fotoContainer.find("div").fadeOut("slow");
				
				if ($("#"+hash).find("img").length<1) {
					$("#loader").show();
					var img = $('<img />').attr('src',allImages[hash]['image']+"&"+Math.random()).load(function(){
						$("#"+hash).append($(this));
						$("#loader").hide();
						$("#"+hash).fadeIn("slow", function() {
							controlItem(hash);
							allImages[hash]['height']=$(this).height();
							o.onSlideEnd.call(allImages[hash]);		
						});	
					})
				}
				else {
					$("#"+hash).fadeIn("slow", function() {
						//nextItem(hash);
						o.onSlideEnd.call(allImages[hash]);		
					});	
				}
			}
			thumbs.css("background","#fff");
			thumbs.eq(o.selected).css("background","#477eab");
		};
		
		function nextItem(hash) {
			var hash = (hash)?hash:allImages["img_"+o.selected]['hash'];
			var nextid = (o.selected+1);
			nextid=(nextid==j)?0:nextid;
			thumbs.eq(nextid).trigger("click");
		}
		function prevItem(hash) {
			var hash = (hash)?hash:allImages["img_"+o.selected]['hash'];
			var previd = (o.selected-1);
			previd=(previd<0)?j-1:previd;
			thumbs.eq(previd).trigger("click");
		}
		function controlItem(hash) {
			$("#"+hash).mousemove(function(e) {
			  var off = $(this).offset();
			  var x = e.pageX - off.left;
			  var w = $(this).width()/4;
				if (x>(w*3)) { 
					$("#fnext").fadeIn();
					$("#fprev").fadeOut() 
				} else if (x<w) { 
					$("#fprev").fadeIn();
					$("#fnext").fadeOut();
				}
				else {
					$(".buttoncontrol").fadeOut();
				}
			});
		}
		
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
				
				liObj.fadeOut(s*3);
				liObj.eq(idx).fadeIn(s*4, function() {
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

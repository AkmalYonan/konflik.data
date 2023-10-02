<link rel="stylesheet" href="assets/js/additional_js/pnotify/pnotify.custom.min.css">
<script src="assets/js/additional_js/pnotify/pnotify.custom.min.js"></script>
<script src="assets/themes/lte2.3.0/plugins/slimScroll/jquery.slimscroll.js"></script>
<script src="assets/js/scrollbox/jquery.scrollbox.js"></script>
<link href="assets/js/scrollbox/demo.css" rel="stylesheet">
<style>
.item{ font-size:10px !important}
</style>
<div class="row">
	<div class="col-md-12">
		<h6  style="font-size:12px;ext-transform:uppercase; border:1px solid #c2c2a3; padding:8px;"><strong>
		<div id="examplerxxxx">
		  5 Kontak Feed Terbaru :
		  
		</div>				
		</strong></h6>
		<div id="testDiv" style="border:1px solid #d5d5c3; padding:0px 5px 0px 5px;">
		<? foreach($top5_bydate as $k=>$v){?>	
		<div class="item" style="border-bottom:1px solid #e0e0d2;padding-bottom:5px;font-size:12px">
			<div class="row">
				<div class="col-md-2">
					<center>
					<img src="assets/images/no-profile-male.jpg" style="margin-top:10px;" width="50px;"><br />
					<span style="color:grey !important"><?=$v['name']?></span>
					</center>
				</div>
				<div class="col-md-10">
					
					<h6 style="text-transform:uppercase; font-size:12px;font-weight:bold">
					<?=$v['subject']?>
					<small><img width="15px" height="15px" style="margin-top:-5px;" src="assets/images/verified.jpg"></small>
					</h6>
					<?
						$string = strlen($v['comments']);
						if($string>90){
						$small = substr($v['comments'], 0, 90);
						
						echo $small."....."."<br />";
						}else{
							echo $v['comments']."<br />";
						}
					?>
					<span style="color:grey !important">
					<?//=$date = date('d-m-Y h:i:s', strtotime($v['created']));?>
					<?=$date=date("jS F, Y h:i:s", strtotime($v['created']));?>
					</span>
					<hr style="background-color: #c2c2a3; height: 1px; border: 0;  " />
					Balasan : 
					</h6>
					<?
						$string2 = strlen($v['reply']);
						if($string2>80){
						$small2 = substr($v['reply'], 0, 80);
						
						echo $small2.".....";
						}else{
							echo $v['reply'];
						}
					?>
					
				</div>
			</div>
		</div>
		<? }?>	
		</div>
	</div>
</div>



<script type="text/javascript">
	 $(function(){
      $('#testDiv').slimscroll({
        size: '3px',
		height: '550px'
      });
     
    });
	$(function() {
	  $('#example').vTicker();
	});
	
/*! vTicker 1.21 http://richhollis.github.com/vticker/ | http://richhollis.github.com/vticker/license/ | based on Jubgits vTicker http://www.jugbit.com/jquery-vticker-vertical-news-ticker/ */
(function(d){var g,c,f;g={speed:700,pause:4E3,showItems:1,mousePause:!0,height:0,animate:!0,margin:0,padding:0,startPaused:!1,autoAppend:!0};c={moveUp:function(a,b){return c.showNextItem(a,b,"up")},moveDown:function(a,b){return c.showNextItem(a,b,"down")},nextItemState:function(a,b){var e,c;c=a.element.children("ul");e=a.itemHeight;0<a.options.height&&(e=c.children("li:first").height());e+=a.options.margin+2*a.options.padding;return{height:e,options:a.options,el:a.element,obj:c,selector:"up"===b?
"li:first":"li:last",dir:b}},showNextItem:function(a,b,e){var d;d=c.nextItemState(a,e);d.el.trigger("vticker.beforeTick");e=d.obj.children(d.selector).clone(!0);"down"===d.dir&&d.obj.css("top","-"+d.height+"px").prepend(e);b&&b.animate?a.animating||c.animateNextItem(d,a):c.nonAnimatedNextItem(d);"up"===d.dir&&a.options.autoAppend&&e.appendTo(d.obj);return d.el.trigger("vticker.afterTick")},animateNextItem:function(a,b){b.animating=!0;return a.obj.animate("up"===a.dir?{top:"-="+a.height+"px"}:{top:0},
b.options.speed,function(){d(a.obj).children(a.selector).remove();d(a.obj).css("top","0px");return b.animating=!1})},nonAnimatedNextItem:function(a){a.obj.children(a.selector).remove();return a.obj.css("top","0px")},nextUsePause:function(){var a,b;b=d(this).data("state");a=b.options;if(!b.isPaused&&!c.hasSingleItem(b))return f.next.call(this,{animate:a.animate})},startInterval:function(){var a,b;b=d(this).data("state");a=b.options;return b.intervalId=setInterval(function(a){return function(){return c.nextUsePause.call(a)}}(this),
a.pause)},stopInterval:function(){var a;if(a=d(this).data("state"))return a.intervalId&&clearInterval(a.intervalId),a.intervalId=void 0},restartInterval:function(){c.stopInterval.call(this);return c.startInterval.call(this)},getState:function(a,b){var c;if(!(c=d(b).data("state")))throw Error("vTicker: No state available from "+a);return c},isAnimatingOrSingleItem:function(a){return a.animating||this.hasSingleItem(a)},hasMultipleItems:function(a){return 1<a.itemCount},hasSingleItem:function(a){return!c.hasMultipleItems(a)},
bindMousePausing:function(a){return function(a,e){return a.bind("mouseenter",function(){if(!e.isPaused)return e.pausedByCode=!0,c.stopInterval.call(this),f.pause.call(this,!0)}).bind("mouseleave",function(){if(!e.isPaused||e.pausedByCode)return e.pausedByCode=!1,f.pause.call(this,!1),c.startInterval.call(this)})}}(this),setItemLayout:function(a,b,c){var f;a.css({overflow:"hidden",position:"relative"}).children("ul").css({position:"absolute",margin:0,padding:0}).children("li").css({margin:c.margin,
padding:c.padding});return isNaN(c.height)||0===c.height?(a.children("ul").children("li").each(function(){if(d(this).height()>b.itemHeight)return b.itemHeight=d(this).height()}),a.children("ul").children("li").each(function(){return d(this).height(b.itemHeight)}),f=c.margin+2*c.padding,a.height((b.itemHeight+f)*c.showItems+c.margin)):a.height(c.height)},defaultStateAttribs:function(a,b){return{itemCount:a.children("ul").children("li").length,itemHeight:0,itemMargin:0,element:a,animating:!1,options:b,
isPaused:b.startPaused,pausedByCode:!1}}};f={init:function(a){var b,e;d(this).data("state")&&f.stop.call(this);b=jQuery.extend({},g);a=d.extend(b,a);b=d(this);e=c.defaultStateAttribs(b,a);d(this).data("state",e);c.setItemLayout(b,e,a);a.startPaused||c.startInterval.call(this);if(a.mousePause)return c.bindMousePausing(b,e)},pause:function(a){var b;b=c.getState("pause",this);if(!c.hasMultipleItems(b))return!1;b.isPaused=a;b=b.element;if(a)return d(this).addClass("paused"),b.trigger("vticker.pause");
d(this).removeClass("paused");return b.trigger("vticker.resume")},next:function(a){var b;b=c.getState("next",this);if(c.isAnimatingOrSingleItem(b))return!1;c.restartInterval.call(this);return c.moveUp(b,a)},prev:function(a){var b;b=c.getState("prev",this);if(c.isAnimatingOrSingleItem(b))return!1;c.restartInterval.call(this);return c.moveDown(b,a)},stop:function(){c.getState("stop",this);return c.stopInterval.call(this)},remove:function(){var a;a=c.getState("remove",this);c.stopInterval.call(this);
a=a.element;a.unbind();return a.remove()}};return d.fn.vTicker=function(a){return f[a]?f[a].apply(this,Array.prototype.slice.call(arguments,1)):"object"!==typeof a&&a?d.error("Method "+a+" does not exist on jQuery.vTicker"):f.init.apply(this,arguments)}})(jQuery);
</script>

<style>
.finger {
	position:absolute;
	border:2px solid transparent;
	border-radius:50%;
	width:50px;
	height:50px;	
	cursor:pointer
}
.finger:hover {
	border:2px solid #ccc;
	background:#eee;
}
.finger.active {
	background:#eee url(assets/images/check-icon.png) top no-repeat;
}
</style>
<div class="row">
	<div class="col-md-6 col-xs-12">
    	<div id="hand-left" style="position:relative; height:400px; width:400px; background:url(assets/images/hand-left.png) center no-repeat;background-size: 400px 400px;">
    		<div id="f9" class="finger fingerbox reg" style="top:155px; left:55px" data-id_jari="9"></div>
    		<div id="f8" class="finger fingerbox reg" style="top:85px; left:115px" data-id_jari="8"></div>
    		<div id="f7" class="finger fingerbox reg" style="top:55px; left:215px" data-id_jari="7"></div>
    		<div id="f6" class="finger fingerbox reg" style="top:75px; left:320px" data-id_jari="6"></div>
    		<div id="f5" class="finger fingerbox reg" style="top:255px; left:400px" data-id_jari="5"></div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
    	<div id="hand-right" style="position:relative; height:400px; width:400px; background:url(assets/images/hand-right.png) center no-repeat;background-size: 400px 400px;">
    		<div id="f0" class="finger fingerbox reg" style="top:255px; left:60px" data-id_jari="0"></div>
    		<div id="f1" class="finger fingerbox reg" style="top:80px; left:145px" data-id_jari="1"></div>
    		<div id="f2" class="finger fingerbox reg" style="top:55px; left:245px" data-id_jari="2"></div>
    		<div id="f3" class="finger fingerbox reg" style="top:85px; left:345px" data-id_jari="3"></div>
    		<div id="f4" class="finger fingerbox reg" style="top:155px; left:405px" data-id_jari="4"></div>
        </div>
    </div>
</div>
<script>
var ref_width=512;
var ref_height=512;
var ref_finger=50;
var hand={
	"left":{
		"kelingking":[155,55],
		"manis":[85,115],
		"tengah":[55,215],
		"telunjuk":[75,320],
		"jempol":[255,400]
	},
	"right":{
		"kelingking":[155,405],
		"manis":[85,345],
		"tengah":[55,245],
		"telunjuk":[80,145],
		"jempol":[255,60]
	}
}
function repos(h,f,nw,nh) {
	var new_top  = (hand[h][f][0] * nh)/ref_height;
	var new_left = (hand[h][f][1] * nw)/ref_width;
	return [new_top,new_left];
}
function resize(nw,nh) {
	var new_height  = (ref_finger * nh)/ref_height;
	var new_width = (ref_finger * nw)/ref_width;
	return [new_height,new_width];
}
$(function(){
	function newpos() {
		var hand_w = $("#hand-left").width();
		var hand_h = $("#hand-left").height();
	
		var kiri_1 = repos("left","kelingking",hand_w,hand_h);
		var kiri_2 = repos("left","manis",hand_w,hand_h);
		var kiri_3 = repos("left","tengah",hand_w,hand_h);
		var kiri_4 = repos("left","telunjuk",hand_w,hand_h);
		var kiri_5 = repos("left","jempol",hand_w,hand_h);
		$("#f9").css({"top":kiri_1[0],"left":kiri_1[1]});
		$("#f8").css({"top":kiri_2[0],"left":kiri_2[1]});
		$("#f7").css({"top":kiri_3[0],"left":kiri_3[1]});
		$("#f6").css({"top":kiri_4[0],"left":kiri_4[1]});
		$("#f5").css({"top":kiri_5[0],"left":kiri_5[1]});
	
		var kanan_1 = repos("right","kelingking",hand_w,hand_h);
		var kanan_2 = repos("right","manis",hand_w,hand_h);
		var kanan_3 = repos("right","tengah",hand_w,hand_h);
		var kanan_4 = repos("right","telunjuk",hand_w,hand_h);
		var kanan_5 = repos("right","jempol",hand_w,hand_h);
		$("#f4").css({"top":kiri_1[0],"right":kiri_1[1],"left":"auto"});
		$("#f3").css({"top":kiri_2[0],"right":kiri_2[1],"left":"auto"});
		$("#f2").css({"top":kiri_3[0],"right":kiri_3[1],"left":"auto"});
		$("#f1").css({"top":kiri_4[0],"right":kiri_4[1],"left":"auto"});
		$("#f0").css({"top":kiri_5[0],"right":kiri_5[1],"left":"auto"});
		
		var nsize = resize(hand_w,hand_h);
		$(".finger").css({"width":nsize[0],"height":nsize[1]});
	}
	newpos();
	$( window ).resize(function() {
	  newpos();
	});
});
</script>
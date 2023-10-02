$(document).ready(function () {
//global
	$("#topnav-menu").topnav();
	$("#search_text").textinout({textDefault:"Ketik kata kunci"});
	$("#search_option").opsel({valuePlace:"#search_category"});
	$("#top-menu").latmenu();
	
	$(".ico-flag").hover(function() {
		$(this).toggleClass("ico-flag-hover");
	});
	
	
	$("#formlogin").live('submit', function(event) {
		event.preventDefault();
		var $form = $( this ),
		name = $form.find( 'input[name="name"]' ).val(),
		pass = $form.find( 'input[name="pass"]' ).val(),
		url  = $form.attr( 'action' );
		
		$("button",$form).text("loading...").attr("disabled",true);
		$.post( url, { name: name, pass:pass } ,
			function( data ) {
				eval(data);
			}
		);
	});
	//global
	$('input[name="search_text"]').keyup(function() {
		$("#search_option").find("li ul").show();
	})
	$("#formsearch").submit(function(event) {
		event.preventDefault();
		var $form = $( this ),
		text = $form.find( 'input[name="search_text"]' ).val(),
		kat = $form.find( 'input[name="search_category"]' ).val(),
		url  = $form.attr( 'action' );
		
		if (text=="Ketik kata kunci") {
			alert('Silahkan Ketik Kata Kunci.');
			return false;
		}
		else {
			if (text.length<3) {
				alert('Kata Kunci pencarian terlalu pendek');
				return false;
			}
			else {
				text = (text).replace(' ','+');
				kat=(kat)?kat:0;
				window.location.href = url+'/index/'+text+'/'+kat;
			}
		}
	});
	
	//global
	$("#btnlogout").live("click", function() {
		window.location.href = 'login/logout';
	})
	
	//global
	$("img.captcha_img").live("click", function() {
		if (!$(this).attr("rel")) {
			$(this).attr("rel",$(this).attr("src"));
		}
		$(this).attr("src",$(this).attr("rel")+'?'+Math.random());
	})
	
	//global
	$(".initload").each(function() {
		$(this).load($(this).attr('rel'));
	});
	
	$('#user_online').load('/new_puskari/time.php?rnd='+ Math.random());
	setInterval(function() {
		$('#user_online').load('/new_puskari/time.php?rnd='+ Math.random());
	}, 300000);
	
})
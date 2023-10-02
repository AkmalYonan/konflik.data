<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="Description" CONTENT="BKIPM - Badan Karantina Ikan, Pengendalian Mutu dan Keamanan Hasil Perikanan, Kementrian Kelautan dan Perikanan Republik Indonesia ">
<META http-equiv="Content-Type" CONTENT="text/html; charset=utf-8" />
<title>Lingkar Arsa Technologies - IT Software Developer, GIS Solutions</title>
<base href="<?=BASE_URL;?>" />
<link rel="shortcut icon" href="assets/image/favicon.ico" />
<link rel="stylesheet" type="text/css" href="assets/themes/bs-square/css/bootstrap.css" media="screen">
<link rel="stylesheet" href="assets/fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="assets/themes/bs-square/css/front.css" media="screen">
<script src="assets/js/jquery/jquery-1.10.2.min.js"></script>
<script src="assets/themes/bs-square/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.sticky.js"></script>
<script>
$(window).load(function(){
  $("#headers").sticky({ topSpacing: 0 });
  $('#myCarousel').carousel();
  /*$(".carousel").mouseenter(function(){
  		$(".carousel-control").show();
  }).mouseleave(function(){
  		$(".carousel-control").hide();
  });*/
});
$(window).scroll(function(){
    if ($(window).scrollTop() >= 50) {
       $('.sticky-header').addClass('fixed');
    }
    else {
       $('.sticky-header').removeClass('fixed');
    }
});
</script>
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100' rel='stylesheet' type='text/css'>
<style>
	body {
		margin:0 30px;
		position:relative;
		border:1px solid #dedede;
		border-width:0 1px;
		background:#f8f8f8;
		font-family:'Roboto',Arial;
	}
	.fixed {
		position: fixed;
		top:0; left:0;
		z-index:1000;
		width: 100%; 
		background-image: linear-gradient(to bottom, #FFF, #F2F2F2);
	  background-repeat: repeat-x;
	}
/* Custom container */
      .container {
        margin: 0 auto;
		width:1000px;
      }
/* CUSTOMIZE THE NAVBAR
    -------------------------------------------------- */

    /* Special class on .container surrounding .navbar, used for positioning it into place. */
    .navbar-wrapper {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      z-index: 999;
      margin-top: 0;
	  border-bottom:3px solid #ccc;
	  background-color: #f8f8f8;
	  /*background-image: linear-gradient(to bottom, #FFF, #F2F2F2);
	  background-repeat: repeat-x;*/
      /*margin-bottom: -90px;  Negative margin to pull up carousel. 90px is roughly margins and height of navbar. */
	  box-shadow: 0px 4px 3px rgba(100, 100, 100, 0.1);
    }
    #sub-header {
	  width:100%;
	  background-color: rgba(74, 74,74,.1);
      background-image: linear-gradient(to bottom, rgba(74, 74, 74,.1), rgba(84, 84, 84,.1));
      background-repeat: repeat-x;

    }
	.navbar-inverse {
		position:relative;
	  padding:0px;
    }
	
/* CUSTOMIZE THE CAROUSEL
    -------------------------------------------------- */

/* Carousel base class */
.carousel {
  margin-bottom: 0px;
}

.carousel .container {
  position: relative;
  z-index: 9;
}

.carousel-control {
    position: absolute;
    top: 30%;
    left: -30px;
    width: 40px;
    height: 80px;
    font-size: 60px;
	line-height:60px;
    color: #FFF;
    text-align: center;
    background: transparent;
    border: 0px solid #FFF;
    border-radius: 0;
    opacity: 1;
	/*display:none*/
}
.carousel-control.right {
	left:auto;
	right:-30px;
}
.carousel-control:hover {
    background: #808080;
}
.carousel .item {
  height: 220px;
}
.carousel img {
  position: absolute;
  top: 0;
  left: 0;
  min-width: 100%;
  height: 220px;
}

.carousel-caption {
  background-color: transparent;
  position: static;
  max-width: 1000px;
  padding: 0 10px;
  margin-top: 100px;
}
.carousel-caption h1{
	font-family:'Oswald',Arial;
}
.carousel-caption h1,
.carousel-caption .lead {
	font-size:40px;
	margin: 0px;
	line-height: 1.25;
	color: #fff;
	text-transform:uppercase;
	text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
}
.carousel-caption.dark > h1,
.carousel-caption.dark > .lead {
	color: #333;
}
.carousel-caption .lead {
	font-size:14px;
	font-family:'Roboto';
	font-weight:400
}
.carousel-caption .btn {
  margin-top: 10px;
}

.footer					{background:url(assets/image/footers.png) repeat-x 0 0 #333/*#36587b*/; text-shadow:0 -1px 0 #232323; }
.footer	 .container		{background:url(assets/image/footer-logo.png) no-repeat 100% 50%; padding:30px 0 10px; color:#c2c2C2;}
.footer	 a				{color:#fff;}
.footer h2				{color:#ffffff; padding-bottom:10px;font:13px/140% 'Roboto', Open Sans, sans-serif; text-transform:uppercase}
.footer ul 				{list-style:none; margin:0;}
.footer ul li			{font:11px/200% 'Roboto', Open Sans, sans-serif;}
.footer ul li a			{color:#ccc}
.footer ul li a:hover	{color:#fff; text-decoration:none}
.footer .border			{background:url(assets/image/border-hr.png) repeat-x 0 0; padding:20px 0 10px 0; clear:left; margin-top:20px;}
.kontak a		 		{font-size:medium; margin:20px 10px 0 2px}

/*Showcase box */
.showcase  {
  position: relative;
  z-index: 9;
}
.showcase-inner {
  overflow: hidden;
  width: 100%;
  position: relative;
}
.showcase-section {
  margin: 10px 0 40px;
  position: relative;
}
.showcase-section h3 {
	border-bottom:2px solid #ddd
}
.showcase .item {
  height: 400px;
}
.showcase img {
  position: relative;
  top: 0;
  left: 0;
  min-width: 100%;
}
.showcase-block {
	position:relative;
}
.showcase-caption {
  background-color: #aaa;
  position: absolute;
  top:0;
  left:0;
  max-width: 350px;
  padding: 20px;
  margin-top: 0px;
  color:#fff;
}
.showcase-caption h1,
.showcase-caption .lead {
  padding: 10px 10px 10px 2px;
  font-size:small;
  line-height:1.3
}
.showcase-caption .btn {
  margin-top: 10px;
}


.content-sub-nav .nav-tabs > li > a, .nav-pills > li > a {
	color:#999;
    padding: 8px 20px 8px 20px;
    margin-right: 0;
    line-height: 14px;
	border-radius:0;
}
.content-sub-nav .nav-tabs > .active > a,.content-sub-nav .nav-pills > .active > a {
	background:#555
}
.content-sub-nav .nav a {
	font-size:12px;
	padding-left:20px;
}
.content-sub-nav .nav a:focus {
    outline: none;
}

.content-sub-nav {
	background:transparent;
	border-bottom:1px solid #ddd;
	padding:10px
}
.btn-primary {
    color: #FFF;
    background-color: green;
    background-image: none;
    border-color: none;
}
.carousel-caption .btn {
	background: #333;
	border:0px!important;
	border-radius:0px!important;
    text-shadow: none!important;
	text-transform:uppercase;
	font-size:12px;
	color:#eee
}
.border{
	border-top:1px solid #aaa
}
</style>
</head>

<body>
<div id="headers" class="navbar-wrapper sticky-header">
      <!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
      <div class="container">
      <div class="navbar">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand pull-left" href="#" style="padding:0 30px 0 0px; position:relative"><img src="assets/image/logo-blank.png" border="0" title="<?=$title;?>" style="margin-top:-0px" /><!--<img src="assets/image/logo-circle.png" border="0" title="<?=$title;?>" style="position:absolute; left:0; top:0; z-index:1001" />--></a>
            <ul class="nav lat-nav">
              <li><a href="#">SOLUTIONS</a></li>
              <li><a href="#">PRODUCT & SERVICES</a></li>
              <li class="active"><a href="showcase">SHOWCASE</a></li>
              <li><a href="#">ABOUT</a></li>
            </ul>
            <ul class="nav lat-nav pull-right">
               <li><a href="#"><i class="icon-phone"></i> +62 21 83702010</a></li>
               <li style="border-left:1px solid #eee"><a href="#"><i class="icon-facebook"></i> <i class="icon-twitter"></i> <i class="icon-envelope"></i>&nbsp;</a></li>
            </ul>
        </div>
      </div><!-- /navbar-inner -->
    </div><!-- /navbar -->
  </div>
</div>
<!--<div id="sub-header">
      <div class="container">
      <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container-fluid">
            <ul class="nav lat-nav">
              <li><a href="#">SOLUTIONS</a></li>
              <li><a href="#">SERVICES</a></li>
              <li><a href="showcase">SHOWCASE</a></li>
              <li><a href="#">ABOUT</a></li>
            </ul>
            <ul class="nav lat-nav pull-right">
               <li><a href="#"><i class="icon-phone"></i> +62 21 83702010</a></li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>-->


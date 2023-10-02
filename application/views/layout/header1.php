<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="Description" CONTENT="BKIPM - Badan Karantina Ikan, Pengendalian Mutu dan Keamanan Hasil Perikanan, Kementrian Kelautan dan Perikanan Republik Indonesia ">
<META http-equiv="Content-Type" CONTENT="text/html; charset=utf-8" />
<title>BRWA - Badan Registerasi Wilayah Adat</title>
<base href="<?=BASE_URL;?>" />
<link rel="stylesheet" type="text/css" href="assets/bs-3.3.1/css/bootstrap.css" media="screen">
<link rel="stylesheet" type="text/css" href="assets/bs-3.3.1/css/bootstrap-theme-lat.css" media="screen">
<link rel="stylesheet" href="assets/fa-4.2.0/css/font-awesome.min.css">
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bs-3.3.1/js/bootstrap.min.js"></script>
<script src="assets/themes/bs-square/js/bootstrap-menu-hovers.js"></script>
<script src="assets/js/jquery.sticky.js"></script>
<script>
$(document).ready(function () {
  $("#headers").sticky({ topSpacing: 0 });
  $('#myCarousel').carousel();
  $("ul.nav li.dropdown").mouseenter(function(){
  		$(this).find("ul.dropdown-menu").slideDown("fast");
  }).mouseleave(function(){
  		$(this).find("ul.dropdown-menu").hide();
  })
  /*$(".carousel").mouseenter(function(){
  		$(".carousel-control").show();
  }).mouseleave(function(){
  		$(".carousel-control").hide();
  });*/
});
$(window).scroll(function(){
    if ($(window).scrollTop() >= 50) {
       $('.sticky-header').addClass('fixed', 5000, "easeInOutQuad");
    }
    else {
       $('.sticky-header').removeClass('fixed', 5000, "easeInOutQuad" );
    }
});
</script>
<script src="https://maps.google.com/maps/api/js?v=3&amp;sensor=false"></script>
<script src="/OpenLayers-2.12/OpenLayers.js"></script>

<link href='https://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600,400,300' rel='stylesheet' type='text/css'>
<style>
	body {
		background:#f4f4f4;
		font-family:'Open Sans','Roboto',Arial;
		font-size:13px;
		color:#333333;
	}
	#closure {
		margin:0;
		position:relative;
		background:#fff;
		
	}
	.fixed {
		position: fixed;
		top:0; left:0;
		z-index:1000;
		width: 100%; 
		background-image: linear-gradient(to bottom, #FFF, #eee);
	  background-repeat: repeat-x;
	}
/* Custom container */
      .container {
        margin: 0 auto;
		width:1100px;
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
img {
		max-width:none;
	}
/* Carousel base class */
.carousel {
  margin-bottom: 0px;
  border-bottom:1px solid #ddd;
}

.carousel .container {
  position: relative;
  z-index: 9;
}

.carousel .item {
  height: 450px;
}
.carousel-inner > .item > img, .carousel-inner > .item > a > img {
  position: absolute;
  top: 0;
  left: 0;
  min-width: 100%;
  height: 450px;
}

.carousel-caption {
  background-color: transparent;
  position: static;
  max-width: 1000px;
  padding: 0 10px;
  margin-top: 100px;
  text-align:left
}
.carousel-caption h1{
	font-family:'Open Sans','Oswald',Arial;
}
.carousel-caption h1,
.carousel-caption .lead {
	font-size:50px;
	font-weight:300;
	margin: 0px;
	line-height: 1.25;
	color: #fff;
	text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
}
.carousel-caption.dark > h1,
.carousel-caption.dark > .lead {
	color: #444;
	text-shadow: 0px 0px 2px rgba(255, 255, 255, 0.6);
}
.carousel-caption .lead {
	font-size:1.2em;
	font-weight:700
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

.lat-feature {
	padding-bottom:0px;
	margin-bottom:0px;
	font-weight:normal
}
.lat-feature a{
	color:#fff;
	text-decoration:none;
}
.lat-feature h4 {
	font-size:16px!important;
	font-weight:normal
}
.lat-feature h4 a{
	color:#fff;
}
.lat-feature i {
	text-shadow: none;
	font-size: 35px;
	display: block;
	text-align: center;
	margin:0px;
	color:#fff
}
.lat-feature .col-lg-12 {
	border:0px solid #ccc; height: auto;
	text-align:center;
	margin:2px;
	background:#777;
	min-height:300px;
}
.lat-feature .col-lg-12:hover {
	opacity:.7
}
.fasilitas ul li:hover i {
	color:#fff
}
.fasilitas ul li:hover a {
	color:#fff
}
.fasilitas ul li a{
	color:#eee;
	text-decoration:none
}
.fasilitas i.red {
	/*background: #ff544f*/
}
.fasilitas .green {
	background: #71b60e
}
.fasilitas i.blue {
	/*background: #00b5e4*/
}
.fasilitas i.grey {
	/*background: #aaa*/
}
.fasilitas p {
	display:block;
	margin-top:15px;
	font-family: 'Open Sans';
	color:#777;
	font-size:.9em
}
.btn {
	background: #555;
	border:0px!important;
	border-radius:0px!important;
    text-shadow: none!important;
	color:#eee
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
ul.nav li.dropdown:hover ul.dropdown-menu{
    /*display: block;*/    
}
.navbar .nav li.dropdown:hover > a {
    color: #71b60e;
    background-color: transparent!important;
	box-shadow:none;
	/*border-bottom:3px solid #71b60e*/
}

.content-box.box-default {
    /*background-color: #F6F6F6;*/
    border: 0px solid #E5E5E5;
}
.content-box.box-green {
    background-color: #71b60e;
    border: 1px solid #E5E5E5;
}
.content-box {
    display: block;
    text-align: center;
    overflow: hidden;
    padding: 10px;
    margin-bottom: 20px;
	min-height:300px;
	font-weight:normal
}
.content-box .icon-title {
	position:relative;
	background:#eee;
	border:1px solid #eee;
	color:#999;
	padding:10px;
	margin:-10px;
	box-shadow: 0px 2px 8px rgba(100, 100, 100, 0.2);
	background-image: -webkit-linear-gradient(top, #eee 0%, #ddd 100%);
	background-image:      -o-linear-gradient(top, #eee 0%, #ddd 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, from(#eee), to(#ddd));
	background-image:         linear-gradient(to bottom, #eee 0%, #ddd 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeeeeeee', endColorstr='#dddddddd', GradientType=0);
	filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
	background-repeat: repeat-x;
	overflow:hidden;
}
.content-box i.back {
	font-size:120px; color:#555; opacity:0.01; position:absolute;
}
.content-box a:hover {
	opacity:.8;
	text-decoration:none
}
.content-box a:hover i.back {
	opacity:.1;
}
.content-box a {
	font-size:1.1em;
	font-weight:bold
}
.content-box .icon-title {
	font-size:45px;
	margin-bottom:10px
}
.content-box .icon-title.icon-title-dark {
	background:#71b60e;
}
.content-box .icon-title.icon-title-dark i {
	color:#eee;
}
.content-box-title {
	color: #006600!important;
	font-size:1.5em
}
.animation-delay-10 {
    animation-delay: 1s !important;
}
.fadeInUp {
    animation-name: fadeInUp;
}
.animated {
    animation-duration: 1s;
    animation-fill-mode: both;
}
* {
    box-sizing: border-box;
}
.section{
	font-weight:normal; padding-bottom:10px
}
h3 {
    font: 400 21px/24px "Open Sans",sans-serif;
}
</style>
</head>

<body>
<div id="main-wrapper" style="display:none;height:988px; opacity:0; position:fixed; top:0; z-index:900; margin:0 -30px" class="modal-backdrop fade in"></div>
  <div class="container">
      <a class="navbar-brands" href="#" style="padding:0 50px 10px 20px; margin:5px; position:relative; z-index:3000"><img src="assets/image/logo-blank2.png" border="0" title="<?=$title;?>" style="margin-top:10px; margin-bottom:-3px" /></a>
  </div><!-- /.container-fluid -->
<div id="headers" class="sticky-header" style="background:#fcfcfc">
<div id="closure">
<nav class="navbar navbar-default" role="navigation">
<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <li><a href="#">BERANDA</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">TENTANG BRWA &nbsp;<i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#">Profil </a></li>
              <li><a href="#">Kantor</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdownx" data-hover="dropdown">PENDAFTARAN &nbsp;<i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#">Prosedur <sup>&reg;</sup></a></li>
              <li class="divider"></li>
              <li><a href="#">Formulir Pendaftaran</a></li>
              <li><a href="#">Pendaftaran Online</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdownx" data-hover="dropdown">DATA &nbsp;<i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#">Teregistrasi</a></li>
              <li><a href="#">Terverifikasi</a></li>
              <li class="divider"></li>
              <li><a href="#">Peta Wilayah Adat &nbsp;<i class="fa fa-globe"></i></a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdownx" data-hover="dropdown">LAYANAN &nbsp;<i class="fa fa-angle-down"></i></a>
            <ul class="dropdown-menu">
              <li><a href="#">SLPP</a></li>
              <li><a href="#">UKP3</a></li>
            </ul>
          </li>
          <li><a href="#">KONTAK</a></li>
        </ul>
      <ul class="nav navbar-nav navbar-right">
       <li><a href="#"><i class="fa fa-phone"></i> +62 21 83702010</a></li>
       <li style="border-left:0px solid #eee"><a href="#"><i class="fa fa-facebook"></i> <i class="fa fa-twitter"></i> <i class="fa fa-envelope"></i>&nbsp;</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
</div>
</nav>
</div>

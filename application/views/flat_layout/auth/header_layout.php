<?
	/*$appname=$this->lat_auth->get_appname();
	$userdata=isset($_SESSION[$appname]["userdata"])?$_SESSION[$appname]["userdata"]:FALSE;
	if(!$userdata):
		redirect("login/");
	endif;
	$id=$this->encrypt_status==TRUE?encrypt($userdata['id']):$userdata['id'];*/
?>

	<!-- Top Bar Starts -->
		<!--<div class="top-bar">-->
		<!-- Nested Container Starts -->
			<!--<div class="container clearfix text-center-xs">
				<p class="pull-left-lg pull-left-md pull-left-sm text-left-lg text-left-md text-left-sm text-light">&nbsp; <small>Media Informasi</small></p>
				<small class="pull-right-lg pull-right-md pull-right-sm text-right-lg text-right-md text-right-sm text-light">
					Direktorat Jendral Otonomi Daerah
				</small>
			</div>-->
		<!-- Nested Container Ends -->
		<!--</div>-->
	<!-- Top Bar Ends -->
    <style>
		.brand-custom a{
			float: left;
			height: 50px;
			padding: 0px 10px 0px;
			font-size: 18px;
			line-height: 40px;
		}
		.brand-custom h3,.brand-custom h4{
			margin-top:0px;
			margin-bottom:0px;
		}
	</style>
	<!-- Main Menu Starts -->
		<nav id="nav" class="main-menu navbar flat navbar-fixed-top" style="border-top:5px solid #033">
		<!-- Nested Container Starts -->
			<div class="container">
			<!-- Nav Header Starts -->
				<div class="navbar-header">
					<button type="button" class="btn btn-navbar navbar-toggle flat animation" data-toggle="collapse" data-target=".navbar-cat-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<i class="fa fa-bars"></i>
					</button>
				</div>
			<!-- Nav Header Ends -->
			<!-- Navbar Cat collapse Starts -->
				<div class="collapse navbar-collapse navbar-cat-collapse animation">
				<!-- Nav Links Starts -->
					<ul class="nav navbar-nav text-bold">
						<li class="active"><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/about.html">BERANDA</a></li>
						<li><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/about.html">POLITIK</a></li>
						<li><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/services.html">EKONOMI</a></li>
						<li class="dropdown">
							<a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/blog.html" class="dropdown-toggle" data-toggle="dropdown">DAERAH <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu flat" role="menu">
								<li><a tabindex="-1" href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/blog.html">Blog Page</a></li>
								<li><a tabindex="-1" href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/blog-2col.html">Blog 2 Col</a></li>
								<li><a tabindex="-1" href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/blog-3col.html">Blog 3 Col</a></li>
								<li><a tabindex="-1" href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/blog-single.html">Blog Single Page</a></li>
							</ul>
						</li>
						<li><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/contact.html">DEMOGRAFI</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">PRESTASI <i class="fa fa-angle-down"></i></a>
							<ul class="dropdown-menu flat" role="menu">
								<li tabindex="-1"><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/team.html">Team</a></li>
								<li tabindex="-1"><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/faq.html">Faq's</a></li>
								<li tabindex="-1"><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/pricing.html">Pricing</a></li>
								<li tabindex="-1"><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/gallery.html">Gallery</a></li>
								<li tabindex="-1"><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/404.html">404</a></li>
								<li tabindex="-1"><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/coming-soon.html">Coming Soon</a></li>
							</ul>
						</li>
                        <li><a href="http://sainathchillapuram.com/BS/Fin-Advicer/demo/contact.html">PROFIL</a></li>
					</ul>
				<!-- Nav Links Ends -->
				<!-- Search Form Starts -->					
					<form class="navbar-form navbar-right hidden-sm hidden-xs" role="search">
						<div class="input-group">
						  <input class="form-control" placeholder="Search" type="text">
						  <span class="input-group-btn">
							<button class="btn btn-default" type="button">
								<i class="fa fa-search"></i>
							</button>
						  </span>
						</div>
					</form>
				<!-- Search Form Ends -->
				</div>
			<!-- Navbar Cat collapse Ends -->
			</div>
		<!-- Nested Container Ends -->
		</nav>
	<!-- Main Menu Ends -->    <!-- Header Starts -->
		<header class="main-header">
		<!-- Nested Container Starts -->
			<div class="container text-center-xs">
			<!-- Nested Row Starts -->
				<div class="row">
				<!-- Logo Starts -->
					<div class="col-lg-4 col-sm-4 col-xs-12">
                    	<div class="clearfix brand-custom">
						<a href="#"><img src="assets/images/logo.png" alt="LOGO" class="img-responsive img-center-xs logo"></a>
							<h3>MESI-OTDA</h3>
						</div>
					</div>
				<!-- Logo Ends -->
				<!-- Opening Hours Starts -->
					<div class="col-lg-4 col-sm-4 col-xs-12 col-lg-offset-1 hidden-xs">
						<div class="clearfix">
							<i class="fa fa-comments-o pull-left-lg pull-left-md pull-left-sm circle"></i>
							<h6 class="text-spl-color text-medium">LAPOR</h6>
							<p class="help-block"><em>Layanan Aspirasi dan Pengaduan Online</em></p>
						</div>
					</div>
				<!-- Opening Hours Ends -->
				<!-- Contact Number Starts -->
					<div class="col-lg-3 col-sm-4 col-xs-12 hidden-xs">
						<div class="clearfix">
							<i class="fa fa-phone pull-left-lg pull-left-md pull-left-sm circle"></i>
							<h6 class="text-spl-color text-medium">Contact Number</h6>
							<p class="text-light"><em>888–123–2323, 555–123–2323</em></p>
						</div>
					</div>
				<!-- Contact Number Ends -->
				</div>
			<!-- Nested Row Ends -->
			</div>
		<!-- Nested Container Ends -->
		</header>
	<!-- Header Ends -->

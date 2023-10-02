	<style>
		.brand-custom a{
			float: left;
			height: 30px;
			padding: 0px 10px 0px;
			font-size: 18px;
			line-height: 40px;
		}
		.brand-custom h3,.brand-custom h4{
			margin-top:0px;
			margin-bottom:0px;
		}
	</style>
		<nav id="nav" class="main-menu navbar flat navbar-fixed-top" style="border-top:7px solid #861e19">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="btn btn-navbar navbar-toggle flat animation" data-toggle="collapse" data-target=".navbar-cat-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<i class="fa fa-bars"></i>
					</button>
				</div>
				<div class="collapse navbar-collapse navbar-cat-collapse animation">	
					
					<ul class="pull-right nav navbar-nav text-bold">
						<li><a><b style="font-size:20px;"><img src="assets/images/logo.jpg" style="margin:-15px 0px -15px -10px" width="60"></b></a></li>
					</ul>
					
					<ul class="pull-left nav navbar-nav text-bold">
						<li class="<?=($this->active=="home")?"active":""?>"><a href="">BERANDA</a></li>
                        <li class="<?=($this->active=="profiles")?"active":""?>"><a href="profiles">ABOUT US</a></li>
                        <!--<li class="<?=($this->active=="berita")?"active":""?>"><a href="news">BERITA</a></li>-->
						<li class="<?=($this->active=="layanan")?"active":""?>"><a href="layanan">LAYANAN</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<!--
		<header class="main-header">
			<div class="container text-center-xs">
				<div class="row">
					<div class="col-lg-4 col-sm-4 col-xs-12">
						<div class="clearfix brand-custom">
						</div>
					</div>
				</div>
			</div>
		</header>
		-->

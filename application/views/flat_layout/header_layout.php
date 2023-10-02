
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
		.pagination > li > a, .pagination > li > span {
			padding-left: 0;
		}
		.containerx {
			padding-top: 0px;
			padding-bottom: 4px;
			padding-right: 15px;
			padding-left: 15px;
			}
		.main-menu .navbar-nav > li.active > a {
			color: #5bc0de !important;
		}
		.main-menu .navbar-nav > li > a:hover{
			color: #5bc0de !important;
		}
	</style>
		<nav id="nav" class="main-menu navbar flat navbar-fixed-top" style="border-top:3px solid #5bc0de; background:#fafafa">
			<div class="container">
				<div class="navbar-header">
                	<a href=""><img src="assets/images/tk.png" class="pull-left" style="margin:5px 15px -30px 15px"></a>
					<button type="button" class="btn btn-navbar navbar-toggle flat animation" data-toggle="collapse" data-target=".navbar-cat-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<i class="fa fa-bars"></i>
					</button>
				
					
						
						<!--<i class="fa fa-angle-down togleup" aria-hidden="true"></i>-->

					
				</div>
				<div class="collapse navbar-collapse navbar-cat-collapse animation">
					
					<!--<ul class="pull-right nav navbar-nav text-bold">
						<li><a><b style="font-size:20px;"><img src="assets/images/tk.png" class="pull-rights" style="margin:5px 15px -30px -10px"></b></a></li>
					</ul>-->

					<ul class="pull-left nav navbar-nav text-bold">
						<li class="<?=($this->active=="dashboard")?"active":""?>"><a href="">BERANDA</a></li>
						<li class="<?=($this->active=="home")?"active":""?>"><a href="home">PETA</a></li>
						<li class="<?=($this->active=="news")?"active":""?>"><a href="news">BERITA</a></li>
                        <li class="<?=($this->active=="profiles")?"active":""?>"><a href="profiles">TENTANG KAMI  .</a></li>
						
						<!-- MENU PUSTAKA -->                 
							<!-- <li class="<?=($this->active=="pustaka")?"active":""?> dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">PUSTAKA &nbsp;<i class="fa fa-angle-down"></i></a>
								<ul class="dropdown-menu" role="menu">
								<li><a href="pustaka/pp">Peraturan Kebijakan</a></li>
								<li><a href="pustaka/hp">Hasil Penelitian & Analisis</a></li>
								</ul>
							</li> -->
						<!-- END MENU PUSTAKA -->
      
                        
                        <li class="<?=($this->active=="layanan")?"active":""?>"><a href="layanan">PELAPORAN</a></li>
                        
						<li class="<?=($this->active=="buku_tamu")?"active":""?>"><a href="buku_tamu">KONTAK</a></li>
                        
      
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
<script>
	$(document).ready(function(){
		$(".togleup").click(function(){
			$(".xhead").slideToggle('slow');
		});
	});
</script>
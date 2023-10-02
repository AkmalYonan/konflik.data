<?
	$appname=$this->lat_auth->get_appname();
	$userdata=isset($_SESSION[$appname]["userdata"])?$_SESSION[$appname]["userdata"]:FALSE;
	if(!$userdata):
		redirect("login/");
	endif;
	$id=$this->encrypt_status==TRUE?encrypt($userdata['id']):$userdata['id'];
	$wilayah = $this->user_data["kd_org"]?$this->lookup_all_wilayah['lookup_wilayah'][$this->user_data["kd_org"]]:"BNN Pusat";
?>

<header class="main-header">
      <!-- Logo -->
    <a href="<?=base_url()?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="assets/images/logo.png" width="40"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg" style="text-align:left; margin-left:-10px"><img src="assets/images/logo_dinamof.png" width="45"> dinamof.co.id</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">

        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu pull-left">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a class="dropdown-toggle" data-toggle="dropdown">
                  <img src="assets/images/indonesia.png" width="70" style="margin:-15px 0px -15px -10px">
                  <span class="hidden-xs"><strong>| Tata Kelola Konflik</strong></span>
                </a>
              </li>
            </ul>
         </div>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                  <i class="glyphicon glyphicon-user"></i> <?=$this->user_data["username"]?> (<?=$this->group_data[0]['name']?>)
                  <span class="caret"></span>
                </a>
                
                <?
									$ts = $this->user_data['last_login'];
									$date = new DateTime("@$ts");
								?>
                <ul class="dropdown-menu" style="width:100%!important">
                  <!-- User image -->
                  <li class="user-header">
                    <p>
                      <?=$this->user_data["first_name"]?><br /><?=$this->group_data[0]['name']?>
                      <small>Login Terakhir <?=$date->format('d-m-Y H:i')?></small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="<?=base_url()?>admin/logout/" class="btn btn-default btn-flat btn-block">Keluar</a>
                    </div> 
                    <div class="pull-right">
                      <a href="admin/user/profil" class="btn btn-default btn-flat btn-block">Profil Saya</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>

        </div>

    </nav>
</header>
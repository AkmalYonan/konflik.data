<? $this->load->view("admin_layout/header");?>
<?
	/*
	$appname=$this->lauth->get_appname();
	$userdata=isset($_SESSION[$appname]["userdata"])?$_SESSION[$appname]["userdata"]:FALSE;
	if(!$userdata):
		redirect("login/");
	endif;
	*/
?>
<!-- start: Header -->
<nav class="navbar navbar-default hidden-print" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <!--<div class="navbar-header">
    <a class="nav-toggle-right visible-xs " href="#" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="icon-resize-full active"></i></a>	
    <a id="main-menu-toggle2" class="nav-toggle visible-xs opennavbar-toggle" data-toggle="collapse" data-target=".sidebar-nav.nav-collapse"><i class="icon-list active"></i></a>	
    <a class="navbar-brand" href="#"><img src="assets/images/logo-tiny.png" style="padding:0"> Grup-3 Kopassus</a>
  </div>-->

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="navbar-collapse navbar-ex1-collapse navbar-top">
    <ul class="nav navbar-nav navbar-right">
        <!-- start: User Dropdown -->
        <li class="dropdown">
            <a class="btn account dropdown-toggle" data-toggle="dropdown" href="index.html#">
                <div class="user">
                    <span class="hello">Selamat Datang!</span>
                    <span class="name"><?=$userdata["first_name"]?> <?php echo $userdata["last_name"]?></span>
                </div>
            </a>
            <ul class="dropdown-menu">
                <li><a href="index.html#"><i class="icon-user"></i> Profile</a></li>
                <li><a href="index.html#"><i class="icon-cog"></i> Settings</a></li>
                <li><a href="index.html#"><i class="icon-envelope"></i> Messages</a></li>
                <li><a href="<?=base_url()?>logout/"><i class="icon-off"></i> Logout</a></li>
            </ul>
        </li>
        <!-- end: User Dropdown -->
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
<!-- end: Header -->

<!-- start: main Menu -->
<?php //echo isset($sidebar)?$sidebar:$this->load->view("admin_layout/menu_example");?>
<!-- end: main Menu -->

                    
<!-- start: Content Wrapper -->
<div id="content">
   	<? echo $content;?>
</div>
<!-- end: Content Wrapper -->


<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="clearfix"></div>

<? $this->load->view("admin_layout/footer");?>
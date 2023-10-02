<? $this->load->view("header");?>
<style>
body {
	background:#fff
}
.container,.carousel {
        margin: 0 auto;
        max-width: 968px;
      }
#login-wraper {
	margin-top:50px;
    display: block;
    padding: 0px;
    width: 968px;
    height: auto;
	border-radius:3px;
    background: #f8f8f8;
}
#login-body {
	padding:10px;
}
#login-footer {
	padding:10px;
	background:#eee
}
.shadow {
	-moz-box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.1);
    -webkit-box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.1);
}
.login-form .body {
    padding-bottom: 30px;
    border-bottom: 1px solid rgb(238, 238, 238);
}
.div_message p {
	margin:0!important;
}
.login-row{

}
</style>
<div class="navbar navbar-inverse" style="background:none; background-color:#fff; margin-bottom:0px;">
    <div class="navbar-inner" style="background:none; background-color:transparent; border:0;">
        <div class="container">
            <a class="brand" href="" style="margin:5px 0px 10px 10px" title="PPID - Provinsi Aceh"><img src="assets/image/logo2.png" align="absmiddle"></a>
        </div>
    </div>
</div>
<?php echo form_open("user/login");?>
<div class="container">
    <div id="login-wraper" class="shadow">
    <div id="login-body">
        <div class="row-fluid">
            <div class="span12"><?php echo message_box();?></div>
        </div>
        <div class="row-fluid">
            <div class="span5" style="padding:10px; border-right:1px dotted #ddd">
                        <input type="hidden" name="pending_url" value="<?=$this->session->flashdata('pending_url');?>" />
                    <legend><?php echo lang('login_heading');?></legend>
                    <div class="bodys">
                        <label><?php echo lang('login_identity_label');?></label>
                        <?php echo form_input($identity);?>
                        
                        <label><?php echo lang('login_password_label');?></label>
                        <?php echo form_input($password);?>
                    </div>
            </div>
            <div class="span7" style="padding:10px;">
                    <legend>Belum menjadi anggota?</legend>
                    <label>Dengan menjadi anggota online <strong>PPID ACEH</strong>, anda dapat:</label>
                        <ul class="unstyled">
                            <li>Melakukan proses permohonan informasi dengan lebih mudah, dan</li>
                            <li>Anda dapat mengetahui proses Permohonan informasi anda sampai dengan selesai</li>
                            <li>Mengajukan permohonan keberatan</li>
                        </ul>
                    
            </div>
        </div>
        <div class="row-fluid">
            <div class="span5" style="padding-left:10px; border-right:1px dotted #ddd">
                <button type="submit" class="btn btn-primary" style="margin-right:10px"><?php echo lang('login_submit_btn'); ?></button>
                <label class="checkbox inline">
                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><?php echo lang('login_remember_label', 'remember');?>
                </label>
            </div>
            <div class="span7" style="padding-left:10px;">
                <a href="user/register" class="btn btn-primary"><?php echo lang('login_register');?></a>
            </div>
        </div>
        
        </div>
        <!--login-body-->
        <!--login-footer-->
        <div id="login-footer">
            <div class="row-fluid">
                <div class="span12" style="padding-left:10px">
                    <a href="user/forgot_password"><?php echo lang('login_forgot_password');?></a><br />
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<?php echo form_close();?>
<div class="container">
	 <div class="row-fluid">
        <div class="span12 help-block" style="margin-top:20px; padding-left:20px;">&copy; 2011-<?=date("Y");?> <a href="https://ppid.acehprov.go.id/"><b>PPID - ACEH</b></a>, All rights reserved.  </div>
    </div>
</div>
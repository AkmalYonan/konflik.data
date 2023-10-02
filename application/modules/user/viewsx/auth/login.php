<? $this->load->view("header");?>
<style>
body {
	background:url(assets/image/login_bg.png) center no-repeat;
}
.form-signin ,.spacer-wall
{
    padding: 15px;
    margin: 0 auto;
}
.form-signin .form-signin-heading, .form-signin .checkbox
{
    margin-bottom: 10px;
}
.form-signin .checkbox
{
    font-weight: normal;
}
.form-signin .form-control
{
    display:block;
    font-size: 16px;
    height: auto;
    padding: 10px;
	width:100%;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.form-signin .form-control:focus
{
    z-index: 2;
}
.form-signin input[type="text"]
{
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}
.form-signin input[type="password"]
{
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
.account-wall
{
    margin-top: 100px;
    padding: 20px 0px 20px 0px;
    background-color: rgba(0,0,0,0.1);
	border-radius:2px;
    /*-moz-box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);
    -webkit-box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);
    box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);*/
}
.login-title
{
    color: #555;
    font-size: 18px;
    font-weight: 400;
    display: block;
}
.profile-img
{
    width: 96px;
    height: 96px;
    margin: 0 auto 10px;
    display: block;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
}
.need-help
{
    margin-top: 10px;
}
.new-account
{
    display: block;
    margin-top: 10px;
}
</style>

<div class="container">
	<div class="row">
    	<div class="span12" style="text-align:center">
        	
        </div>
    </div>
    <div class="row">
        <div class="span4 offset4">
            <div class="account-wall">
            	 <div class="spacer-wall">
                 	<div style="color:#fff; text-align:center; font-size:x-large">PPID ACEH - Login</div>
                 </div>
                <!--<img class="profile-img" src="assets/image/login-logo.png" alt="">-->
                <?php echo form_open("user/login",'class="form-signin"');?>
                <?php echo form_input($identity);?>
                <?php echo form_input($password);?>
                <input type="hidden" name="pending_url" value="<?=$this->session->flashdata('pending_url');?>" />
                <!--<input type="text" class="form-control" placeholder="Email" required autofocus>-->
                <!--<input type="password" class="form-control" placeholder="Password" required>-->
                <button type="submit" class="btn btn-success btn-large btn-block"><?php echo lang('login_submit_btn'); ?></button>
                <label class="checkbox  pull-left">
					<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><?php echo lang('login_remember_label', 'remember');?>
                </label>
                <label class="checkbox pull-right">
                <a href="user/forgot_password" class="need-help"><?php echo lang('login_forgot_password');?></a><span class="clearfix"></span>
                </label>
                &nbsp;
				<?php echo form_close();?>
                <div class="spacer-wall" style="border-top:1px solid #ddd">
                <div style="text-align:center"></div>
                <a href="user/register" class="text-center new-account btn btn-primary btn-large btn-block">Belum punya Akun? <?php echo lang('login_register');?></a>
                </div>
            </div>
            
        </div>
    </div>
</div>

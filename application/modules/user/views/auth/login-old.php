<? $this->load->view("header");?>
<style>
body {
	background:#fff
}
#login-wraper {
    position: absolute;
    top: 50%;
    left: 50%;
    display: block;
    margin-top: -200px;
    margin-left: -285px;
    padding: 0px;
    width: 520px;
    height: auto;
	border-radius:5px;
    background: #f7f7f7;
}
.shadow {
	-moz-box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);
    -webkit-box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);
    box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);
}
.login-form .body {
    padding-bottom: 30px;
    border-bottom: 1px solid rgb(238, 238, 238);
}
.div_message p {
	margin:0!important;
}
</style>

<div class="container">
        <div id="login-wraper">
        <div class="row-fluid" style="background:#fff">
        	<div class="span12"><?php echo message_box();?></div>
        </div>
        <div class="row-fluid shadow">
        	<div class="span4" style="background:#03873d url(assets/image/login-logo.png) no-repeat; height:320px; padding:10px 20px 10px 10px">
            </div>
            <div class="span8" style="padding:10px;">
			<?php echo form_open("user/login");?>
        			<input type="hidden" name="pending_url" value="<?=$this->session->flashdata('pending_url');?>" />
                <legend><?php echo lang('login_heading');?></legend>
                <div class="bodys">
                    <label><?php echo lang('login_identity_label');?></label>
                    <?php echo form_input($identity);?>
                    
                    <label><?php echo lang('login_password_label');?></label>
                    <?php echo form_input($password);?>
                </div>
            
                <div class="footer" style="margin-bottom:10px">
                	<!--<?php echo form_submit('submit', lang('login_submit_btn'));?>-->
                    <button type="submit" class="btn btn-primary" style="margin-right:10px"><?php echo lang('login_submit_btn'); ?></button>
                    <label class="checkbox inline">
                        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><?php echo lang('login_remember_label', 'remember');?>
                    </label>
                </div>
            	<a href="user/forgot_password"><?php echo lang('login_forgot_password');?></a><br />
                Belum punya Akun? <a href="user/register"><?php echo lang('login_register');?></a>
            <?php echo form_close();?>
        </div>
		</div>
        
		</div>
        </div>
        
    </div>

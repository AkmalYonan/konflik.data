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
    margin-top: -185px;
    margin-left: -285px;
    padding: 0px;
    width: 520px;
    height: auto;
	border-radius:5px;
    background: #eee;
}
.login-form .body {
    padding-bottom: 30px;
    border-bottom: 1px solid rgb(238, 238, 238);
}
</style>

<div class="container">
		<?php if(!empty($message)):?>
        <div class="alert alert-error">
        	<a class="close" data-dismiss="alert" href="#">x</a><?php echo $message;?>
        </div>
        <?php endif;?>
	
        <div id="login-wraper">
        <div class="row-fluid">
        	<div class="span4" style="background:#03873d; height:320px; padding:10px 20px 10px 10px">
            <img src="assets/image/kemhub_logos.png" />
            </div>
            <div class="span8" style="padding:10px;">
			<?php echo form_open("user/auth/login");?>
                <legend>Sign in</legend>
                <div class="bodys">
                    <label>Username</label>
                    <?php echo form_input($identity);?>
                    
                    <label>Password</label>
                    <?php echo form_input($password);?>
                </div>
            
                <div class="footer" style="margin-bottom:10px">
                	<!--<?php echo form_submit('submit', lang('login_submit_btn'));?>-->
                    <button type="submit" class="btn btn-primary" style="margin-right:10px"><?php echo lang('login_submit_btn'); ?></button>
                    <label class="checkbox inline">
                        <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><?php echo lang('login_remember_label', 'remember');?>
                    </label>
                </div>
            	<a href="user/forgot_password"><?php echo lang('login_forgot_password');?></a>
            <?php echo form_close();?>
        </div>
		</div>
        
		</div>
        </div>
        
    </div>

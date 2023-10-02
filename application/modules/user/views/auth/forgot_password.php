<div class="subheader">
    <div class="container subheader-inner">
    	<h1><?php echo lang('forgot_password_heading');?></h1>
    </div>
</div>
<div class="container" style="margin-bottom:20px">
<ul class="breadcrumb" style="margin-left:0; margin-top:-10px">
        <li><a href="#">Home</a> <span class="divider">/</span></li>
        <li><a href="user">User</a> <span class="divider">/</span></li>
        <li class="active">Forgot Password</li>
    </ul>
	<div class="row-fluid">
	    <div class="span12">    
        	<h3 class="sub" style="border-bottom:2px solid #aaa">Reset Password</h3>
            <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
            
            <div id="infoMessage"><?php echo $message;?></div>
            
            <?php echo form_open("user/forgot_password");?>
            
                  <p>
                    <label for="email"><?php echo sprintf(lang('forgot_password_email_label'), $identity_label);?></label> <br />
                    <?php echo form_input($email);?>
                  </p>
            	  <div class="form-actions">
                    <?php echo form_submit('submit', lang('forgot_password_submit_btn'),' class="btn btn-primary"');?>
                </div>
            
            <?php echo form_close();?>
        </div>
    </div>
</div>
<div class="subheader">
    <div class="container subheader-inner">
    	<h1><?php echo lang('reset_password_heading');?></h1>
    </div>
</div>
<div class="container" style="margin-bottom:20px">
<ul class="breadcrumb" style="margin-left:0; margin-top:-10px">
        <li><a href="#">Home</a> <span class="divider">/</span></li>
        <li><a href="user">User</a> <span class="divider">/</span></li>
        <li class="active">Change Password</li>
    </ul>
	<div class="row-fluid">
	    <div class="span12">    
        	<h3 class="sub" style="border-bottom:2px solid #aaa">Change Password</h3>

                <div id="infoMessage"><?php echo $message;?></div>
                
                <?php echo form_open('user/reset_password/' . $code);?>
                
                    <p>
                        <label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
                        <?php echo form_input($new_password);?>
                    </p>
                
                    <p>
                        <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
                        <?php echo form_input($new_password_confirm);?>
                    </p>
                
                    <?php echo form_input($user_id);?>
                    <?php echo form_hidden($csrf); ?>
                
                    <div class="form-actions">
						<?php echo form_submit('submit', lang('reset_password_submit_btn'),' class="btn btn-primary"');?>
                    </div>
                
                <?php echo form_close();?>
			</div>
        </div>
    </div>
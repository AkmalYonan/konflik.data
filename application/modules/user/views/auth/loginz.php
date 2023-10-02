<? $this->load->view("header");?>
<?php echo form_open("admin/auth/login");?>
<table align="center" style="width:50%;min-width:300px">
	<?php if(!empty($message)):?>
	<tr><td colspan="2"><div id="infoMessage" class="alert alert-warning"><?php echo $message;?></div></td></tr>
    <?php endif;?>
    <tr><td colspan="2"><h1><?php echo lang('login_heading');?></h1></td></tr>
    <tr><td colspan="2"><p><?php echo lang('login_subheading');?></p></td></tr>
	<tr>
    	<td>
			<?php echo lang('login_identity_label', 'identity');?>
    	</td>
    	<td>
    		<?php echo lang('login_password_label', 'password');?>
        </td>
    </tr>
    <tr>
    	<td><?php echo form_input($identity);?></td><td><?php echo form_input($password);?></td>
    </tr>
    <tr>
    	<td colspan="2">
		<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><label><?php echo lang('login_remember_label', 'remember');?></label>
    	
    </td>
    </tr>
    <tr>
    	<td colspan="2"><?php echo form_submit('submit', lang('login_submit_btn'));?></td>
    </tr>
	 <tr>
    	<td colspan="2"><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></td>
    </tr>
</table>
<?php echo form_close();?>

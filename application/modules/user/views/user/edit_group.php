 <div id="breadcrumbs" class="breadcrumbs-fixed">
  <ul class="breadcrumb">
    <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
    <li><a href="admin/auth/">Account Manager</a> <span class="divider">/</span></li>
    <li><a href="admin/groups/">Groups</a> <span class="divider">/</span></li>
    <li class="active">Edit</li>
    </ul>
</div>
<div style="padding:40px 25px">
<div class="row-fluid">
<div class="span12">
<h4 class="title"><?php echo lang('edit_group_heading');?></h4>
<p><?php echo lang('edit_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("admin/auth/edit_group/$id");?>
	
      <p>
            <?php echo lang('create_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

      <p><?php echo form_submit('submit', lang('edit_group_submit_btn'));?></p>

<?php echo form_close();?>

</div></div></div>
<div id="breadcrumbs" class="breadcrumbs-fixed">
<ul class="breadcrumb">
    <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
    <li><a href="admin/auth/">Account Manager</a> <span class="divider">/</span></li>
    <li><a href="admin/auth/groups/">Groups</a> <span class="divider">/</span></li>
    <li class="active">Create</li>
    </ul>
 </div>   
<div style="padding:40px 25px">
<div class="page-header">
	<h1>Group <small> Create </small></h1>
</div>
<!--<h4 class="title"><?php echo lang('create_group_heading');?></h4>-->
<p><?php echo lang('create_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_group","class='form-horizontal'");?>

      <p>
            <?php echo lang('create_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('create_group_desc_label', 'description');?> <br />
            <?php echo form_input($description);?>
      </p>

      <p><?php echo form_submit('submit', lang('create_group_submit_btn'),"class='btn btn_info'");?></p>

<?php echo form_close();?>
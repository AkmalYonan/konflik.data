  <ul class="breadcrumb">
    <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
    <li><a href="admin/auth/">Account Manager</a> <span class="divider">/</span></li>
    <li class="active">Users</li>
    </ul>

<h4 class="title"><?php echo lang('index_heading');?></h4>
<p><?php echo lang('index_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<table cellpadding=0 cellspacing=10 class="table table-bordered table-stripped">
	<tr>
		<th><?php echo lang('index_fname_th');?></th>
		<th><?php echo lang('index_lname_th');?></th>
        <th><?php echo lang('index_name_th');?></th>
		<th><?php echo lang('index_email_th');?></th>
		<th><?php echo lang('index_groups_th');?></th>
		<th><?php echo lang('index_status_th');?></th>
		<th><?php echo lang('index_action_th');?></th>
	</tr>
	<?php foreach ($users as $user):?>
		<tr>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name;?></td>
            <td><?php echo $user->username;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("admin/auth/edit_group/".$group->id, $group->name) ;?><br />
                <?php endforeach?>
			</td>
			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
			<td><?php echo anchor("admin/auth/edit_user/".$user->id, 'Edit') ;?></td>
		</tr>
	<?php endforeach;?>
</table>

<p><?php echo anchor('admin/auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('admin/auth/create_group', lang('index_create_group_link'))?></p>
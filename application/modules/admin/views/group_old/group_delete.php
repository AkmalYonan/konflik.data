<div id="breadcrumbs" class="breadcrumbs-fixed">
<ul class="breadcrumb">
        <li><a href="admin/">Home</a> <span class="divider">/</span></li>
        <li><a href="<?=$this->module?>">Account Manager</a> <span class="divider">/</span></li>
        <li><a href="<?=$this->module?>group_list">Groups</a> <span class="divider">/</span></li>
        <li class="active">Delete</li>
    </ul>
</div>

<div style="padding:40px 25px">
<div class="page-header">
	<h1>Group <small> Delete </small></h1>
</div>
<br>

<div class="row-fluid">
<div class="span12">
	
	Are You sure to delete this data:<br>
    <form method="post" action="<?php echo $this->module?>group_delete/<?php echo $data["id"]?>" >
    <input type="hidden" name="act"  value="delete" />
    <table class="table table-condensed table-bordered" style="max-width:500px">
    	<thead class="box_quote">
    	<tr>
        	<th style="width:300px">Group</th>
        	<th>Description</th></tr>
        </thead>
        <tr>
        	<td><?php echo $data["name"]?></td>
            <td><?php echo $data["description"]?></td>
        </tr>
    </table>
    
    <div class="form-actions">
        	<button class="btn btn-warning" type="submit"><i class="icon-book icon-white"></i> Ya </button>
        	<a class="btn" href="<?php echo $this->agent->referrer()?>" class="btn btn-warning "><i class="icon-refresh"></i> Back To Group List</a>
        </div>
    </form>
    
</div></div><!-- /row-->

<script>
	$(function(){
		var act_link="group";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>
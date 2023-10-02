<div id="breadcrumbs" class="breadcrumbs-fixed">
    <ul class="breadcrumb">
    <li><i class="icon-home bc-icon"></i> <a href="#">Home</a> <span class="divider">\</span></li>
    <li><a href="<?=$this->module?>link_list">Link Directory</a> <span class="divider">\</span></li>
    <li><a href="<?=$this->module?>category_list">Category</a> <span class="divider">\</span></li>
    <li class="active">Delete</li>
    </ul>
</div>
<!-- div for positioning -->
<div style="padding:40px 25px">
<div class="page-header">
	<h1>Delete Category<small> </small></h1>
</div>
<!-- end Komeng Prepend -->
<div class="row-fluid">
<div class="span12">
	<!--<ul class="breadcrumb">
        <li><a href="admin/">Home</a> <span class="divider">/</span></li>
        <li><a href="admin/dms/">DMS</a> <span class="divider">/</span></li>
        <li><a href="admin/dms/category_list">Category</a> <span class="divider">/</span></li>
        <li class="active">Delete</li>
    </ul>
	
    <h4 class="heading">Category : Delete</h4>--><br />
	Are You sure to delete this data:<br>
    <form method="post" action="<?php echo $this->module?>category_delete/<?php echo $data["idx"]?>" >
    <input type="hidden" name="act"  value="delete" />
    <table class="table table-condensed table-bordered" style="max-width:500px">
    	<thead class="box_quote">
    	<tr>
        	<th style="width:300px">Category</th>
        	<th>Description</th></tr>
        </thead>
        <tr>
        	<td><?php echo $data["category"]?></td>
            <td><?php echo $data["description"]?></td>
        </tr>
    </table>
    
    <div class="form-actions">
        	<button class="btn btn-warning" type="submit"><i class="icon-book icon-white"></i> Ya </button>
        	<a class="btn" href="<?php echo $this->module?>category_list" class="btn btn-warning "><i class="icon-refresh"></i> Back To Category List </a>
        </div>
    </form>
    
</div></div><!-- /row-->

</div>

<script>
	$(function(){
		var act_link="<?=$this->module?>category";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>
<div id="breadcrumbs" class="breadcrumbs-fixed">
    <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider">\</span></li>
    <li><a href="<?=$this->module?>link_list">Link/Directory</a> <span class="divider">\</span></li>
        <li class="active">Edit</li>
    </ul>
</div>

<!-- div for positioning -->
<div style="padding:40px 25px">
<div class="page-header">
	<h1>Link Delete<small> </small></h1>
</div>
<!-- end Komeng Prepend -->

<div class="row-fluid">
<div class="span12">
	<!--<ul class="breadcrumb">
        <li><a href="admin/">Home</a> <span class="divider">/</span></li>
        <li><a href="<?=$this->module?>link_list">Link/Directory</a> <span class="divider">/</span></li>
        <li class="active">Delete</li>
    </ul>
	
    <h4 class="heading">Link : Delete</h4>--><br />
	Are You sure to delete this data:<br>
    <form method="post" action="<?php echo $this->module?>link_delete/<?php echo $data["idx"]?>" >
    <input type="hidden" name="act"  value="delete" />
    <table class="table table-condensed table-bordered" style="max-width:500px">
    	<thead class="box_quote">
    	<tr>
        	<th style="width:300px">Name</th>
        	<th>URL</th>
            <th>Category</th>
            </tr>
        </thead>
        <tr>
        	<td><?php echo $data["name"]?></td>
            <td><?php echo $data["link_url"]?></a></td>
            <td><?php echo $this->arr_category[$data["category"]]?><?=$$data["category"]?></td>
        </tr>
    </table>
    
    <div class="form-actions">
        	<button class="btn btn-warning" type="submit"><i class="icon-book icon-white"></i> Ya </button>
        	<a href="<?php echo $this->module?>category_list" class="btn"><i class="icon-refresh"></i> Back To Category List </a>
        </div>
    </form>
    
</div></div><!-- /row-->
</div>

<script>
	$(function(){
		var act_link="<?=$this->module?>link";	
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>
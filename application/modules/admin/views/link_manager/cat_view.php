<script>
	$(document).ready(function(){
	    $(".a_edit").click(function(e){
			e.preventDefault();
			var id=$("#id").val();
			var url="<?php echo base_url();?><?php echo $this->module;?>user_edit/"+id;
			location=url;
		});
		
		$(".a_view").click(function(e){
			e.preventDefault();
			var id=$("#id").val();
			var url="<?php echo base_url();?><?php echo $this->module;?>user_view/"+id;
			location=url;
		});
	   
	});
	
	
</script>

<div class="row-fluid">
<div class="span12">
 <ul class="breadcrumb">
        <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
        <li><a href="admin/account_manager/">Account Manager</a> <span class="divider">/</span></li>
        <li><a href="admin/account_manager/">Users</a> <span class="divider">/</span></li>
        <li class="active">View</li>
    </ul>
    <ul class="nav nav-tabs">
                  <li class="active"><a href="/view" class="a_view"><i class="icon-eye-open"></i> View</a></li>
                  <li><a href="/edit" class="a_edit"><i class="icon-edit"></i> Edit</a></li>
            </ul>
	<?php //echo portlet_simple_start();?>
   
	<div class="fields">
    <h4 class="title">Data User</h4>
    <form id="frm" class="form-horizontal" method="post">
		<input type="hidden" name="method" id="method" value="edit_save" />
		<input type="hidden" name="id" id="id" value="<?=$data["id"]?>" />
		<fieldset>
    		
            
            <div class="row-fluid">
            <div class="span6">
             <table class="table table-condensed table-bordered">
            	<tr>
                	<td style="background-color:#F7F7F7;width:150px">User Name</td><td><?php echo $data["username"];?>&nbsp;</td>
                </tr>
                <tr>
                	<td style="background-color:#F7F7F7">First Name</td><td><?php echo $data["first_name"];?>&nbsp;</td>
                </tr>
                <tr>
                	<td style="background-color:#F7F7F7">Last Name</td><td><?php echo $data["last_name"];?>&nbsp;</td>
                </tr>
                <tr>
                	<td style="background-color:#F7F7F7">Email</td><td><?php echo $data["email"];?>&nbsp;</td>
                </tr>
                 <tr>
                	<td style="background-color:#F7F7F7">Group</td><td>
					<?php 
						$group_arr=array();
						foreach($data["groups"] as $group):
							$group_arr[]=$group["name"];
                    	endforeach;
						echo cek_array($group_arr)?join(",",$group_arr):"";
					?></td>
                </tr>
                
            </table>
            </div></div><!-- /span /row-->
            
        <div class="control-group">
            <label for="tentang" class="control-label">&nbsp;</label>
             <div class="controls">
             </div>
		</div>	
     	</fieldset>
    </form>
   </div>
</div> 

</div>


<script>

$(function(){
	$('#thumbs img:first').click();
	$(".a_img_remove").data("id",$("#thumbs img:first").data("id"));
	$("#description").html($("#thumbs img:first").attr("alt"));
	
	$('#thumbs').on('click','img', function(e){
		e.preventDefault();
		
		$('#largeImage').attr('src',$(this).attr('src').replace('thumb','ori'));
		$('#description').html($(this).attr('alt'));
		
		$(".a_img_remove").data("id",$(this).data("id"));
	});
	
	$(".a_img_remove").click(function(e){
		e.preventDefault();
		var elem_link=$("#thumbs [data-id="+$(this).data("id")+"]");
		$.post("<?=base_url()?><?=$this->module?>del_foto_ikan/"+$(this).data("id"),function(msg){
			elem_link.remove();
			$("#thumbs img:first").click();
		});
	});
});



</script>

<script>
		function uploadImage(data){
			var datafile=data.data_file;
			//var raw_name=data.data_file.raw_name;
			var fullpath="<?=base_url()?>docs/"+data.data_file.full_path.split("\/docs\/")[1];
			$.post("<?=base_url()?><?=$this->module?>add_foto_ikan/?id_file="+data.data_file.idx+"&id_ikan="+$("#id_ikan").val(),function(){
				$("#thumbs").append("<image src='"+fullpath.replace("ori","thumb")+"' alt='"+datafile.raw_name+"'/>");
				$("#thumbs img:last").click();
				$(".msg").html(data.msg);
				if($("#div_alert").length>0){
					$("#div_alert").remove();
				}
				
				setTimeout(function(){
					$(".msg").html("");
				},2000);
			});
			
			/*
			$('#largeImage').attr('src',fullpath);
			*/
			
		}
	</script>
    
    </div>
    <?php //echo portlet_simple_end();?>
</div><!-- end span -->
</div><!-- end row--> 
   

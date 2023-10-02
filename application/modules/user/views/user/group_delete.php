<script>
$(document).ready(function(){
	$(".deleteData").click(function(e){
		e.preventDefault();
			var url="<?php echo base_url();?><?php echo $this->module;?>group_delete_save";
			var dataString=$("#frm").serialize()+"&time="+(new Date).getTime();
			$.ajax({
				 type: "POST",
				 url: url,
				 data: dataString,
				 success: function(msg){
				 		if($.trim(msg)=="ok"){
								//Alert("Konfirmasi","Data berhasil di hapus!");
								$.sticky("<b>Konfirmasi</b><p>Data telah dihapus</p>",stickyoptions,function(response){
								var time=parseFloat(response.timedelay);
								setTimeout(function(){
									location="<?php echo base_url();?><?php echo $this->module;?>list_group/";
								},time);
							});
						}else{
								Alert("Warning","Proses delete tidak berhasil,kontak Admin!");
					}	
				   }
			});
					
	});
	
	$(".cancel").click(function(e){
		e.preventDefault();
    	history.back();
    });
});
</script>
<?php 
$chk=$_REQUEST["chk"];
?>

 <div id="breadcrumbs" class="breadcrumbs-fixed">
  <ul class="breadcrumb">
    <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
    <li><a href="admin/auth/">Account Manager</a> <span class="divider">/</span></li>
    <li><a href="admin/groups/">Groups</a> <span class="divider">/</span></li>
    <li class="active">Delete</li>
    </ul>
</div>

<div style="padding:40px 25px">
<div class="row-fluid">
<div class="span12">
	<form id="frm" class="form-horizontal" method="post">
   		<fieldset>
          <legend>Konfirmasi</legend>
        <label><b>Anda akan mendelete group berikut?</b></label>
    <table class="table table-bordered table-condensed">
	<thead class="box_quote">
    <tr>
    	<th style="width:200px">Group Name</th>
        <th>Description</th>
        
    </tr>
    </thead>
	<?php foreach($data as $group):?>
    <tr>
    	<td><input name="chk[]" type="hidden" value="<?php echo $group["id"]; ?>" />
        	<?php echo $group["name"];?>
        </td>
        <td><?php echo $group["description"];?></td>
    </tr>
    <?php endforeach;?>
</table>
</div></div>
	<div class="box_quote" style="margin-top:20px">
	<div class="btn-group pull-left">
<a href="/DeleteData" class="btn deleteData"><span class="iconize icon_del"></span>Yes</a><a href="/Cancel" class="btn right cancel"><span class="iconize icon_cancel"></span>No</a>
	</div>
    <div class="clearfix"></div>
    </div>
    </fieldset>
</form>

</div>
</div>
</div>

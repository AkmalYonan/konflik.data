<script>
$(document).ready(function(){
	$(".deleteData").click(function(e){
		e.preventDefault();
			var url="<?php echo base_url();?><?php echo $this->module;?>user_delete_save";
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
									location="<?php echo base_url();?><?php echo $this->module;?>";
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
        <li><a href="admin/account_manager/">Account Manager</a> <span class="divider">/</span></li>
        <li><a href="admin/account_manager/">Users</a> <span class="divider">/</span></li>
        <li class="active">Delete</li>
    </ul>
</div>

<div style="padding:40px 25px">
<div class="row-fluid">
<div class="span12">
<?php //echo portlet_simple_start();?>
	
	<form id="frm" class="form-horizontal" method="post">
   		<fieldset>
          <legend>Konfirmasi</legend>
        <label><b>Anda akan mendelete data user berikut?</b></label>
    <table class="table table-bordered table-condensed" width="500px">
    	<thead class="box_quote">
    	<tr>
        	<th>User Name</th>
            <th>Email</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
<?
foreach($data as $x=>$value):
?>
	<tr>
   			<td><input name="chk[]" type="hidden" value="<?php echo $value["id"]; ?>" />
				<?php echo $value["username"];?></td>
            <td><?php echo $value["email"];?></td>
			<td><?php echo $value["first_name"]." ".$value["last_name"];?></td>
	    	    	
    </tr>
        
<?
endforeach;
?>
</tbody>
</table>
	<div class="box_quote" style="margin-top:20px">
	<div class="btn-group pull-left">
<a href="/DeleteData" class="btn deleteData"><span class="iconize icon_del"></span>Yes</a><a href="/Cancel" class="btn right cancel"><span class="iconize icon_cancel"></span>No</a>
	</div>
    <div class="clearfix"></div>
    </div>
    </fieldset>
</form>
<?php // echo portlet_simple_end();?>
</div>
</div>

</div>

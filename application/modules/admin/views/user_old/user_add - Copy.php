<?php $arrGroup=$this->ion_auth->groups()->result_array(); ?>
<script>
	$(document).ready(function(){
	   $("#frm").validate();
	
	   $(".asterix").remove();
	   $(".required").each(function(i){
		 	$(this).parent().find("label:first-child").append("<label class='asterix'>*</label>");
	   });
		
	   $(".save").live("click",function(e){
			e.preventDefault();
			var url="<?php echo base_url();?><?php echo $this->module;?>/user_add_save";
			var dataString=$("#frm").serialize()+"&time="+(new Date).getTime();
			if($("#frm").valid()==false){
				return false;
			}
			$.ajax({
				type: "POST",
				url: url,
				data: dataString,
				success: function(msg){
				if($.trim(msg)=="ok"){
					$.sticky("<b>Konfirmasi</b><p>Data Telah Tersimpan</p>",stickyoptions,function(response){
					var time=parseFloat(response.timedelay);
					setTimeout(function(){
										location="<?php echo base_url();?><?php echo $this->module;?>";
									},time);
								});
											
					}else{
								Alert("Warning","Proses penyimpanan tidak berhasil,kontak Admin!")
								}	
						}
			});
					
		});
		
		
	});
	
</script>
<div id="breadcrumbs" class="breadcrumbs-fixed">
<ul class="breadcrumb">
        <li><a href="admin/dashboard">Home</a> <span class="divider">/</span></li>
        <li><a href="admin/auth/">Account Manager</a> <span class="divider">/</span></li>
        <li><a href="admin/auth/">Users</a> <span class="divider">/</span></li>
        <li class="active">Add</li>
    </ul>
</div>    

<div class="row-fluid">
<div class="span12">
	
	
	<?php //echo portlet_simple_start();?>
    <div class="fields"> 
		<form id="frm" method="post" class="form-horizontal">
        <legend>Data User</legend>
  		<fieldset>
        
        <!-- control-nama-->
        <div class="control-group">	
        	<label for="username" class="control-label">User Name</label>
            <div class="controls">
        	<input type="text" id="username" name="username" class="input-xlarge required" value="" />
            
            </div>
        </div>
        <!-- /control-group nm_umum-->
        
                        
        <!-- control-group nm_latin-->
        <div class="control-group">	
        	<label for="first_name" class="control-label">First Name</label>
            <div class="controls">
        	<input type="text" id="first_name" name="first_name" class="input-xlarge required" value="" />
            </div>
        </div>
        <!-- /control-group nm_latin-->
        
                        
        <!-- control-group hscode-->
        <div class="control-group">	
        	<label for="last_name" class="control-label">Last Name</label>
            <div class="controls">
        	<input type="text" id="last_name" name="last_name" class="input-xlarge" value="" />
            </div>
        </div>
        
        <!-- /control-group hscode-->
        
        <div class="control-group">	
        	<label for="email" class="control-label">Email</label>
            <div class="controls">
        	<input type="text" id="email" name="email" class="input-xlarge required email" value="" />
            </div>
        </div>
        
        <div class="control-group">	
        	<label for="email" class="control-label">Phone</label>
            <div class="controls">
        	<input type="text" id="phone" name="phone" class="input-xlarge" value="" />
            </div>
        </div>
        
         <div class="control-group">	
        	<label for="email" class="control-label">Password</label>
            <div class="controls">
        	<input type="text" id="password" name="password" class="input-xlarge required" value="" />
            </div>
        </div>
        
         <div class="control-group">	
        	<label for="email" class="control-label">Confirm Password</label>
            <div class="controls">
        	<input type="text" id="confirm_password" equalto="#password" name="confirm_password" class="input-xlarge required" value="" />
            </div>
        </div>
         
         <div class="control-group">	
        	<label for="email" class="control-label">Groups</label>
            <div class="controls">
            <? $def_group=$this->config->item('default_group','ion_auth');?>
            <? foreach($arrGroup as $group):?>
            	<label class="checkbox">
                <?php $checked="";?>
				<?php if($group["name"]==$def_group):?>
                	<?php $checked=" checked='checked' ";?>
				<?php endif;?>
        		<input type="checkbox" name="groups[]" value="<?php echo $group["id"]?>" <?php echo $checked?>> 	<?php echo $group["name"]?>
                </label>
            <? endforeach;?>
          
            </div>
        </div>
                        
        
        <div class="form-actions">
        	<button class="btn btn-primary hover save"><i class="icon-book"></i> Save Data</button>
        	<button type="reset" class="btn btn-warning">Reset</button>
        </div>
        
        
            
        </fieldset>
        </form>   
    </div><!-- end fields -->
    <?php //echo portlet_simple_end();?>
    
    
   </div><!-- end span12 -->
</div><!-- end row--> 

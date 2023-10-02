<?php $arrGroup=$this->ion_auth->groups()->result_array(); ?>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <!-- start: page header -->
        <div class="page-header">
            <div class="row"> 
                <div class="col-md-12">
                    <h1><?=$this->module_title?><small> Users Add</small></h1>
                </div><!-- col -->
              </div><!-- row-->
        </div><!-- end: page-header -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>admin/"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
			<li><a href="admin/account_manager/"><?=$this->module_title?></a> <span class="divider"></span></li>
			<li><a href="admin/account_manager/">Users</a> <span class="divider"></span></li>
            <li class="active">Add</li>
         </ul>
        <!-- end: breadcrumbs -->
   </div><!-- cols -->
</div> <!-- row -->
<?php echo message_box();?>
<div style="padding:0px;">
<div class="row topbar box_shadow">
		<div class="col-md-12">
			<div class="pull-left">
				<ul class="tab-bar grey-tab">
					<li>
						<a href="<?php echo $this->module?>">
							<span class="block text-center">
								<i class="icon-list"></i> 
							</span>
							Daftar <?=$this->module_titles?>
						</a>
					</li>
					<li class="active">
						<a href="<?php echo $this->module?>user_add">
							<span class="block text-center">
								<i class="icon-plus"></i> 
							</span>
							Input <?=$this->module_titles?>
						</a>
					</li>
				</ul>
			</div>
			<!--<form class="search_form col-md-3 pull-right" action="<?//=$this->module?>" method="get">
				<?php //$this->load->view("widget/search_box_db"); ?>
			</form>-->
		</div>
	</div>
<div class="row">
<div class="col-md-6">
    <form id="frm" method="post" action="<?php echo $this->module;?>user_add/" class="form-horizontal">
    	<input type="hidden" name="act" id="act" value="create"/>
   <fieldset>
        
        <!-- control-nama-->
        <div class="control-group">	
        	<label for="username" class="control-label">Username</label>
            <div class="controls">
        	<input type="text" id="username" name="username" class="form-control input-xlarge required" value="" />
            </div>
        </div>
        <!-- /control-group nm_umum-->
        
                        
        <!-- control-group nm_latin-->
        <div class="control-group">	
        	<label for="first_name" class="control-label">Firstname</label>
            <div class="controls">
        	<input type="text" id="first_name" name="first_name" class="form-control input-xlarge required" value="" />
            </div>
        </div>
        <!-- /control-group nm_latin-->
        
                        
        <!-- control-group hscode-->
        <div class="control-group">	
        	<label for="last_name" class="control-label">Lastname</label>
            <div class="controls">
        	<input type="text" id="last_name" name="last_name" class="form-control input-xlarge" value="" />
            </div>
        </div>
        
        <!-- control-group hscode-->
        <div class="control-group">	
        	<label for="last_name" class="control-label">N.I.K.</label>
            <div class="controls">
        	<input type="text" id="nomor_induk" name="nomor_induk" class="form-control input-xlarge" value="" />
            </div>
        </div>
        
        <!-- /control-group hscode-->
        
        <div class="control-group">	
        	<label for="email" class="control-label">Email</label>
            <div class="controls">
        	<input type="text" id="email" name="email" class="form-control input-xlarge required email" value="" />
            </div>
        </div>
        
        <div class="control-group">	
        	<label for="email" class="control-label">Phone</label>
            <div class="controls">
        	<input type="text" id="phone" name="phone" class="form-control input-xlarge" value="" />
            </div>
        </div>
        
         <div class="control-group">	
        	<label for="email" class="control-label">Password</label>
            <div class="controls">
        	<input type="text" id="password" name="password" class="form-control input-xlarge required" value="" />
            </div>
        </div>
        
         <div class="control-group">	
        	<label for="email" class="control-label">Confirm Password</label>
            <div class="controls">
        	<input type="text" id="confirm_password" equalto="#password" name="confirm_password" class="form-control input-xlarge required" value="" />
            </div>
        </div>
        
         
         <div class="control-group">	
        	<label for="email" class="control-label">Groups</label>
            <div style="padding-left:30px;" class="controls">
            <? $def_group=$this->config->item('default_group','ion_auth');?>
            <? 
			$a=1;
			foreach($arrGroup as $group):
			?>
            	
				<label class="radio">
                <?php $checked="";?>
				<?php if($group["name"]==$def_group):?>
                	<?php $checked=" checked='checked' ";?>
				<?php endif;?>
        		<input class="group<?=$a;?>" type="radio" name="groups" data-org="<?php echo $group['use_organization'];?>" value="<?php echo $group["id"]?>" <?php echo $checked?>> 	<?php echo $group["name"];?>
 	
				</label>
				
            <? $a++; endforeach;?>
          
            </div>
        </div>
		<div class="control-group">	
        	<label for="propinsi" class="control-label">Propinsi</label>
            <div class="controls">	
			<?php 
				$arrPropinsi=m_lookup("propinsi2","kode_bps","nama");
				$arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
			?>
			<?=form_dropdown("id_propinsi",$arrPropinsi1,0,"id='id_propinsi_h' disabled class='form-control required'");?>

			<?php 
			$b=1;
			foreach($arrGroup as $group):
			if($b == 3):?>
			<div id="id_h" >	
				<?php 
					$arrPropinsi=m_lookup("propinsi2","kode_bps","nama");
					$arrPropinsi1=array(""=>"--Pilih Propinsi--")+$arrPropinsi;
				?>
				<?=form_dropdown("id_propinsi",$arrPropinsi1,0,"id='id_propinsi' class='form-control required'");?>
			</div>
			<?php endif; ?>  
			<? $b++; endforeach;?>
			</div>
        </div>
        <!--<div class="control-group">	
        	<label for="username" class="control-label">SKPA-P</label>
            <div class="controls">
            <?//=form_dropdown("company",$m_skpa,$category,"id='company' class='input-xlarge required'");?>
            </div>
        </div>-->
        <br>
        <div class="form-actions">
        	<button type="submit" class="btn btn-primary">Save changes</button>
			<button type="button" class="btn">Cancel</button>
        </div>
        </fieldset>
    </form>
    
</div></div>
<script type="text/javascript">
	 $(document).ready(function () {
		$('#id_h').hide('fast');
		$('.group1').click(function () {
		   $('#id_h').hide('fast');
		   $('#id_propinsi_h').show('fast');
		   $('#id_propinsi option:eq(0)').attr('selected','selected');
		});
		$('.group2').click(function () {
			  $('#id_h').hide('fast');
			  $('#id_propinsi_h').show('fast');
			  $('#id_propinsi option:eq(0)').attr('selected','selected');
		 });
		 $('.group3').click(function () {
			  $('#id_propinsi_h').hide('fast');
			  $('#id_h').show('fast');
			  
		 });
		 $('.group4').click(function () {
			  $('#id_h').hide('fast');
			  $('#id_propinsi_h').show('fast');
			  $('#id_propinsi option:eq(0)').attr('selected','selected');
		 });
   });
</script>
<script>
	$(function(){
		$("#frm").validate();
		
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
		
		$(".group").click(function(){
			//$("#company").prop("disabled",$(this).data('org')==1 ? false: true);
			var use_org = $(this).data('org');
			$("#company").val(use_org);
			$("#company option").show();
			$("#company option").each(function(){
				if (!use_org) {
					$(this).val()!=0?$(this).hide():$(this).show();
				}
				else {
					$(this).val()!=0?$(this).show():$(this).hide();
				}
			});
		})
	})
</script>
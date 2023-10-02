<?php
	$arrCategory=$this->arr_category;
	$arrCategory[""]="All";
?>
<style>
.table .table-preview img {
  width: 50px;
  height:50px;
  margin-right: 10px;
  margin-top:2px;
  float: left;
}
.table .identitas{
	float:left;
}
.table .table-preview .name {
  font-weight: bold;
  margin-top: 5px;
  display: block;
}
</style>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <!-- start: page header -->
        <div class="page-header">
            <div class="row"> 
                <div class="col-md-12">
                    <h1>Configuration <small>List</small></h1>
                </div><!-- col -->
              </div><!-- row-->
        </div><!-- end: page-header -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>admin/"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
             <li><a href="<?=$this->folder?>">Configuration</a> <span class="divider"></span></li>
            <li class="active"><?=$this->module_title?></li>
         </ul>
        <!-- end: breadcrumbs -->
        
   </div><!-- cols -->
</div> <!-- row -->

<div class="row">
<div class="col-md-12 col-lg-12">
<?php echo message_box();?>
<? //$this->load->view("toolbar_std");?>
<div class="row topbar box_shadow">
    <div class="col-md-12">
    	<div class="pull-left">
            <ul class="tab-bar grey-tab">
                <li class="active">
                    <a href="<?php echo $this->module?>">
                        <span class="block text-center">
                            <i class="icon-list"></i> 
                        </span>
                        Setting <?=$this->module_title?>
                    </a>
                </li>
        
                <li>
                    <a href="<?php echo $this->module?>">
                        <span class="block text-center">
                            <i class="icon-refresh"></i> 
                        </span>	
                        Refresh
                    </a>
                </li>
            </ul>
        </div>
    	
    </div>
</div>
<div class="table-responsive">
				
				<form id="frm" action="<?php echo $this->module;?>edit" method="post" enctype="multipart/form-data" >
				<input type="hidden" name="act" id="act" value="update"/>
		    
<table class="table table-hover small-font">
	<thead>
    	<tr>
    	<th></th>
        <th width="50">No</th>
		<th width="200">Nama</th>
		<th width="150">Key</th>
		<th >Value</th>
		<th></th>
		<th width="150">ID</th>
        </tr>
    </thead>
    <tbody>
    		<?php if(cek_array($arrDB)):?>
		        	<?php foreach($arrDB as $x=>$val):?>
		            	<? 
							
							$key=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
						?>	
						
            	<tr >
            		<td><input type="hidden" id="idx" name="idx[]" style="color: red" class="form-control input-xs required" value="<?=$val['idx'];?>" readonly /></td>
                	<td><?=$this->pagination->cur_page+$x+1; ?></td>
                	<td valign="top"><input type="text" id="nama" name="nama[]" class="form-control required" value="<?=$val['nama'];?>" /></td>
                	<td valign="top"><input type="text" id="id_key" name="id_key[]" class="form-control required" value="<?=$val['id_key'];?>" /></td>
                	<td valign="top"><textarea cols="21" id="value" name="value[]" class="form-control required" ><?=$val['value'];?></textarea></td>
                	<td valign="top"><input type="hidden" id="status" name="status[]" class="form-control required" value="<?=$val['status'];?>" /></td>
                	<td valign="top"><input type="text" id="id_category" name="id_category[]" class="form-control required" value="<?=$val['id_category'];?>" /></td>
                	<td></td>
                </tr>
   

   

                
              
          
				
             <?php endforeach;?>
		<?php endif;?>
		 </tbody>
</table>
</div>
		<div style="float:right; margin-right:90px;">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    	</div>
	
    <br />
</div>
		
</div>


</div></div><!-- end row span-->
</div><!-- end div positioning -->



<script>
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	
		$(".pagination .active a").click(function(e){
			e.preventDefault();
		});
		
		$("#pp_select").change(function(){
			var pp=parseInt($(this).find("option:selected").val());
			if(pp<0){
				location=document.URL.split("?")[0];
				return false;
			}
			get_query();
		});
		
		$("#frm-search").submit(function(e){
			e.preventDefault();
			get_query();
		});
	});
	
	
	function get_query(){
			var q =$("#q").val()||"";
			var perPage=$("#pp_select option:selected").val();
			$("#pp").val(perPage);
			var pp =$("#pp").val()||"";
			
			
			var data=[];
			if(q){
				data.push("q="+q);
			}
			
			if((pp)&&(pp!=25)){
				data.push("pp="+pp);
			}
			var param='';
			if(data){
				param="?"+data.join("&");
			}
			var url=document.URL.split("?")[0];
			location=url+param;
	}
</script>
<script>
	$(function(){
		var act_link="<?=substr(trim($this->module), 0, -1);?>";	
		$(".menu-bar").find("li.active").removeClass("active");
		$(".menu-bar").find("a[href*='"+act_link+"']").parents("li:last").addClass("active");
	});
</script>

<? //$this->load->view("active_menu");?>
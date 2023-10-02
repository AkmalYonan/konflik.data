<?php 
if ($_POST['uo'] || $_POST['sort'] || $_POST['q']) {
	$class_toggle=" active";
	$class_content="";
}
else {
	$class_toggle="";
	$class_content="none";
}
?>
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>List <small>Groups</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active"><?=$this->module_title?></li>
         </ul>
        <!-- end: breadcrumbs -->

	</div> 
	
	<div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
	  <div class="box" style="padding-top:10px;">

		<div class="col-md-12">
			<div class="row topbar box_shadow">
				<div class="col-md-12">
					<div class="rows well well-sm">
						<div style="vertical-align:middle;line-height:25px">
						<a class="btn btn-default active" href="<?php echo $this->module?>group_list">
							<i class="fa fa-list"></i> List
						</a>
						<a class="btn btn-default" href="<?php echo $this->module?>group_add">
							<i class="fa fa-plus"></i> Input
						</a>	  
						<a class="btn btn-default" href="<?php echo $this->module?>group_add">
							<i class="fa fa-refresh"></i> Refresh
						</a>
						<!--<a id="filter_toggle" class="btn btn-default" >
							<i class="fa fa-search"></i> Search
						</a>-->
						
						<form class="search_form col-md-3 pull-right" action="<?=$this->module?>group_list" method="get">
						<?php $this->load->view("widget/search_box_db"); ?>
						</form>
						</div>
					</div>
				</div>
			</div><!-- ./box-body -->
		</div>
		<div class="col-md-12">
			<?php echo message_box();?>
		</div>
		<div class="box-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th style="width:80px;"></th>
						<th style="width:300px">Group</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
				<?php if(cek_array($arrData)):?>
					<?php foreach($arrData as $x=>$val):
							$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
					?>
						<tr>
							<td class="tc">
								<center>
									<div class="btn-group">
										<a class="btn btn-xs btn-default" href="<?php echo $this->module."group_edit/".$id?>"><i class="fa fa-pencil"></i></a>					
									</div>
									<div class="btn-group">
										<a class="btn btn-xs btn-default" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?php echo $this->module."group_delete/".$id?>"><i class="fa fa-trash icon-alert"></i></a> 						
									</div>
								</center>
							</td>
							<td><?=$this->pagination->cur_page+$x+1; ?>. <?php echo $val["name"]?></a></td>
							<td><?php echo $val["description"]?></td>
							<!--<td class="tc"><?php //if($val["publish"]==1):?>
									<span class="label label-info">Yes</span>
								<?php //else:?>
									<span class="label label-important">No</span>
								<?php //endif;?>
							</td>
							<td>
								<?php //if($val["order_num"]>1):?>
									<a href="<?//=$this->module?>up/<?//=$val["idx"]?>/"?><i class="icon-arrow-up"></i></i>
								<? //endif;?>
							</td>
							 
							<td>
								<?php //if($val["order_num"]< count($arrData)):?>
									<a href="<?//=$this->module?>down/<?//=$val['idx']?>/"><i class="icon-arrow-down"></i></a>
								<? //endif;?>
							
							</td>
							<td><?php //echo $val["order_num"]?></td>-->
						</tr>
					<?php endforeach;?>
				<?php endif;?>
			</tbody>
			</table>
		</div>
		<div class="box-footer">
			<div class="row">
				<div class="col-sm-12 col-lg-12">
					<div class="col-md-12">
					<?php $page_link=$this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
			<div class="rows well well-sm">
			<div class="col-md-8">
				<div style="vertical-align:middle;line-height:25px">
				<?php 
					$to_page=$this->pagination->cur_page * $this->pagination->per_page;
					$from_page=($to_page-$this->pagination->per_page+1);
					if($from_page>$to_page):
						$from_page=1;
						$to_page=$from_page;
					endif;
					$total_rows=$this->pagination->total_rows;
					if($to_page>1):
						echo "Displaying : ".$from_page." - ".$to_page." of ". 
								$this->pagination->total_rows." entries";
					endif;
					if($to_page<=1):
						echo "Displaying : 1 of ". 
								$this->pagination->total_rows." entries";		
					endif;		
				?>,
				<?php
			$arrPerPageSelect=array(
					3=>3,
					10=>10,
					25=>25,
					50=>50,
					-1=>"All"
				);
				$pp=$perPage;
			?>
			Rows/page:<?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select' class='input-mini'")?>	
			<input type="hidden" id="pp" name="pp" value="" />
				
				 </div>
			</div><!-- end span 6-->
			<div class="col-md-4">

			<span class="pull-right">
				<div style="margin-top:-23px; margin-right:10px">
				<?php echo $page_link; ?>
				</div>
			</span>

			</div><!-- end span 6-->
			<div class="clearfix" style="height:24px"></div>

			</div><!-- end class well -->
		</div><!-- /.box-footer -->
	  </div><!-- /.box -->
	</div><!-- /.col -->
</div><!-- /.row -->	

	
</div><!-- end div positioning -->
<script>
	$(function(){
		var act_link="group";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>


<script>
	$(function(){
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
			var cat_id =$("#cat_id option:selected").val()||"";
			
			var data=[];
			
			if(q){
				data.push("q="+q);
			}
			if((pp)&&(pp!=25)){
				data.push("pp="+pp);
			}
			var param='';
			if(data){
				param=data.join("&");
				if(param!=""){
					param="?"+param;
				}
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

<script>
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
	})
</script>
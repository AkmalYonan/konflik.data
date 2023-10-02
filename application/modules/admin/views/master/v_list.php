<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>List <small>Pegawai</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">SKPD</li>
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
						<a class="btn btn-default active" href="<?php echo $this->module?>listview">
							<i class="fa fa-list"></i> List
						</a>
						<a class="btn btn-default" href="<?php echo $this->module?>add">
							<i class="fa fa-plus"></i> Input
						</a>	  
						<a class="btn btn-default" href="<?php echo $this->module?>listview">
							<i class="fa fa-refresh"></i> Refresh
						</a>
						
						<form class="search_form col-md-3 pull-right" action="<?=$this->module?>listview" method="get">
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
						<th width="80"></th>
						<th width="50">No</th>
						<th>Nama</th>
					</tr>
				</thead>
				<tbody>
					<?php if(cek_array($arrData)):?>
						<?php foreach($arrData as $x=>$val):?>
							<? 
								
								$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
							?>	
							<tr >
								<td><center>
									<div class="btn-group">
										<a title="Edit" class="btn btn-xs btn-default" href="<?=$this->module?>edit/<?=$id?>"><i class="fa fa-pencil"></i></a>
									</div>
									<div class="btn-group">
										<a title="Hapus" class="btn btn-xs btn-default" onclick="return confirm('Anda yakin akan menghapus data ini?');" href="<?=$this->module?>del/<?=$id?>"><i class="fa fa-remove icon-danger"></i></a>
									</div>
									</center>
								</td>
								<td><?=$this->pagination->cur_page+$x+1; ?></td>
								<td valign="top"><?php echo $val["nama"]?></td>
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
<script language="javascript">
$(document).ready(function(){      
	$('#prov').change(function(){
		$.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
		$('#kab').html(obj);
		});
    });
});
</script>


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
		$("#filter_toggle").click(function(){
			$(this).toggleClass("active");
			$("#filter_content").slideToggle();
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
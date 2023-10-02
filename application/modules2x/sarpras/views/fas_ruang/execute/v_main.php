<script src="assets/additional_js/sweetalert/sweetalert/dist/sweetalert.min.js" type="text/javascript"></script>
<link href="assets/additional_js/sweetalert/sweetalert/dist/sweetalert.css" rel="stylesheet" />
<?php
	$lookup_empty[""]="--Pilih--";
	$lookup_balai=$lookup_empty+lookup("m_instansi","kd_instansi","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");
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

<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->parent_module_title?>
    <small>Sarana & Prasarana</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
    <li><a href="<?php echo $this->module?>" class="active"><?=$this->module_title?></a></li>
  </ol>
</section>

<section class="content">
    <div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <!-- TOOLBAR -->
			<div class="content-toolbar">
					<a class="btn btn-white" href="<?=$this->module?>list_instansi" data-toggle="tooltip" title="">
                        <i class="fa fa-list"></i>
                    </a>
					<?php if($act!=="view"): ?>
					<a class="btn btn-white btn-save" href="" data-toggle="tooltip" title="" data-original-title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle="tooltip" title="" data-original-title="Reset">
                        <i class="fa fa-circle-o"></i>
                    </a>	
					<?php endif; ?>
            </div>
            <!-- END: TOOLBAR -->
			<?php 
				if($act=="add"): 
					$action	=	$this->module."add";
				elseif($act=="edit"):
					$action	=	$this->module."edit/".$kode_enc;
				endif;
			?>
			<form id="frm" action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data"  class="form-horizontal">
			
			<input type="hidden" name="act" value="<?=$act?>" />
			
        	<div class="box box-widget">
            	<!--box body-->
				<div class="box-body">
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-condensed">
								<tr>
									<td width="100"><h4><strong>Instansi</strong></h4></td>
									<td>
										<?php
											if($act=="add"):
												echo form_dropdown("kd_org",$lookup_balai,$data['kd_org'],"id='kd_balai' class='form-control select2 required' style='width:30%'");
											else:
                                                echo "<h4>".$lookup_balai[$data['kd_org']]."</h4>";
											endif;
										?>
									</td>
								</tr>
							</table>
						</div>
					</div><!--End Of Row-->
					
					<div class="row">
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#home">Fasilitas</a></li>
								<li><a data-toggle="tab" href="#dokter">Dokter</a></li>
								<li><a data-toggle="tab" href="#perbid">Perawat & Bidan</a></li>
								<li><a data-toggle="tab" href="#tensos">Tenaga Sosial</a></li>
								<li><a data-toggle="tab" href="#penunjang_medis">Penunjang Medis</a></li>
								<li><a data-toggle="tab" href="#adm_umum">Administrasi Umum</a></li>
								<li><a data-toggle="tab" href="#peralatan">Peralatan</a></li>
							</ul>

							<div class="tab-content">
								<div id="home" class="tab-pane fade in active">									
									<h4 class="heading">Fasilitas Ruang</h4>
									<p><?=$v_fas_ruang?></p>
							  	</div><!--End Of Tab Pane-->
							  	<div id="dokter" class="tab-pane fade">								
									<h4 class="heading">Dokter</h4>
									<p><?=$v_dokter?></p>
							 	</div><!--End Of Tab Pane-->
								<div id="perbid" class="tab-pane fade">							
									<h4 class="heading">Perawat Dan Bidan</h4>
									<p><?=$v_perbid?></p>
							 	</div><!--End Of Tab Pane-->
								<div id="tensos" class="tab-pane fade">
									<h4 class="heading">Tenaga Sosial</h4>
									<p><?=$v_tensos?></p>
							 	</div><!--End Of Tab Pane-->
								<div id="penunjang_medis" class="tab-pane fade">
									<h4 class="heading">Penunjang Medis</h4>
									<p><?=$v_penunjang_medis?></p>
							 	</div><!--End Of Tab Pane-->
								<div id="adm_umum" class="tab-pane fade">
									<h4 class="heading">Administrasi Umum</h4>
									<p><?=$v_adm_umum?></p>
							 	</div><!--End Of Tab Pane-->
								<div id="peralatan" class="tab-pane fade">
									<h4 class="heading">Peralatan</h4>
									<p><?=$v_peralatan?></p>
							 	</div><!--End Of Tab Pane-->
							</div>
						</div>
					</div>
				</div>
                
            </div>
			</form>
        </div>
    </div>
</section>

<?php if($act=="add"): ?>
<script>
$(document).ready(function(){
	$('#kd_balai').on("change",function(){
		

		var daftar_kode 	=	[<?=$kd_org_list?>];	
		var kd_org			=	$(this).val();
	
		for(var i=0; i<daftar_kode.length; i++){
			if(kd_org==daftar_kode[i]){
				$(this).val("");
				sweetAlert("Maaf!", "Daftar Sarana Prasarana Pada Instansi Tersebut Sudah Pernah Diisi", "error");
			}
		}
	});
});
</script>
<?php endif; ?>

<?php if($act=="view"): ?>
<script>
$(document).ready(function(){
	$(".form-control").prop("disabled",true);
});
</script>
<?php endif; ?>

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

<script>
$(document).ready(function(){
    $('input[type="number"]').keypress(validateNumber);
});

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;

    if (event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 37 || event.keyCode === 39) {
        return true;
    }
    else if ( key < 48 || key > 57 ) {
        return false;
    }
    else return true;
};  
    
</script>
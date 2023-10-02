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
                	<!--
					<a class="btn btn-white active" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="List">
                        <i class="fa fa-list"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>pasien_list" data-toggle='tooltip' data-original-title="Add">
                        <i class="fa fa-plus"></i>
                    </a>
					-->
					<a class="btn btn-white btn-save" href="" data-toggle="tooltip" title="" data-original-title="Save">
                        <i class="fa fa-check"></i>
                    </a>
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle="tooltip" title="" data-original-title="Reset">
                        <i class="fa fa-circle-o"></i>
                    </a>	
            </div>
            <!-- END: TOOLBAR -->
        	<div class="box box-widget">
            	<!--
				<div class="box-header with-borders">
                	<div class="row">
                        <div class="col-md-8 col-xs-12">
                        <form class="form-inline" action="<?=$this->module?>" method="get">
                          <div class="form-group">
                            <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                          </div>
                          <div class="form-group">
                            <?php $this->load->view("widget/search_box_db"); ?>
                          </div>
                          <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                        </div>
                        <div class="col-md-4 hidden-xs">
                            <div class="btn-group pull-right hidden">
                            	<a class="btn btn-transparent" href=""> <i class="fa fa-question"></i> Help</a>
                            </div>
                            <div class="btn-group pull-right hidden">
                              <button type="button" class="btn btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-share"></i>&nbsp; Export Data <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                              </ul>
                              
                            </div>
                        </div>
                    </div>
                </div>
				-->
            	<!--box body-->
				<div class="box-body table-responsive">
					<div class="row">
						<div class="col-md-2">
							<ul id="rhTab" class="nav nav-pills nav-stacked dtab" role="tablist" style="background:#eee">
							  <li class="active"><a data-toggle="tab" href="#home">Fasilitas Ruangan</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="doket" aria-expanded="true" data-url="sarpras/fas_ruang/attr/dokter" href="#menu1">Dokter</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="perbid" aria-expanded="true" data-url="sarpras/fas_ruang/attr/perbid" href="#menu2">Perawat & Bidan</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="tensos" aria-expanded="true" data-url="sarpras/fas_ruang/attr/tensos" href="#menu3">Tenaga Sosial</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="pnj_medis" aria-expanded="true" data-url="sarpras/fas_ruang/attr/penunjang_medis" href="#menu4">Penunjang Medis</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="adm_umum" aria-expanded="true" data-url="sarpras/fas_ruang/attr/adm_umum" href="#menu5">Administrasi Umum</a></li>
							  <li><a role="tab" data-toggle="tab" aria-controls="alat" aria-expanded="true" data-url="sarpras/fas_ruang/attr/peralatan" href="#menu6">Peralatan</a></li>
							</ul>
						</div>
						<div class="col-md-10">
							<div class="tab-content">
							  <div id="home" class="tab-pane fade in active">
							   <form id="frmd" action="<?php echo $this->module;?>" method="POST" enctype="multipart/form-data"  class="form-horizontal">
								<p><b>Fasilitas Ruangan</b></p>
								<input type="hidden" name="attr" id="attr" value="fasruang"/>
								<input type="hidden" name="act" id="act" value="add"/>
									<div class="col-md-5">
										<table class="table">
											<?php if(cek_array($arrData)):?>
												<?php foreach($arrData as $x=>$val):?>
													<input name="idx[]" value="<?=$val['idx']?>" type="hidden" class="form-control">
													<input name="kode[]" value="<?=$val['kode']?>" type="hidden" class="form-control" />
													<tr>
														<td><?=$val['uraian']?></td>
														<td>
															<input name="jumlah[]" value="<?=$val['jumlah']?>" type="number" class="form-control">
														</td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</table>
									</div>
									<div class="col-md-5">
										<table class="table">
											<?php if(cek_array($arrData2)):?>
												<?php foreach($arrData2 as $x2=>$val2):?>
													<input name="idx[]" value="<?=$val2['idx']?>" type="hidden" class="form-control">
													<tr>
														<td><?=$val2['uraian']?></td>
														<td><input name="jumlah[]" type="number" value="<?=$val2['jumlah']?>" class="form-control"></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</table>
									</div>
									</form>
							  </div>
							  <div id="menu1" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu2" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							  <div id="menu3" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu4" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							  <div id="menu5" class="tab-pane fade">
								<h3>Menu 1</h3>
								<p>Some content in menu 1.</p>
							  </div>
							  <div id="menu6" class="tab-pane fade">
								<h3>Menu 2</h3>
								<p>Some content in menu 2.</p>
							  </div>
							</div>
						</div>
					</div>
				</div>

                
            </div>
        </div>
    </div>
</section>
<script>
	$(function(){
		var active_frm = 'frmd';
		//TAB DATA URL
		$('.dtab a').click(function (e) {
			if ($(this).data("url")) {
				e.preventDefault();
				
				var tabcontent = $(this).attr("href");
				var tahun = $("#tahun option:selected").val();
				$("#shadow-year").text(tahun);
				// var url = $(this).data("url")+'/'+active_kec+'/'+tahun;
				var url = $(this).data("url");
				// alert(url);
				$(tabcontent).html("Loading...");
				$(this).tab('show');
				$(tabcontent).load(url,function(){
					active_frm = $(tabcontent).find("form").attr("id");
					// alert(active_frm);
					$(tabcontent).find(".tahun").val($("#tahun option:selected").val());
				});
			}
			else {
				active_frm = 'frmd';
				$("#shadow-year").text("");
			}
			
		});
		$(".btn-save").click(function(e){
			e.preventDefault();
			$("#"+active_frm).submit();	
		});
		$("#tb_cancel").click(function(e){
			e.preventDefault();
			$(".tb_reset").trigger("click");	
		});
	})
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
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
.blek{border:1px solid black;}
.ret{background-color:#DD5A61}
.text-muted{
	font-size:12px;
}
.small-opt{
	margin-right:-30px;
}
.small-opt2{
	margin-right:-45px;
}
</style>
<?php
	$data_propinsi=lookup("m_propinsi","kd_propinsi","nm_propinsi");
	foreach($data_propinsi as $x=>$val):
		$data_propinsi[$x]=strtoupper($val);
	endforeach;
	$lookup_empty[""]="";
	$lookup_wilayah=$lookup_empty+lookup("m_kabupaten","kd_wilayah","nm_kabupaten","","order by kd_wilayah");
	
	$lookup_status_konflik["BD"]="Belum Ditangani";
	$lookup_status_konflik["PS"]="Dalam Proses";
	$lookup_status_konflik["SL"]="Selesai";
	
	$label_status_konflik["BD"]="warning";
	$label_status_konflik["PS"]="info";
	$label_status_konflik["SL"]="primary";
	
	$lookup_kategori["K1"]="Masyarakat Adat";
	$lookup_kategori["K2"]="Non Masyarakat Adat";
	
	$lookup_status_konflik_proses["Mediasi"]="Mediasi";
	$lookup_status_konflik_proses["Hukum"]="Hukum";
	
	$label_sifat['Public']="info";
	$label_sifat['Private']="danger";
	
	if($this->user_prop):
		if($this->user_kab):
			$lookup_propinsi	=	m_lookup("propinsi","kd_propinsi","nm_propinsi","kd_propinsi='".$this->user_prop."'");
			$lookup_kabupaten	=	m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$this->user_prop."' and kd_kabupaten='".$this->user_kab."' and kd_kabupaten!='00'");											
		else:
			$lookup_propinsi	=	m_lookup("propinsi","kd_propinsi","nm_propinsi","kd_propinsi='".$this->user_prop."'");
			$lookup_kabupaten	=	array(""=>"--Pilih--")+m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$this->user_prop."' and kd_kabupaten!='00'");											
		endif;
	else:
		$lookup_propinsi	=	array(""=>"Propinsi")+m_lookup("propinsi","kd_propinsi","nm_propinsi","");
		if($_GET['propinsi']):
			$lookup_kabupaten	=	array(""=>"--Pilih--")+m_lookup("kabupaten","kd_wilayah","nm_kabupaten","kd_propinsi='".$_GET['propinsi']."' and kd_kabupaten!='00'");
		endif;
	endif;
?>
<section class="content-header">
  <h1 class="hidden-xs">
    <?=$this->parent_module_title?>
    <small><?=$this->module_title?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo $this->module?>"><i class="fa fa-user-plus"></i> <?=$this->parent_module_title?></a></li>
    <li><a href="<?php echo $this->module?>" class="active"><?=$this->module_title?></a></li>
  </ol>
</section>

<section class="content">
    <div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
            <!-- TOOLBAR -->
			<div class="content-toolbar">
                	<a class="btn btn-white active" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="List">
                        <i class="fa fa-list"></i>
                    </a>
					<div class="btn-group">
                          	<a class="btn btn-white" href="<?php echo $this->module?>import/" data-toggle='tooltip' data-original-title="Add">
                               Import
                            </a>
                          	<a class="btn btn-white" href="<?php echo $this->module?>index/<?=$category?>" data-toggle='tooltip' data-original-title="Refresh">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                    <a class="btn btn-white" href="<?php echo $this->module?>add" data-toggle='tooltip' data-original-title="Add">
                        <i class="fa fa-plus"></i>
                    </a>	  
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
					<div class="btn-group pull-right">
						<a href="#" class="print-pdf hidden" data-url=""><i class="fa fa-file-pdf-o"></i> PDF</a>
						<div class="btn-group btn-group-sm pull-right">
							<a href="/print" class="btn btn-white div_id_print_modal" data-div_id="#print_this" data-page_orientation='L' data-page_size='A4' data-toggle='tooltip' data-original-title="Print Preview"><i class="fa fa-print"></i>&nbsp;Print Preview</a>
							<a href="#" class="btn btn-white print-excel" data-url="" data-toggle='tooltip' data-original-title="Export to Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</a>
						</div>
					</div>
            </div>
            <!-- END: TOOLBAR -->
        	<div class="box box-widget">
            	<div class="box-header with-borders">
                	<div class="row">
                        <div class="col-md-12 col-xs-12 table-responsive">
                        <form class="form-inline" action="<?=$this->module?>" method="get" id="search_form">
							
                          <div class="form-group hidden">
                            <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                          </div>
                          <div class="form-group">
								<?php
									$y				=	date("Y");
									$tahun['All']	=	"All";
									for($i=0; $i<31; $i++):
										$tahun[$i]	=	$y-$i;
									endfor;
									
								?>
								<select name="tahun" class="form-control">
									<?php foreach($tahun as $k=>$v): ?>
										<option value="<?=$v?>" <?=($_GET['tahun']==$v)?"selected":""?>><?=$v?></option>
									<?php endforeach; ?>
								</select>
                          </div>
						  <div class="form-group">
								<select name="propinsi" class="form-control" id="propinsi">
									<?php foreach($lookup_propinsi as $k=>$v): ?>
										<option value="<?=$k?>" <?=($_GET['propinsi']==$k)?"selected":""?> class="small-opt2">
											<?=$v?>
										</option>
									<?php endforeach; ?>
								</select>
                          </div>
						  <div class="form-group">
							<select name="kabupaten" class="form-control" id="kabupaten">
								<?php foreach($lookup_kabupaten as $k=>$v): ?>
										<option value="<?=$k?>" <?=($_GET['kabupaten']==$k)?"selected":""?>><?=$v?></option>
								<?php endforeach; ?>
							</select>
                          </div>
						  <div class="form-group">
								<select name="sektor" class="form-control" id="sektor">
									<option value="">Sektor</option>
									<?php foreach($this->lookup_sektor as $k=>$v): ?>
										<option value="<?=$k?>" <?=($_GET['sektor']==$k)?"selected":""?> class="small-opt"><?=$v?></option>
									<?php endforeach; ?>
								</select>
                          </div>
                          <div class="form-group">
								<select name="konflik" class="form-control" id="konflik">
									<option value="">Konflik</option>
									<?php foreach($this->lookup_konflik as $k=>$v): ?>
										<option value="<?=$v?>" <?=($_GET['konflik']==$v)?"selected":""?> class="small-opt"><?=$v?></option>
									<?php endforeach; ?>
								</select>
                          </div>
						  
						  <div class="form-group">
								<select name="status" class="form-control">
									<option value="">Status</option>
									<?php foreach($lookup_status_konflik as $k=>$v): ?>
										<option value="<?=$k?>" <?=($_GET['status']==$k)?"selected":""?> class="small-opt"><?=$v?></option>
									<?php endforeach; ?>
								</select>
                          </div>
						  
						  <div class="form-group">
								<select name="sifat" class="form-control">
									<option value="">Sifat</option>
									<?php foreach($label_sifat as $k=>$v): ?>
										<option value="<?=$k?>" <?=($_GET['sifat']==$k)?"selected":""?> class="small-opt"><?=$k?></option>
									<?php endforeach; ?>
								</select>
                          </div>                           
                          <div class="form-group">
								<select name="kategori" class="form-control">
									<option value="">Kategori</option>
									<?php foreach($lookup_kategori as $k=>$v): ?>
										<option value="<?=$k?>" <?=($_GET['kategori']==$k)?"selected":""?> class="small-opt"><?=$v?></option>
									<?php endforeach; ?>
								</select>
                          </div> 
                          
                          <div class="form-group">
                            <?php $this->load->view("widget/search_box_db"); ?>
                          </div>
						  
						  <div class="form-group">
							<button type="submit" class="btn btn-primary">Search</button>
						  </div>
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
            	<!--box body-->
                <?php 
					/* 
					   ditaro diatas supaya tabel dapet offset dr pagination, 
					   digunakan untuk penomoran tabel 
					*/
					$page_link=$this->pagination->create_links(); 
					$offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;
				?>
				<div class="box-body">
				<table class="table table-bordered table-condensed small-font">
					<thead>
						<tr>
							<th width="20px">No.</th>
							<th>Kejadian</th>
							<th>Judul</th>
							<th>Clip</th>
							<th>Konflik</th>
							<th>Sektor</th>
							<th>Status</th>
							<th>Kategori</th>
							<th style="width:100px;"></th>
						</tr>
					</thead>
					<tbody>
						<?php if(cek_array($arrData)):?>
							<?php foreach($arrData as $x=>$val):
									$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
							?>
								<tr>
									<td><?php echo $offset+$x+1?>.</td>
									<td><?=date_format(date_create($val['tgl_kejadian']),"d-m-Y")?></td>
									<td align='justify'>
										<?=$val["judul"]?><br />
										<span class="text-muted"><em><?=$val['nm_propinsi']?></em>&nbsp;</span><br />
										<span class="text-muted"><em><?=$val['nm_kabupaten']?></em>&nbsp;</span>
										<br /><br />
                                        <span class="text-muted"><em>Confidentiality: </em></span>
										<br />
                                        <span class="label label-<?=$label_sifat[$val['sifat']]?>">
											<?=$val['sifat']?>
										</span>
                                    </td>
									<td align='justify'><?=$val["clip"]?></td>
									<td>
										<?php
											if($val["kd_konflik"]):
												$arr_konflik	=	explode(",",$val["kd_konflik"]);
											endif;
										?>
										<?php if($val["kd_konflik"]): ?>
											<table class="table table-condensed">
												<?php foreach($arr_konflik as $k=>$v): ?>
													<tr>
														<td><?=$v?></td>
													</tr>
											<?php endforeach; ?>
											</table>
										<?php endif; ?>
                                        
									</td>
									<td align="center"><span class="badge" style="background-color:<?=$this->sektor_color[$val["kd_sektor"]]?>" data-toggle='tooltip' title="<?=$val["sektor"]?>">&nbsp;</span></td>
									<td>
										<?php if($val['status_konflik']=='PS'): ?>
											<span class="label label-<?=$label_status_konflik[$val['status_konflik']]?>">
												<?=$lookup_status_konflik[$val['status_konflik']]?>&nbsp;<?=$lookup_status_konflik_proses[$val['status_konflik_proses']]?>
											</span>
										<?php else: ?>
											<span class="label label-<?=$label_status_konflik[$val['status_konflik']]?>">
												<?=$lookup_status_konflik[$val['status_konflik']]?>
											</span>
										<?php endif; ?>
									</td>
									<td>
										<?=$lookup_kategori[$val['kategori']?$val['kategori']:"K2"]?>
									</td>
									<td align="center">
										<!--<div class="btn-group btn-group-xs">
										<a class="btn btn-xs btn-default" href="<?=$this->module?>view/<?=$id?>" data-toggle='tooltip' title="View"><i class="fa fa-search blue"></i></a> 
										<a class="btn btn-xs btn-default " href="<?=$this->module?>edit/<?=$id?>" data-toggle='tooltip' title="Edit"><i class="fa fa-pencil green"></i></a> 
										<a class="btn btn-xs btn-default" onclick="return confirm('Anda yakin akan menghapus data ini?');" data-toggle='tooltip' href="<?php echo $this->module."del/".$id?>" title="Delete"><i class="fa fa-remove red"></i></a> 
										</div>-->
										
										
										<div class="btn-group btn-group-xs">
										<a class="btn btn-xs btn-default" href="<?=$this->module?>view/<?=$id?>" data-toggle='tooltip' title="View"><i class="fa fa-search blue"></i></a> 
										<a class="btn btn-xs btn-default" href="<?=$this->module?>edit/<?=$id?>" data-toggle='tooltip' title="Edit"><i class="fa fa-pencil green"></i></a> 
										<a class="btn btn-xs btn-default" onclick="return confirm('Anda yakin akan menghapus data ini?');" data-toggle='tooltip' href="<?php echo $this->module."del/".$id?>" title="Delete"><i class="fa fa-remove red"></i></a>
										</div>
									</td>
								</tr>
							<?php endforeach;?>
						<?php endif;?>
					</tbody>
				</table>
				</div>
				
				<div id="print_this" class="bg-white hidden">
				<div id="div_excel">
					<div style="text-align:center;font-size:14px;"><p>
					<?php if($_GET['tahun']=='All'):?>
					<b>DAFTAR KONFLIK LAHAN<br>SELURUH TAHUN</b>
					<?php else: ?>
					<b>DAFTAR KONFLIK LAHAN<br>TAHUN <?=($_GET['tahun']=="")?date('Y'):$_GET['tahun']?></b>
					<?php endif; ?>
					</p>
					</div>
					<div class="box-body table-responsive">
					<table class="blek" border="1" style="border-collapse:collapse; width:100%;  border:thin solid;">
						<thead class="ret blek">
							<tr class="ret blek">
								<td align="center" class="ret blek" width="20px"><b>No.</b></td>
								<td align="center" class="ret blek"><b>Kejadian</b></td>
								<td align="center" class="ret blek"><b>Nomor Kejadian</b></td>
								<td align="center" class="ret blek"><b>Judul</b></td>
								<td align="center" class="ret blek"><b>Clip</b></td>
								<td align="center" class="ret blek"><b>Konflik</b></td>
								<td align="center" class="ret blek"><b>Sektor</b></td>
								<td align="center" class="ret blek"><b>Status</b></td>
								<td align="center" class="ret blek"><b>Investasi <br> (Rp) </b></td>
								<td align="center" class="ret blek"><b>Luas <br> (Ha)</b></td>
								<td align="center" class="ret blek"><b>Dampak Masyarakat <br> (Jiwa)</b></td>
								<td align="center" class="ret blek"><b>Confidentiality</b></td>
							</tr>
						</thead>
						<tbody class="blek">
							<?php if(cek_array($arrData)):?>
								<?php foreach($arrData as $x=>$val):
										$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];

								$exp_luas	=	explode(".",$val["luas"]);
								$luas		=	number_format($exp_luas[0]);
								$exp_investasi	=	explode(".",$val["investasi"]);
								$investasi		=	number_format($exp_investasi[0]);
								?>
									<tr class="blek">
										<td class="blek"><?php echo $offset+$x+1?>.</td>
										<td class="blek"><?=date_format(date_create($val['tgl_kejadian']),"d-m-Y")?></td>
										<td class="blek" align='justify'><?=$val["nomor_kejadian"]?></td>
										<td class="blek" align='justify'><?=$val["judul"]?></td>
										<td class="blek" align='justify'><?=$val["clip"]?></td>
										<td class="blek">
											<?=$val["kd_konflik"];?>
										</td>
										<td class="blek" align="left"><?=$val["sektor"]?></td>
										<td class="blek">
											<?php if($val['status_konflik']=='PS'): ?>
												<span>
													<?=$lookup_status_konflik[$val['status_konflik']]?>&nbsp;<?=$lookup_status_konflik_proses[$val['status_konflik_proses']]?>
												</span>
											<?php else: ?>
												<span>
													<?=$lookup_status_konflik[$val['status_konflik']]?>
												</span>
											<?php endif; ?>
										</td>
										<td class="blek" align="right"><?php echo str_replace(",",".",$investasi); ?>,<?php echo ($exp_investasi[1])?$exp_investasi[1]:"00"; ?></td>
										<td class="blek" align="right"><?php echo str_replace(",",".",$luas); ?>,<?php echo ($exp_luas[1])?$exp_luas[1]:"00"; ?></td>
										<td class="blek" align="right"><?php echo str_replace(",",".",number_format($val["dampak"]));?></td>
										<td class="blek">
											<span>
												<?=$val['sifat']?>
											</span>
										</td>
									</tr>
								<?php endforeach;?>
							<?php endif;?>
						</tbody>
					</table>
					</div>
				</div>
				</div>
				
                <!--end: box body-->
                <div class="box-footer clearfix">
                    <div class="row">
                        <div class="col-md-8 col-xs-12">
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
                                5=>5,
                                10=>10,
                                25=>25,
                                50=>50,
                                -1=>"All"
                            );
                            $pp=$perPage;
                        ?>
                        Rows/page: <label><?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select' class='form-control input-sm'")?></label>
                        <input type="hidden" id="pp" name="pp" value="" />
                            
                             </div>
                        </div><!-- end span 6-->
                        <div class="col-md-4 col-xs-12">
            
                                <?php echo $page_link; ?>
            
                        </div><!-- end span 6-->
                    </div>
                    <!-- end class well -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
	$(document).ready(function(){
		$("#propinsi").on("change",function(){
								
			var id_propinsi	=	$(this).val();
								
			var url			=	"<?=$this->module?>get_kabupaten";
								
			$.ajax({
				url		:	url,
				type	:	"POST",
				data	:	{kd_propinsi:id_propinsi},
				success	:	function(html_result,status){
					if(status=="success"){
						$("#kabupaten").html(html_result);
					}
				}
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
								
		$("#sektor").on("change",function(){
									
			var sektor_value	=	$(this).val();
									
			var get_konflik_url	=	"<?=$this->module?>getKonflik";
									
			$.ajax({
				url		:	get_konflik_url,
				type	:	"POST",
				data	:	{kode_sektor:sektor_value},
				success	:	function(html_result){
											
					$("#konflik").html(html_result);
											
				}
			});
									
		});
								
		<?php if($_GET['sektor']): ?>
			var get_konflik_url	=	"<?=$this->module?>getKonflik";
									
			var sektor_value	=	$("#sektor").val();
			
			var konflik_value	=	"<?=$_GET['konflik']?>";
			
			$.ajax({
				url		:	get_konflik_url,
				type	:	"POST",
				data	:	{kode_sektor:sektor_value},
				success	:	function(html_result){
											
					$("#konflik").html(html_result);
					if(konflik_value){
						$("#konflik option[value='"+konflik_value+"']").prop("selected",true);
					}
				}
			});
		<?php endif; ?>
								
	});
</script>
<script type="text/javascript" src="assets/js/lingkar/jquery.export2excel.js"></script>
<script type="text/javascript" src="assets/js/lingkar/jquery.table2csv.js"></script>

<script>
	$(function(){
		var style = '<style>table {font-family:chelvetica, Arial;font-size:9px;margin:0;width:100%}table.section{margin-top:10px;}th {text-align:left!important;}h5 {font-family:chelvetica, Arial;}.val{font-weight:bold}</style>';
		/*
		$("a.print-excel").click(function(e){
			e.preventDefault();
			//var file="file_20140929134835.xls";
			
			var file="laporan_konflik<?="_".date("YmdHis").".xls";?>";
			var base_url="<?=base_url()?>";
			/*get html table 
			var tbl = $('<div>').append($('div#div_excel').clone()).remove().html();
			
			/* add table to div to export  
			var div = $('<div>').append(tbl);
			div.find("table").attr("border","1");
			$(div).Export2XLS({filename:file,urlAction:base_url+"export/xls/"});
		});
		*/
		
		$("a.print-excel").click(function(e){
			e.preventDefault();
			var base_url		=	"<?=base_url()?>";
			
			var target			=	"<?=$this->module?>get_export_template?type=xls&";
			var url_parameter	=	$("#search_form").serialize();
			var complete_url	=	base_url+target+url_parameter;
			var style 			=	'<style>table {font-family:chelvetica, Arial;font-size:9px;margin:0;width:100%}table.section{margin-top:10px;}th {text-align:left!important;}h5 {font-family:chelvetica, Arial;}.val{font-weight:bold}.report-title{font-size:12px !important;}</style>';
			var file="Data_konflik<?="_".date("YmdHis").".xls";?>";
			$.get(complete_url,function(data_html){
				/*get html table */
				var tbl = data_html;
				/* add table to div to export */
				var div = $('<div>').append(tbl);
				div.find("table").attr("border","1");
				$(div).Export2XLS({filename:file,urlAction:base_url+"export/xls/"});
			});	
		});
		
		/*
		$("a.print-html").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
            var html=$("div#print_this").html();
			var file="penetapan_batas_propinsi_<?="_".date("YmdHis").".html";?>";
            UrlSubmit(base_url+"export/html_print/",{filename:file,tbl:encodeURIComponent(html),target:"_blank"});
			return false;
			//$(this).attr("target","_blank");
		});
		
		*/
		
		
		$("a.print-pdf").click(function(e){
			e.preventDefault();
			var base_url="<?=base_url()?>";
			var html=style+$("div#print_this").html();
			var file="test<?="_".date("YmdHis").".pdf";?>";
			UrlSubmit(base_url+"export/proxy_pdf/",{filename:file,tbl:encodeURIComponent(html),time:(new Date).getTime(),header_height:70,p:'A4',o:'L',target:"_blank"});
		});
		
	});
</script>
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
.text-muted{
	font-size:12px;
}
</style>

<?php
	$arr_jns_wikera	=	lookup("m_jenis","kode","uraian","status='1'"," order by idx");
	$arr_tahapan	=	lookup("m_tahapan","kode","uraian","status='1'"," order by idx");
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
                    <a class="btn btn-white" href="<?php echo $this->module?>add" data-toggle='tooltip' data-original-title="Add">
                        <i class="fa fa-plus"></i>
                    </a>	  
                    <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' data-original-title="Refresh">
                        <i class="fa fa-refresh"></i>
                    </a>
					
					<div class="pull-right">
						<div class="btn-group btn-group-sm pull-right">
							<button class="btn btn-white export_csv" data-original-title="Export CSV">
								<i class="fa fa-file"></i>&nbsp;Export CSV
							</button>
						</div>
					</div><!-- end col -->
					
            </div>
            <!-- END: TOOLBAR -->
        	<div class="box box-widget">
            	<div class="box-header with-borders">
                	<div class="row">
                        <div class="col-md-12 col-xs-12">
                        <form class="form-inline" action="<?=$this->module?>" method="get">
                          <div class="form-group">
                            <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-circle-o-notch"></i></button>
                          </div>
                          <div class="form-group">
								<?php
									$y	=	date("Y");
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
										<option value="<?=$k?>" <?=($_GET['propinsi']==$k)?"selected":""?>><?=$v?></option>
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
							<?=form_dropdown("jenis_wikera",array(""=>"Jenis Wilayah Kelola")+$this->lookup_map_group,$_GET['jenis_wikera'],"class='form-control'")?>
                          </div>
						  
						  <div class="form-group">
							<?=form_dropdown("status_validasi",array(""=>"Status Validasi",1=>"Valid",2=>"Tidak Valid"),$_GET['status_validasi'],"class='form-control'")?>
                          </div>
						  
                          <div class="form-group">
                            <?php $this->load->view("widget/search_box_db"); ?>
                          </div>
                          <!--<div class="form-group">
                            <label for="exampleInputEmail2">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
                          </div>-->
                          <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                        </div>
                        <div class="col-md-4 hidden">
                            <div class="btn-group pull-right hidden">
                            	<a class="btn btn-transparent" href=""> <i class="fa fa-file"></i> Export</a>
                            </div>
                            <div class="btn-group pull-right">
                              <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file"></i>&nbsp; Export Data <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu">
                                <li><a href="<?=$this->module?>ExportCSV" target="_blank"><i class="fa fa-file-zip-o">&nbsp;</i>Export To CSV File</a></li>
								<!--
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Separated link</a></li>
								-->
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
				
                <div class="box-body table-responsive">
                <table class="table table-bordered table-condensed small-font">
                    <thead>
                        <tr>
                            <th width="25px">No.</th>
                            <th>Tanggal Input</th>
                            <th>Nama Wilayah Kelola</th>
                            <th>Profil</th>
							<th>Jenis Wilayah Kelola</th>
							<th>Tahapan</th>
							<th>Status Validasi Peta</th>
                            <th style="width:100px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$val):
                                    $id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
                            ?>
                                <tr>
                                    <td align="center"><?php echo $offset+$x+1?></td>
                                    <td><?=date_format(date_create($val['tgl_kejadian']),"d-m-Y")?></td>
                                    <td>
										<?=$val["nama_wikera"]?><br />
										<span class="text-muted"><em><?=$val['nm_propinsi']?></em>&nbsp;</span><br />
										<span class="text-muted"><em><?=$val['nm_kabupaten']?></em>&nbsp;</span>
									</td>
                                    <td align="justify"><?=$val["clip"]?></td>
									<td>
										<?=$this->lookup_map_group[$val["kode_jns_wikera"]]?>
										<?php if($val["kode_jns_wikera"]=="PIAPS"): ?>
											<br /><span class="text-muted"><?=$this->lookup_kategori_perhutanan[$val['kategori_perhutanan']]?></span>
										<?php endif; ?>
									</td>
									<td><?=$arr_tahapan[$val["kode_tahapan"]]?></td>
									<td>
										<?php if($val['status_validas_peta']==1): ?>
											<span class="label label-info">Valid</span>
										<?php elseif($val['status_validas_peta']==2): ?>
											<span class="label label-danger">Tidak Valid</span>
										<?php endif; ?>
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
	
	var	limit		=	'<?=$_GET['pp']?>';
	var offset		=	'<?=$offset?>';
	var tahun		=	'<?=$_GET['tahun']?$_GET['tahun']:date("Y")?>';
	var key			=	'<?=$_GET['q']?>';
	var target		=	'_blank';
	var export_url	=	'<?=$this->module?>ExportCSV';
	
	$(".export_csv").on("click",function(){
		
		UrlSubmit(export_url,{limit:limit,offset:offset,tahun:tahun,key:key,target:target});
		
	});
	
});
</script>

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
	
	//alert('<?=$offset?>');
	
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

<style>
.ajax-spinner-bars {
    background-image: url(assets/images/i-loading.gif);
	height:70%;
	width:50%;
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

<!--header-->
<div class="well well-sm sub-head" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-3">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>DATA WILAYAH KELOLA</strong></h6>
                    </div>
					<div class="col-md-9 col-xs-9">
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end header-->
<div class="main-container container text-center-xs">
        <!--header-->
        <div class="row">
            <div class="col-sm-12">
                <section class="content" >
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-inline" action="<?=$this->module?>" method="get">
                        
                            <div class="form-group col-xs-inline-block">
							  <?php
                                $req=get_post();
                                $lookup_tipe[1]="Semua Data ";
                                $lookup_tipe[2]="Per Tahun";
                                
                                $tipe=$req["tipe"]?$req["tipe"]:"";
                                
								$y	=	date("Y");

								for($i=0; $i<31; $i++):
									$tahun[$i]	=	$y-$i;
								endfor;
								
								$lookup_propinsi	=	array(""=>"Propinsi")+m_lookup("propinsi","kd_propinsi","nm_propinsi","");
                            ?>
                                <?=form_dropdown("tipe",$lookup_tipe,$tipe,"id='tipe' style='width:125px !important' class='form-control select2 required'");?>
        
                                <!-- <label for="tahun">Tahun</label> -->
                                <select id="tahun" name="tahun" class="form-control">
                                    <?php foreach($tahun as $k=>$v): ?>
                                    <option value="<?=$v?>" <?=($selected_tahun==$v)?"selected":""?>><?=$v?></option>
                                    <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="checkbox">
                                <label class="<?=($selected_tahun?"":"not-used")?>">
                                <input type="checkbox" id="mmode" value="1" <?=($mmode)? "checked":""?> <?=($selected_tahun?"":" disabled='disabled'")?> >s/d Bulan
                                <input type="hidden" name="mmode" value="<?=($mmode)? "1":"0"?>" />
                                </label>
                              </div>
                              <div class="form-group">
                                <select id="bulan" name="bulan" class="form-control <?=($selected_tahun?"":"not-used")?> <?=($selected_tahun?"":" disabled='disabled'")?>">
                                    <option value="">Semua Bulan</option>
                                    <?php foreach($listMonth as $k=>$v): ?>
                                    <option value="<?=($k+1)?>" <?=($selected_bulan==($k+1))?"selected":""?>><?=$v?></option>
                                    <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="form-group">
								<select name="kd_prop" class="form-control" id="kd_prop">
									<?php foreach($lookup_propinsi as $k=>$v): ?>
										<option value="<?=$k?>" <?=($_GET['kd_prop']==$k)?"selected":""?>><?=$v?></option>
									<?php endforeach; ?>
								</select>
                                </div>
                                <div class="form-group">
                                    <?=form_dropdown("jenis_wikera",array(""=>"Jenis Wilayah Kelola")+$this->lookup_map_group,$_GET['jenis_wikera'],"class='form-control'")?>
                                </div>

                                <div class="form-group">
                                    <?=form_dropdown("kode_tahapan",array(""=>"Pilih Tahapan")+$this->lookup_tahapan,$_GET['kode_tahapan'],"class='form-control'")?>
                                </div>

                                <!-- <div class="form-group">
                                    <?=form_dropdown("status_validasi",array(""=>"Status Validasi",1=>"Valid",2=>"Tidak Valid"),$_GET['status_validasi'],"class='form-control'")?>
                                </div> -->
                                
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search">&nbsp;</i></button>
                        </form>
                    </div>
                </div>
                </section>
                
                <?php 
                    $page_link=$this->pagination->create_links(); 
                    $offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;
                ?>
                <section class="content" style="padding:0; margin-bottom:20px" >
                <div class="row table-responsive">
                    <div class="col-sm-12">
                        <table class="table table-condensed table-bordered" style="margin-bottom:0">
                            <thead class="well">
                                <tr>
                                    <th width="25px">No.</th>
                                    <th>Tanggal Input</th>
                                    <th>Nama Wilayah Kelola</th>
                                    <th>Profil</th>
                                    <th>Jenis Wilayah Kelola</th>
                                    <th>Tahapan</th>
                                    <!-- <th>Status Validasi Peta</th> -->
                                 	<th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(cek_array($arrData)):?>
                                    <?php foreach($arrData as $x=>$val):
                                            $id	=	encrypt($val[$this->tbl_idx]);
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
									<!-- <td>
										<?php if($val['status_validas_peta']==1): ?>
											<span class="label label-info">Valid</span>
										<?php elseif($val['status_validas_peta']==2): ?>
											<span class="label label-danger">Tidak Valid</span>
										<?php endif; ?>
									</td> -->
									<td align="center">
                                                <a href="<?=$this->module?>detil/<?=$id?>">
                                                    <button class="btn btn-info btn-xs"><i class="fa fa-search">&nbsp;</i>Detail</button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                </section>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="paging pull-left">
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
                                    5	=>	5,
                                    10	=>	10,
                                    25	=>	25,
                                    50	=>	50,
                                    -1	=>	"All"
                                );
                                $pp=$perPage;
                            ?>
                            Rows/page: <label><?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select' class='form-control input-sm'")?></label>
                            <input type="hidden" id="pp" name="pp" value="" />
                        </div>
                    </div>

                    <div class="col-sm-12 col-xs-12">
                        <div class="paging pull-right">
                            <?php echo $page_link; ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
</div>



<script>
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	
		$(".pagination .active a").click(function(e){
			e.preventDefault();
		});
		
		$("#mmode").click(function(){
			$("[name='mmode']").val($(this).is(":checked")?"1":"0");
		});
		
		$("#tipe").change(function(){
			$("#bulan,#mmode").attr("disabled",$(this).val()==2?false:true);
			if ($(this).val()==2) {
				$("#bulan,#mmode").removeClass("not-used");
				$("#mmode").parent().removeClass("not-used")
			} else {
				$("#bulan").addClass("not-used");
				$("#mmode").parent().addClass("not-used")
				$("#mmode").attr("checked",true);
				$("#bulan,#mmode").attr("disabled",true);
				
			}
		});
	
		$("#tipe").change();
		
		$("#pp_select").change(function(){
			var pp=parseInt($(this).find("option:selected").val());
			if(pp<0){
				location=document.URL.split("?")[0];
				return false;
			}
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
<style>
.ajax-spinner-bars {
    background-image: url(assets/images/i-loading.gif);
	height:70%;
	width:50%;
}
</style> 
<!--header-->
<div class="well well-sm sub-head" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-3">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>DATA KONFLIK</strong></h6>
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
        
                                <label for="tahun">Tahun</label>
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
                                <select name="sektor" class="form-control" style='width:150px !important'>
                                    <option value="">Semua Sektor</option>
                                    <?php foreach($this->lookup_sektor as $k=>$v): ?>
                                        <option value="<?=$k?>" <?=($_GET['sektor']==$k)?"selected":""?>><?=$v?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="konflik" class="form-control" style='width:150px !important'>
                                    <option value="">Semua Konflik</option>
                                    <?php foreach($this->lookup_konflik as $k=>$v): ?>
                                        <option value="<?=$v?>" <?=($_GET['konflik']==$v)?"selected":""?>><?=$v?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
								<select name="kd_prop" class="form-control" id="propinsi">
									<?php foreach($lookup_propinsi as $k=>$v): ?>
										<option value="<?=$k?>" <?=($_GET['kd_prop']==$k)?"selected":""?> class="small-opt2">
											<?=$v?>
										</option>
									<?php endforeach; ?>
								</select>
                          	</div>
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
                                    <th><p align="center">No</p></th>
                                    <th><p align="center">Tahun</p></th>
                                    <th><p align="center">Judul</p></th>
                                    <th><p align="center">Klip</p></th>
                                    <th><p align="center">Konflik</p></th>
                                    <th><p align="center">Sektor</p></th>
                                    <th><p align="center">&nbsp;</p></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(cek_array($arrData)):?>
                                    <?php foreach($arrData as $x=>$val):
                                            $id	=	encrypt($val[$this->tbl_idx]);
                                    ?>
                                        <tr>
                                            <td align="center"><?php echo $offset+$x+1?></td>
                                            <td><?=$val["tahun"]?></td>
                                            <td><?=$val["judul"]?></td>
                                            <td><?=$val["clip"]?></td>
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
                                            <td><span class="badge" style="background-color:<?=$this->sektor_color[$val["kd_sektor"]]?>"><?=$val["sektor"]?></span></td>
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
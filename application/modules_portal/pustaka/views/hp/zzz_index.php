<style>
.ajax-spinner-bars {
    background-image: url(assets/images/i-loading.gif);
	height:70%;
	width:50%;
}
</style> 

<?
	$lookup_empty[]="--Pilih--";
	
	$lookup_cat_pp=$lookup_empty+lookup("cms_pp_category","kd_cat_pp","ur_cat_pp","parent_id=2","order by order_num");
?>

<!--header-->
<div class="well well-sm sub-head" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-md-6">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>PERATURAN & KEBIJAKAN</strong></h6>
                    </div>
					<div class="col-md-6 col-xs-9">
                      <form class="form-inline" action="<?=$this->module?>" method="get" style="float:right !important">
    
                      <div class="form-group col-xs-inline-block">
					  
						  <!--
                          <label for="tahun">Tahun</label>
                          <select id="tahun" name="tahun" class="form-control">
                              <option value="">Semua</option>
                              </?php foreach($tahun as $k=>$v): ?>
                              <option value="</?=$v?>" </?=($selected_tahun==$v)?"selected":""?>></?=$v?></option>
                              </?php endforeach; ?>
                          </select>
						  -->
							
							<input type="text" name="q" class="form-control" value="<?=$_GET['q']?>" placeholder="Kata Kunci" />
						   <input type="hidden" id="cat" name="cat" value="" />
                        </div>
                        <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                        <button type="reset" class="btn btn-white" data-toggle='tooltip' title="Reset"><i class="fa fa-remove text-red"></i></button>
                        <!--<button id="btn_print" class="btn btn-white pull-right" data-toggle='tooltip' title="Save as PDF"><i class="fa fa-file-pdf-o"></i></button>-->
                      </form>
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
            <div class="col-sm-8 col-xs-12">
         		<section class="content" >   
            	<?php 
					/* 
					   ditaro diatas supaya tabel dapet offset dr pagination, 
					   digunakan untuk penomoran tabel 
					*/
					$page_link=$this->pagination->create_links(); 
					$offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;
				?>
            
              <div class="box-body table-responsive">
                <table class="table table-condensed small-font">
                    <thead>
                    	<tr>
                        <th width="20">No.</th>
                        <th style="width:50px">Tahun</th>
                        <th style="width:200px">Peraturan</th>
                        <th style="width:100px">File</th>
                        <th style="width:100px">Size</th>
                        
                        </tr>
        		</thead>
                <tbody>
                		
                
                    <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$val):
									$id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
									$url_edit = $this->module."edit/".$id;
									$url_delete = $this->module."delete/".$id;
		
									$status_badges = ($val['publish'])==1?'<span class="label label-info">Published</span>':'<span class="label label-warning">Draft</span>';
							
								$file_name_arr=explode(",",$val["realname"]);
								$file_size_arr=explode(",",$val["file_size"]);
								
							
							?>
                            	<tr>
                                	<td><?php echo $offset+$x+1?>.</td>
                                    <td><?php echo $val["year"]?></a></td>
                                    <td rel="no_pp"><?=$val['no_pp'];?> tentang <?php echo $val["about"]?></td>
                                    <td>
                                    <? if(cek_array($file_name_arr)):?>
                                    	<? foreach($file_name_arr as $xx=>$valx):?>
                                        <a href="<?=$this->config->item("dir_pp");?><?php echo $valx?>" title="<?=$valx;?>"><i class="fa fa-cloud-download"></i> Unduh</a>
                                   <br>
										<? endforeach;?>
                                    <? else:?>
                                    	<a href="<?=$this->config->item("dir_pp");?><?php echo $val["realname"]?>"><i class="fa fa-cloud-download"></i></a>
                                         <?=size_format($val["file_size"]*1024);?>
									<? endif;?>
                                    </td>
                                    <td>
                                    	<? foreach($file_size_arr as $xx=>$valx):?>
                                        	<?=size_format($valx*1024);?>
                                            <br>
                                        <? endforeach;?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
              	
              </div>
              </section>
              <!-- footer -->
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
              <!-- end footer-->
              
               
    </div>
</div>
<script>
$(document).ready(function(){
	$('.upx').load('filler/filler/dash_map', function(){
		$('.ajax-spinner-bars').hide();
	});

	$('.bootom').load('filler/filler/list_konflik', function(){
		$('.ajax-spinner-bars').hide();
	});
});
</script>
<script>
$(".fancybox").fancybox({
    helpers : {
        overlay : {
            css : {
                'background' : 'rgba(58, 42, 45, 0.95)'
            }
        }
    }
});
</script>

<style>
.ajax-spinner-bars {
    background-image: url(assets/images/i-loading.gif);
	height:70%;
	width:50%;
}
</style> 

<?php
	$lookup_empty[""]="Semua Peraturan";
	
	$lookup_cat_pp=$lookup_empty+lookup("cms_pp_category","kd_cat_pp","ur_cat_pp","parent_id=1","order by order_num");
	$req=get_post();
	$cat=$req["cat"]?$req["cat"]:'';
	
?>


<!--header-->
<div class="well well-sm sub-head xhead" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-4">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>PERATURAN & KEBIJAKAN</strong></h6>
                    </div>
					<div class="col-md-8 col-xs-9">
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
                           <input type="hidden" id="pp" name="pp" value="" />
                           
						   <input type="hidden" name="cat" id="cat" class="form-control" value="<?=$cat?>"/>
                           	
							<input type="text" name="q" id="q" class="form-control" value="<?=$_GET['q']?>" placeholder="Kata Kunci" />
						  
                        </div>

                        <div class="form-group">
								<select name="tahun" class="form-control">
									<option value="">Tahun</option>
                                        <?  $thn=date('Y');
                                            for($thn;$thn>date('Y')-10;$thn--): ?>
                                            <option value="<?=$thn?>" <?=($_GET['tahun']==$thn)?"selected":""?> class="small-opt"><?=$thn?></option>
                                        <?  endfor; ?>
								</select>
                          </div>

                        <div class="form-group">
                            <select name="kd_cat_pp" class="form-control">
                                <? foreach($lookup_cat_pp aS $k=>$v):?>	
                                    <option value="<?=$k?>" <?=($_GET['kd_cat_pp']==$k)?"selected":""?> class="small-opt"><?=$v?></option>
                                <? endforeach;?>
                            </select>
                          </div>
                        <button id="btn_search" type="submit" class="btn btn-white">Tampilkan</button>
                        <button type="reset" class="btn btn-white btn-reset" data-toggle='tooltip' title="Reset"><i class="fa fa-remove text-red"></i></button>
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
            <div class="col-sm-9">
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
                        <th colspan='2' style="width:200px">Peraturan</th>
                        <th style="width:100px">File</th>
                        <th  style="width:100px">#</th>
                        </tr>
        		</thead>
                <tbody>
                		
                
                    <?php if(cek_array($arrData)):?>
                            <?php foreach($arrData as $x=>$val):
                                    $id=$this->encrypt_status==TRUE?encrypt($val[$this->tbl_idx]):$val[$this->tbl_idx];
									$url_edit = $this->module."edit/".$id;
									$url_delete = $this->module."delete/".$id;
        
                                    $upload = "uploaded : "."<br />".$val['created'];
		
									$status_badges = ($val['publish'])==1?'<span class="label label-info">Published</span>':'<span class="label label-warning">Draft</span>';
							?>
                            	<tr>
                                	<td><?php echo $offset+$x+1?>.</td>
                                    <td><?php echo $val["year"]?></a></td>
                                    <?php $gambar=$val['image']!=''?$val['image']:"noimg.jpg"; ?>
						 	        <td>
                                        <? if($val['image']):?>
                                            <img src="<?=$this->config->item("dir_pp").$gambar?>" id="previewplay" width="60px" style="height:60px; max-height:60px">
                                        <? else:?>
                                           <div style="border:1px solid grey;width:60px !important;height:70px !important">
                                                <small><p><center> No <br />Cover</center></p></small>
                                           </div>
                                        <? endif;?>
                                    </td>
                                    <td rel="no_pp"><?=$val['no_pp'];?> tentang <?php echo $val["about"]?></td>
                                   
                                    <td><a href="<?=$this->config->item("dir_pp");?><?php echo $val["realname"]?>"><i class="fa fa-cloud-download"></i></a>&nbsp;<?=size_format($val["file_size"]*1024);?></td>
                                    <td><small><?=$upload?></small></td>
                                    
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
                        
                            
                             </div>
                        </div><!-- end span 6-->
                        <div class="col-md-4 col-xs-12">
            
                                <?php echo $page_link; ?>
            
                        </div><!-- end span 6-->
                    </div>
              <!-- end footer-->
    </div><!-- end col -->
    <div class="col-md-3">
    	<section class="content" > 
        	
        	
            <div class="box">
            <div class="hidden box-header">
              <h6 class="box-title">Kategori</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
              	<thead>
                <tr>
                	<th colspan="2">Kategori Peraturan</th>
                </tr>
                </thead>
            	<?php if(cek_array($lookup_cat_pp)):?>
            	<? unset($lookup_cat_pp[0]);?>
                <tbody>
				<? foreach($lookup_cat_pp as $x=>$val):?>
                	<tr>
                    	<? if($cat==$x):
						   		$icon="<i class='fa fa-check' style='color:#be251c'></i>";
						   		$s_active="color:#be251c !important;";
						   else:
						   	 	$icon="";
								$s_active="";
						   endif;
						?>
                  		<td width="5px"><?=$icon?></td>
                        <td> <a style="<?=$s_active?>" class="a-cat" href="javascript:void(0);" data-cat="<?=$x?>"><?=$val?></a></td>
                	</tr>	
				<? endforeach;?>
                </tbody>
				<?php endif;?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
            
        </section>
    </div>
</div>
<script>
	$(function(){
		$(".a-cat").click(function(e){
			e.preventDefault();
			
			var cat=$(this).data("cat");
			$("#cat").val(cat);
			//get_query();
			$("form").submit();
		});	
		
		$(".btn-reset").click(function(e){
			e.preventDefault();
			location="<?=$this->module?>";
		})
		
		$("#pp_select").change(function(){
			var pp=parseInt($(this).find("option:selected").val());
			$("#pp").val(pp);
			$("form").submit();
		});
		
		$("form").submit( function(e){
			e.preventDefault();
			//convert form to query string, i.e. a=1&b=&c=, then cleanup with regex
			var q = $(this).serialize().replace(/&?[\w\-\d_]+=&|&?[\w\-\d_]+=$/gi,""),
			url = this.getAttribute('action')+ (q.length > 0 ? "?"+q : "");
			window.location.href = url;
		});
	});
	
</script>

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

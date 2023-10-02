<style>
.ajax-spinner-bars {
    background-image: url(assets/images/i-loading.gif);
	height:70%;
	width:50%;
}
</style> 
<!--header-->
<div class="well well-sm sub-head xhead" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-md-6">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>BERITA & INFORMASI</strong></h6>
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
               
			<!--end header-->
            <?php foreach($arrData as $k=>$v): ?>
			<?php
                $page_link=$this->pagination->create_links();
                $offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;

                if(!$v["image"]):
                    $src    =   "./content/images/noimg.png";
                else:
                    $src    =   $this->config->item("dir_news").$v["image"];
                endif;
            ?>
            <section class="content" >
                <div class="row">
                      <!--<div class="container text-center-xs hidden">
                        <ol class="breadcrumb flat">
                          <li><a href="home"><?=$home;?></a></li>
                          <li><a href="<?=$this->module?>"><?=ucfirst($active)?></a></li>
                          <li class="active"><?=$breadcrumb?></li>
                        </ol>
                      </div>-->
                        <div class="col-sm-12 col-xs-12">
                            
                                <div class="media">
                                    <div class="pull-left" >
                                        <a href="<?=$src?>" class="fancybox" title="<?=$v['title']?>">
                                            <img src="<?=$src?>" class="avatar media-object" alt="<?=date('Y')?>" style=" width:130px;height:100px;margin:1px;border:thin solid #CCCCCC" />
                                        </a>
                                    </div>
                                      <div class='media-body'>
    
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h6 class="media-heading">
                                                    <a href="news/read/<?=$v['idx'];?>" class="news-title">
                                                        <?php
                                                            if(strlen($v['title'])>60):
                                                                echo substr($v['title'],0,60)."...";
                                                            else:
                                                                echo $v['title'];
                                                            endif;
                                                        ?>
                                                    </a>
                                                </h6>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="pull-left">
                                                    <span class="label label-info">
                                                        <i class="fa fa-calendar">&nbsp;</i><?=date_format(date_create($v['created']),"d-m-Y");?>
                                                    </span>
                                                    &nbsp;
                                                    <span class="label label-default">
                                                        <i class="fa fa-pencil">&nbsp;</i><?=$v['author']?$v['author']:"Admin"?>
                                                    </span>
                                                </div>
                                            </div>
    
                                            <div class="col-sm-12">
                                                <div>
                                                    <p align="justify">
                                                    <?php if(strlen($v['clip'])>150): ?>
                                                        <?=substr($v['clip'],0,150)."...";?>
                                                    <?php else: ?>
                                                        <?=$v['clip']?>
                                                    <?php endif; ?>
    
                                                    </p>
                                                    <a href="news/read/<?=$v['idx'];?>" class="news"><i>read more &raquo;</i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                     <!-- Contact Form Wrap Ends -->
    
                            
                        </div>
                    </div>
            </section><?php endforeach; ?>
            <section class="content" style="background-color:transparent">
            	<div class="box-footer clearfix">
                    <div class="row" style="text-align:right; padding-top:10px;">
                        <div class="col-md-12 col-xs-12">
                            <div style="vertical-align:middle;line-height:25px;color:#3399ff">
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
                                                $this->pagination->total_rows." News";
                                    endif;
                                    if($to_page<=1):
                                        echo "Displaying : 1 of ".
                                                $this->pagination->total_rows." News";
                                    endif;
                                ?>
                            </div>
                        </div><!-- end span 6-->
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <center>
                                <?php echo $page_link; ?>
                            </center>
                        </div>
                    </div>
                </div>
              </section>
        </div>
        <div class="col-md-4">        
            <section class="content" style="background-color:transparent; margin-top:-15px;">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                    	<div class="sblock-2" style="width:100%; height:160px">
							<div class="ajax-spinner-bars">&nbsp;</div>
								<span class="upx">
									<?php //modules::load('filler/filler')->dash_map();?>
								</span>
							<div class="ajax-spinner-bars">&nbsp;</div>
								<div class="bootom" style="margin-top:15px;">
									<?php //modules::load('filler/filler')->list_konflik();?>
								</div>
							
						</div>
                    </div>
                </div>
            </section>
        </div>
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

<link rel="stylesheet" href="assets/css/rrss.css">
<script src="assets/js/jquery-rrss.js"></script>

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
                    <div class="col-md-12">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong><?=$data['title']?></strong></h6>
                    </div>
					
                </div>
            </div>
        </div>
    </div>
</div>
<!--end header-->
<div class="main-container container text-center-xs">
	<div class="row">
    	<div class="col-md-8">        
            <section class="content" style="padding-top:0px">
                <div class="row">
                     
                    <div class="col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="box-3" style="margin-top:-1px;">
                                <?php
                                    if(!$data["image"]):
                                        $src    =   "assets/images/noimg.jpg";
                                    else:
                                        $src    =   $this->config->item("dir_news").$data["image"];
                                    endif;
                                ?>
                                <p align="center">
                                <? if($data["image"]): ?>
                                    <img src="<?=$src?>" alt="Blog Image" style="width:100%" class="img-responsive img-center-xs">
								<? endif; ?>
								&nbsp;
								</p>
                                <div class="inner">
                                    <p class="date-meta text-grey-color text-uppercase" style="margin-top:5px;">
                                        <span class="label label-info">
                                            <i class="fa fa-pencil"></i>&nbsp;<?=$v['author']?$v['author']:"Admin"?>
                                        </span>&nbsp;
                                        <span class="label label-default">
                                            <i class="fa fa-calendar"></i>&nbsp;<?=date_format(date_create($data['created']),"d-m-Y")?>
                                        </span>&nbsp;
                                        <span class="label label-primary">
                                            <i class="fa fa-clock-o"></i>&nbsp;<?=date_format(date_create($data['created']),"H:i")?> WIB
                                        </span>&nbsp;
                                    </p>
                                    <!--<h5 class="sub-heading-1 tiny text-medium text-center-xs">
                                        <?=$data['title']?>
                                    </h5>-->
                                    <div class="blog-post-content">
                                        <p align="justify">
                                            <?=$data['content']?>
											<? modules::load('filler/filler')->social_share('Tanah Kita - Berita: '.$data['title']);?>
                                        </p>
                                    </div>
									
                                </div>
                            </div>
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
							<div id="dash_map" class="ajax-spinner-bars"></div>
						</div>
                    </div>
                </div>
				
				<div class="row">
                    <div class="col-sm-12 col-xs-12">
                    	<div class="sblock-2">
							<div id="trend_konflik" class="ajax-spinner-bars"></div>
						</div>
                    </div>
                </div>
				
                <div class="row">
                    <div class="col-sm-12 col-xs-12" style="margin-top:-20px;">
                    	<div class="sblock-2x">
							<span id="title">Berita Lain</span>
							<div id="other_news" class="ajax-spinner-bars"></div>
						</div>
                    </div>
                </div>
            </section>
        </div>
      </div>
    </div>
</div>

<script>
$(document).ready(function(){
	var base_url		=	"<?=base_url()?>";
	var dash_map_url	=	"filler/filler/dash_map";
	var trend_url		=	"filler/filler/trend_konflik";
	var news_url		=	"filler/filler/news_pages/0/<?=$data['idx']?>";
	
	$.get(base_url+dash_map_url,function(result_html,status){
		if(status=="success"){
			var style	=	"<style>#dash_map{width:100%; height:160px;}</style>";
			$("#dash_map").removeClass("ajax-spinner-bars");
			$("#dash_map").html(style+result_html);
		}
	});
	
	$.get(base_url+trend_url,function(result_html,status){
		if(status=="success"){
			var style	=	"<style>#jml_tahun{height:125px;width:100%;}</style>";
			$("#trend_konflik").removeClass("ajax-spinner-bars");
			$("#trend_konflik").html(style+result_html);
		}
	});
	
	$.get(base_url+news_url,function(result_html,status){
		if(status=="success"){
			$("#other_news").removeClass("ajax-spinner-bars");
			$("#other_news").html(result_html);
		}
	});

})
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

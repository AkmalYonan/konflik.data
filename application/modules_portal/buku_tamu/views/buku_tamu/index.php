<!--
<section class="main-banner text-center-xs">
    <div class="container text-lite-color" style="background-image:url('assets/images/banner.jpg'); height:100%">
        <h2 class="text-medium">Blog Single Page</h2>
    </div>
</section>
-->
<div class="main-container container">
    <div class="row">
    	<div class="col-sm-12 col-xs-12">
            <div class="main-container container text-center-xs">
                <div class="row">
                  <div class="container text-center-xs hidden">
                    <ol class="breadcrumb flat">
                      <li><a href="home"><?=$home;?></a></li>
                      <li><a href="<?=$this->module?>"><?=ucfirst($active)?></a></li>
                      <li class="active"><?=$breadcrumb?></li>
                    </ol>
                  </div>
                    <div class="col-sm-12 col-xs-12">
                      <div class="text-uppercase block-2">
                          <!--<h5 style="padding-top:10px;">Berita Ekonomi</h5>-->
                          <h6 style=" border:none !important;padding-top:10px;" class="sub-heading-1 text-center-xs text-spl-color"><strong>Berita</strong></h6>

                      </div>

                        <?php foreach($arrData as $k=>$v): ?>
                            <?php
                                $page_link=$this->pagination->create_links();
                                $offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;

                                if(!$v["image"]):
                                    $src    =   "assets/images/noimg.jpg";
                                else:
                                    $src    =   $this->config->item("dir_news").$v["image"];
                                endif;
                            ?>
                            <div class="media ">
                                <div class="pull-left" >
                                    <a href="<?=$src?>" class="fancybox" title="<?=$v['title']?>">
                                        <img src="<?=$src?>" class="avatar media-object" alt="<?=date('Y')?>" style=" width:130px;height:100px;margin:1px;border:thin solid #CCCCCC" />
                                    </a>
                                </div>
                                  <div class='media-body' style="border-bottom:1px solid #ccccb3">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6 class="media-heading">
                                                <a href="news/read/<?=$v['idx'];?>" class="news-title">
                                                    <?php
                                                        if(strlen($v['title'])>70):
                                                            echo substr($v['title'],0,70)."...";
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
                                                    <i class="fa fa-pencil">&nbsp;</i><?=$v['author']?>
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
                        <?php endforeach; ?>
			                     <!-- Contact Form Wrap Ends -->

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
                    </div>
                    
					<!--
                    </?php if(!$this->ion_auth->logged_in()): ?>
                    <div class="col-sm-4 col-xs-12">
                        <div class="sblock-2">
                            <h6 style=" border:none !important" class="sub-heading-1 text-center-xs text-spl-color"><strong>Berita Lain</strong></h6>
                            </?php modules::load('filler/filler')->other_news_list(1,"dm",5);?>

                        </div>
						<h6 style=" border:none !important" class="sub-heading-1 text-center-xs text-spl-color"><strong>Prestasi </strong></h6>
                        </?php modules::load('filler/filler')->prestasi_list(1,false,5);?>
                    </div>
                    </?php endif; ?>
					-->
                </div>
            </div>
        </div>
    </div>
</div>

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

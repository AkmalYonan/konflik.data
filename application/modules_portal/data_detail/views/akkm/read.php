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
                  <div class="container text-center-xs">
                    <ol class="breadcrumb flat">
                      <li><a href="home"><?=$home;?></a></li>
                      <li><a href="<?=$this->module?>"><?=ucfirst($active)?></a></li>
                      <li class="active"><?=$breadcrumb?></li>
                    </ol>
                  </div>
                    <div class="col-sm-8 col-xs-12">
                      <div class="text-uppercase block-2">
                          <h6 style=" border:none !important" class="sub-heading-1 text-center-xs text-spl-color"><strong>Berita Demografi</strong></h6>
                          <!--<h6 style="padding-top:10px;">Berita Politik</h6>-->
                      </div>

                        <div class="row">
                            <div class="box-3" style="margin-top:-1px;">
                                <?php
                                    if(!$data["image"]):
                                        $src    =   "assets/images/noimg.jpg";
                                    else:
                                        $src    =   $this->config->item("dir_pages_news").$data["image"];
                                    endif;
                                ?>
                                <p align="center">
                                    <img src="<?=$src?>" alt="Blog Image" style="width:100%" class="img-responsive img-center-xs">
				</p>
                                <div class="inner">
                                    <p class="date-meta text-grey-color text-uppercase">
                                        <span class="label label-info">
                                            <i class="fa fa-pencil"></i>&nbsp;<?=$data['author']?>
                                        </span>&nbsp;
                                        <span class="label label-default">
                                            <i class="fa fa-calendar"></i>&nbsp;<?=date_format(date_create($data['created']),"d-m-Y")?>
                                        </span>&nbsp;
                                        <span class="label label-primary">
                                            <i class="fa fa-clock-o"></i>&nbsp;<?=date_format(date_create($data['created']),"H:i")?> WIB
                                        </span>&nbsp;
                                        <!--
                                        <span class="label label-success">
                                            <i class="fa fa-comments"></i>&nbsp; 10 Comments
                                        </span>
                                        -->
                                    </p>
                                    <h5 class="sub-heading-1 tiny text-medium text-center-xs">
                                        <?=$data['title']?>
                                    </h5>
                                    <div class="blog-post-content">
                                        <p align="justify">
                                            <?=$data['content']?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <?php if(!$this->ion_auth->logged_in()): ?>
                    <div class="col-sm-4 col-xs-12">
                        <div class="sblock-2">
                          <h6 style=" border:none !important" class="sub-heading-1 text-center-xs text-spl-color"><strong>Kategori Berita</strong></h6>

                            <?php modules::load('filler/filler')->news_category();?>
			</div>
			<h6 style=" border:none !important" class="sub-heading-1 text-center-xs text-spl-color"><strong>Berita Lain</strong></h6>
                        <?php modules::load('filler/filler')->news_list(1,$data['idx'],3);?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

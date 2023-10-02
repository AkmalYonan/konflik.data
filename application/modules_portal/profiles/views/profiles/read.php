<!--header-->
<div class="well well-sm sub-head xhead" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>PROFILE</strong></h6>
                    </div>
					
                </div>
            </div>
        </div>
    </div>
</div>
<!--end header-->

<div class="main-container container text-center-xs">
        
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
                                    <div class="blog-post-content">
                                        <p align="justify">
                                            <?=$arrData[0]['content']?>
                                        </p>
                                    </div>
                                    <p class="date-meta text-grey-color text-uppercase">
                                        <span class="label label-info">
                                            <i class="fa fa-pencil"></i>&nbsp;<?=$arrData[0]['author']?$arrData[0]['author']:"Admin"?>
                                        </span>&nbsp;
                                        <span class="label label-default">
                                            <i class="fa fa-calendar"></i>&nbsp;<?=date_format(date_create($arrData[0]['created']),"d-m-Y")?>
                                        </span>&nbsp;
                                        <span class="label label-primary">
                                            <i class="fa fa-clock-o"></i>&nbsp;<?=date_format(date_create($arrData[0]['created']),"H:i")?> WIB
                                        </span>&nbsp;
                                        <!--
                                        <span class="label label-success">
                                            <i class="fa fa-comments"></i>&nbsp; 10 Comments
                                        </span>
                                        -->
                                    </p>

                    </div>
                    </div>
            </section>
        
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

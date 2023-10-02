<!--header-->
<div class="well well-sm sub-head xhead" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>PELAPORAN</strong></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end header-->
<div class="main-container container text-center-xs">
        <!--header-->
        
            <section class="content" style="background-color:transparent" >
                <div class="row">
                         <div class="col-sm-12 col-xs-12" style="background-color:#ffffff">
                   
									 <div class="row">
										<div class="box-3" style="margin-top:-1px;">

											<div class="inner">


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
									</div>

						  </div>
						  <!--<div class="col-md-4 hidden">        
							<section class="content" style="background-color:transparent; margin-top:-25px;">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<div class="sblock-2" style="width:100%; height:160px">
											<?php //modules::load('filler/filler')->kontak_feed();?>
										</div>
									</div>
								</div>
							</section>
						</div>-->
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

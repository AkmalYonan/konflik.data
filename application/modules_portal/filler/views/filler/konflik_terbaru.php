<base href="<?=BASE_URL;?>" />
<style>
.products-list > .item::after {
    clear: both;
}
.products-list > .item::before, .products-list > .item::after {
    content: " ";
    display: table;
}
.product-list-in-box > .item {
	-webkit-box-shadow: none;
	box-shadow: none;
	border-radius: 0;
	border-bottom: 1px solid #f4f4f4;
}
.products-list > .item {
	border-radius: 3px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    padding: 10px 0;
}
.products-list {
	list-style: none;
	list-style-type: none;
    list-style-image: none;
    list-style-position: outside;
    padding-left: 2px !important;
    float: left;
}
.products-list .product-img {
	float: left;
}
#title {
	font-weight:bold;
	text-transform:uppercase;
}
</style>

<?php

$lookup_sektor	=	lookup("m_sektor","kode","uraian");
?>

<div class="row">

	<div class="col-md-12" style="position:relative; background-color:transparent !important; margin-top:10px;">
		<div class="row" style="margin-top:0px;">
			<div class="col-md-12" style="background-color:transparent">
				<span id="title"><?=$limit?> KONFLIK TERBARU</span>
				<div style="border-top:1px solid #ddd"></div>
                    
					<div class="row">
						<div class="col-md-12">
							<ul class="products-list product-list-in-box">
                       
								<? foreach ($top5_bydate as $k => $v) :?>
									<li class="item" >
										<div class="row">
											<div class="col-md-3 col-xs-4">
												<div class="product-img" style="text-align:center">
													<img src="assets/images/indonesia_grey.png" width="80">
													<span style="font-size:12px;" class="product-description "><?=date( "d-m-Y", strtotime($v['created']) )?></span>
												</div>
											</div>
											<div class="col-md-9 col-xs-8">
												<div class="product-info" style="text-align:left !important">
													<span class="product-title">
														<strong>
															<a href="data_detail/index/<?=encrypt($v['idx'])?>">
																<?=$v['judul']?>
															</a>
														</strong>
													</span>
													<br />
													<span  style="font-size:11px;">
														Sektor : <?=$lookup_sektor[$v['kd_sektor']]?>
													</span><br />
													<span  style="font-size:11px;">
														Luas : <?=number_format($v['luas'])?> Ha, Dampak : <?=number_format($v['dampak'])?> Jiwa
													</span>
												</div>
											</div>
										</div>
									</li>
								<? endforeach;?>
								
							</ul>
						</div>
                </div>
			</div>
		</div>
	</div>
</div>
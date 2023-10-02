<div class="row" style="margin-bottom:20px">
	<div class="col-md-12">
		<?php if ($title) { ?><h3 class="rightsub" style="border-bottom:0px solid #0a3e73">Berita</h3><? } ?>
		<?php if (is_array($list)) { ?>
		<?php 
		  	foreach($list as $k=>$v) { 
		  		$image = ($v['image'])?$v['image']:"blank.png";
				$category = ($v['category']==2)?'<small><span class="label label-important">Pengumuman</span></small>':'';
		?>
		<!--media-->
		<div class="media" style="padding-top:15px; padding-bottom:15px; margin-bottom:5px; margin-top:5px; width:100%; border-bottom: thin solid #CCC;">
			<div class='media-body'>
                <div class="pull-left" style="color:grey">
					<small><?=$v['date_formatted'];?></small>
				</div><br />
                <div>
                    <h5 class="media-heading" align="justify" style="font-size:12pt;">
						<a href="news/read/<?=$v['idx'];?>" class="news-title"><?=$v['title'];?></a>
					</h5>
                </div>
            </div>
		</div>
		<!--end media-->
		<? }} ?>
	</div>
</div>
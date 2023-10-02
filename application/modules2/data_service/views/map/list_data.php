<style>
.text-muted{
	font-size:11px;
}
.load-more{
	font-size:12px;
	color:#b3b3b3;
}
.load-more:hover{
	text-decoration:none;
}
.small-text{
	font-size:11px;
	color:#8c8c8c;
}
</style>


<!--<ul id="ter" class="list-group outer" style="margin-left:0px;">-->
<?php if(cek_array($data)): ?>
	<?php foreach($data as $k=>$v): ?>
		<li class='list-group-item'>
			<div class="row">
				<div class="col-sm-12">
					<p align='justify'><a onclick='event.preventDefault(); return marker_trigger("<?=$v['id_enc']?>");' href='#'>
						<?=$v['judul']?></a>
					</p>
					<span class="text-muted"><em><?=$v['nm_kabupaten']?>, <?=$v['nm_propinsi']?></em></span><br />
					<span class="text-muted">Sektor <?=$v['nama_sektor']?> [<?=$v['tahun']?>]</span><br />
					<span class="text-muted">Luas : <?=number_format($v['luas'])?> Ha</span><br />
					<span class="text-muted">Dampak : <?=number_format($v['dampak'])?> Jiwa</span><br />
				</div>
			</div>
		</li>		
	<?php endforeach; ?>
<?php else: ?>
	<li class='list-group-item'><p><font color='#ff0000'>Tidak Ada Data</font></p></li>
<?php endif; ?>
<!--</ul>-->

<?php if($total>$limit): ?>
<li class='list-group-item small-text'><p>Show <?=number_format($limit)?> Of <?=number_format($total)?> Entries</p></li>
<p>
<center>
	<a href="#" class="load-more">
		<i class="fa fa-long-arrow-down">&nbsp;</i>Load More
	</a>
</center>
</p>

<?php else: ?>
	<?php if($total>0): ?>
        <li class='list-group-item small-text'><p>Show All <?=number_format($total)?> Entries</p></li>
		<!--<div class="row" style="margin-top:-15px; margin-left:-5px; margin-right:-5px;">
			<div class="col-sm-12">
				<div class="pull-right">
					<span class="small-text"><i>Show All <?=number_format($total)?> Entries</i></span>
				</div>
			</div>
		</div>-->
	<?php endif; ?>
<?php endif; ?>

<script>
$(document).ready(function(){
	
	var base_url		=	"<?=$this->base_url?>";
	var load_more_url	=	base_url+"data_service/map/jkpp.html?tipe=list_data&x_gte=95&y_gte=-11&y_lte=11";
	
	$(".load-more").on("click",function(e){
		e.preventDefault();
		
		var	kd_prop		=	$("#kd_prop").val();
			id_kabupaten=	$("#id_kabupaten").val();
			sektor		=	$("#sektor").val();
			konflik		=	$("#konflik").val();
			tahun		=	$("#tahun").val();
			limit		=	<?=$limit?>+10;
			
			load_more_data(limit,kd_prop,id_kabupaten,sektor,konflik,tahun);
		
	});
	
	function load_more_data(limit,kd_prop,id_kabupaten,sektor,konflik,tahun){
		
		var limit				=	limit?limit:10;
		var kd_prop_val			=	kd_prop?kd_prop:false;
		var id_kabupaten_val	=	id_kabupaten?id_kabupaten:false;
		var sektor_val			=	sektor?sektor:false;
		var	konflik_val			=	konflik?konflik:false;
		var	tahun_val			=	tahun?tahun:0;
		
		var q					=	"&limit="+limit+"&kd_prop="+kd_prop_val+"&kd_kab="+id_kabupaten_val+"&sektor="+sektor_val+"&konflik="+konflik_val+"&tahun="+tahun_val;
		
		$.get(load_more_url+q,function(data_html,status){
			$("#ter").html("Loading...");
			if(status=="success"){
				$("#ter").html(data_html);
			}
		});
		
	}
	
});
</script>

<script>
	function marker_trigger(enc_idx){

		var idx_enc	=	enc_idx;
		for (var i=0;i<theme2['layers'].length;i++) {
			theme2['layers'][i].lyr.eachLayer(function(data_feature){
				if(data_feature.feature.properties.id_enc==idx_enc){
	
					var new_longitude	=	data_feature.feature.properties.longitude;
					var new_latitude	=	data_feature.feature.properties.latitude;
					
					map.panToOffset(new L.LatLng(new_latitude, new_longitude),[0,100]);
					data_feature.openPopup();
				}
			});
		}
    }
</script>
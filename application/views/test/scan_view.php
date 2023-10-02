<?=$this->load->view("admin_lte_layout/header")?>

<div class="row">
<div class="col-md-12">
<input type="text" name="idx_pasien" id="idx_pasien" value="10">
<div class="row">
<div class="col-md-6">
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="0">Scan 0</a>
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="1">Scan 1</a>
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="2">Scan 2</a>
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="3">Scan 3</a>
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="4">Scan 4</a>
</div>
<div class="col-md-6">
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="5">Scan 5</a>
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="6">Scan 6</a>
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="7">Scan 7</a>
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="8">Scan 8</a>
    <a href="#" class="btn btn-primary scan_finger" data-id_jari="9">Scan 9</a>
</div>

</div>
<iframe style="display:none" id="scan" src="" height="0" width="0"></iframe>

<script>

	$(function(){
		$(".scan_finger").click(function(e){
			e.preventDefault();
			var idx_pasien=$("#idx_pasien").val();
			var id_jari=$(this).data("id_jari");
			$.getJSON("http://127.0.0.1:8090/api/scan_finger/"+idx_pasien+"/"+id_jari,function(d){
				//if(d.status==1){
					$("#scan").attr("src","http://127.0.0.1:8090/api/scan");
				//}		
			});
			$("#scan").attr("src","");
		});
		
	});
</script>
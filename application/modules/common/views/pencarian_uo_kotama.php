<? 
	$arrDataUO=$this->conn->GetAll("select code,name from organization_dimension1 order by code");
	if(cek_array($arrDataUO)):
		$arr_uo[""]="--Pilih UO--";
		foreach($arrDataUO as $dataUO):
			$arr_uo[$dataUO["code"]]="(".$dataUO["code"].") ".$dataUO["name"];
		endforeach;
	endif;
	$arr_kotama[]="--Pilih Kotama--";
	$uo=$this->input->get_post("kd_uo")?$this->input->get_post("kd_uo"):"";
	$kotama=$this->input->get_post("kd_kotama")?$this->input->get_post("kd_kotama"):"";
	$curYear=date("Y");
	$selectYear=$this->input->get_post("tahun")?$this->input->get_post("tahun"):$curYear;
	$arrTahun[""]="--Tahun--";
	for($i=$curYear;$i>=$curYear-5;$i--):
		$arrTahun[$i]=$i;
	endfor;
	if($uo!=""):
		$arrTmpKotama=$this->map_uo=lookup("organization_dimension2","code","name","organization1='".$uo."'","order by code");
		$arr_kotama=$arr_kotama+$arrTmpKotama;
	endif;
	
?>

<form id="frmSearch" action="<?=$this->module?>" method="post" style="z-index:9999999">
<div class="form-inline pull-right" style="margin-top:-48px">
<div class="form-group">
	<? echo form_dropdown("tahun",$arrTahun,$selectYear,"id='tahun' class='form-control' style='height:28px;width:100px;font-size:0.9em'");?>
</div>
<div class="form-group">
<? echo form_dropdown("kd_uo",$arr_uo,$uo,"id='kd_uo' class='select2 form-control' style='height:28px;width:200px;font-size:0.9em'");?>
</div>
<div class="form-group">
<? echo form_dropdown("kd_kotama",$arr_kotama,$kotama,"id='kd_kotama' class='form-control select2' style='height:28px;width:200px;font-size:0.9em'");?>
</div>
<button class="btn btn-primary btn-sm btn_submit" style="height:28px"><i class="icon-search"></i> </button>
</div>
</form>

<script>
	$(function(){
		/*
		var kd_kotama="<?=$kotama?>"||"";
		var kd_uo=$("#kd_uo").find("option:selected").val();
		$.get("common/service/lookup_kotama/"+kd_uo,function(ret){
			$("#kd_kotama").html(ret);
			$("#kd_kotama").val(kd_kotama);
		});
		*/
		
		$("#kd_uo").change(function(){
			var kd_uo=$(this).find("option:selected").val();
			$.get("common/service/lookup_kotama/"+kd_uo,function(ret){
				$("#kd_kotama").html(ret);
			});
		});
		
		
	});
	
	function set_kotama(kd_uo,kd_kotama,callback){
		//var kd_uo=$(this).find("option:selected").val();
		$("#kd_uo").val(kd_uo);
		$.get("common/service/lookup_kotama/"+kd_uo,function(ret){
			$("#kd_kotama").html(ret);
			if(kd_kotama.length>=2){
				$("#kd_kotama").val(kd_kotama);
			}
			if (callback) {
        		callback();
    		}
		});
	}
</script>
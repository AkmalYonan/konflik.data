<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<table class="table table-condensed table-bordered">
	<thead>
    <tr>
    	<th width="150px">Tgl</th>
        <th>Kegiatan</th>
        <th>Lampiran</th>
    </tr>
    </thead>
    <tbody>
    	<? $data_tmp=array();?>
		<? if(cek_array($data_detox)): ?>
        	<? foreach($data_detox as $x=>$val):?>
            	<? $data_tmp[$val["idx"]]=$val;?>
            	<tr id="tr_<?=$val["idx"];?>">
                	<td><?=date2indo($val["tgl_kegiatan"]);?></td>
                    <td><?=$val["keterangan"]?></td>
                    <td>
                    	<div class="btn-group btn-group-xs">
                                        <a class="btn btn-xs btn-default btn-edit" data-id="<?=$val["idx"]?>" href="javascript:void()" data-toggle='tooltip' title="Edit"><i class="fa fa-pencil green"></i></a> 
                                        <a class="btn btn-xs btn-default" onclick="return confirm('Anda yakin akan menghapus data ini?');" data-toggle='tooltip' href="<?php echo $this->module."del_detox/".$id."/".$val["idx"]?>" title="Delete"><i class="fa fa-remove red"></i></a> 
                    </td>
                </tr>
			<? endforeach;?>
		<? endif;?>
    </tbody>
    
</table>



<script>
	$(function(){
		var data_all=<?=json_encode($data_tmp)?>||false;
		$(".btn-edit").click(function(e){
			e.preventDefault();
			if($("#div_form").is(":hidden")==true){
				$("#div_form").slideDown();
			}
			
			$("#frm").find("#act").val("update");
			//var data=$(this).closest("tr").data("all");
			var data=data_all[$(this).data("id")];
			
			$("#frm").find("#idx").val(data.idx);	
			$("#keterangan").val(data.keterangan)
			setdate(data.tgl_kegiatan);
		});	
		
		$(".btn-add").click(function(){
			//$("#div_form").toggle();
			if($("#div_form").is(":hidden")==true){
				$("#frm").find("#act").val("create");
				$("#frm #keterangan").val("");
				$("#frm").find("#idx").val("");
				var tgl_kegiatan=new Date();
				setdate(tgl_kegiatan);
				$("#div_form").slideDown();
			}else{
				$("#div_form").slideUp();
			}
		});
		
		
	});
	
	function setdate(tgl_kegiatan){
		var date = new Date(tgl_kegiatan);
		var dd = date.getDate();             
		var mm = date.getMonth() + 1;
		var yyyy = date.getFullYear();
	
		var todate = mm + '/' + dd + '/' + yyyy;
		//console.log(todate);
		$("#tgl_kegiatan").val(todate);
		$("#tgl_kegiatan_selector").datepicker("setDate",todate);
		//var FromDate = mm + '/01/' + yyyy;
		//$('#txtToDate').datepicker('setDate', ToDate);
		//$('#txtFromDate').datepicker('setDate', FromDate);	
	}
</script>

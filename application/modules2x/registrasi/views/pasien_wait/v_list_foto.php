<?php
	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
?>
<?php 
	
		$data_foto=$this->conn->GetAll("select * from t_pasien_foto where idx_parent='".$data["idx"]."' order by idx desc")
?>
    <table class="table table-bordered table-condensed table-foto">
    	<thead>
        	<tr>
            	<th>Nama file</th>
                <th>Foto</th>
                <th>Aktif</th>
                <th>Delete</th>
                
            </tr>
        </thead>
        <tbody>
		<? if(cek_array($data_foto)):?>
    	<? foreach($data_foto as $x=>$val):?>
        <? $foto=$val["path"].$val["file_name"];?>
        <tr>
        	<td><?=$foto?></td>
        	<td><img src="<?=$this->base_url?><?=$foto?>" style="width:50px"  /> </td>
        	<td class="tc"><input type="radio" name="flag_default" data-id="<?=$val["idx"]?>" class="flag_default" id="flag_default_<?=$val["idx"]?>" value="1" <?=$val["flag_default"]==1?"checked='checked'":""?> /></td>
            <td class="tc"> <a class="btn btn-xs btn-delete-foto" data-toggle='tooltip' data-id="<?=$val["idx"]?>" href="javascript:void()" title="Hapus Foto"><i class="fa fa-remove red"></i></a>
            </td>
        </tr>
        <? endforeach;?>
        <? endif;?>
		</tbody>
    </table>
    
    
    <script>
		$(function(){
			$(".table-foto").on("click",".btn-delete-foto",function(e){
				e.preventDefault();
				var btn=$(this);
				var id=btn.data("id");
				if(confirm("Anda yakin akan menghapus foto ini??")){
					$.post("<?=$this->module?>del_foto/"+id,function(data){
						btn.closest("tr").slideUp().remove();
						set_foto_default();	
					});
				}
			});
			
			
			$(".flag_default").click(function(){
				var idx=$(this).data("id");
				$.post("<?=$this->module?>activate_foto/"+idx,function(){
					set_foto_default();	
				});
			});
			
			
		});
		
		function set_foto_default(){
			$.getJSON("<?=$this->module?>get_foto_default/<?=$id?>",function(data){
				var idx=data.idx;
				$(".table-foto").find("#flag_default_"+idx).prop("checked",true);
				$("#foto_pasien,.foto-pasien").prop("src",data.path+data.file_name);				
			});	
		}
	</script>
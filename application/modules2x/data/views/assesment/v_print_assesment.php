<div id="div_print2">
		<style>
			tr,td{vertical-align:top}
			.no_border td,.no_border tr,.no_border{
					border:none !important;
					border-top:none !important;
				}
		</style>
		<h3><p align="center"><strong>FORMULIR ASESMEN DAN REHABILITASI MEDIS<br></strong></p></h3>
        <hr>
        <table width="100%">
        <tr><td width="50%">	
        <table>
        	<tr>
            	<td width="150px">Tanggal Kedatangan</td>
                <td>:&nbsp;</td>
                <td><? echo date2indo($data_assesment["tgl_kedatangan"])?></td>
            </tr>
            <tr>
            	<td>No Rekam Medis</td>
                <td>:&nbsp;</td>
                <td><?php echo $data_assesment["no_rekam_medis"]?></td>
            </tr>
            
             <tr>
            	<td>Nama</td>
                <td>:&nbsp;</td>
                <td><?php echo $data_assesment["no_rekam_medis"]?></td>
            </tr>
            <tr>
            	<td>Alamat tempat tinggal</td>
                <td>:&nbsp;</td>
                <td><?php echo $data_assesment["alamat"]?></td>
            </tr>
            <tr>
            	<td>Telp/HP</td>
                <td>:&nbsp;</td>
                <td><?php echo $data_assesment["no_telp"]?></td>
            </tr>
            
            
		</table>  
		</td>
        
        <td style="vertical-align:bottom">
        <table>
        	<tr>
            	<td width="150px">Tanggal Kedatangan</td>
                <td>:&nbsp;</td>
                <td><? echo date2indo($data_assesment["tgl_kedatangan"])?></td>
            </tr>
            <tr>
            	<td>No Rekam Medis</td>
                <td>:&nbsp;</td>
                <td><?php echo $data_assesment["no_rekam_medis"]?></td>
            </tr>
		</table>    
		</td>
        </tr>
 </table>
	
    <hr>
  
    <?=$this->load->view("v_print_assesment_1")?>
    <pagebreak />
    <?=$this->load->view("v_print_assesment_2")?>
    <pagebreak />
	<?=$this->load->view("v_print_pemeriksaan_fisik")?>
    


</div><!-- end div-print -->

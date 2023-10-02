<? 
	foreach($data as $x=>$val):
		$data_assesment[$val["idx_assesment"]][]=$val;
	endforeach;
	
	
	$lookup_status_proses=lookup("m_proses_rehab","kd_status_proses","ur_proses","","order by kd_status_rehab,order_num");
	
	
	pre($lookup_status_proses);
?>
<table class="table" border=1>
	<tbody>
    	<? $i=0;?>
    	<? foreach($data_assesment as $x=>$data_history):?>
    	<tr>
        	<td>Assesment <?=$i?></td>
        	<td>
				<? foreach($data_history as $xx=>$history):?>
            		<table class="table table-condensed">
                    	<tr>
                        	<td><?=$lookup_status_proses[$history["status_proses"]]?></td>
                            <td><?=$history["status_rm"]?></td>
                        </tr>
                    </table>
				<? endforeach;?>
            </td>
        </tr>
        <?=$i++?>
        <? endforeach;?>
    </tbody>    

</table>

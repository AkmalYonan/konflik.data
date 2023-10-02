<div class="subheader">
    <div class="container subheader-inner">
    	<h1>Status Permohonan</h1>
    </div>
</div>
<?php $this->load->view('dok_menu',array("active"=>"user/dokumen"))?>
<div class="container" style="margin-bottom:20px">
<div class="row-fluid">
        <div class="span12">
        	<ul class="nav nav-tabs" style="margin-top:30px;border-bottom:1px solid #aaa">
                <!--<li><a href="user/dokumen">Dokumen</a></li>-->
                <li class="active"><a href="user/dokumen/request"><i class="icon-list"></i> &nbsp;List</a></li>
            </ul>
        </div>
    </div>
<div class="row-fluid">
    <div class="span12 toolbar" style="margin-bottom:30px">
        <div class="pull-left">
            <div class="btn-group">
                <a href="dip/request" class="btn"><i class="icon-plus bc-icon"></i>&nbsp; Permohonan Baru</a>
            </div>
        </div>
        <div class="clearfix" style="height:30px"></div>
    </div>
</div>
<div class="row-fluid">
<div class="span12 content-page">
    <!--<ul class="breadcrumb" style="margin-left:0; margin-top:-10px">
        <li><a href="#">Home</a> <span class="divider">/</span></li>
        <li><a href="#">Informasi Publik</a> <span class="divider">/</span></li>
        <li class="active">Index</li>
    </ul>-->

    
    <div class="row-fluid">
        <div class="span12" style="padding-left:5px">
        	<?php echo message_box();?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-condensed">
        <thead>
        <tr>
        <th width="20" class="tc">&nbsp;</th>
        <th class="forder" rel="date">Nomor/Tanggal</th>
        <th class="forder" rel="title">Informasi yang dimohon</th>
        <th colspan="3">Status</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
  <? if (is_array($arrDB)) { foreach($arrDB as $k=>$v) {
  		$tr_color=($k%2)?"#fff":"#fafafa";
		
		$url_view =  $this->module."dokumen/view/".$v['idx'];
		$url_delete = $this->module."dokumen/cancel/".$v['idx'];
		
		$publish = ($v['status'])?'<span class="label label-success">Ya</span>':'<span class="label label-warning">Belum</span>';
		$kandungan = '<span class="help-block" style="color:#999">'.$v['kandungan_dokumen'].'</span>';
		$tujuan = '<span class="help-block" style="color:#999">'.$v['tujuan_penggunaan'].'</span>';
   		switch($v['status']) {
			case -1:
				$status="New";
				$label="label-important";
				$reply="";
				$datetime1 = date_create(date("Y-m-d"));
				$datetime2 = date_create(date("Y-m-d",strtotime($v['created_date'])));
				$interval = date_diff($datetime1, $datetime2);
				$interval= $interval->format('%d');
				$max[]=$interval;
				break;
			case 1:
				$status="Open";
				$label="label-success";
				$reply="";
				$tgl_proses = $v['detil'][1];
				
				$p1 = date_create(date("Y-m-d",strtotime($tgl_proses)));
				$p2 = date_create(date("Y-m-d",strtotime($v['created_date'])));
				$i1 = date_diff($p1, $p2);
				$i1= $i1->format('%d');
				$max[]=$i1;
				break;
			case 2:
				$status="Diproses";
				$label="label-warning";
				$reply="";
				$tgl_proses = $v['detil'][2];
				
				$p1 = date_create(date("Y-m-d",strtotime($tgl_proses)));
				$p2 = date_create(date("Y-m-d",strtotime($v['created_date'])));
				$i2 = date_diff($p1, $p2);
				$i2= $i1->format('%d');
				$max[]=$i2;
				break;
			case 3:
				$status="Selesai";
				$reply=$v['reply']['pemberitahuan'];
				$tgl_proses = $v['detil'][1];
				$label="";
				
				$p1 = date_create(date("Y-m-d",strtotime($tgl_proses)));
				$p2 = date_create(date("Y-m-d",strtotime($v['created_date'])));
				$i3 = date_diff($p1, $p2);
				$i3= $i3->format('%d');
				$max[]=$i3;
				break;
		}
		switch($v['reply']['pemberitahuan']) {
			case 'ditolak':
				$label_r="badge-important";
				break;
			case 'dapatdiberikan':
				$label_r="badge-success";
				break;
			case 'tidakdapatdiberikan':
				$label_r="badge-warning";
				break;
		}
		
  		?>
   				<style>
					.bardate{
						display:inline-block; 
						width:12px; 
						border:1px solid #ccc;
						height:16px;
						line-height:16px;
						text-align:center;
						font-size:xx-small
					}
					.bardate.pass{
						background:#ddd;
					}
					.bardate.passopen{
						background:green;
					}
					.bardate.passproses{
						background:orange;
					}
					.bardate.passclose{
						background:#aaa;
					}
				</style>
            	<tr>
                    <td class="tc"><?=($data_start+$k);?></td> 	
                    <td><div><strong><?=$v['nomor_permohonan'];?></strong></div>Tanggal: <?=date("d-m-Y",strtotime($v['created_date']));?></td>
                    <td rel="title_col">
                    	<strong><?=$v['judul_dokumen'];?></strong>
						<?=$kandungan;?>
                        <div>Tujuan Penggunaan</div>
						<?=$tujuan;?>
                    </td>
                    <td align="center"><span class="label <?=$label?>"><?=$status;?></span></td>
                    <td align="center"><span><?=date("d-m-Y",strtotime($tgl_proses));?></span></td>
                    <td align="center"><span class="badge <?=$label_r?>"><?=$reply;?></span></td>
                    <!--<td>
                        <span>
                        	<?php
									for($i=0;$i<10;$i++) { 
										$class=($i>=$interval && $i<=(int)$i1)?" pass":"";
										$class=($i>=(int)$i1 && $i<=(int)$i2)?" passopen":$class;
										$class=($i>=(int)$i2 && $i<=(int)$i3)?" passproses":$class;
										$class=($i==(int)$i3)?" passclose":$class;
									?>
                        				<div class="bardate<?=$class?>"><?=($i+1)?></div>
                            <?php } ?>
                        </span>
                    </td>-->
					<td>
                    	<a href="<?=$url_view;?>" class="btn btn-mini"><i class="icon-search icon-alert"></i> lihat</a>
                    	<!--<a href="<?=$url_delete;?>" class="btn btn-mini btn-danger"><i class="icon-remove icon-alert"></i> Batal</a>-->
                    </td>               
                    <td align="center"><span><?=$v['id_keberatan']?'<a class="btn btn-mini btn-danger" href="user/keberatan/view/'.$v['id_keberatan'].'"><i class="icon-exclamation-sign" title="Telah diajukan Keberatan atas Permohonan Informasi ini"></i></a>':'';?></span></td>
            	</tr>
        <? } }?>
        </tbody>
        </table>
    <br />
    <div class="table-nav table-nav-border-top">
			<div class="pull-left text">Displaying : <?=$data_start;?> - <?=$data_end;?> of <?=$total_rows;?> entries</div>            
            <div class="pull-right"><?=$paging;?></div>
            <div class="pull-right"><?=$perpage;?></div>
            <div class="pull-right">Rows/page: </div>
        </div>
          
      </div>
    </div>
    <br />
</div><!--end span8-->
</div>

</div>

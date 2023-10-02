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
                <li><a href="user/profile/<?=$user->id;?>">Profile</a></li>
                <!--<li><a href="user/dokumen">Dokumen</a></li>-->
                <li class="active"><a href="user/dokumen/request">Permohonan</a></li>
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
        <th class="forder" rel="title">Dokumen</th>
        <th colspan="2">Status</th>
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
				break;
			case 1:
				$status="Open";
				$label="label-success";
				break;
			case 2:
				$status="Diproses";
				$label="label-warning";
				break;
			case 3:
				$status="Selesai";
				$label="";
				break;
		}
		$datetime1 = date_create(date("Y-m-d"));
		$datetime2 = date_create(date("Y-m-d",strtotime($v['created_date'])));
		$interval = date_diff($datetime1, $datetime2);
		$interval= $interval->format('%d');
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
                    <td align="center"><div class="label <?=$label?>"><?=$status;?></div></td>
                    <td>
                        <span title="Umur Permohonan: <?=$interval?> hari">
                        	<?php
									for($i=0;$i<10;$i++) { 
										$class=($i<$interval)?" pass":"";
									?>
                        				<div class="bardate<?=$class?>"><?=($i+1)?></div>
                            <?php } ?>
                        </span>
                    </td>
					<td>
                    	<a href="<?=$url_view;?>" class="btn btn-mini"><i class="icon-search icon-alert"></i> lihat</a>
                    	<a href="<?=$url_delete;?>" class="btn btn-mini btn-danger"><i class="icon-remove icon-alert"></i> Batal</a>
                    </td>               
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

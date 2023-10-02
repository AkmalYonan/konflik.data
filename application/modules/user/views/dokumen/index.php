<div class="subheader">
    <div class="container subheader-inner">
    	<h1>My Document</h1>
    </div>
</div>
<?php $this->load->view('dok_menu',array("active"=>"user/dokumen"))?>
<div class="container" style="margin-bottom:20px">
<div class="row-fluid">
        <div class="span12">
        	<ul class="nav nav-tabs" style="margin-top:30px;border-bottom:1px solid #aaa">
                <li><a href="user/profile/<?=$user->id;?>">Profile</a></li>
                <!--<li class="active"><a href="user/dokumen">Dokumen</a></li>-->
                <li><a href="user/dokumen/request">Permohonan</a></li>
            </ul>
        </div>
    </div>
    <!--<div class="row-fluid">
        <div class="span12 toolbar" style="margin-bottom:30px">
            <div class="pull-left">
                <div class="btn-group">
                    <a href="dip/" class="btn"><i class="icon-list bc-icon"></i>&nbsp; Daftar Informasi Publik</a>
                </div>
            </div>
            <div class="clearfix" style="height:30px"></div>
        </div>
    </div>-->
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
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-hover">
        <thead>
        <tr>
        <th width="20" class="tc">&nbsp;</th>
        <th class="forder" rel="date">Tanggal</th>
        <th>Ketegori</th>
        <th class="forder" rel="title">Title/Judul</th>
        <th>Size</th>
        <th><em>Status</em></th>
        <th></th>
        </tr>
        </thead>
        <tbody>
  <? if (is_array($arrDB)) { foreach($arrDB as $k=>$v) {
  		$tr_color=($k%2)?"#fff":"#fafafa";
		
		$url_edit = "user/dokumen/view/".$v['idx'];
		$kandungan = '<span class="help-block" style="color:#999">'.$v['kandungan_dokumen'].'</span>';
		$publish = ($v['status'])?'<span class="label label-success">Ya</span>':'<span class="label label-warning">Belum</span>';
		$skpa = '<span class="help-block" style="color:#999">'.$m_skpa[$v['skpa']].'</span>';
   		switch($v['status']) {
					case 1:
						$status="Open";
						$label="label-info";
						break;
					case 2:
						$status="Diproses";
						$label="label-success";
						break;
					case 3:
						$status="Selesai";
						$label="";
						break;
				}
   ?>
            	<tr>
                    <td class="tc"><?=($data_start+$k);?></td> 	
                    <td rel="date_col"><?=date("d-m-Y",strtotime($v['created_date']));?></td>
                    <td><?=$m_jenis[$v['jenis']];?></td>
                    <td rel="title_col">
                        <strong><?=$v['judul_dokumen'];?></strong>
                        <?=$skpa;?>
                        <?=$kandungan;?>
                    </td>
                    <td><?=size_format($v['file_size']);?></td>
                    <td><span class="label <?=$label?>"><?=$status;?></span></td>
					<td>
                        <a href="<?=$url_edit;?>" class="btn btn-mini"><i class="icon-search icon-alert"></i> lihat</a>
                    </td>               
            	</tr>
        <? } }?>
        </tbody>
        </table>

        </td>
      </tr>
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

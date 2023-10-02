<div class="subheader">
    <div class="container subheader-inner">
    	<h1>Status Permohonan</h1>
    </div>
</div>
<?php $this->load->view('dok_menu',array("active"=>"user/dokumen"));?>
<?php if ($this->session->flashdata('message')) { ?>
<style>
.modal-backdrop, .modal-backdrop.fade.in {
    background: none repeat scroll 0px 0px #000;
    opacity: 0.9;
}
</style>
<div id="myModal" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-body">
	<h3>Terimakasih atas partisipasi anda</h3>
	<p>Anda telah melakukan Permohonan Dokumen/Informasi, dengan data sebagai berikut </p>
    <table cellpadding="2" border="0" cellspacing="0">
    	<tr>
        <td>SKPA</td><td width="10">:</td><td><strong><?=$m_skpa[$arrData['skpa']];?></strong></td>
        </tr>
        <tr>
        <td>Judul Dokumen</td><td width="10">:</td><td><strong><?=$arrData['judul_dokumen'];?></strong></td>
        </tr>
        <tr>
        <td>Kategori</td><td width="10">:</td><td><strong><?=$m_jenis[$arrData['jenis']]?></strong></td>
        </tr>
        </tr>
        <td>Nama File</td><td width="10">:</td><td style="white-space:nowrap"><strong><?=$arrData['file_name'];?></strong></td>
        </tr>
        <tr>
        <td>Ukuran File</td><td width="10">:</td><td><strong><?=size_format($arrData['file_size']);?></strong></td>
        </tr>
    </table>
    <br />
    <p>Untuk melihat dokumen / download Dokumen/Informasi silahkan klik tombol "lanjut" dibawah </p>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Lanjut</button>
</div>
</div>
<? } ?>
<div class="container" style="margin-bottom:20px">
<div class="row-fluid">
        <div class="span12">
        	<ul class="nav nav-tabs" style="margin-top:30px;border-bottom:1px solid #aaa">
                <li><a href="user/profile/<?=$user->id;?>">Profile</a></li>
                <li class="active"><a href="user/dokumen/request">Permohonan</a></li>
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 toolbar" style="margin-bottom:30px">
            <div class="pull-left">
                <div class="btn-group">
                    <a href="user/dokumen/request" class="btn"><i class="icon-list bc-icon"></i>&nbsp; Back</a>
                </div>
                <div class="btn-group">
                    <a href="user/dokumen/view/<?=$arrData['idx']?>" class="btn active"><i class="icon-search bc-icon"></i>&nbsp; View</a>
                    <a href="user/dokumen/bukti_permohonan/<?=$arrData['idx']?>" class="btn"><i class="icon-edit bc-icon"></i>&nbsp; Bukti permohonan</a>
                    <?php if ($arrData['status']==3) { ?><a href="user/dokumen/bukti_pemberitahuan/<?=$arrData['idx']?>" class="btn"><i class="icon-ok bc-icon"></i>&nbsp; Pemberitahuan Tertulis</a> <? } ?>
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
        <div class="span12" style="padding-left:10px">
        	<div class="row-fluid">
                <div class="span8">
                <p>Permohonan Informasi pada Tanggal <strong><?=date("d-m-Y",strtotime($arrData['created_date']))?></strong>. Dengan nomor pendaftaran <span style="border-bottom:1px solid #000"><strong><?=$arrData['nomor_permohonan']?></strong></span>.<br>
                    </p>
                        <table cellpadding="2" border="0" cellspacing="0">
                        <tr>
                        <td width="160">Nama Pemohon</td>
                        <td width="10">:</td><td><?=$user['first_name']?></td>
                        </tr>
                        <tr>
                        <td>Pekerjaan</td><td width="10">:</td><td></td>
                        </tr>
                        <tr>
                        <td>Alamat</td><td width="10">:</td><td><?=$user['alamat']?></td>
                        </tr>
                        <tr>
                        <td>Telepon</td><td width="10">:</td><td><?=$user['phone']?></td>
                        </tr>
                        <tr>
                        <td>Email</td><td width="10">:</td><td><?=$user['email']?></td>
                        </tr>
                </table><br>
                </div>
                 <div class="span4" style="text-align:center">
                    <img src="<?=$arrData['status']==3?'assets/image/stempel_selesai.png':'/ppid_admin/assets/image/stempel_online.png' ?>">
                 </div>
            </div>
        	<div class="row-fluid">
                <div class="span8">
                	
                
                        <div style="border:1px solid #ccc; padding:10px; background:#eee; margin-top:10px">
                            <p>Informasi yang dimohon:<br><h4 style="line-height:20px"><?=$arrData['judul_dokumen'];?></h4></p>
                            <p>Kandungan Informasi:<br><strong><?=$arrData['kandungan_dokumen']?></strong></p>
                            <p>Tujuan Penggunaan:<br><strong><?=$arrData['tujuan_penggunaan']?></strong></p>
                        </div>
                        <div style="border:1px solid #ccc; padding:10px; background:#eee;">
                            <div style="font-size:0.9em;">SKPA Termohon: <strong><?=$m_skpa[$arrData['skpa']];?></strong></div>
                        </div>
                        <br>  
                </div>
                <div class="span4">
                	<div style="padding-left:10px">
                    <table cellpadding="2" border="0" cellspacing="0" class="table">
                    	<thead>
                        <tr>
                        <th>Tanggal</td>
                        <th>Status</td>
                        </tr>
                        </th>
                        <tbody
                        <?php
						if (cek_array($status_list)) {
							foreach($status_list as $k=>$v) { 
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
								case 4:
									$status="Diperpanjang";
									$label="label-info";
									break;
							}
						?>
                            <tr>
                            <td><?=date("d-m-Y h:i",strtotime($v['created_date']))?></td>
                            <td><div class="label <?=$label?>"><?=$status;?></div></td>
                            </tr>
                        <? }} ?>
                        </tbody>
                    </table>
                	
					
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <br />
	<?
    	$ft = ($arrData['file_name'])?substr($arrData['file_name'],strrpos($arrData['file_name'],".")+1):"undefined";
		if ($ft=='pdf') {
    ?>
    	<div class="row-fluid">
        <div class="span12" style="padding-left:10px">
        	<iframe src="user/dokumen/view_f/<?=$arrData['id_dokumen']?>" style="height:800px; width:100%"></iframe>
        </div>
        </div>
    <?
    	}
    ?>

</div><!--end span8-->
</div>

</div>
<script>
$(document).ready(function () {
	$('#myModal').modal({backdrop:true,show:true});
})
</script>
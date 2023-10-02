<div class="subheader">
    <div class="container subheader-inner">
    	<h1>My Document</h1>
    </div>
</div>
<?php $this->load->view('dok_menu');?>
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
                <li class="active"><a href="user/dokumen">Dokumen</a></li>
                <li><a href="user/dokumen/request">Permohonan</a></li>
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 toolbar" style="margin-bottom:30px">
            <div class="pull-left">
                <div class="btn-group">
                    <a href="user/dokumen" class="btn"><i class="icon-list bc-icon"></i>&nbsp; Back</a>
                </div>
                <div class="btn-group">
                    <a href="user/dokumen" class="btn active"><i class="icon-search bc-icon"></i>&nbsp; View</a>
                    <a href="user/dokumen/download/<?=$arrData['idx']?>" class="btn"><i class="icon-level-down bc-icon"></i>&nbsp; Download</a>
                    <a href="user/dokumen" class="btn"><i class="icon-print bc-icon"></i>&nbsp; Cetak Bukti permohonan</a>
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
                <div class="span8" style="border-right:1px solid #ccc">
                    
                    <h4><?=$arrData['judul_dokumen'];?></h4>
                	<div style="font-size:0.9em; margin-top:-10px">SKPA: <strong><?=$m_skpa[$arrData['skpa']];?></strong></div>
                    <div style="font-size:0.9em; margin-bottom:20px">Kode Dokumen: <strong><?=$arrData['kode_dokumen'];?></strong>, Kategori: <strong><?=$m_jenis[$arrData['jenis']]?></strong></div>
                    <div><?=$arrData['kandungan_dokumen']?></div>
                </div>
                <div class="span4">
                	<table cellpadding="2" border="0" cellspacing="0">
                        <tr>
                        <td>Nama File</td>
                        <td width="10">:</td>
                        <td style="white-space:nowrap"><strong><?=$arrData['file_name'];?></strong></td>
                        </tr>
                        <tr>
                        <td>Ukuran File</td><td width="10">:</td><td><strong><?=size_format($arrData['file_size']);?></strong></td>
                        </tr>
                    </table>
                    <br />

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
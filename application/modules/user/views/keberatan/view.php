<div class="subheader">
    <div class="container subheader-inner">
    	<h1>Status Pengajuan Keberatan</h1>
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
	<p>Anda telah melakukan Pengajuan Keberatan atas Permohonan Informasi, dengan data sebagai berikut </p>
    <table cellpadding="2" border="0" cellspacing="0">
        <tr>
        <td>Nomor Registrasi Keberatan</td><td width="10">:</td><td><strong><?=$arrData['nomor_keberatan'];?></strong></td>
        </tr>
        <tr>
        <td>Nomor Pendaftaran Permohonan Informasi</td><td width="10">:</td><td><strong><?=$arrData['nomor_permohonan'];?></strong></td>
        </tr>
        </tr>
        <td>Tujuan Penggunaan Informasi</td><td width="10">:</td><td style="white-space:nowrap"><strong><?=$arrData['tujuan_penggunaan'];?></strong></td>
        </tr>
    </table>
    <br />
    <p>Kami akan merespon keberatan anda secepatnya, &quot;Hari/tanggal tanggapan atas keberatan akan diberikan&quot; akan di isi oleh Petugas penerima keberatan.</p>
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
                <li><a href="user/dokumen/request"><i class="icon-list"></i> &nbsp;List</a></li>
                <li><a href="user/dokumen/view/<?=$arrData['id_permohonan']?>">Lihat Permohonan </a></li>
                <li class="active"><a href="user/keberatan/view/<?=$arrData['id_keberatan']?>">Lihat Keberatan</a></li>
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12 toolbar" style="margin-bottom:30px">
        	<div class="row-fluid">
                <div class="span8">
                    <div class="btn-group">
                        <a href="user/dokumen/request" class="btn"><i class="icon-list bc-icon"></i>&nbsp; Back</a>
                    </div>
                    <div class="btn-group">
                        <a href="user/keberatan/bukti_pk/<?=$arrData['idx']?>" class="btn"><i class="icon-edit bc-icon"></i>&nbsp; Bukti Pengajuan Keberatan</a>
                        <?php if ($arrData['status']==3) { ?><a href="user/keberatan/bukti_tanggapan_pk/<?=$arrData['idx']?>" class="btn"><i class="icon-ok bc-icon"></i>&nbsp; Bukti Tanggapan atas Keberatan</a> <? } ?>
                    </div>
                </div>
                
                <div class="span4">
                    <?php if ($arrData['status']==3 && $reply['file_id']) { ?>
                        <a class="btn btn-primary btn-block" href="user/dokumen/download/<?=$arrData['idx']?>" class="btn"><i class="icon-download bc-icon"></i>&nbsp; Download Informasi</a>
                    <? } ?>
                </div>
            </div>
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
                <p>Pengajuan Keberatan atas Permohonan Informasi, Tanggal <strong><?=date("d-m-Y",strtotime($arrData['created_date']))?></strong>
                    </p>
                    <table cellpadding="2" border="0" cellspacing="0">
                          <tr>
                            <td><strong>Nomor Registrasi Keberatan</strong></td>
                            <td>:</td>
                            <td><?=$arrData['nomor_keberatan']?></td>
                          </tr>
                          <tr>
                            <td><strong>Nomor Pendaftaran Permohonan Informasi</strong></td>
                            <td>:</td>
                            <td><?=$arrData['nomor_permohonan']?></td>
                          </tr>
                     </table>
                </div>
                 <div class="span4" style="text-align:center">
                    <img src="/ppid_admin/assets/image/stempel_online.png">
                 </div>
            </div>
        	<div class="row-fluid">
                <div class="span8">
                	
                
                        <div style="border:1px solid #ccc; padding:10px; background:#eee; margin-top:10px">
                         <table cellpadding="2" border="0" cellspacing="0">
                          <tr>
                            <td colspan="3"><strong>Tujuan Penggunaan Informasi</strong></td>
                          </tr>
                          <tr>
                            <td colspan="3"><div style="margin-left:20px">
                              <?=$arrData['tujuan_penggunaan']?>
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="3"><strong>Identitas Pemohon</strong></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Nama </div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['nama_pemohon']?></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Pekerjaan</div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['pekerjaan_pemohon']?></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Alamat</div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['alamat_pemohon']?></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Telepon</div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['telepon_pemohon']?></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Email</div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['email_pemohon']?></td>
                          </tr>
                          <tr>
                            <td colspan="3"><strong>Identitas Kuasa Pemohon</strong></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Nama </div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['kuasa_nama']?></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Alamat</div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['kuasa_alamat']?></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Telepon</div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['kuasa_telepon']?></td>
                          </tr>
                          <tr>
                            <td><div style="margin-left:20px">Email</div></td>
                            <td width="10">:</td>
                            <td><?=$arrData['kuasa_email']?></td>
                          </tr>
                          <tr>
                            <td colspan="3"><strong>ALASAN PENGAJUAN KEBERATAN</strong>***</td>
                          </tr>
                          <tr>
                            <td colspan="3"><div style="margin-left:20px">
                                <table>
                                  <?php 
								  	$alasan=preg_split("/;/",$arrData['alasan']);
                                foreach($m_alasan as $k=>$v) { 
                                    $checked = (in_array($k,$alasan))?"&radic;":"";
                                ?>
                                  <tr>
                                    <td valign="top"><?=$checked?></td>
                                    <td valign="top"><?=$k?>.</td>
                                    <td valign="top"><?=$v?></td>
                                  </tr>
                                  <?php
                                }
                                ?>
                                </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td colspan="3"><strong>KASUS POSISI</strong></td>
                          </tr>
                          <tr>
                            <td colspan="3"><div style="margin-left:20px">
                              <?=$arrData['kasus_posisi'];?>
                            </div></td>
                          </tr>
                        <tr>
                          <td colspan="3"><strong>HARI/TANGGAL TANGGAPAN ATAS KEBERATAN AKAN DIBERIKAN :</strong></td>
                          </tr>
                        <tr>
                          <td colspan="3"><div style="margin-left:20px"><?=$arrData['will_reply_date']?date("d-m-Y",strtotime($arrData['will_reply_date'])):"-";?></div></td>
                          </tr>
                        </table>
                        </div>
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
								switch($k) {
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
									$status="Ditanggapi";
									$label="";
									break;
								case 4:
									$status="Diperpanjang";
									$label="label-info";
									break;
							}
						?>
                            <tr>
                            <td><?=date("d-m-Y h:i",strtotime($v))?></td>
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

</div><!--end span8-->
</div>

</div>
<script>
$(document).ready(function () {
	$('#myModal').modal({backdrop:true,show:true});
})
</script>
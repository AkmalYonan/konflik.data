<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="assets/js/plugin/datepicker/bootstrap-datepicker.js"></script>
<link href="assets/bootstrap/css/datepicker.css" rel="stylesheet">	
<!-- Place inside the <head> of your HTML -->
<div class="subheader">
    <div class="container subheader-inner">
    	<h1>Pengajuan keberatan</h1>
    </div>
</div>
<?php $this->load->view('dok_menu',array("active"=>"dip/requests"));?>
<div class="container" style="margin-bottom:20px">
<div class="row-fluid">
<?php 
	if ($message) {
		echo '<div class="row-fluid"><div class="span12 alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$message.'</div></div>';
	}
?>
<!--tab content-->
    <?php echo form_open("user/keberatan/index/".$request['idx'],'id="fdata"');?>
    <input type="hidden" name="id_permohonan" value="<?=$request['idx'];?>" />
    <input type="hidden" name="id_dokumen" value="<?=$dokumen['idx'];?>" />
    <input type="hidden" name="kode_dokumen" value="<?=$dokumen['kode_dokumen'];?>" />
    <input type="hidden" name="file_name" value="<?=$dokumen['file_name'];?>" />
    <input type="hidden" name="file_type" value="<?=$dokumen['file_type'];?>" />
    <input type="hidden" name="file_size" value="<?=$dokumen['file_size'];?>" />
    <input type="hidden" name="jenis" value="<?=$dokumen['jenis'];?>" />
    <input type="hidden" name="judul_dokumen" value="<?=$dokumen['title'];?>" />
    <input type="hidden" name="skpa" value="<?=$request['skpa'];?>" />
    <input type="hidden" name="skpa_name" value="<?=$m_skpa[$request['skpa']];?>" />
    <input type="hidden" name="mode" value="<?=($idx)?'dokumen':"request";?>" />
    <input type="hidden" name="id_user" value="<?=$user['id']?>" />
	<div id="tab-edit" class="tab-pane active">    
	<div class="row-fluid">
	    <div class="span12">
            <div class="row-fluid">
                <div class="span7">
                    <h3 class="sub span11" style="border-bottom:2px solid #aaa">Informasi Pengajuan Keberatan</h3>
                    	<?php
							$readonly = ($idx)?'readonly="readonly"':"";
							$kodedoc = ($idx)?'kode_dokumen':"dummy";
						?>
                    	<div class="row-fluid">
                            <div class="span11">
                                <label>No. Pendaftaran Permohonan</label>
                                <input type="text" class="span12 required" name="nomor_permohonan" value="<?=$request['nomor_permohonan']?>" >
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span11">
                                <label>Tujuan Penggunaan Informasi</label>
                                <textarea name="tujuan_penggunaan" class="span12 required" rows="2"><?=$request['tujuan_penggunaan']?></textarea>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span11">
                                <label>Nama Pemohon</label>
                                <input type="text" class="span12 required" name="nama_pemohon" value="<?=$user['first_name']?>" >
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span11">
                                <label>Pekerjaan</label>
                                <input name="pekerjaan_pemohon" type="text" class="span12" value="<?=$user['pekerjaan']?>" >
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span11">
                                <label>Alamat</label>
                                <textarea name="alamat_pemohon" class="span12 required" rows="1"><?=$user['alamat']?></textarea>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span11">
                                <label>Telepon</label>
                                <input name="telepon_pemohon" type="text" class="span12 required" value="<?=$user['phone']?>" >
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span11">
                                <label>Email</label>
                                <input name="email_pemohon" type="text" class="span12 required" value="<?=$user['email']?>" >
                            </div>
                        </div>
                        <!-- -->
                        <div class="row-fluid">
                            <div class="span11">
                            	<br />
                                <label>Alasan Pengajuan Keberatan:</label>
                                <?php 
								if (cek_array($m_alasan)) { foreach($m_alasan as $k=>$v) { ?>
                                	<label class="checkbox">
                                        <input name="alasan[]" type="checkbox" value="<?=$k;?>" />
                                        <?=$v;?>
                                    </label>
                                <? }}?>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span11">
                            	<br />
                                <label>Kasus Posisi</label>
                                <textarea name="kasus_posisi" class="span12 required" rows="5"></textarea>
                       			<div class="help-block"><i class="icon-exclamation-sign"></i> &nbsp; Diisi kronologis singkat pengajuan keberatan</div>
                            </div>
                        </div>
                </div> <!-- span6 -->
                <div class="span5">
                    <div class="row-fluid">
					<h3 class="sub span12" style="border-bottom:2px solid #aaa">Identitas Kuasa Pemohon</h3>
                    <div class="row-fluid">
                        <div class="span12" style="padding:5px">
                        	<div class="row-fluid">
                            	<div class="span12">
                                    <label>Nama</label>
                                    <input type="text" class="span12" name="kuasa_name" value="" >
                        		</div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <label>Alamat</label>
                                    <textarea name="kuasa_alamat" class="span12" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <label>Telepon</label>
                                    <input name="kuasa_telepon" type="text" class="span12" value="" >
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <label>Email</label>
                                    <input name="kuasa_email" type="text" class="span12" value="" >
                                </div>
                            </div>
                            <div class="help-block"><i class="icon-exclamation-sign"></i> &nbsp;Isi form Identitas Kuasa Pemohon, jika Pengajuan Keberatan dikuasakan</div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    	</div> <!-- span12 -->
    </div>
    <div class="form-actions">
        <button id="btn-submit" type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
    <br />
</div>
<?php echo form_close();?>


</div>
</div>
<script>
$(document).ready(function () {
	/*$('#dp1').datepicker().on('changeDate', function(ev){
		$('#dp1').datepicker('hide');
	});*/
	tgl_lahir = $('.dp1').datepicker({
		format:"dd/mm/yyyy"
	}).on('changeDate', function(ev){
		var newDate = new Date(ev.date);
		$("#tanggal_lahir").val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
		$('.dp1').datepicker('hide');
	}).data('datepicker');
	
	$('.dp1').on("keyup",function(){
		setValDate(tgl_lahir,"#tanggal_lahir");
	});
	
	function setValDate(dp,target,sender) {
		if (sender) {
			if ($(sender).val().length<8) {
				$(target).val("");
				return;
			}
		}
		var newDate = new Date(dp.date);
		$(target).val(newDate.getFullYear()+"-"+(newDate.getMonth()+1)+"-"+newDate.getDate());
	};
	$(".required").each(function(i){
		$(this).closest("div").find(".asterix").remove();
		$(this).closest("div").find("label").append("<span class='asterix'>&nbsp;*</span>");
   });
   
   $("#fdata").submit(function(){
   		$(".form-actions").html("Submitting data...");
   });
});
</script>
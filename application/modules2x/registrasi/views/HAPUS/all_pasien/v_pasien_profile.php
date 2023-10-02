<?php
	$data_foto=pasien_foto($data["idx"]);
	$foto=cek_array($data_foto)?$data_foto["path"].$data_foto["file_name"]:"assets/images/pic.jpg";
	$lookup_bnnp=lookup("m_org","kd_org","nama","tipe_org='BNNP' and active='1'","order by idx");
	$lookup_bnnk=lookup("m_org","kd_org","nama","tipe_org='BNNK' and active='1'","order by idx");
	$lookup_balai=lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");

	?>
<div class="row">

<!--
<div class="col-md-3">
	<div class="box box-widget">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive foto-pasien" style="width:100% !important;" src="<?=$foto?>" alt="Foto Pasien">
			  <h3 class="profile-username text-center"><?=$data["nama"]?></h3>

              <p class="text-muted text-center"><?=$data["no_rekam_medis"]?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
				  <b>Identitas</b> <span class="pull-right">NIK, <?=$data["nik"]?></span>
                </li>
                <li class="list-group-item">
                  <b>Jenis Kelamin</b> <span class="pull-right"><?=$this->data_lookup["jenis_kelamin"][$data["jenis_kelamin"]]?></span>
                </li>
                <li class="list-group-item">
				  <b>Lahir</b> <span class="pull-right"><?=$data["tempat_lahir"]?>, <?=$this->utils->dateToString2($data["tgl_lahir"],'',3)?></span>
                </li>
              </ul>

              <a href="#" class="btn btn-primary btn-block hidden"><b>Follow</b></a>
            </div>
          </div>

          <div class="box box-widget">
            <div class="box-header with-border">
              <h3 class="box-title">Informasi Pasien</h3>
            </div>

            <div class="box-body">
			  <strong><i class="fa fa-envelope margin-r-5"></i> Alamat </strong>
              <p class="text-muted" style="margin-bottom:0px">
                <?=$data["alamat"]?>
              </p>
			  <hr>
			  <strong>
			  	<i class="fa fa-map-marker margin-r-5"></i>
				<?php
					if($data['jns_org']==1):
						echo "BNNP";
					elseif($data['jns_org']==2):
						echo "Balai/Loka";
					elseif($data['jns_org']==3):
						echo "BNNK";
					endif;
				?>
			  </strong> <br />
				<?php
					if($data['jns_org']==1):
						echo $lookup_bnnp[$data['kd_bnn']];
					elseif($data['jns_org']==2):
						echo $lookup_balai[$data['kd_bnn']];
					elseif($data['jns_org']==3):
						echo $lookup_bnnk[$data['kd_bnn']];
					endif;
				?>
			  <hr>
			  <strong><i class="fa fa-pencil margin-r-5"></i>Status</strong>
			 <p>
             	<?=lookup_status_proses_label($data["status_proses"])?>
              </p>

			  <?php if($data["status_proses"]=="SS"): ?>
			  <strong><i class="fa fa-calendar margin-r-5"></i>Tanggal Rencana Assesment</strong>
			  <p><?=date("d-m-y",strtotime($data['tgl_assestment']))?></p>
			  <?php endif; ?>
			</div>
          </div>


</div>
-->

<div class="col-md-12">



	<div class="box box-widget">
			<div class="box-body">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#pasien-data" data-toggle="tab">Data Pasien</a></li>
              <li><a href="#pasien-foto" data-toggle="tab">Foto</a></li>
               <li><a href="#pasien-sidik" data-toggle="tab">Sidik Jari</a></li>
							 <li><a href="#dokumen" data-toggle="tab">File Pendukung</a></li>
            <!--  <li><a href="#settings" data-toggle="tab">History</a></li>-->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="pasien-data">
              	  <?=$this->load->view("common_view/pasien/v_data_pasien_rh");?>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="pasien-foto">
                 <?=$this->load->view("v_take_picture2")?>
                 <div class="formSep"></div>
                 <?=$this->load->view("v_list_foto")?>
              </div>
              <!-- /.tab-pane -->
			  <div class="tab-pane" id="pasien-sidik">
              <h4 class="heading">Registrasi Scan 10 Jari</h4>
                 <?=$this->load->view("v_sidik_jari2")?>
                 <?=$this->load->view("v_sidik_jari")?>

                 <?=$this->load->view("v_sidik_jari_identifikasi")?>
              </div>
              <div class="tab-pane" id="settings">
                <?=$this->load->view("v_riwayat_pasienby_assestment")?>
              </div>
							<div class="tab-pane" id="dokumen">

              	  <?=$this->load->view("common_view/pasien/v_view_pemeriksaan_dokumen");?>
              </div>
              <!-- /.tab-pane -->
            </div>
			</div>
            <!-- /.tab-content -->
          </div>


</div> <!-- end col -->


</div><!-- end row-->

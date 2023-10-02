<?php 
	$data_foto=pasien_foto($data["idx"]);
	$foto=cek_array($data_foto)?$data_foto["path"].$data_foto["file_name"]:"assets/images/pic.jpg";
	$lookup_bnnp=lookup("m_org","kd_org","nama","tipe_org='BNNP'","order by idx");
	$lookup_balai=lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");

	?>
<div class="row">
<div class="col-md-3 hidden">
	<div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive foto-pasien" style="width:150px !important;" src="<?=$foto?>" alt="Foto Pasien">
			  <h3 class="profile-username text-center"><?=$data["nama"]?></h3>

              <p class="text-muted text-center"><?=$data["no_rekam_medis"]?></p>

              <ul class="list-group list-group-unbordered">
			  	<li class="list-group-item">
                  <b>NIK</b> <span class="pull-right"><?=$data["nik"]?></span>
                </li>
                <li class="list-group-item">
                  <b>Tanda Pengenal Lainnya</b> <span class="pull-right"><?=$data["jenis_identitas"]?>, <?=$data["no_identitas"]?></span>
                </li>
                <li class="list-group-item">
                  <b>Jenis Kelamin</b> <span class="pull-right"><?=$this->data_lookup["jenis_kelamin"][$data["jenis_kelamin"]]?></span>
                </li>
                <li class="list-group-item">
                  <b>Lahir</b> <span class="pull-right"><?=$data["tempat_lahir"]?>, <?=date2indo($data["tgl_lahir"])?></span>
                </li>
               <!-- <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>-->
              </ul>

              <a href="#" class="btn btn-primary btn-block hidden"><b>Follow</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Informasi Pasien</h3>
            </div>
            <!-- /.box-header -->
			
            <div class="box-body">
			  <strong><i class="fa fa-envelope margin-r-5"></i> Alamat </strong>
              <p class="text-muted" style="margin-bottom:0px">
                <?=$data["alamat"]?>
              </p>
			  <hr>
			  <strong><i class="fa fa-map-marker margin-r-5"></i><?=($data['jns_org']==1)?"BNNP":"BALAI/LOKA"?></strong> <br />
				<? if($data['jns_org']==1){ ?>
					<?=$lookup_bnnp[$data['kd_bnn']]?>
				<? }else if($data['jns_org']==2){?>
					<?=$lookup_balai[$data['kd_bnn']]?>
				<? }?>
			  <hr>
			  <strong><i class="fa fa-pencil margin-r-5"></i>Status</strong>
			  <p>
              	<?=lookup_status_proses_label($data["status_proses"])?>
              </p>
			</div>
            <!-- /.box-body -->
          </div>
    
    
</div><!-- end col -->

<div class="col-md-12">
		
		<div class="nav-tabs-custom">
			
            <ul class="nav nav-tabs">
              <li class="active"><a href="#pasien-data" data-toggle="tab">Data Pasien</a></li>
              <li><a href="#pasien-foto" data-toggle="tab">Foto</a></li>
              <li><a href="#settings" data-toggle="tab">Disclaimer</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="pasien-data" style="padding:0 !important;">
              		<?=$this->load->view("common_view/pasien/v_data_pasien");?>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane hidden" id="pasien-foto">
                 <?=$this->load->view("v_take_picture2")?>
                 <div class="formSep"></div>
                 <?=$this->load->view("v_list_foto")?>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>

</div> <!-- end col -->


</div><!-- end row-->
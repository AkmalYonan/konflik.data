<?php 
	$data_foto=pasien_foto($data["idx"]);
	$foto=cek_array($data_foto)?$data_foto["path"].$data_foto["file_name"]:"assets/images/pic.jpg";
	$lookup_bnnp=lookup("m_org","kd_org","nama","tipe_org='BNNP' and active='1'","order by idx");
	$lookup_bnnk=lookup("m_org","kd_org","nama","tipe_org='BNNK' and active='1'","order by idx");
	$lookup_balai=lookup("m_instansi","id_kabupaten","nama_instansi","jenis_tempat_rehab='BB' or jenis_tempat_rehab='BLK'","order by idx");

	?>
<div class="row">

<div class="col-md-12">


	
	<div class="box box-widget">
			<div class="box-body">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#pasien-data" data-toggle="tab">Data Konflik</a></li>
              <!--
			  <li><a href="#pasien-foto" data-toggle="tab">Foto</a></li>
              <li><a href="#pasien-sidik" data-toggle="tab">Sidik Jari</a></li> 
              <li><a href="#settings" data-toggle="tab">History</a></li>
			  -->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="pasien-data">
              	  <?//=$this->load->view("common_view/pasien/v_data_pasien_rh");?>
              </div>
              <!-- /.tab-pane -->
            <!-- 
              <div class="tab-pane" id="pasien-foto">
                 <?//=$this->load->view("v_take_picture2")?>
                 <div class="formSep"></div>
                 <?//=$this->load->view("v_list_foto")?>
              </div>
			  <div class="tab-pane" id="pasien-sidik">
              <h4 class="heading">Registrasi Scan 10 Jari</h4>
                 <?//=$this->load->view("v_sidik_jari2")?>
                 <?//=$this->load->view("v_sidik_jari")?>
                 <?//=$this->load->view("v_sidik_jari_identifikasi")?>
              </div>
			  
              <div class="tab-pane" id="settings">
                <?//=$this->load->view("v_riwayat_pasienby_assestment")?>
              </div>
			-->
            </div>
			</div>
            <!-- /.tab-content -->
          </div>


</div> <!-- end col -->


</div><!-- end row-->
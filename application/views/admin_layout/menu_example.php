<!-- Nav tabs -->
<div class="container hidden-print">
    <div class="row menu-bar">
        <div class="dropdown">
            <ul id="tabber" class="nav nav-tabs" data-toggle="tab-hover">
              <li><a id="mn_dashboard" href=""><i class="icon-home"></i></a></li>
              <? if($this->cms->has_read("pam")):?>
              <li><a id="mn_pam" href="#pam" data-toggle="tab" class="sisfopam">SISFO-PAM</a></li>
              <? endif;?>
              <? if($this->cms->has_read("operasi")):?>
              <li><a id="mn_operasi" href="#ops" data-toggle="tab" class="sisfoops">SISFO-OPS</a></li>
              <? endif;?>
              <? if($this->cms->has_read("pegawai")):?>
              <li><a id="mn_pegawai" href="#personil" data-toggle="tab" class="sisfopers">SISFO-PERS</a></li>
              <? endif;?>
              <? if($this->cms->has_read("logistik")):?>
              <li><a id="mn_logistik" href="#logistik" data-toggle="tab" class="sisfolog">SISFO-LOG</a></li>
              <? endif;?>
			  <? if($this->cms->has_read("setting")):?>		
              <li><a id="mn_setting" href="#setting" class='pengaturan' data-toggle="tab"><i class="icon-wrench"></i>&nbsp; Pengaturan</a></li>
              <? endif;?>
              <li><a href="help"><i class="icon-question-sign"></i>&nbsp; Help</a></li>
            </ul>
            <div id="mb-separator"></div>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane" id="dash">
              	<ul class="nav nav-pills">
                    <li>
                        <a>&nbsp;</a>
                    </li>
                </ul>
              </div>
              <? if($this->cms->has_read("setting")):?>
              <div class="tab-pane" id="setting">
              	<ul class="nav nav-pills">
                    <li class="dropdown-submenu">
                        <a href="javascript:void(0)">
                            <i class="icon-wrench"></i> &nbsp;Pengaturan Akun  <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="setting/user"><i class="icon-user"></i>User</a></li>
                            <li><a href="setting/group"><i class="icon-group"></i>Group</a></li>
                            <li><a href="setting/acl"><i class="icon-lock"></i>Group ACL</a></li>
                            <li><a href="setting/module"><i class="icon-table"></i>Module</a></li>
						</ul>
                    </li>
                    <li class="divider"></li>
                     <li>
                        <a href="setting/calendar">
                            <i class="icon-calendar"></i> &nbsp;Kalender kerja
                        </a>
                    </li>
                    <li>
                        <a href="master/organisasi">
                            <i class="icon-sitemap"></i> &nbsp;Unit Organisasi
                        </a>
                    </li>
                    <li>
                        <a href="timeline.html">
                            <i class="icon-flag"></i> &nbsp;Nationalities
                        </a>
                    </li>
                </ul>
              </div>
              <? endif;?>
              
              <? if($this->cms->has_read("pegawai")):?>
              <div class="tab-pane" id="personil">
              	<ul class="nav nav-pills">
                    <li>
                        <a href="pegawai/report/index">
                            <i class="icon-dashboard"></i>
                        </a>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="mn_ct_pers_personel">
                          <i class="icon-user"></i>&nbsp;  Personel <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a href="pegawai/pegawai/">Daftar Personel</a></li>
                          <li><a href="pegawai/pegawai/add">Tambah data Personel</a></li>
                          <li class="divider"></li>
                          <li><a href="forms/absensi/">Absensi</a></li>
                          <li><a href="forms/pendidikan/">Pendidikan</a></li>
                          <li><a href="forms/cuti/">Cuti</a></li>
                          <li class="divider"></li>
                          <li><a href="pegawai/search/">Search</a></li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                   <!-- <li>
                        <a href="forms/cuti" id="mn_ct_pers_absensi">
                          <i class="icon-check"></i> &nbsp;Absensi  
                        </a>
                      </li>
                    <li>
                        <a href="forms/cuti" id="mn_ct_pers_cuti">
                          <i class="icon-signout"></i> &nbsp;Cuti  
                        </a>
                      </li>-->
                    <!--<li>
                        <a href="forms/pendidikan" id="mn_ct_pers_ddk">
                          <i class="icon-book"></i> &nbsp;Pendidikan  
                        </a>
                      </li>-->
                    <li>
                        <a href="forms/pelayanan" id="mn_ct_pers_pelayanan">
                          <i class="icon-check"></i> &nbsp;Pelayanan 
                        </a>
                      </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="mn_ct_pers_dd">
                          <i class="icon-bell-alt"></i>&nbsp;  Dinas Dalam <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a href="forms/piket/grup">Piket Grup</a></li>
                          <li><a href="forms/piket/batalyon">Piket Batalyon</a></li>
                          <li class="divider"></li>
                          <li><a href="forms/piket/calendar/<?=date("Y/m/d");?>">Kalender Piket</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="forms/set_jabatan" id="mn_ct_pers_pj">
                          <i class="icon-sitemap"></i> &nbsp;Jabatan  
                        </a>
                      </li>
                    <li class="mn_separator">&nbsp;</li>
                    <li class="dropdown-submenu">
                        <a href="pegawai/report" id="mn_ct_report">
                            <i class="icon-bar-chart"></i> &nbsp;Report  <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="pegawai/report/rp2">Rekapitulasi Personel</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_113t">Bentuk PERS 113T</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_102c">Bentuk PERS 102-C</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_matrik_jabatan">Matrik Jabatan 102-E1</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_kkel">KUAT Keluarga</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_kagama">KUAT Agama</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_kkorps">KUAT Kecabangan</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_ksumber">KUAT Sumber TNI</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_kumur">KUAT Umur</a></li>
                          <li><a tabindex="-1" href="pegawai/report/rp_ktop">Rekapitulasi TOP/DSPP</a></li>
                        </ul>
                    </li>
                    <li class="mn_separator">&nbsp;</li>
                    <li class="dropdown-submenu">
                        <a href="master" id="mn_ct_master">
                            <i class="icon-table"></i> &nbsp;Data <em>Master</em> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="master/top">T O P</a></li>
                            <li><a href="master/document_category">Dokumen Personal</a></li>
                            <li><a href="master/pendidikan">Pendidikan</a></li>
                            <li><a href="master/pangkat">Pangkat</a></li>
                            <li><a href="master/jabatan">Tipe Jabatan</a></li>
                            <li><a href="master/korps">Korps</a></li>
                            <li><a href="master/sumber_tni">Sumber TNI</a></li>
                            <li><a href="master/penghargaan">Penghargaan</a></li>
						</ul>
                    </li>
                </ul>
              </div>
              <? endif;?>
              <? if($this->cms->has_read("pam")):?>
              <div class="tab-pane" id="pam">
              	<ul class="nav nav-pills">
                	<li>
                        <a href="pam/index">
                            <i class="icon-dashboard"></i>
                        </a>
                    </li>
                    <li class="dropdown-submenu">
                    <a tabindex="-1" href="pam/tamu/" id="mn_ct_tamu"><i class="icon-male"></i>&nbsp;  Tamu  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="pam/tamu/registrasi">Daftar Tamu</a></li>
                      <li class="divider"></li>
                      <li><a href="pam/tamu/all/">Search</a></li>
                     </ul>
                  </li>
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="pam/pelanggaran/"><i class="icon-exclamation-sign"></i>&nbsp;  Pelanggaran  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                     <!-- <li><a tabindex="-1" href="pam/pelanggaran/listview">Daftar Pelanggaran</a></li>
                      <li><a href="pam/pelanggaran/add/">Input Pelanggaran</a></li>-->
                      <li><a tabindex="-1" href="pam/pelanggaran/list_cp">Daftar Peristiwa</a></li>
                      <li><a href="pam/pelanggaran/add_cp">Input Peristiwa</a></li>
                      <li><a tabindex="-1" href="pam/pelanggaran/list_personel">Daftar Pelanggaran</a></li>
                      <li class="divider"></li>
                      <li><a href="pam/pelanggaran/all/">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="pam/binter/"><i class="icon-star"></i>&nbsp;  BINTER  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="pam/binter/listview">Daftar Binter</a></li>
                      <li><a href="pam/binter/add/">Input Binter</a></li>
                      <li class="divider"></li>
                      <li><a href="pam/binter/all/">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="pam/kendaraan/"><i class="icon-truck"></i>&nbsp;  Kendaraan  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="pam/kendaraan/cari_personel/">Input Kendaraan</a></li>
                      <li class="divider"></li>
                      <li><a href="pam/kendaraan/search_personil/">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="pam/informasi/" onclick="return false;"><i class="icon-truck"></i>&nbsp;  Informasi  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                    <li><a href="pam/informasi/listview/">Data Informasi</a></li>
                      <li><a href="pam/informasi/add/">Input Informasi</a></li>
                      <li class="divider"></li>
                      <li><a href="javascript:void();">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                        <a href="pegawai/report" id="mn_ct_pam_report">
                            <i class="icon-bar-chart"></i> &nbsp;Report  <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Tamu</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Pelanggaran</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Binter</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Kendaraan</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Peminjaman Asset</a></li>
                          
                        </ul>
                  </li>
                  
                </ul>
              </div>
              <? endif;?>
              
              <? if($this->cms->has_read("logistik")):?>
              <div class="tab-pane" id="logistik">
              	<ul class="nav nav-pills">
              		<li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);">Asset  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="logistik/asset_tetap/">Asset Tetap</a></li>
                      <li><a tabindex="-1" href="logistik/senjata/">Senjata</a></li>
                      <li><a tabindex="-1" href="logistik/kendaraan/">Kendaraan</a></li>
                      <li><a tabindex="-1" href="logistik/perhubungan/">Perhubungan</a></li>
                      <li><a tabindex="-1" href="logistik/zeni/">Zeni</a></li>
                      <li><a tabindex="-1" href="logistik/kesehatan/">Kesehatan</a></li>
                      <li><a tabindex="-1" href="logistik/munisi/">Munisi</a></li>
                      <li><a tabindex="-1" href="logistik/optik_lain/">Optik Perlengkapan lain</a></li>
                        
                      <li class="divider"></li>
                      <li><a href="logistik/search/">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);">Fasilitas Personel  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="logistik/fasilitas_dinas/">Daftar Fasilitas Personel</a></li>
                      <li class="divider"></li>
                      <li><a href="logistik/search/">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);" id="mn_ct_ops_peminjaman_asset">Peminjaman Asset  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="javascript:void(0)">Daftar Peminjaman Asset</a></li>
                      <li><a tabindex="-1" href="javascript:void(0)">Peminjaman Asset</a></li>
                      <li><a tabindex="-1" href="javascript:void(0)">Pengembalian Asset</a></li>
                      <li class="divider"></li>
                      <li><a href="javascript:void(0)">Search</a></li>
                     </ul>
                  </li>
                  
                   <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);" id="mn_ct_ops_penitipan_asset">Penitipan Asset  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="javascript:void(0)">Daftar Penitipan Asset</a></li>
                      <li><a tabindex="-1" href="javascript:void(0)">Penitipan Asset</a></li>
                      <li><a tabindex="-1" href="javascript:void(0)">Pengambilan Asset</a></li>
                      <li class="divider"></li>
                      <li><a href="javascript:void(0)">Search</a></li>
                     </ul>
                  </li>
                  
                   <li class="mn_separator">&nbsp;</li>
                    <li class="dropdown-submenu">
                        <a href="master" id="mn_ct_master_logistik">
                            <i class="icon-table"></i> &nbsp;Data <em>Master</em> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="master/asset_category/">Kategori Asset</a></li>
                            <li><a href="logistik/asset_jabatan/">Fasilitas Ke Jabatan</a></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown-submenu">
                        <a href="pegawai/report" id="mn_ct_log_report">
                            <i class="icon-bar-chart"></i> &nbsp;Report  <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Jumlah Asset</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Peminjaman Asset</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Penitipan Asset</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Kondisi Asset</a></li>
                          
                        </ul>
                  </li>
                    
                 </ul>
              </div>
              <? endif; ?>
              <? if($this->cms->has_read("operasi")):?>
              <div class="tab-pane" id="ops">
              	<ul class="nav nav-pills">
                	<li>
                        <a href="operasi/index">
                            <i class="icon-dashboard"></i>
                        </a>
                    </li>
                    
                     <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);">Daftar Personel <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="operasi/personel/listview">Profile Personel</a></li>
                      <li><a href="operasi/keahlian_personel/list_keahlian/">Input Keahlian Personel</a></li>
                     </ul>
                  </li>
                    <li class="mn_separator">&nbsp;</li>
                    
                	<li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);" id="mn_ct_ops_pelatihan">Pelatihan  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="operasi/pelatihan/listview">Daftar Pelatihan</a></li>
                      <li><a tabindex="-1" href="operasi/pelatihan/add">Input Pelatihan</a></li>
                      <li class="divider"></li>
                      <li><a tabindex="-1" href="operasi/pelatihan/pelatihan_cal">Kalender Pelatihan</a></li>
                      <!--<li><a href="javascript:void(0)">Search</a></li>-->
                     </ul>
                  </li>
                  
                  
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);">Penugasan  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="operasi/penugasan/listview">Daftar Penugasan</a></li>
                      <li><a tabindex="-1" href="operasi/penugasan/add">Input Penugasan</a></li>
                      <li class="divider"></li>
                      <li><a href="javascript:void(0)">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);">Pendidikan/Pelatihan  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="operasi/tarlat/listview">Daftar Tarlat</a></li>
                      <li class="divider"></li>
                      <li><a href="javascript:void(0)">Search</a></li>
                     </ul>
                  </li>
                  
                 
                 <li class="mn_separator">&nbsp;</li>
                 <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);" id="mn_ct_piket">Piket <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="operasi/piket/siaga_jadwal">SIAGA G3</a></li>
                      <li><a tabindex="-1" href="operasi/piket/pawas_jadwal">PAWAS G3</a></li>
                      <li class="divider"></li>
                      <li><a tabindex="-1" href="operasi/piket/piket_cal">Kalender Piket</a></li>
                      <li><a href="javascript:void(0)">Search</a></li>
                     </ul>
                 </li>
                 
                 
                 <!--
                    <li class="dropdown-submenu">
                        <a href="operasi/keahlian_personel/" id="mn_ct_keahlian_personel">
                            <i class="icon-table"></i> &nbsp;Data Keahlian Personel<em></em> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="operasi/keahlian_personel/list_keahlian/">Daftar Keahlian Personel</a></li>
                            
						</ul>
                    </li> 
                    -->
                    
                    <li class="dropdown-submenu">
                        <a href="operasi/report" id="mn_ct_ops_report">
                            <i class="icon-bar-chart"></i> &nbsp;Report  <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="operasi/report/kekuatan_per_satuan/">Kekuatan Per Satuan</a></li>	
                           <li><a tabindex="-1" href="operasi/report/rp_tso/">Personel Tidak Siap Operasi</a></li>	
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Pelatihan</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Penugasan</a></li>
                          <li><a tabindex="-1" href="javascript:alert('Under Development')">Rekap Peminjaman Asset</a></li>
                          
                        </ul>
                  </li>
                  <li class="mn_separator">&nbsp;</li>
                  <li class="dropdown-submenu">
                        <a href="master" id="mn_ct_master_keahlian">
                            <i class="icon-table"></i> &nbsp;Data <em>Master</em> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="master/keahlian_umum/">Keahlian Umum</a></li>
                            <li><a href="master/keahlian_khusus/">Keahlian Khusus</a></li>
                        </ul>
                    </li>
                    
                    
                  
                </ul>
              </div>
              <? endif;?>
            </div>
        </div>
     </div>
</div>


<!--<div class="container hidden-print">
    <div class="row menu-bar">
        <div class="dropdown">
            <ul class="nav nav-pills">
              <li class=""><a href="#">Dashboard</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Pengaturan <span class="caret"></span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-submenu">
                        <a href="master">
                            <i class="icon-wrench"></i> &nbsp;Pengaturan Akun
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="setting/group"><i class="icon-group"></i>Group</a></li>
                            <li><a href="profile.html"><i class="icon-user"></i>User</a></li>
						</ul>
                    </li>
                    <li class="divider"></li>
                    <li class="dropdown-submenu">
                        <a href="master">
                            <i class="icon-table"></i>Data <em>Master</em>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/hrms/master/penghargaan">Penghargaan</a></li>
                            <li><a href="/hrms/master/jabatan">Jabatan</a></li>
                            <li><a href="/hrms/master/pangkat">Pangkat</a></li>
                            <li><a href="/hrms/master/pendidikan">Pendidikan</a></li>
                            <li><a href="/hrms/master/pelatihan">Pelatihan</a></li>
                            <li><a href="/hrms/master/status_pegawai">Status Pegawai</a></li>
                            <li><a href="/hrms/master/hukuman">Hukuman</a></li>
						</ul>
                    </li>
                     <li>
                        <a href="setting/calendar">
                            <i class="icon-calendar"></i>Kalender kerja
                        </a>
                    </li>
                    <li>
                        <a href="master/organisasi">
                            <i class="icon-sitemap"></i>Unit Organisasi
                        </a>
                    </li>
                    <li>
                        <a href="timeline.html">
                            <i class="icon-flag"></i>Nationalities
                        </a>
                    </li>
                </ul>
              </li>
                              
              <li class="dropdown" id="mn_pegawai">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Personil <span class="caret"></span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li>
                        <a href="pegawai">
                            <i class="icon-list"></i>
                            Daftar Personil
                        </a>
                    </li>
                    <li>
                        <a href="pegawai/add">
                            <i class="icon-plus"></i>
                            Tambah data
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <i class="icon-time"></i> &nbsp;Form <em>Input</em>
                        </a>
                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                          <li><a href="forms/jabatan">Jabatan</a></li>
                          <li><a href="#">Pangkat</a></li>
                          <li class="divider"></li>
                        </ul>
                      </li>
                    <li class="dropdown-submenu">
                        <a href="profile.html">
                            <i class="icon-report"></i>
                            Report
                        </a>
                        <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="#">PIM Report</a></li>
                          <li><a tabindex="-1" href="#">EEO 1 Reports</a></li>
                        </ul>
                    </li>
                </ul>
              </li>

              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  P A M <span class="caret"></span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="#">Tamu</a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="pam/tamu/registrasi">Daftar Tamu</a></li>
                      <li class="divider"></li>
                      <li><a href="pam/tamu/all/">Search</a></li>
                     </ul>
                  </li>
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="pam/pelanggaran/">Pelanggaran</a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="pam/pelanggaran/listview">Daftar Pelanggaran</a></li>
                      <li><a href="pam/pelanggaran/add/">Input Pelanggaran</a></li>
                      <li class="divider"></li>
                      <li><a href="pam/pelanggaran/all/">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="pam/pelanggaran/">BINTER</a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="pam/binter/listview">Daftar Binter</a></li>
                      <li><a href="pam/binter/add/">Input Binter</a></li>
                      <li class="divider"></li>
                      <li><a href="pam/binter/all/">Search</a></li>
                     </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="pam/pelanggaran/">Kendaraan</a>
                    <ul class="dropdown-menu">
                      <li><a href="pam/kendaraan/cari_personel/">Input Kendaraan</a></li>
                      <li class="divider"></li>
                      <li><a href="pam/kendaraan/all/">Search</a></li>
                     </ul>
                  </li>
                  
                </ul>
              </li>
              
              
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Logistik<span class="caret"></span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);">Asset</a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="logistik/asset_tetap/">Asset Tetap</a></li>
                      <li><a tabindex="-1" href="logistik/senjata/">Senjata</a></li>
                      <li><a tabindex="-1" href="logistik/kendaraan/">Kendaraan</a></li>
                      <li><a tabindex="-1" href="logistik/perhubungan/">Perhubungan</a></li>
                      <li><a tabindex="-1" href="logistik/zeni/">Zeni</a></li>
                      <li><a tabindex="-1" href="logistik/kesehatan/">Kesehatan</a></li>
                      <li><a tabindex="-1" href="logistik/munisi/">Munisi</a></li>
                      <li><a tabindex="-1" href="logistik/optik_lain/">Optik Perlengkapan lain</a></li>
                        
                      <li class="divider"></li>
                      <li><a href="pam/tamu/all/">Search</a></li>
                     </ul>
                  </li>
                 </ul>
              </li>
              
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Operasi<span class="caret"></span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                  <li class="dropdown-submenu">
                    <a tabindex="-1" href="javascript:void(0);">Asset</a>
                    <ul class="dropdown-menu">
                      <li><a tabindex="-1" href="logistik/asset_tetap/">Asset Tetap</a></li>
                      <li><a tabindex="-1" href="logistik/senjata/">Senjata</a></li>
                      <li><a tabindex="-1" href="logistik/kendaraan/">Kendaraan</a></li>
                      <li><a tabindex="-1" href="logistik/perhubungan/">Perhubungan</a></li>
                      <li><a tabindex="-1" href="logistik/zeni/">Zeni</a></li>
                      <li><a tabindex="-1" href="logistik/kesehatan/">Kesehatan</a></li>
                      <li><a tabindex="-1" href="logistik/munisi/">Munisi</a></li>
                      <li><a tabindex="-1" href="logistik/optik_lain/">Optik Perlengkapan lain</a></li>
                        
                      <li class="divider"></li>
                      <li><a href="pam/tamu/all/">Search</a></li>
                     </ul>
                  </li>
                 </ul>
              </li>
                            
              <li><a href="#">Help</a></li>

              
            </ul>

        </div>
    </div>
</div>-->
<script>
$(function(){
});

var timer;
$('.nav-tabs[data-toggle="tab-hover"] > li > a').bind("mouseenter",
    function(){ //hover
		clearTimeout(timer);
		var t = $(this);
		timer = setTimeout(function(){
			t.tab('show');
		}, 300);
        //clearTimeout(timer);
		
    }
).bind("mouseleave",
	function(){ //hover
		clearTimeout(timer);
		timer = setTimeout(function(){
			if (!$('.tab-pane').hasClass("tabopen")) $('.tab-pane.active').removeClass("active")
			$('#tabber li.tabopen a').tab('show');
		}, 1000);
	}
)
$('.tab-content').bind('mouseenter',
	function(){ //hover
        clearTimeout(timer);
    }
).bind('mouseleave', function(){
	clearTimeout(timer);
	timer = setTimeout(function(){
			if (!$('.tab-pane').hasClass("tabopen")) $('.tab-pane.active').removeClass("active")
		 	$('#tabber li.tabopen a').tab('show');
	}, 1000);
});
</script>


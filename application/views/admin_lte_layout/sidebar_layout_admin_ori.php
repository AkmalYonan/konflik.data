<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
		   <?php if($this->cms->has_view("admin/dashboard/")): ?>	
           <li class="active">
                <a href="admin/dashboard/">
                    <i class="fa fa-line-chart fa-lg"></i> <span>Dashboard</span>
                </a>
                <a class="hidden" href="admin/dashboard_rehab/">rehab</a>
                <a class="hidden" href="admin/dashboard_pasca/">pasca</a>
                <a class="hidden" href="admin/dashboard_instansi/">instansi</a>
            </li>
			<?php endif; ?>
			<?php if($this->cms->has_view("admin/peta_data/")): ?>
            <li>
                <a href="map/view/">
                    <i class="fa fa-globe fa-lg"></i> <span>Peta Data</span>
                </a>
            </li>
			<?php endif; ?>
			<?php if($this->cms->has_view("admin/daftar_pasien/")): ?>
			<li class="sidebar-spacer">&nbsp;</li>
			<li class="treeview">
                <a href="registrasi/all_pasien/">
                    <i class="fa fa-user-circle"></i> <span>Daftar Pasien</span>
                </a>
            </li>
			<?php endif; ?>
            <!-- MODULE REHABILITASI -->
			<?php if($this->cms->has_view("admin/registrasi/")): ?>
            <li class="treeview">
				<a href="#">
					<i class="fa fa-user-plus fa-lg"></i>
					<span>Pendaftaran</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/pasien/")): ?>
					<li><a href="registrasi/offline/"><i class="fa fa-user"></i>Offline</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/online/")): ?>
					<li><a href="registrasi/online/"><i class="fa fa-globe"></i>Online</a></li>
					<?php endif; ?>
                </ul>
                
			</li>
			<?php endif; ?>
            <!-- END REHABILITASI -->
			
			<?php if($this->cms->has_view("admin/assesment/")): ?>
            <li class="treeview">
				<a href="#">
					<i class="fa  fa-edit fa-lg"></i> <span> Assesment</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/waiting_list/")): ?>
					<li>
                    	<a href="registrasi/pasien/">
                            <i class="fa fa-clock-o"></i> <span>Daftar Tunggu</span>
                        </a>
                    </li>
					<?php endif; ?>
					<li>
                    	<a href="registrasi/tolak/">
                            <i class="fa fa-address-book"></i> <span>Daftar Pasien Ditolak</span>
                        </a>
                    </li>
					<?php if($this->cms->has_view("admin/resume_assesment/")): ?>
					<li>
                    	<a href="registrasi/assesment/">
                            <i class="fa  fa-check-square-o"></i> <span>Resume Assesment</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
			<?php endif; ?>

			<?php if($this->cms->has_view("admin/rehabilitasi/")): ?>
            <li class="treeview">
				<a href="#">
					<i class="fa fa-history fa-lg"></i>
					<span>Rehabilitasi</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="rehab/daftar_rehab"><i class="fa fa-vcard-o"></i>Daftar Pasien Rehabilitasi</a></li>
					<?php if($this->cms->has_view("admin/detox/") or $this->cms->has_view("admin/entry_unit/") or $this->cms->has_view("admin/primary_treatment/") or $this->cms->has_view("admin/re_entry/")): ?>
					<li>
						<a href="#">
							<i class="fa fa-sign-in"></i>Rawat Inap <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<?php if($this->cms->has_view("admin/detox/")): ?>
							<li><a href="rehab/detox"><i class="fa fa-medkit"></i>Detoxifikasi</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/entry_unit/")): ?>
							<li><a href="rehab/entry_unit"><i class="fa fa-medkit"></i>Entry Unit</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/primary_treatment/")): ?>
							<li><a href="rehab/primary"><i class="fa fa-users"></i>Primary Treatment</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/re_entry/")): ?>
							<li><a href="rehab/reentry"><i class="fa fa-table"></i>Re-Entry</a></li>
							<?php endif; ?>
						</ul>
					</li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/rj_konseling/") or $this->cms->has_view("admin/terapi_kelompok/") or $this->cms->has_view("admin/primary_treatment/") or $this->cms->has_view("admin/simtomatik")): ?>
					<li><a href="#">
							<i class="fa fa-street-view"></i>Rawat Jalan <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<li>
								<?php if($this->cms->has_view("admin/rj_konseling/")): ?>
								<li><a href="rehab/konseling"><i class="fa fa-medkit"></i>Konseling</a></li>
								<?php endif; ?>
								<?php if($this->cms->has_view("admin/terapi_kelompok/")): ?>
								<li><a href="rehab/terapi_kelompok"><i class="fa fa-medkit"></i>Terapi Kelompok</a></li>
								<?php endif; ?>
								<?php if($this->cms->has_view("admin/simtomatik/")): ?>
								<li><a href="rehab/terapi_simtomatik"><i class="fa fa-users"></i>Terapi Simptomatik</a></li>
								<?php endif; ?>
							</li>
						</ul>
					</li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/laporan_rawat_jalan/")): ?>
					<li>
						<a href="rehab/report_rawat_jalan/index_rujukan"><i class="fa fa-file-text-o"></i>Laporan</a>
						<!--
						<ul class="treeview-menu">
							<li><a href="rehab/report_rawat_jalan/index_rujukan"><i class="fa fa-table"></i>Laporan Rawat Jalan</a></li>
						</ul>
						-->
					</li>
					<?php endif; ?>
                </ul>     
			</li>
			<?php endif; ?>
			
            <!-- MODULE PASCA REHAB -->
			<?php if($this->cms->has_view("admin/pasca_rehab/")): ?>
            <li class="treeview">
				<a href="#">
					<i class="fa fa-child fa-lg"></i>
					<span>Pasca Rehabilitasi</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/form_penerimaan_pasca/")): ?>
					<li><a href="pasca/pasca_rehab"><i class="fa  fa-check-square"></i>Penerimaan Pasien Pasca</a></li>
					<?php endif; ?>
                    <li class="sidebar-spacer">&nbsp;</li>
					<?php if($this->cms->has_view("admin/daftar_pasien_pasca/")): ?>
					<li><a href="pasca/daftar_pasca"><i class="fa fa-user"></i>Daftar Pasien Pasca Rehab</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/daily_activity/") or $this->cms->has_view("admin/discharge/")): ?>
					<li><a href="#">
							<i class="fa fa-sign-in"></i>Rawat Inap <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<?php if($this->cms->has_view("admin/daily_activity/")): ?>
							<li><a href="pasca/daily_act"><i class="fa fa-clipboard"></i>Daily Activity</a></li>
							<?php endif; ?>							
							<?php if($this->cms->has_view("admin/discharge/")): ?>
							<li><a href="pasca/discharge"><i class="fa fa-paperclip"></i>Discharge/Rujukan</a></li>
							<?php endif; ?>
						</ul>
					</li>
					<?php endif; ?>
					<li>
						<a href="#">
							<i class="fa fa-street-view"></i>Rawat Jalan <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<?php if($this->cms->has_view("admin/peer_group/")): ?>
							<li><a href="pasca/peer_group"><i class="fa fa-users"></i>Peer Group</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/pengembangan_diri/")): ?>
							<li><a href="pasca/pengembangan_diri"><i class="fa fa-user"></i>Pengembangan Diri</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/dukungan_keluarga/")): ?>
							<li><a href="pasca/dukungan_keluarga"><i class="fa fa-home"></i>Dukungan Keluarga</a></li>
							<?php endif; ?>
						</ul>
					</li>
					
					<?php if($this->cms->has_view("admin/kegiatan_produktif/") or $this->cms->has_view("admin/evaluasi/") or $this->cms->has_view("admin/pemantauan_urin/") or $this->cms->has_view("admin/home_visit/") or $this->cms->has_view("admin/pertemuan_kelompok/") or $this->cms->has_view("admin/pendampingan_konseling/") or $this->cms->has_view("admin/pendampingan_urin/")): ?>
                    <li><a href="#">
							<i class="fa fa-plus-square"></i>Rawat Lanjut <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<?php if($this->cms->has_view("admin/kegiatan_produktif/") or $this->cms->has_view("admin/evaluasi/") or $this->cms->has_view("admin/pemantauan_urin/")): ?>
							<li>
								<a href="#"><i class="fa fa-home"></i>Pemantauan <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<?php if($this->cms->has_view("admin/kegiatan_produktif/")): ?>
									<li><a href="pasca/produktif"><i class="fa fa-plus"></i>Kegiatan Produktif</a></li>
									<?php endif; ?>
									<?php if($this->cms->has_view("admin/evaluasi/")): ?>
									<li><a href="pasca/evaluasi"><i class="fa fa-check-square-o"></i>Evaluasi Perkembangan</a></li>
									<?php endif; ?>
									<?php if($this->cms->has_view("admin/pemantauan_urin/")): ?>
									<li><a href="pasca/pemantauan_urin"><i class="fa fa-tint"></i>Tes Urin</a></li>
									<?php endif; ?>
								</ul>
							</li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/home_visit/") or $this->cms->has_view("admin/pertemuan_kelompok/") or $this->cms->has_view("admin/pendampingan_konseling/") or $this->cms->has_view("admin/pendampingan_urin/")): ?>
							<li>
								<a href="#"><i class="fa fa-file-text"></i>Pendampingan <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="pasca/home_visit"><i class="fa fa-home"></i>Home Visit</a></li>
									<li><a href="pasca/pertemuan_kelompok"><i class="fa fa-file-text"></i>Partemuan Kelompok</a></li>
									<li><a href="pasca/konseling"><i class="fa fa-medkit"></i>Konseling</a></li>
									<li><a href="pasca/pendampingan_urin"><i class="fa fa-tint"></i>Tes Urin</a></li>
								</ul>
							</li>
							
							<?php endif; ?>
							<!--
							<li><a href="pasca/home_visit"><i class="fa fa-home"></i>Home Visit</a></li>
							<li><a href="pasca/pertemuan_kelompok"><i class="fa fa-file-text"></i>Partemuan Kelompok</a></li>
							-->
						</ul>
					</li>
					<li>
						<a href="pasca/outcome"><i class="fa fa-user-circle"></i>Daftar Outcome Pasien </a>
					</li>
					<li>
						<a href="pasca/luar_outcome"><i class="fa fa-user-circle"></i>Daftar Pasien Luar Outcome</a>
					</li>
					<?php endif; ?>
                    <li>
						<a href="pasca/report_pendampingan/index_rawat_lanjut"><i class="fa fa-table"></i>Laporan</a>
						<!--
						<ul class="treeview-menu">
							<li><a href="pasca/report_pendampingan/index_rawat_lanjut"><i class="fa fa-table"></i>Laporan Pendampingan</a></li>
						</ul>
						-->
					</li>
                    
                </ul>
                
			</li>
			<?php endif; ?>
            <!-- END PASCA REHAB -->
            <li class="sidebar-spacer">&nbsp;</li>
			
            <!-- MODULE SARANA PRASARANA-->
			<?php if($this->cms->has_view("admin/sarpras/")): ?>
            <li class="treeview">
				<a href="#">
					<i class="fa fa-linode fa-lg"></i>
					<span>Sarana & Prasarana</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/input_sarpras/")): ?>
					<li><a href="sarpras/fas_ruang"><i class="fa fa-plus"></i>Input Sarpras</a></li>
					<?php endif; ?>
					<!--
					<li><a href="common/uc_page"><i class="fa fa-plus"></i>Laporan</a></li>
					-->
                </ul>
            </li>
			<?php endif; ?>
            <!-- END SARANA PRASARANA -->
            
            
            <!-- MODULE LAPORAN-->
			<?php if($this->cms->has_view("admin/laporan/")): ?>
            <li class="treeview">
				<a href="#">
					<i class="fa fa-table fa-lg"></i>
					<span>Laporan</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
                	<?php if($this->cms->has_view("admin/monitoring_pasien/")): ?>
                    <li><a href="laporan/laporan/monitoring_pasien"><i class="fa fa-table"></i>Monitoring Pasien</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/laporan_baru/")): ?>
					<li><a href="laporan/laporan/pasien_baru_per_klinik"><i class="fa fa-user"></i>Pasien Baru</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/laporan_lama/")): ?>
                    <li><a href="laporan/laporan/pasien_lama_per_klinik"><i class="fa fa-user"></i>Pasien Lama</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/rekap_bulanan/")): ?>
                    <li><a href="laporan/laporan/rekap_bulanan"><i class="fa fa-table"></i>Rekap Laporan Bulanan</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/rekap_tahunan/")): ?>
                    <li><a href="laporan/laporan/rekap_tahunan"><i class="fa fa-table"></i>Rekap Laporan Tahunan</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/rekap_status_rawat/")): ?>
					<li><a href="laporan/laporan/rekap_status_rawat"><i class="fa fa-table"></i>Rekap Berdasarkan Status Rawat</a></li>
					<li><a href="laporan/laporan/rekap_sumber_pasien"><i class="fa fa-table"></i>Rekap Berdasarkan Sumber Pasien</a></li>
					<li><a href="organisasi/ketersediaan_balai"><i class="fa fa-building"></i>Ketersediaan Balai</a></li>
					<?php endif; ?>
				</ul>
            </li>
			<?php endif; ?>
            <!-- END SARANA PRASARANA -->
            
            <?php if($this->cms->has_view("admin/instansi/")): ?>
            <li class="treeview">
				<a href="#">
					<i class="fa fa-sitemap fa-lg"></i>
					<span>Instansi</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/instansi_bnnp/")): ?>
					<li><a href="organisasi/org"><i class="fa"></i>BNNP</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/instansi_bnnk/")): ?>
					<li><a href="organisasi/bnnk"><i class="fa"></i>BNNK</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/instansi_klinik_pratama/")): ?>
					<li><a href="organisasi/kp"><i class="fa"></i>Klinik Pratama</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/instansi_balai_loka/")): ?>
                    <li><a href="organisasi/balai"><i class="fa"></i>Balai Besar/Balai/Loka</a></li>
					<?php endif; ?>
                    <?php if($this->cms->has_view("admin/instansi_ipwl/")): ?>
					<li><a href="organisasi/instansi"><i class="fa"></i>IPWL</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/instansi_rumah_damping/")): ?>
                    <li><a href="organisasi/rd"><i class="fa"></i>Rumah Damping</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/instansi_komponen_masyarakat/")): ?>
                    <li><a href="organisasi/km"><i class="fa"></i>Komponen Masyarakat</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/instansi_ipnwl/")): ?>
                    <li><a href="organisasi/ipnwl"><i class="fa"></i>IP Non IPWL</a></li>
					<?php endif; ?>
                </ul>
			</li>
			<?php endif; ?>
            
			 <?php if($this->cms->has_view("admin/master/")):?>
			 <li class="treeview">
				<a href="#">
					<i class="fa fa-puzzle-piece fa-lg"></i>
					<span>Data Master</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/master_napza/")): ?>
					<li><a href="master_data/jenis_napza"><i class="fa"></i>Jenis Napza</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/master_status_legal/")): ?>
					<li><a href="master_data/status_legal"><i class="fa"></i>Status Legal</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/master_lookup/")): ?>
                    <li><a href="master_data/lookup"><i class="fa"></i>Lookup</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/master_jenis_instansi/")): ?>
                    <li><a href="master_data/jenis_instansi"><i class="fa"></i>Jenis Instansi</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/master_sumber_biaya/")): ?>
                    <li><a href="master_data/sumber_biaya"><i class="fa"></i>Sumber Biaya</a></li>
					<?php endif; ?>
					<?php if(($this->cms->has_view("admin/master_peer_group/")) or ($this->cms->has_view("admin/master_evaluasi/")) or ($this->cms->has_view("admin/master_perkembangan_diri/")) or ($this->cms->has_view("admin/master_dukungan_keluarga/")) or ($this->cms->has_view("admin/master_daily_activity/"))): ?>
					<li>
						<a href="#">
							<i class="fa"></i>Jenis Kegiatan <i class="fa fa-angle-left pull-right"></i>
						</a>
						<ul class="treeview-menu">
							<?php if($this->cms->has_view("admin/master_peer_group/")): ?>
							<li><a href="master_data/jenis_kegiatan/index/pg"><i class="fa"></i>Peer Group</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/master_evaluasi/")): ?>
							<li><a href="master_data/jenis_kegiatan/index/ep"><i class="fa"></i>Evaluasi Perkembangan</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/master_perkembangan_diri/")): ?>
							<li><a href="master_data/jenis_kegiatan/index/pd"><i class="fa"></i>Perkembangan Diri</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/master_dukungan_keluarga/")): ?>
							<li><a href="master_data/jenis_kegiatan/index/dk"><i class="fa"></i>Dukungan Keluarga</a></li>
							<?php endif; ?>
							<?php if($this->cms->has_view("admin/master_daily_activity/")): ?>
							<li><a href="master_data/jenis_kegiatan/index/da"><i class="fa"></i>Daily Activity</a></li>
							<?php endif; ?>
						</ul>
					</li>
					<?php endif; ?>
				 </ul>
                
			</li>
			<?php endif;?>
			
			<?php if($this->cms->has_view("admin/web_content/")): ?>	
			<li class="treeview">
				<a href="#">
					<i class="fa fa-laptop fa-lg"></i>
					<span>Web Content</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/slider/")): ?>
					<li><a href="content/slider"><i class="fa"></i>Slider</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/news/")): ?>
                    <li><a href="content/news"><i class="fa"></i>News</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/articles/")): ?>
                    <li><a href="content/articles"><i class="fa"></i>Articles</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/profil/")): ?>
                    <li><a href="content/profiles"><i class="fa"></i>Profil BNN</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/layanan_rehab/")): ?>
                    <li><a href="content/rehab"><i class="fa"></i>Layanan Rehab</a></li>
					<?php endif; ?>
				</ul>
                
			</li>
			<?php endif; ?>
			
			<?php if($this->cms->has_admin("admin/account_manager/")): ?>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-cog fa-lg"></i>
					<span>Account Manager</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_admin("admin/users/")): ?>
					<li><a href="admin/user/"><i class="fa"></i>Users</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_admin("admin/groups/")): ?>
					<li><a href="admin/group"><i class="fa"></i>Groups</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_admin("admin/acl_groups/")): ?>
					<li><a href="admin/acl"><i class="fa"></i>ACL Groups </a></li>
					<?php endif; ?>
				</ul>
			</li>
			<?php endif; ?>
			<!--<?//php endif;?>-->

        </ul>
    </section>
</aside>



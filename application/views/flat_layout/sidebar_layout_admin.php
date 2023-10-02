<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
           <?php if($this->cms->has_view("dashboard/pra/")):?>
           <li class="active">
                <a href="dashboard/pra/">
                    <i class="fa fa-line-chart fa-lg"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php endif;?>
            <?php if($this->cms->has_view("kandidat/pascal/")):?>
            <li class="treeview">
				<a href="<?= base_url()?>">
					<i class="fa fa-star fa-lg"></i>
					<span>Calon</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li>
                        <a href="kandidat/pascal/">
                            <i class="fa"></i> <span>Pasangan Calon</span>
                        </a>
                    </li>
                    <?php if($this->cms->has_read("kandidat/survey/")):?>
                    <li><a href="<?= base_url()?>kandidat/survey"><i class="fa"></i> <span>Survey</span></a></li>
					<?php endif;?>
                </ul>
			</li>
            <?php endif;?>
            <?php if($this->cms->has_view("kalender/")):?>
            <li class="treeview">
				<a href="<?= base_url()?>kalender/kegiatan/">
					<i class="fa fa-calendar fa-lg"></i>
					<span>Kegiatan</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
                	<?php if($this->cms->has_view("kalender/kegiatan/")):?>
					<li><a href="<?= base_url()?>kalender/kegiatan/"><i class="fa"></i>Kalender Kegiatan</a></li>
                    <?php endif;?>
					<?php if($this->cms->has_write("kalender/kategori/")):?>
                    <li role="separator" class="divider"></li>
                    <li style="border-top:1px dotted #666"><a href="<?= base_url()?>kalender/kategori/"><i class="fa"></i>Kategori</a></li>
					<?php endif;?>
                </ul>
			</li>
            <?php endif;?>
            <?php if($this->cms->has_read("adwil/")):?>
            <!--<li class="treeview" class="active">
				<a href="">
					<i class="fa fa-puzzle-piece fa-lg"></i>
					<span>Wilayah Pilkada</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="adwil/kecamatan"><i class="fa"></i>Kecamatan</a></li>
                    <li><a href="adwil/deskel"><i class="fa"></i>Desa/Kelurahan</a></li>
                    <li><a href="adwil/tps"><i class="fa"></i>TPS</a></li>
				</ul>
			</li>-->
            <?php endif;?>
            <?php if($this->cms->has_read("adwil/")):?>
            <li class="treeview">
                <a href="adwil/kecamatan">
					<i class="fa fa-puzzle-piece fa-lg"></i> <span>Wilayah Pilkada</span>
				</a>
                <!-- dummy link for active menu -->
                <a href="adwil/deskel" class="hidden"></a>
                <a href="adwil/tps" class="hidden"></a>
            </li>
            <?php endif;?>
            <?php if($this->cms->has_read("timses/timses/")):?>
            <li class="treeview">
                <a href="timses/timses">
					<i class="fa fa-users fa-lg"></i> <span>Tim Jaringan</span>
				</a>
            </li>
            <?php endif;?>
            <?php if($this->cms->has_read("pemilih/potensial/")):?>
            <li class="treeview">
                <a href="<?= base_url()?>pemilih/potensial">
					<i class="fa fa-check-square-o fa-lg"></i> <span>Pemilih Potensial</span>
				</a>
            </li>
            <?php endif;?>
            
            <li class="sidebar-spacer">&nbsp;</li>
            
            <?php if($this->cms->has_view("imedia/monitoring/")):?>
            <li class="treeview">
				<a href="<?= base_url()?>imedia/monitoring">
					<i class="fa fa-bullhorn fa-lg"></i>
					<span>Monitoring Media</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?= base_url()?>imedia/monitoring"><i class="fa"></i>Isu Media</a></li>
					<li><a href="<?= base_url()?>imedia/rss"><i class="fa"></i>RSS</a></li>
                    <?php if($this->cms->has_write("imedia/monitoring/")):?>
                    <li role="separator" class="divider"></li>
                    <li style="border-top:1px dotted #666"><a href="<?= base_url()?>admin/master/index/isu"><i class="fa"></i>Kategori Isu</a></li>
                    <li><a href="<?= base_url()?>admin/master/index/jenis_media"><i class="fa"></i>Jenis Media</a></li>
					<?php endif;?>
                </ul>
			</li>
            <?php endif;?>
            <?php if($this->cms->has_read("pemetaan/")):?>
			<li class="treeview">
                <a href="<?= base_url()?>pemetaan/tokoh">
					<i class="fa fa-user fa-lg"></i> <span>Pemetaan Tokoh</span>
				</a>
            </li>
            <?php endif;?>
			<?php if($this->cms->has_read("logistik/")):?>
            <li class="treeview">
				<a href="">
					<i class="fa fa-cube fa-lg"></i>
					<span>Logistik</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?= base_url()?>logistik/stok"><i class="fa"></i>Stok/Distribusi</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?= base_url()?>logistik/kategori"><i class="fa"></i>Kategori Barang</a></li>
				</ul>
			</li>
            <?php endif;?>
            <li class="sidebar-spacer">&nbsp;</li>
            <li class="treeview">
				<a href="">
					<i class="fa fa-database fa-lg"></i>
					<span>Data Referensi</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="master/partai"><i class="fa"></i>Partai</a></li>
					<li><a href="master/organisasi"><i class="fa"></i>Organisasi</a></li>
					<li><a href="admin/master/index/pendidikan"><i class="fa"></i>Pendidikan</a></li>
                    <li><a href="admin/master/index/agama"><i class="fa"></i>Agama</a></li>
                    <li><a href="admin/master/index/profesi"><i class="fa"></i>Profesi</a></li>
                    <li><a href="admin/master/index/ts_jabatan"><i class="fa"></i>Jabatan Timses</a></li>
				</ul>
			</li>

			<?php if($this->cms->has_admin("admin/konfigurasi/")):?>
			<li class="treeview">
                <a href="<?= base_url()?>admin/config">
					<i class="fa fa-cogs fa-lg"></i> <span>Konfigurasi</span>
				</a>
            </li>
            <?php endif;?>
            
			 <?php if($this->cms->has_admin("admin/group/") || $this->cms->has_admin("admin/acl/") || $this->cms->has_admin("admin/user/")):?>
			 <li class="treeview">
				<a href="#">
					<i class="fa fa-lock fa-lg"></i>
					<span>Account Manager</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_admin("admin/user/")): ?><li><a href="admin/user/"><i class="fa"></i>Users</a></li><?php endif;?>
					<?php if($this->cms->has_admin("admin/group/")): ?><li><a href="admin/group"><i class="fa"></i>Groups</a></li><?php endif;?>
					<!--<li><a href="setting/module/"><i class="fa fa-angle-double-right"></i>  Module</a></li>-->
					<?php if($this->cms->has_admin("admin/acl/")): ?><li><a href="admin/acl"><i class="fa"></i>ACL Groups </a></li><?php endif;?>
				</ul>
			</li>
			<?php endif;?>
        </ul>
    </section>
</aside>



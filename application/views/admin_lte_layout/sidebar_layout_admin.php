<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
		   <?php if($this->cms->has_view("admin/dashboard/")): ?>

		   <li class="treeview active">
				<a href="#">
				<i class="fa fa-line-chart fa-lg"></i>
					<span>Dashboard</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
				
					<li><a href="admin/dashboard/"><i class="fa"></i>Dashboard Utama</a></li>
					<li><a href="home/petax"><i class="fa"></i>Dashboard Peta</a></li>
					
				</ul>

			</li>
           
			<?php endif; ?>

		
			<?php //if($this->cms->has_view("admin/peta_data/")): ?>
            <!--
			<li>
                <a href="map/view/">
                    <i class="fa fa-globe fa-lg"></i> <span>Peta Konflik</span>
                </a>
            </li>
			-->
			<?php //endif; ?>

			<?php //if($this->cms->has_view("admin/dashboard/")): ?>
           <li class="active">
                <a href="registrasi/jkpp">
				<i class="fa fa-clone fa-lg" aria-hidden="true"></i>


					<span>Daftar Kelola Konflik</span>
                </a>
            </li>

			
			<?php //endif; ?>

			<?php if($this->cms->has_view("admin/wikera/") or $this->cms->has_view("admin/tp/")): ?>
            <li class="treeview">
				<a href="#">
					<i class="fa fa-map-o fa-lg"></i>
					<span>Peta Dasar</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/wikera/")): ?>
					<li><a href="wikera/jenis"><i class="fa"></i>Peta Tematik</a></li>
					<?php endif; ?>
				</ul>
			</li>
			<?php endif; ?>
			<li class="sidebar-spacer">&nbsp;</li>
             <li class="treeview">
				<a href="#">
					<i class="fa fa-book fa-lg"></i>
					<span>Pustaka</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php //if($this->cms->has_view("admin/master_sektor/")): ?>
					<li><a href="admin/pp"><i class="fa"></i>Peraturan Kebijakan</a></li>
					<?php //endif; ?>
					<?php //if($this->cms->has_view("admin/master_konflik/")): ?>
					<li><a href="admin/hp"><i class="fa"></i>Hasil Penelitian</a></li>
					<?php //endif; ?>
				 </ul>
			
            <li class="sidebar-spacer">&nbsp;</li>
			<?php if($this->cms->has_view("admin/data_master/")):?>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-puzzle-piece fa-lg"></i>
					<span>Data Master</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<?php if($this->cms->has_view("admin/master_sektor/")): ?>
					<li><a href="master_data/sektor"><i class="fa"></i>Sektor</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/master_konflik/")): ?>
					<li><a href="master_data/konflik"><i class="fa"></i>Konflik</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/master_tahapan/")): ?>
					<li><a href="master_data/tahapan"><i class="fa"></i>Tahapan Usulan</a></li>
					<?php endif; ?>
                    <li><a href="master_data/cat_pp"><i class="fa"></i>Kategori Publikasi</a></li>
                    <li><a href="master_data/layer_pd"><i class="fa"></i>Group Peta Dasar</a></li>
                    <li><a href="master_data/layer_wk"><i class="fa"></i>Group Wilayah Kelola</a></li>
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
					
					<?php if($this->cms->has_view("admin/news/")): ?>
                    <li><a href="content/news"><i class="fa"></i>News</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/profil_jkpp/")): ?>
                    <li><a href="content/profiles"><i class="fa"></i>Profil</a></li>
					<?php endif; ?>
					<?php if($this->cms->has_view("admin/layanan_jkpp/")): ?>
                    <li><a href="content/layanan"><i class="fa"></i>Pelaporan</a></li>
					<?php endif; ?>
                    
					<?php if($this->cms->has_view("admin/buku_tamu/")): ?>
                    <li><a href="content/buku_tamu"><i class="fa"></i>Buku Tamu</a></li>
					<?php endif; ?>
				</ul>

			</li>
			<?php endif; ?>
            
            

			<?php if($this->cms->has_admin("admin/account_manager/")): ?>
      <li class="sidebar-spacer">&nbsp;</li>
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

        </ul>
    </section>
</aside>

<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <!--<div class="user-panel">
                        <div class="pull-left image">
                            <img src="assets/themes/admin_lte/img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, Jane</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>-->
                    <!-- search form -->
                    <!--<form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>-->
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <?php //if($this->cms->has_read("admin/dashboard")):?>
                        <li class="active">
                            <a href="admin/dashboard/">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                      <? //endif; ?>  
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-puzzle-piece"></i>
                                <span>Wilayah Adat</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
								<li><a href="register/register"><i class="fa"></i>User List </a></li>
                                <li><a href="wa_reg/wa_reg"><i class="fa"></i>Pengajuan Baru</a></li>
                                <li><a class="mnu_reg" href="reg"><i class="fa"></i>Registrasi</a></li>
                                <li><a class="mnu_ver" href="ver"><i class="fa"></i>Verifikasi </a></li>
								<li><a class="mnu_ser" href="ser"><i class="fa"></i>Sertifikasi </a></li>
								<li><a class="mnu_keberatan" href="keberatan"><i class="fa"></i>Pengajuan Keberatan </a></li>
                            </ul>
                        </li>
                        
                         <?php //if($this->cms->has_read("admin/batas_wilayah")):?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-code"></i>
                                <span>Web Content</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin/slider"><i class="fa"></i>Carousel</a></li>
                                <li><a href="admin/news"><i class="fa"></i>Berita </a></li>
								<li><a href="admin/articles"><i class="fa"></i>Artikel </a></li>
								<li><a href="admin/rss"><i class="fa"></i>RSS </a></li>
                            </ul>
                        </li>
                        <? //endif; ?>
                        
                         <?php //if($this->cms->has_read("admin/rpt")):?>
                         <li class="treeview">
                            <a href="#">
                                <i class="fa fa-file-o"></i>
                                <span>Web Pages</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
								<li><i class="fa"></i><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BRWA</b> </li>
                                <li><a href="admin/pages/index/pbrwa"><i class="fa"></i>Profil </a></li>
                                <!--<li><a href="admin/pages/index/kbrwa"><i class="fa"></i>Kantor</a></li>-->
								<li><a href="admin/regulasi"><i class="fa"></i>Regulasi </a></li>
								<li><a href="admin/rujukan"><i class="fa"></i>Rujukan </a></li>
								<!--<li><a href="admin/pages/index/kontak"><i class="fa"></i>Kontak </a></li>-->
								<li><a href="admin/pages/index/kepengurusan_brwa"><i class="fa"></i>Kepengurusan BRWA </a></li>
								<li><i class="fa"></i><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pendaftaran</b> </li>
                                <li><a href="admin/pages/index/psdbrwa"><i class="fa"></i>Prosedur</a></li>
								<li><i class="fa"></i><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Layanan</b> </li>
                                <li><a href="admin/pages_"><i class="fa"></i>SLPP</a></li>
								<li><a href="admin/pages_UKP3_/"><i class="fa"></i>UKP3</a></li>
								
                            </ul>
                        </li>
                        <?php //endif;?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-link"></i>
                                <span>Web Links</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
								<li><a href="admin/link_manager/category_list"><i class="fa"></i>Category</a></li>
								<li><a href="admin/link_manager/link_list"><i class="fa"></i>Link</a></li>
                            </ul>
                        </li>
                         <?php //if($this->cms->has_read("master_data")):?>
                         <li class="treeview">
                            <a href="#">
                                <i class="fa fa-th"></i>
                                <span>Master Data</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            
                            <ul class="treeview-menu">
                                <li><a href="master_data/entitas"><i class="fa"></i>Entitas</a></li> 
                                <li><a href="master_data/jenis_ekosistem"><i class="fa"></i>Jenis Ekosistem</a></li>
                                <li><a href="master_data/jenis_document"><i class="fa"></i>Jenis Dokumen</a></li>
                                <li><a href="master_data/kondisi_fisik"><i class="fa"></i>Kondisi Fisik</a></li>                                
                                <li><a href="master_data/potensi_hayati"><i class="fa"></i>Potensi Hayati</a></li>
                                <li><a href="master_data/satuan"><i class="fa"></i>Satuan</a></li>
                                <li><a href="master_data/document"><i class="fa"></i>Dokumen</a></li>
                                <li><a href="master_data/tanda_pengenal"><i class="fa"></i>Tanda Pengenal</a></li>
                            </ul>
                        </li>
                        <?php //endif;?>
                        
                        
                         <?php //if($this->cms->has_read("setting")):?>
                         <li class="treeview">
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                <span>Account Manager</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin/account_manager/"><i class="fa"></i>Users</a></li>
                                <li><a href="admin/account_manager/group_list"><i class="fa"></i>Groups</a></li>
                                <!--<li><a href="setting/module/"><i class="fa fa-angle-double-right"></i>  Module</a></li>-->
                                <li><a href="admin/acl"><i class="fa"></i>ACL Groups </a></li>
                            </ul>
                        </li>
                        <?php //endif;?>
                        
                      <?php //if($this->cms->has_read("admin/dashboard")):?>
                        <li class="active">
                            <a href="admin/config_/">
                                <i class="fa fa-briefcase"></i> <span>Configuration</span>
                            </a>
                        </li>
                      <? //endif; ?>  
                        <?php //endif;?>
                        
                        
                        <!--
                        <li>
                            <a href="pages/widgets.html">
                                <i class="fa fa-th"></i> <span>Widgets</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Charts</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                                <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                                <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>UI Elements</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> General</a></li>
                                <li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> Icons</a></li>
                                <li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                                <li><a href="pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                                <li><a href="pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Forms</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> General Elements</a></li>
                                <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Advanced Elements</a></li>
                                <li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Editors</a></li>                                
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Tables</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/tables/simple.html"><i class="fa fa-angle-double-right"></i> Simple tables</a></li>
                                <li><a href="pages/tables/data.html"><i class="fa fa-angle-double-right"></i> Data tables</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="pages/calendar.html">
                                <i class="fa fa-calendar"></i> <span>Calendar</span>
                                <small class="badge pull-right bg-red">3</small>
                            </a>
                        </li>
                        <li>
                            <a href="pages/mailbox.html">
                                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                                <small class="badge pull-right bg-yellow">12</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Examples</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                                <li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                                <li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                                <li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                                <li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                                <li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>                                
                                <li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
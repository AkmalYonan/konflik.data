				<div class="antiScroll">
					<div class="antiscroll-inner" style="width: 257px; height: 383px;">
						<div class="antiscroll-content" style="height: 383px;">
					
							<div class="sidebar_inner" style="margin-bottom: -92px; min-height: 100%;">
								<form method="post" class="input-append" action="index.php?uid=1&amp;page=search_page">
									<input type="text" placeholder="Search..." size="16" class="search_query input-medium" name="query" autocomplete="off"><button class="btn" type="submit"><i class="icon-search"></i></button>
								</form>
								<div class="accordion" id="side_accordion">
									
									<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#side_accordion" href="#collapseOne">
												<i class="icon-folder-close"></i> Content
											</a>
										</div>
										<div id="collapseOne" class="accordion-body collapse">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="javascript:void(0)">Articles</a></li>
													<li><a href="admin/news/">News</a></li>
													<li><a href="javascript:void(0)">Newsletters</a></li>
													<li><a href="javascript:void(0)">Comments</a></li>
												</ul>
											</div>
										</div>
									</div>
                                    
                                    <!-- LINK MANAGER -->
                                    <div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#side_accordion" href="#link_manager">
												<i class="icon-th"></i> Link/Directory Manager</a>
										</div>
										<div id="link_manager" class="accordion-body collapse">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="admin/link_manager/category_list">Category</a></li>
                                                    <li><a href="admin/link_manager/link_list">Link</a></li>
                                                    <li><a href="admin/link_manager/">Index</a></li>
												</ul>
											</div>
										</div>
									</div>
                                    <!-- END LINK MANAGER -->
                                    
                                    
                                    <!-- PP -->
                                    <div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#side_accordion" href="#pp">
												<i class="icon-th"></i> Peraturan & Perundangan</a>
										</div>
										<div id="pp" class="accordion-body collapse">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="admin/pp/category_list">Category</a></li>
                                                    <li><a href="admin/pp/pp_list">PP</a></li>
                                                    <li><a href="admin/pp/">Index</a></li>
												</ul>
											</div>
										</div>
									</div>
                                    <!-- END PP -->
                                    
									<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#side_accordion" href="#collapseTwo">
												<i class="icon-th"></i> Modules
											</a>
										</div>
										<div id="collapseTwo" class="accordion-body collapse">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="javascript:void(0)">Content blocks</a></li>
													<li><a href="javascript:void(0)">Tags</a></li>
													<li><a href="javascript:void(0)">Blog</a></li>
													<li><a href="javascript:void(0)">FAQ</a></li>
													<li><a href="javascript:void(0)">Formbuilder</a></li>
													<li><a href="javascript:void(0)">Location</a></li>
													<li><a href="javascript:void(0)">Profiles</a></li>
												</ul>
											</div>
										</div>
									</div>
                                    <? 
										$class_dms_heading="";
										$class_dms_collapse="";
										if(isset($acc_active)):
											if($acc_active=="dms"):
												$class_dms_heading=" sdb_h_active ";
												$class_dms_collapse=" in ";
											endif;
										endif;
									?>
                                    <div class="accordion-group" id="dms">
										<div class="accordion-heading  <?php echo $class_dms_heading?> ">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#side_accordion" href="#dms_child">
												<i class="icon-user"></i> Document Management System
											</a>
										</div>
										<div id="dms_child" class="accordion-body collapse <?php echo $class_dms_collapse?>">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="admin/dms/doc_list/">Document List</a></li>
                                                     <li><a href="admin/dms/doc_ck_in/">Check-in List</a></li>
                                                    <li><a href="admin/dms/category_list/">Category</a></li>
                                                    <li><a href="admin/dms/dms_admin/">Setting</a></li>
													<!--<li><a href="admin/dms/doc_type_list/">Document Type</a></li>-->
                                                    <li><a href="admin/dms/access_log/">Access Log</a></li>
												</ul>
												
											</div>
										</div>
									</div>
                                    
                                    <? 
										$class_acm_heading="";
										$class_acm_collapse="";
										if(isset($acc_active)):
											if($acc_active=="account_manager"):
												$class_acm_heading="sdb_h_active";
												$class_acm_collapse="in";
											endif;
										endif;
									?>
									<div class="accordion-group" id="account_manager">
										<div class="accordion-heading  <?php echo $class_acm_heading?>">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#side_accordion" href="#collapseThree">
												<i class="icon-user"></i> Account manager
											</a>
										</div>
										<div id="collapseThree" class="accordion-body collapse <?php echo $class_acm_collapse?>">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li><a href="admin/account_manager/">Users</a></li>
													<li><a href="admin/auth/list_group/">Groups</a></li>
												</ul>
												
											</div>
										</div>
									</div>
									<div class="accordion-group">
										<div class="accordion-heading">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#side_accordion" href="#collapseFour">
												<i class="icon-cog"></i> Configuration
											</a>
										</div>
										<div id="collapseFour" class="accordion-body collapse">
											<div class="accordion-inner">
												<ul class="nav nav-list">
													<li class="nav-header">People</li>
													<li class="active"><a href="javascript:void(0)">Account Settings</a></li>
													<li><a href="javascript:void(0)">IP Adress Blocking</a></li>
													<li class="nav-header">System</li>
													<li><a href="javascript:void(0)">Site information</a></li>
													<li><a href="javascript:void(0)">Actions</a></li>
													<li><a href="javascript:void(0)">Cron</a></li>
													<li class="divider"></li>
													<li><a href="javascript:void(0)">Help</a></li>
												</ul>
											</div>
										</div>
									</div>
									
								</div>
								
								<div class="push" style="height: 92px;"></div>
							</div>
							   
							<div class="sidebar_info" style="height: 92px;">
								<ul class="unstyled">
									<li>
										<span class="act act-warning">65</span>
										<strong>New comments</strong>
									</li>
									<li>
										<span class="act act-success">10</span>
										<strong>New articles</strong>
									</li>
									<li>
										<span class="act act-danger">85</span>
										<strong>New registrations</strong>
									</li>
								</ul>
							</div> 
						
						</div>
					</div>
				<div class="antiscroll-scrollbar antiscroll-scrollbar-vertical" style="height: 205.896px; top: 0px;"></div></div>
                
                
                
                
               
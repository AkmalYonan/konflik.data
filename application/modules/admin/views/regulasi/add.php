
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <!-- start: page header -->
        <div class="page-header">
            <div class="row"> 
                <div class="col-md-12">
                    <h1>Regulasi<small> Add </small></h1>
                </div><!-- col -->
            </div><!-- row-->
        </div><!-- end: page-header -->
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
            <li><a href="<?=base_url()?>admin/"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li><a href="<?=$this->folder?>">Content</a> <span class="divider"></span></li>
			<li><a href="<?=$this->folder?>"><?=$this->module_title?></a> <span class="divider"></span></li>
            <li class="active">Add</li>
         </ul>
        <!-- end: breadcrumbs -->
   </div><!-- cols -->
</div> <!-- row -->

                        
<div style="padding:0px">
<div class="row topbar box_shadow">
    <div class="col-md-12">
            <ul class="tab-bar grey-tab">
                <li>
                    <a href="<?php echo $this->module?>">
                        <span class="block text-center">
                            <i class="icon-list"></i> 
                        </span>
                        Daftar <?=$this->module_title?>
                    </a>
                </li>
                <li class="active">
                    <a href="<?php echo $this->module?>add">
                        <span class="block text-center">
                            <i class="icon-plus"></i> 
                        </span>
                        Input <?=$this->module_title?>
                    </a>
                </li>
            </ul>
    	<!--<form class="search_form col-md-3 pull-right" action="<?=$this->module?>listview" method="get">
        	<?php //$this->load->view("widget/search_box_db"); ?>
        </form>-->
    </div>
</div>
<div class="row-fluid">
<ul class="nav nav-tabs" id="news-tab">
   <li class="active"><a href="#tab-edit" class="a_view"><i class="icon-plus"></i> Add</a></li>
</ul>
<!--tab content-->
<div class="tab-content">
    
<div id="tab-edit" class="tab-pane active">    
  <form action="<?=$module;?>add" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="author" value="<?=$user_name;?>" />
	<input type="hidden" name="category" value="1017" />
    <div class="row">
	    <div class="col-md-8">
            <div class="row">
                <div class="col-md-8">
                    <label>File Title</label>
                    <input type="text" id="title" name="title" class="form-control input-xs required" placeholder="title" value="<?=$data['title'];?>" />
				</div>
				 <div class="col-md-8">
                    <label>File Ket.</label>
                   <textarea class="form-control input-xxlarge" id="keterangan" name="keterangan" ><?=$data['keterangan'];?></textarea>
				</div>
            </div>
        </div>
		<div class="col-md-8">
            <div class="row">
                <div class="col-md-8">
                    <label>File <span class="help-block" style="display:inline">(Max filesize: 500kb)</span></label>
                    <input type="file" name="image_name"/>
				</div>
            </div>
        </div>

	    <div class="col-md-8">
                <div class="row">
					<div class="col-md-8">
                      <div style="padding-top:10px;" class="span12">
                        <? $checked=($data['status'])?" checked":""; ?>
                        <label>
                            <input type="checkbox" value="1" name="status"<?=$checked;?> />
                            Publish
                        </label>
                      </div>
					</div>  
                </div>
        </div> 
    </div>
    <br />
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
  </form>
</div>

</div>
<!-- en tab-content-->
</div>
</div>

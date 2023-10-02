<? $id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx]; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$this->module_title?>
    <small>Edit Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin/dashboard"><i class="fa fa-chain"></i> Home</a></li>
    <li><a href="admin/link_manager/category_list"> <?=$this->module_title?></a></li>
    <li class="active">Edit Category</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">

            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>category_list">
                    <i class="fa fa-bars"></i> Daftar Category
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>category_add" id="addData">
                <i class="fa fa-plus"></i> Input Category
            </a>
            <a class="btn btn-app bg-purple" href="<?php echo $this->module?>category_list" id="refresh">
                <i class="fa fa-refresh"></i> Refresh
            </a>


            <?php echo message_box();?>
            <form id="frm" method="post" action="<?php echo $this->module;?>category_edit/<?php echo $data["idx"];?>" class="form-horizontal">
                <input type="hidden" name="act" id="act" value="update"/>

                <div class="box box-default">
                    <div class="box-header with-border">
                      <h3 class="box-title">Edit Data</h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="category" class="control-label">Category</label>
                                        <div class="controls">
                                            <input type="text" id="category" name="category" class="form-control input-xlarge required" value="<?php echo $data["category"];?>" />
                                        </div>
                                    </div><!-- /control-group category-->
                                 
                                <!-- control-group category-->
                                     <div class="col-md-12">
                                        <label for="description" class="control-label">Description</label>
                                        <div class="controls">
                                            <textarea class="form-control input-xxlarge" id="description" name="description"><?php echo $data["description"]?></textarea>
                                        </div>
                                    </div><!-- /control-group description-->
                                    
                                </div>

                                <div class="col-md-12 form-group">
                                    <label>
                                      <input type="checkbox" class="minimal" <?=$data["publish"]==1?"checked":""?> id="publish" name="publish" value="1" />
                                        Publish
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="reset" class="btn">Batal</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</section>



<script>
	$(function(){
		var act_link="<?=$this->module?>category";	
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	})
</script>
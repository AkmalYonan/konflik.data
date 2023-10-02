
<div class="row ">
    <div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<h1>Input <small>SKPD</small></h1>
		</div><!-- col -->
        
        <!-- start: breadcrumbs -->
         <ul class="breadcrumb">
             <li><a href="<?=base_url()?>"><i class='icon-home blue'></i> Home</a> <span class="divider"></span></li>
            <li class="active">Input SKPD</li>
         </ul>
        <!-- end: breadcrumbs -->

	</div> 
	
	<div class="col-sm-12 col-lg-12">
		<div class="col-md-12">
			<div class="box" style="padding-top:10px;">
			<div class="col-md-12">
				<div class="row topbar box_shadow">
					<div class="col-md-12">
						<div class="rows well well-sm">
							<div style="vertical-align:middle;line-height:25px">
							<a class="btn btn-default" href="<?php echo $this->module?>listview">
								<i class="fa fa-list"></i> List
							</a>
							<a class="btn btn-default active" href="<?php echo $this->module?>add">
								<i class="fa fa-plus"></i> Input
							</a>	  
							<a class="btn btn-default" href="<?php echo $this->module?>add">
								<i class="fa fa-refresh"></i> Refresh
							</a>	
							</div>
						</div>
					</div>
				</div><!-- ./box-body -->
			</div>
			<!-- form start -->
			<?php
			$attributes = array('role' => 'form');

			echo form_open('admin/master/insert', $attributes);
			?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<label>Nama</label>
							<input type="text" id="nama" name="nama" class="form-control" required />
						</div>
					</div>
				</div><!-- /.box-body -->

				<div class="box-footer">
					<button type="submit" name="save" value="Simpan" class="btn btn-primary">Simpan</button>
					<button type="button" class="btn" onclick="window.history.back();return false;">Batal</button>
				</div>
			</form>		

		
		  </div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->	
</div><!-- end div positioning -->

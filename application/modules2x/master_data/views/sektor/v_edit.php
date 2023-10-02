<script src='assets/additional_js/color_palette/spectrum.js'></script>
<link rel='stylesheet' href='assets/additional_js/color_palette/spectrum.css' />
<?php 
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	
	
?>
<section class="content-header">
	<h1>
		<?=$this->parent_module_title?>
		<small><?=$this->module_title?></small>
	</h1>
	<ol class="breadcrumb">
		<li><i class="fa fa-puzzle-piece"></i> <?=$this->parent_module_title?></li>
		<li><a href="<?php echo $this->module?>"><?=$this->module_title?></a></li>
		<li class="active">Edit</li>
	</ol>
</section>
<section class="content">
	<div class="row">
    	<div class="col-md-12">
        	<? if (message_box()) :?><?php echo message_box();?><? endif; ?>
        	<div class="content-toolbar">
                <a class="btn btn-white" href="<?php echo $this->module?>" data-toggle='tooltip' title="List">
                    <i class="fa fa-list"></i>
				</a>
				<a class="btn btn-white" href="<?php echo $this->module?>edit/<?php echo $id;?>" data-toggle='tooltip' title="Refresh">
					<i class="fa fa-refresh"></i>
				</a>
				<a class="btn btn-white btn-save" href="" data-toggle='tooltip' title="Save">
					<i class="fa fa-check"></i>
				</a>
				<a class="btn btn-white btn-delete" href="<?php echo $this->module?>" data-toggle='tooltip' title="Cancel/Back To List">
					<i class="fa fa-remove"></i>
				</a>	  
            </div>
        	<div class="box box-widget">
                <div class="box-body">
                <form id="frm" method="post" action="<?php echo $this->module;?>edit/<?php echo $id;?>">
					<input type="hidden" name="act" id="act" value="update"/>
					<input type="hidden" name="idx" id="id" value="<?=$data['idx']?>"/>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="kode_sektor">Kode Sektor</label>
								<input class="form-control required" name="kode" type="text" style="width:50%" value="<?=$data['kode']?>" />
							</div>
							<div class="form-group">
								<label for="ur_sektor">Nama Sektor</label>
								<input class="form-control required" name="uraian" placeholder="" type="text" value="<?=$data['uraian']?>" >
							</div>
							<div class="form-group">
								<label for="color_sektor">Warna Sektor</label><br />
								<input type="text" name="color" id="color" value="<?=$data['color']?>">
							</div>
							<div class="form-group">
								<label for="status_sektor">Status</label>
								<br />
								<input type="radio" name="status" value="1" <?=($data['status']==1)?"checked='checked'":""?> />&nbsp;Aktif<br />
								<input type="radio" name="status" value="0" <?=($data['status']==0)?"checked='checked'":""?> />&nbsp;Tidak Aktif
							</div>
						</div>
					</div>
                    <!-- /.col -->
                    <div class="col-md-6">
                      	<!-- KOSONG -->
                    </div>
                    <!-- /.col -->
                </form>
				</div>
                  <!-- /.row --> 
			</div>
        </div>
    </div>
</section>
<script language="javascript">
$(document).ready(function(){      
	$('#prov').change(function(){
		$.post("<?php echo base_url();?>admin/pegawai/get_city/"+$('#prov').val(),{},function(obj){
			$('#kab').html(obj);
		});
    });
	$("#previewplay").click(function(){
		$("#imgInpPlay").trigger("click");
	});
});
function readURLplay(input) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
			reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
				$('#previewplay').attr('width', '180px');
                //$('#previewplay').attr('height', '200px');
            }
			 reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
</script>
<script>
	$(function(){
		$("#frm").validate();
		
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href$='"+act_link+"']").parent("li").addClass("active");
		
		$(".group").click(function(){
			//$("#company").prop("disabled",$(this).data('org')==1 ? false: true);
			var use_org = $(this).data('org');
			$("#company").val(use_org);
			$("#company option").show();
			$("#company option").each(function(){
				if (!use_org) {
					$(this).val()!=0?$(this).hide():$(this).show();
				}
				else {
					$(this).val()!=0?$(this).show():$(this).hide();
				}
			});
		});
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
		  checkboxClass: 'icheckbox_flat-green',
		  radioClass: 'iradio_flat-green'
		});
	})
</script>

<script>
$(document).ready(function(){
    
    var palette =   [
            ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
            "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
            ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
            "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
            ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
            "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
            "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
            "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
            "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
            "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
            "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
            "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
            "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
            "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
        ];
      
		$("#color").spectrum({
			color: "<?=$data['color']?>",
			showInput: true,
			className: "full-spectrum",
			showInitial: true,
			showPalette: true,
			showSelectionPalette: true,
			maxSelectionSize: 10,
			preferredFormat: "hex",
			localStorageKey: "spectrum.demo",
			/*
			move: function (color) {
	
			},
			show: function () {

			},
			beforeShow: function () {

			},
			hide: function () {

			},
			*/
			change: function() {
				var color   =   $(this).val();
				$(this).val(color);
			},
			palette: palette,
		});
});
</script>   


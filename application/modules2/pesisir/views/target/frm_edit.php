<script src='assets/additional_js/color_palette/spectrum.js'></script>
<link rel='stylesheet' href='assets/additional_js/color_palette/spectrum.css' />
<input type="hidden" name="author" value="<?=$user_name;?>" />
    <div class="row">
	    <div class="col-md-7">
            <div class="row">
				<div class="col-md-5">
					<div class="form-group">
                        <label for="nama">Group</label>
						<? echo form_dropdown("kd_group",$this->lookup_map_group,$data['kd_group'],"id='kd_group' class='form-control lookup alamat-r' data-target='kabupaten' data-url='kabupaten'");?>
                    </div>
				</div>
                <div class="col-md-7">
                	<div class="pull-right">
                    	<? $checked=($data['status'])?" checked":""; ?>
                    <label>
                        <input type="checkbox" value="1" name="status"<?=$checked;?> />
                        Publish
                    </label>
                    </div>
                    <label>Wilayah Kelola</label>
                    <input type="text" id="title" name="ur_layer" class="form-control required" value="<?=$data['ur_layer'];?>" />
                </div>
            </div>
            <div class="row">
				<div class="col-md-12">
                	<div class="form-group">
					<label>Deskripsi</label>
					<textarea name="description" id="clip" class="form-control" rows="3" placeholder="..."><?=$data['description'];?></textarea>
					</div>
                </div>
            </div>
            <div class="row">
				<div class="col-md-5">
					<div class="form-group">
                        <label for="nama">Tipe Layer</label>
						<select name="layer_type" class='form-control'>
                        	<option value="POLYGON">POLYGON</option>
                        </select>
                    </div>
				</div>
                <div class="col-md-2">
                    <label>Color</label><br />
                    <input type="text" id="color" name="layer_color" value="<?=$data['layer_color']?$data['layer_color']:'#dddddd';?>" />
                </div>
                <div class="col-md-2">
                    <label>Outline</label><br />
                    <input type="text" id="outline_color" name="layer_outline_color" value="<?=$data['layer_outline_color']?$data['layer_outline_color']:'#333333';?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Lampiran file Peta (Format: Zip file Contain .shp,.dbf,.shx) /  (Maks Size: 30mb)</label>
					<div class="well well-sm" style="position:relative"><div id="pct" style="position:absolute;font-size:50px; line-height:40px;color:#ddd; right:0">0%</div>
                    <div class="progress progress-xxs" style="margin-bottom:10px; margin-top:-10px">
                    <div id="upload-progress" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                      <span class="pb sr-only">0% Complete (warning)</span>
                    </div>
                  </div>
                    <div class="row">
                        <div class="col-md-2 col-xs-12">
                            <div id="container">
                                <a id="pickfiles" class="btn btn-primary" href="javascript:;">[Select files]</a>
                                <a id="uploadfiles" class="hidden" href="javascript:;">[Upload files]</a>
                            </div>
                        </div>
                        <div class="col-md-10 col-xs-12" id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                    </div>
                    <input type="hidden" id="file_name" name="filename" />
                    </div>
                </div>
            </div>
            
        </div>
	    <div class="col-md-5">
            <div class="row">
            	<div class="col-md-12">
                        <label for="nama">ATRIBUT DATA</label>
				</div>
            </div>
            <div class="row">
            	<div class="col-md-12">
				<?php
                    if (cek_array($all_fields)) :
                    foreach($all_fields as $k=>$v) :
                    ?>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="layer_fields[]" value="<?=$v?>"<?=in_array($v,$layer_fields)?' checked="checked"':''?>>
                        <?=$v?>
                      </label>
                    </div>
                    <?php
                    endforeach;
                    endif;
                ?>
            	</div>
            </div>
        </div> 
    </div>
    
    
    
	<div class="form-actions hidden">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
    <br />
   </div>
   
   <script>
   	$(function(){
		$("#title").blur(function(){
				$("#s_title").text($(this).val());
		});	
		
		$("#news_clip").blur(function(){
				$("#s_lead").text($(this).val());
		});	
		
		$("#buttontext").blur(function(){
				$("#s_button").text($(this).val());
		});	
		
	});
   </script>
   
   
   <script>
	function readURLplay(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewplay').attr('src', e.target.result);
                $('#previewplay').attr('width', '300px');
                $('#previewplay').attr('height', '200px');
            }
             reader.readAsDataURL(input.files[0]);
        }
    }
   
    $("#imgInpPlay").change(function(){
        readURLplay(this);
    });
	
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
      
		$("#color,#outline_color").spectrum({
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
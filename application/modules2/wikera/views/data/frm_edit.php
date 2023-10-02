<input type="hidden" name="author" value="<?=$user_name;?>" />
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">WILAYAH KELOLA</a></li>
  <li role="presentation"><a href="#profile" role="tab" data-toggle="tab">PETA SPASIAL</a></li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    	<div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-7">
                        <label>Jenis Wilayah Kelola</label>
                            <? echo form_dropdown("kd_layer",$this->lookup_map_layer,$data['kd_layer'],"id='kd_layer' class='form-control'");?>
                    	<input type="text" id="title" name="ur_layer" value="<?=$this->lookup_map_layer[$data['kd_layer']]?>" />
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nama">Group</label>
                            <? echo form_dropdown("kd_group",$this->lookup_map_group,$data['kd_group'],"id='kd_group' class='form-control'");?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                        <label>Subject/Nama Wilayah Kelola</label>
                        <input type="text" id="title" name="ur_wilayah" class="form-control required" value="<?=$data['ur_wilayah'];?>" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label>Luas</label>
                            <input type="text" id="luas" name="luas" class="form-control required" value="<?=$data['luas'];?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label>Profil</label>
                        <textarea name="profile" id="profilex" class="form-control required" rows="3" placeholder="Enter ..."><?=$data['profile'];?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="propinsi">Provinsi</label>
                            <? echo form_dropdown("kd_prop",$lookup_propinsi,$kd_prop,"id='propinsi' class='form-control lookup alamat-r' data-target='kabupaten' data-url='kabupaten'");?> 
                          </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                        <label for="kabupaten">Kab/Kota</label>
                        <? echo form_dropdown("kd_kab",$lookup_kabupaten,$kd_kab,"id='kabupaten' class='form-control lookup alamat-r' data-target='kecamatan' data-url='kecamatan'");?>  
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label for="kabupaten">Kecamatan</label>
                            <input type="text" id="kd_kec" name="kd_kec" class="form-control required" value="<?=$data['ur_layer'];?>" />
                      </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                        <label for="kabupaten">Tahapan</label>
                        <? echo form_dropdown("tahapan",$lookup_kabupaten,$data['tahapan'],"id='kabupaten' class='form-control lookup alamat-r' data-target='kecamatan' data-url='kecamatan'");?>  
                      </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                          <? $checked=($data['status'])?" checked":""; ?>
                          <label>&nbsp;</label><br />
                        <label> Data Valid?
                            <input type="checkbox" class="flat-green" value="1" name="status"<?=$checked;?> />
                        </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <label>Data Pendukung</label>
                            <input type="text" id="data_pendukung" name="data_pendukung" class="form-control" value="<?=$data['data_pendukung'];?>" />
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nama">Sumber data</label>
                            <input type="text" id="sumber" name="sumber" class="form-control" value="<?=$data['sumber'];?>" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nama">Nomor</label>
                            <input type="text" id="sk_nomor" name="sk_nomor" class="form-control" value="<?=$data['sk_nomor'];?>" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Tahun</label>
                            <input type="text" id="sk_tahun" name="sk_tahun" class="form-control" value="<?=$data['sk_tahun'];?>" />
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <label>Tentang</label>
                        <textarea name="sk_tentang" id="sk_tentang" class="form-control required" rows="3" placeholder="SK ..."><?=$data['sk_tentang'];?></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <label>File</label>
                        	
                            <!--<input type="file" id="imgInpPlay" name="sk_file" class="form-control" value="<?=$data['sk_file'];?>" />-->
                    </div>
                </div>
                
                
            </div> 
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="profile">
    	<div class="row">
        	<div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div id="ct_form">
                            <div class="row">
                                <div class="col-md-12 frm">
                                    <!-- dummy submitter -->
                                    <div id="submitter1" class="row hide">
                                        <div class="col-md-6">
                                            <table class="table">
                                                <tr>
                                                    <td>File Peta</td><td><div class="plupload_progress_bar_0"></div></td><td><div class="plupload_progress_text_0"></div></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>Lampiran file Peta (Format: GEOJSON)</label>
                                            <input id="imgInpPlay" type="file" name="up_file" class="form-control" style="padding:0; margin:-2px" /><label>Ukuran File Maksimal: 1.2M</label>
                                            <textarea id="text" class="hidden"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?=$this->load->view("map/v_view_spasial");?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="messages">...</div>
    <div role="tabpanel" class="tab-pane" id="settings">...</div>
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
var form = '#fdata_update';
var oload = false;
$(document).ready(function(){
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  if($(this).parent().index()==1 && !oload) {
	  	init();
		oload=true;
	  }
	})
});
function refreshMap(act) { 
	$("#map_container").attr("src", "wikera/data/spasial_view/YTJr");
	if (act) {
		$(".submitter").removeClass("hide");
		$("#submitter1").addClass("hide");
		$("#lampiran_peta").val("");

		$(".fdata_").addClass('hide');
		form = act;
		$(form).removeClass('hide');
	}
	//$("#map_container").contentWindow.location.reload(true);
}
</script>   
<script>
function readText(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
		   var text = reader.result;
		   $('#text').val(text);
		   deserialize(text);
		}
		reader.readAsText(input.files[0]);
	}
}   
$("#imgInpPlay").change(function(){
	readText(this);
});
</script>
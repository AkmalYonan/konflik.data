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
                    <label>Wilayah Kelola</label>
                    <input type="text" id="title" name="ur_layer" class="form-control required" value="<?=$data['ur_layer'];?>" />
                </div>
            </div>
            <div class="row">
				<div class="col-md-12">
					<label>Deskripsi</label>
					<textarea name="description" id="clip" class="form-control required" rows="3" placeholder="Enter ..."><?=$data['description'];?></textarea>
				</div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <? $checked=($data['status'])?" checked":""; ?>
                    <label>
                        <input type="checkbox" value="1" name="status"<?=$checked;?> />
                        Publish
                    </label>
                    </div>
                </div>
            </div>
        </div>
	    <div class="col-md-5">
                
            <!--</div>--> <!-- form separator -->
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
</script>
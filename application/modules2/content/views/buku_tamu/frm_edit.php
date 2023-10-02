<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<!--<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>-->
<script type="text/javascript" src="assets/js/plugin/ckeditor4.4.2/ckeditor.js"></script>
<script type="text/javascript" src="assets/js/plugin/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/pluploader.js"></script>
<script type="text/javascript" src="http://www.plupload.com/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<input type="hidden" name="author" value="<?=$user_name;?>" />
    <div class="row">
		
	    <div class="col-md-9">
            <div class="row" style="padding-bottom:4px;">
                <div class="col-md-1">
                    <p><strong>From  :</strong></p>
                </div>
                <div class="col-md-11">
					 <input type="text" id="name" name="name" readonly class="form-control input-xs required" value="<?=$data['name'];?>" />	
				</div>
            </div>
			<div class="row" style="padding-bottom:4px;">
				<div class="col-md-1">
				    <p><strong>Email  :</strong></p>
				</div>	
                
				<div class="col-md-11">
					 <input type="text" name="email" id="nama" readonly class="form-control required" rows="3" placeholder="Enter ..." value="<?=$data['email'];?>">
				</div>
			</div>
            <div class="row" style="padding-bottom:4px;">
                <div class="col-md-1">
					    <p><strong>Subject:</strong></p>
                </div>
				<div class="col-md-11">
					<input type="text" name="subject" id="subject" readonly class="form-control required" rows="3" placeholder="Enter ..." value="<?=$data['subject'];?>">
				</div>
			</div>
			<div class="row hidden">
				<div class="col-md-1"><label for="nama">Tanggal</label></div>
				<div class="col-md-11">
					<?php
						$tgl_berita=$data["created"]?$data["created"]:date("Y-m-d H:i:s");
					?>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="text" id="created_selector" class="input-sm form-control input-date required" value="<?=date("d/m/Y",strtotime($tgl_berita))?>" placeholder="dd/mm/yyyy"/>
						<input type="hidden" id="created" name="created" value="<?=date("Y-m-d",strtotime($tgl_berita));?>" class="required" />
					</div>
				</div>
			</div>
			
            <div class="row" style="padding-bottom:4px;">
				<div class="col-md-1">
					    <p><strong>Uraian   :</strong></p>
                </div>
				<div class="col-md-11">
						<textarea name="comments" id="comments" class="form-control" rows="3"><?=$data['comments'];?></textarea>
				</div>
			</div>
            <!--Hiddeen --->
			<hr />
			<div class="row">
				<div class="col-md-6">
					<label>Silahkan Isi Balasan Anda di bawah ini ! </label>
				</div>
				<div class="col-md-6">
					<div class="pull-right">
					<input type="checkbox" name="publish" value="1"  <?=($data['publish']=1)? "checked='checked'":""?> /> <label>Publish</label>
					</div>
				</div>
			</div>
			<div class="row ">
                <div class="col-md-12">
                    
                    <textarea name="reply" id="reply" cols="10" rows="3" class="col-md-11 ckeditor"><?=$data['reply']?></textarea>
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
</script>
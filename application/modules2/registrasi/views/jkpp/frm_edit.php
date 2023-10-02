<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<!--<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/ckeditor/adapters/jquery.js"></script>-->
<script type="text/javascript" src="assets/js/plugin/ckeditor4.4.2/ckeditor.js"></script>
<script type="text/javascript" src="assets/js/plugin/datepicker/bootstrap-datepicker.js"></script>


<input type="hidden" name="author" value="<?=$user_name;?>" />
<input type="hidden" name="category_id" value="sp" />


<div class="box box-widget">
<div class="box-body">


 
  
			    <input type="hidden" name="c_prop" value="<? echo $propinsi;?>" />
			    <input type="hidden" name="c_kabkot" value="<? echo $kab_kota;?>" />
			    <div class="containerx" style="padding-left:15px !important">
			    	<div class="formSepx">
                    <h2>Import Excel [ .xls ] | [ .xlsx ] | [ .csv ]</h2>
			        <h5>Pilih file excel anda dan upload dilakukan ketika anda klik tombol  <span style="color:#06F">Import</span> </h5>
					
					<h5>Jika anda tidak memiliki template, default file excel  dapat anda <span> <a style="cursor:pointer;" href="docs/konflik_xls/format.xlsx" class="btn-xs btn-flat btn-warning download_template_propinsi" target="_blank">Download template</a></span>  </h5>
				
					<!--
                    <h5>Jika anda tidak memiliki template, default file excel  dapat anda <span> <a style="color:#06F" href="docs/template/Template.xlsx" target="_blank" >Download</a></span>  </h5>
					 <h5>Download <span> <a style="color:#06F" href="docs/template/KODE REFERENSI.xlsx" target="_blank" >Kode Referensi</a></span>  </h5>-->
                   
                    
					</div> <!-- form separator -->
					<div class="row">
						<div class="col-md-6" style="margin:0 a">
						  <div class="row">
								<br />
								<div class="col-md-6">
									 	<input type="file" id="import" name="import" required >
								
                                </div> <!-- span6 -->
								<br />
								<br />
								</div>
							</div>
					</div>
						<!--<div class="formSep">
			            </div> <!-- form separator -->
			    <br />
				</div>
		<div class="modal-footer">
			
		
		
  
 

    
    
	<div class="form-actions hidden">
        <button type="submit" class="btn btn-primary">Save changes</button>
        <button type="reset" class="btn">Cancel</button>
    </div>
   </div>
   </div>
   </div>
   
   
   
  
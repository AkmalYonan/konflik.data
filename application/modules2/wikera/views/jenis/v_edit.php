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
    <li><i class="fa fa-cog"></i> <?=$this->parent_module_title?></li>
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
            </div><!-- end content toolbar -->
            
            <div class="box box-widget">
            	<!--<div class="box-header with-border">
                  <h3 class="box-title">Data User</h3>
                </div>-->
                <div class="box-body">
                    <form id="frm" method="post" action="<?php echo $this->module;?>edit/<?php echo $id;?>" enctype="multipart/form-data">
                      	<input type="hidden" name="act" id="act" value="update"/>
                      	<input type="hidden" name="id" id="id" value="<?php echo $id;?>"/>
						  
						  <?=$this->load->view("frm_edit");?>
						 
                    </form>
                <!-- /.box-body -->
                <div class="box-footer well well-sm no-shadow">
                     Note: Nama Wilayah harus diisi, dan File Spasial harus menggunakan Projection EPSG:4326
                     &nbsp;
                </div>
                
              </div>
        </div>
    </div></div>
    
    
</section>
<script type="text/javascript" src="assets/js/plugins/pluploader/plupload.full.min.js"></script>
<script type="text/javascript">
// Custom example logic

var flag_submit = false;
var uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
     
    browse_button : 'pickfiles', // you can pass in id...
    container: document.getElementById('container'), // ... or DOM Element itself
    multi_selection: false, 
    chunk_size: '2mb',
	max_retries: 3,
	url: "<?=base_url()?>chunk.php",
    
    filters : {
        max_file_size : '200mb',
        mime_types: [
            {title : "Zip files", extensions : "zip"}
        ]
    },
 
    // Flash settings
    flash_swf_url : 'assets/js/plugins/pluploader/Moxie.swf',
 
    // Silverlight settings
    silverlight_xap_url : 'assets/js/plugins/pluploader/Moxie.xap',
     
 
    init: {
        PostInit: function() {
            document.getElementById('filelist').innerHTML = '';
 
            document.getElementById('uploadfiles').onclick = function() {
                uploader.start();
                return false;
            };
        },
 
        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
				if (up.files.length > 1) {
					up.removeFile(file);
				}
				else {
					document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
					document.getElementById('file_name').value=file.name;
				}
			});
        },
		FileUploaded: function() {
			if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
				flag_submit=true;
				$('#frm').submit();
			}
		},
 
        UploadProgress: function(up, file) {
            //document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        	document.getElementById('pct').innerHTML=file.percent+"%";
			document.getElementById("upload-progress").style.width=file.percent+"%";
		},
 
        Error: function(up, err) {
            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
        }
    }
});
 
uploader.init();
$('#frm').submit(function(e) {
	// Files in queue upload them first
	if (!$(this).valid()) return false;
	if (uploader.files.length > 0) {
		$("#pickfiles").addClass("disabled");
		uploader.start();
	} else {
		flag_submit = true;
		//alert('Spasial file harus ada!.');
	}
	if (!flag_submit) return false;
});    
</script>
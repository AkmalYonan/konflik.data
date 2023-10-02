<? $this->load->view("admin_lte_layout/print_header");?>
<?
	/*
	$appname=$this->lauth->get_appname();
	$userdata=isset($_SESSION[$appname]["userdata"])?$_SESSION[$appname]["userdata"]:FALSE;
	if(!$userdata):
		redirect("login/");
	endif;
	*/
?>
<? $this->load->view("admin_lte_layout/print_header_layout");?>

<style>
	.kk {
		border:1px #333333 solid;	
	}
</style>

<!-- start: main Menu -->
<?php //echo isset($sidebar)?$sidebar:$this->load->view("admin_layout/menu_example");?>
<div class="row" style="background-color:#FFF">
<div class="col-md-12" style="background-color:#FFF">
<?php echo $content;?>
</div></div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    
</div>


<script>
	$(function(){
		$("#change_password").click(function(e){
			e.preventDefault();
			$("#modal_password").modal('show');
		});
		
		$("#save_password").click(function(){
			if(($("#password").val()=="")&&($("#confirm_password").val()=="")){
				$("#modal_password").modal("hide");
				alert("Password not change!!");
				return false;
				
			}
			//var id=$("#frm").data("idx");
			var sdata=$("#frm_change_pass").serialize();
			if(!$("#frm_change_pass").valid()){
				return false;
			};
			$.ajax({
				url: $("#frm_change_pass").attr("action"),
				data:  sdata,
				type: "POST",
				success: function(data) {
					//$("#frm")[0].reset();
					//$('#calendar').fullCalendar("refetchEvents");
					if(data=="ok"){
						$("#modal_password").modal("hide");
						alert("Updated Successfully");
					}else{
						alert("Update failed. Contact Sysadmin");
					}
					
				}
			});
		});
	});
</script>        
        
<div class="modal fade" id="modal_password" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">x</button>
            <h4 class="modal-title" id="myModalLabel">Change Password</h4>
            </div>
            <div class="modal-body">
            	<?
                	//$id=$this->encrypt_status==TRUE?encrypt($userdata["id"]):$userdata["id"];
				?>
                <form id="frm_change_pass" method="post" class="form-horizontal control-label-left" action="<?=base_url()?>setting/user/change_pwd/<?=$userdata["id"]?>" role="form">
                	<input type="hidden" name="act" id="act" value="update"/>
    				<div class="form-group">	
                        <label for="email" class="control-label col-md-4">Password</label>
                        <div class="col-md-8">
                        <input type="password" id="password" name="password" placeholder='(hidden password)' class="form-control" value="" />						<span class="help-block">entry new password if you want to change</span>
                        </div>
                    </div>
                    
                     <div class="form-group">	
                        <label for="email" class="control-label col-md-4">Confirm Password</label>
                        <div class="col-md-8">
                        <input type="password" id="confirm_password" equalto="#password" placeholder='(hidden password)' name="confirm_password" class="form-control" value="" />
                        <span class="help-block">repeat new password (confirm and password must be match)</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_password">Save Update</button>
        </div>
    </div>
  </div>
</div>
<!-- END MODAL PASSWORD -->


<div class="modal fade" id="print_preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title" id="myModalLabel">Print Preview</h4>

            </div>
            <div class="modal-body" style="height:80%">
                <div class="col" style="height:100%">
                    <iframe id="iframe_print_preview" width="100%" height="100%" style="border:none" src=""></iframe>
                </div>
            </div>
            <div class="modal-footer hide">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
	$(function(){
		var frameSrc = "http://localhost/binadwil/eoffice/surat/inbox/pdf_setting/";
	
		$('.print_modal').click(function(e){
			e.preventDefault();
			var url=$(this).attr("href");
			$("#iframe_print_preview").attr("src","");
			$('#print_preview').on('shown.bs.modal', function () {
				//$('iframe').attr("src",frameSrc);
				//$( ".modal" ).find( "iframe" )[ 0 ].src = url;
				$("#iframe_print_preview").attr("src",url);
			});
			$('#print_preview').modal({show:true});
		});
		
		
	});
</script>

<script type="text/javascript">
        function windowDimensions() { // prototype/jQuery compatible
        var myWidth = 0, myHeight = 0;
        if( typeof( window.innerWidth ) == 'number' ) {
            //Non-IE or IE 9+ non-quirks
            myWidth = window.innerWidth;
            myHeight = window.innerHeight;
        } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
            //IE 6+ in 'standards compliant mode'
            myWidth = document.documentElement.clientWidth;
            myHeight = document.documentElement.clientHeight;
        } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
            //IE 5- (lol) compatible
            myWidth = document.body.clientWidth;
            myHeight = document.body.clientHeight;
        }
        if (myWidth < 1) myWidth = screen.width; // emergency fallback to prevent division by zero
        if (myHeight < 1) myHeight = screen.height; 
        return [myWidth,myHeight];
    }
	
		var dim = windowDimensions();
    	myIframe = $('#iframe_print_preview'); // changed the code to use jQuery
    	myIframe.height((dim[1]-200) + "px");
    
    </script>

<!--<div class="clearfix"></div>-->
<!--<br><br>-->

<? $this->load->view("admin_lte_layout/print_footer");?>
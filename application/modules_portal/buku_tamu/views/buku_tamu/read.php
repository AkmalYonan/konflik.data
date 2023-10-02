<link rel="stylesheet" href="assets/js/additional_js/pnotify/pnotify.custom.min.css">
<script src="assets/js/additional_js/pnotify/pnotify.custom.min.js"></script>

<!-- Slimscroll 
    <script src="assets/themes/lte2.3.0/plugins/slimScroll/jquery.slimscroll.min.js"></script>-->
	<script src="assets/themes/lte2.3.0/plugins/slimScroll/jquery.slimscroll.js"></script>
	<!--<script src="assets/themes/lte2.3.0/plugins/slimScroll/examples/libs/prettify/prettify.js"></script>
	<link href="assets/themes/lte2.3.0/plugins/slimScroll/examples/libs/prettify/prettify.css" type="text/css" rel="stylesheet" />-->
	


	
<script src="assets/js/scrollbox/jquery.scrollbox.js"></script>
<link href="assets/js/scrollbox/demo.css" rel="stylesheet">
<!--header-->
<div class="well well-sm sub-head xhead" style="margin-top:-1px;margin-bottom:10px;">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6">
                      <h6 class="box-title" style="ext-transform:uppercase"><strong>KONTAK</strong></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end header-->
<div class="main-container container text-center-xs">
        
            <section class="content" >
                <div class="row">
                    
                    <div class="col-sm-12 col-xs-12">
                   
                        <div class="row" >
								
								<div class="col-md-8" style="border-right:0px solid grey; margin-bottom:15px;">
									
								
									<h6  style="font-size:12px;ext-transform:uppercase"><strong>KONTAK'S FEED  </strong></h6>
									<hr />
									
									<div id="testDiv">
										<? foreach($data as $k=>$v){?>	
										<div class="item" style="border-bottom:1px solid #e0e0d2;padding-bottom:5px;font-size:12px">
											<div class="row">
												<div class="col-md-1">
													<img src="assets/images/no-profile-male.jpg" style="margin-top:10px;" width="50px;"><br />
													<span style="color:grey !important"><?=$v['name']?></span>
													
												</div>
												<div class="col-md-10">
													<h6 style="text-transform:uppercase; font-size:13px;font-weight:bold">
														<?=$v['subject']?>
													<small><img width="15px" height="15px" style="margin-top:-5px;" src="assets/images/verified.jpg"></small>
													</h6>
													<?=$v['comments']?><br />
													<span style="color:grey !important">
													<?//=$date = date('d-m-Y h:i:s', strtotime($v['created']));?>
													<?=$date=date("jS F, Y h:i:s", strtotime($v['created']));?>
													</span>
													<hr />
													Balasan : <?=$v['reply']?>
												</div>
											</div>
											
										</div>
										<? }?>	
									
									</div>
								</div>
								
								<div class="col-md-4" style="margin-top:15px;">
									<div id="container" style="border:1px solid #e0e0d2; padding:10px; font-size:11px;">
									<img style="top: -15px; left: -15px; position: relative;" src="assets/images/Lacak_title.png" alt="Lacak laporan Anda">
									
									<form id="form">
											<p>Silahkan Isi form dibawah ini untuk mengirimkan pesan anda kepada kami !  </p>
											<hr />
											<div>
												<div class="row">
												<div class="col-md-12">
												<input type="text" id="name" placeholder="Name" class="form-control" /><br/>
												</div>
												</div>
												<div class="row">
														<div class="col-md-12">
														<input type="email" id="email" class="form-control" required placeholder="contoh@gmail.com"/><br/>
														</div>
														
												</div>
												<div class="row">
												<div class="col-md-12">
												<input type="text" id="password" class="form-control"  placeholder="Subject"/><br/>
												</div>
												</div>
												<div class="row">
												<div class="col-md-12">
												<textarea id="contact" class="form-control"  rows="10" placeholder="uraian"></textarea><br/>
												</div>
												</div>
												<button type="button" class="btn btn-danger" id="submit" onclick="myFunction()"/> kirim</button>
											</div>
										</form>
										
									</div>
									
									
								</div>
                                
                            
                        </div>
                    </div>
                    </div>
            </section>

    </div>
</div>
<script type="text/javascript">
    $(function(){
      $('#testDiv').slimscroll({
        size: '3px',
		height: '550px'
      });
     
    });
</script>
<script>
 
function myFunction() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var subject = document.getElementById("password").value;
    var comments = document.getElementById("contact").value;
// Returns successful data submission message when the entered information is stored in database.
    var dataString = 'name1=' + name + '&email1=' + email + '&subject1=' + subject + '&comments1=' + comments;
    if (name == '' || email == '' || password == '' || contact == '')
    {
        alert("Please Fill All Fields");
    }
    else
    {
//AJAX code to submit form.
        $.ajax({
            type: "POST",
            url: "buku_tamu/buku_tamu/add",
            data: dataString,
            cache: false,
            success: function(html) {
				 $('#name,#password,#contact').val("");
                new PNotify({
                title   : '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                text    : 'Input data Berhasil !',
				type: 'success',
				animate: {
					animate: true,
					in_class: 'bounceInLeft',
					out_class: 'bounceOutRight'
				},
                hide    : true
            });
            }
        });
    }
    return false;
}
 
  </script>

 <script>
$(document).ready(function(){
	
    
    $("#email").on("blur",function(){
        var email_validation    =   new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
        var email_val    =   $(this).val();
       
        if(!email_validation.test(email_val)){
            $(this).val("");
            new PNotify({
                title   : '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                text    : 'Format Email Salah',
                hide    : true
            });
        }
       
    });
    
    $("#name,#password,#contact").on("blur",function(){
        var length    =   $(this).val().length;
        if(length<5){
            $(this).val("");
            new PNotify({
                title   : '<h6 style="margin-top:-1px;">Pemberitahuan</h6>',
                text    : 'Mohon Isikan Lebih Dari 5 Karakter',
                hide    : true
            });
        }
    });
    
})
</script>   

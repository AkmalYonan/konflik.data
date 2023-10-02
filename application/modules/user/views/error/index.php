<? $this->load->view("header");?>
<style>
body {
}
#login-wraper {
    position: absolute;
    top: 50%;
    left: 50%;
    display: block;
    margin-top: -185px;
    margin-left: -285px;
    padding: 0px;
    width: auto;
    height: auto;
    background: none repeat scroll 0% 0% white;
	border:1px solid #ccc
}
.login-form .body {
    padding-bottom: 30px;
    border-bottom: 1px solid rgb(238, 238, 238);
}
.message-header {
	font-family:"Segoe UI";
	padding-bottom:0;
	padding-left:5px;
	padding-right:5px;
	border:none
}
.message-header h1,.message-header small {
	font-family:"Segoe UI";
	font-size:40px;
	font-weight:100;
	line-height:90px;
	color:#999;
}
.message-header small {
	color:#999;
}
</style>

<div class="container">
     <div id="login-wraper">
        <div class="row-fluid">
        	<div class="span4" style="background:#36587b; height:120px; padding:10px 20px 10px 10px">
            	<img src="assets/image/kemhub_logo.png" />
            </div>
            <div class="span8 message-header">
                <h1><?=$error_code;?>. <small><?=$error_text;?></small></h1>
                <!--<button class="btn btn-mini btn-info" type="button" onClick="javascript:history.back()">Back</button>-->
            </div>
   		</div>
    </div>
</div>

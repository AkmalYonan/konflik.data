<?php //<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PORTAL</title>
<? /*
<meta name="viewport" content="width=device-width, initial-scale=1.0">
*/ ?>
<meta name="description" content="">
<meta name="author" content="">
<base href="<?=base_url()?>"/>

<LINK REL="shortcut icon" HREF="<?=base_url()?>favicon.ico">

<!-- LOAD LIBRARY CSS -->
<link href="assets/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/fa/css/font-awesome.min.css" rel="stylesheet">
<?php echo css_asset("styles.css")?>
<?php echo css_asset("mybootstrap.css")?>
   
<!--[if IE 7]>
	<link rel="stylesheet" href="<?=base_url()?>assets/fa/css/font-awesome-ie7.min.css">
<![endif]-->
	 <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
   
   
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<?php echo js_asset("html5.js");?>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="<?php echo base_url();?>assets/bootstrap/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>assets/bootstrap/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>assets/bootstrap/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>assets/bootstrap/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>assets/bootstrap/ico/apple-touch-icon-57-precomposed.png">

<!--link href="<?=base_url()?>assets/themes/facebook/bootstrap.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/themes/facebook/lat.css" rel="stylesheet">
-->
  <link href="<?=base_url()?>assets/themes/google/bootstrap.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/themes/google/lat.css" rel="stylesheet">
  <link href="<?=base_url()?>assets/app/admin/css/admin.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/datepicker.css">	
 
 <script src="<?=base_url()?>assets/js/1.7.2/jquery.min.js"></script>
 <script src="<?=base_url()?>assets/bootstrap/2.3.2/js/bootstrap.min.js"></script>
 <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>assets/bootstrap/js/locales/bootstrap-datepicker.id.js" charset="UTF-8">
</script>
<?php echo js_asset("plugin/date.format.js");?>
<?php loadFunction("sticky");?>
<?php loadFunction("apprise");?>
<?php loadFunction("validate");?>
<script src="assets/bootstrap/js/jquery.validate.bootstrap.js"></script>
 <script>
 	function Alert(title,message){
		apprise("<b>"+title+"</b><p>"+message+"</p>");  
	}
	
	function removeScript(html){
		html=html.replace("/<script\b[^>]*>(.*?)<\/script>/i", "");
		html=html.replace("/<styles\b[^>]*>(.*?)<\/styles>/i", "");
		html=html.replace("/<link href\b[^>]*>(.*?)<\/link>/i", "");
		return html;
	}
	
	function UrlSubmit(url, params) {
		params["target"]=params["target"]||'';
		var target=('target="'+params["target"])+'"'||'';
		var form = [ '<form id="flyfrm" name="flyfrm" method="POST" ',target,' action="', url, '">' ];
	
		for(var key in params) 
			form.push('<input type="hidden" name="', key, '" value="', params[key], '"/>');
	
		form.push('</form>');
	
		jQuery(form.join('')).appendTo('body')[0].submit();
	}
	
	/* save /update to database return json obj status,msg,data */
	function save_data_ret_json(url,dataString,locate){
			if(!locate){
				locate=self.location;
			}
			$.post(url,dataString,function(data){
					if(data.status=="ok"){
						$.sticky("<b>Konfirmasi</b><p>"+data.msg+"</p>",stickyoptions,function(response){
						var time=parseFloat(response.timedelay);
						setTimeout(function(){
							location=locate;
							},time);
						});
													
					}else{
						Alert("Warning",data.msg)
					}	
			},'json');
			
		}/* end function */
		
 </script>
       
<body>


 
    
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="Description" CONTENT="BKIPM - Badan Karantina Ikan, Pengendalian Mutu dan Keamanan Hasil Perikanan, Kementrian Kelautan dan Perikanan Republik Indonesia ">
<META http-equiv="Content-Type" CONTENT="text/html; charset=utf-8" />
<title>CMS - Lingkar Arsa Technologies</title>
<base href="<?=BASE_URL;?>" />
<link rel="shortcut icon" href="assets/image/favicon.ico" />
<link rel="stylesheet" type="text/css" href="assets/bootstrap/2.3.2/themes/bs-square/css/bootstrap.css" media="screen">
<link rel="stylesheet" href="assets/fa/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="assets/bootstrap/2.3.2/themes/bs-square/css/lat.css" media="screen">
<script src="assets/js/1.10.2/jquery.min.js"></script>
<script src="assets/bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/jquery.hotkeys.js"></script>
<script type="text/javascript" src="assets/bootstrap/2.3.2/plugin/bootstrap-wysiwyg.js"></script>
<script>
$(window).load(function(){
  $('#key_list').on('keydown',function (event) {
		var keypressed = event.keyCode || event.which;
		if (keypressed == 13) {
			$("#button_list").trigger("click");
		}
	});
  $('#fsearch').on('submit',function (event) {
		event.preventDefault();
	});
  $('ul.nav .btn').click(function (e) {
  		alert($(this).attr("href"));
		e.preventDefault();
	});
});
</script>
</head>

<body>
  <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand pull-left" href="#">Lingkard <i class="icon-circle-blank"></i></a>
          <a class="brand2 pull-right" href="#"><i class="icon-gear"></i></a>
            <ul class="nav lat-nav">
              <li class="active"><a href="#">News</a></li>
              <li><a href="#">Client <span class="badge bg-purple"><small>2</small></span></a></li>
              <li><a href="#">Portfolio</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-th icon-white"></i> Lingkar <span class="badge bg-green"><small>5</small></span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Address</a></li>
                  <li><a href="#">Contact</a></li>
                  <li class="divider"></li>
                  <li class="nav-header">Nav header</li>
                  <li><a href="#">info@lingkar.co.id</a></li>
                  <li><a href="#">Coordinate</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav lat-nav pull-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> <?=$user_name;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="admin/auth/logout"><i class="icon-off"></i> Logout</a></li>
                  <li><a href="#"><i class="icon-wrench"></i> Setting</a></li>
                  <li><a href="#"><i class="icon-user"></i> Profiled</a></li>
                </ul>
              </li>
            </ul>
        </div>
      </div><!-- /navbar-inner -->
    </div><!-- /navbar -->
  </div>

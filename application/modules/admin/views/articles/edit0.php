<? if (!$_SESSION['login']) { ?>
<script>window.location.href='auth/login/';</script>
<? exit; }  ?>

<? if ($process) { ?>
    <div id="result">
    <div>Proses Berhasil</div>
    </div>
    <script>window.location.href='<?=$module;?>';</script>
<? } else { ?>
<style>
#editor {
	width:100%;
	max-height: 250px;
	height: 250px;
	background-color: white;
	border-collapse: separate; 
	border: 1px solid rgb(204, 204, 204); 
	padding: 4px; 
	box-sizing: content-box; 
	-webkit-box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset; 
	box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
	border-top-right-radius: 3px; border-bottom-right-radius: 3px;
	border-bottom-left-radius: 3px; border-top-left-radius: 3px;
	overflow: auto;
	outline: none;
}
#voiceBtn {
  width: 20px;
  color: transparent;
  background-color: transparent;
  transform: scale(2.0, 2.0);
  -webkit-transform: scale(2.0, 2.0);
  -moz-transform: scale(2.0, 2.0);
  border: transparent;
  cursor: pointer;
  box-shadow: none;
  -webkit-box-shadow: none;
}

div[data-role="editor-toolbar"] {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.dropdown-menu a {
  cursor: pointer;
}
</style>

<!-- Place inside the <head> of your HTML -->

<div id="breadcrumbs">
    <ul class="breadcrumb">
    <li><a href="#">Home</a> <span class="divider"><i class="icon-angle-right"></i></span></li>
    <li><a href="#">News</a> <span class="divider"><i class="icon-angle-right"></i></span></li>
    <li class="active">Edit</li>
    </ul>
</div>
<div class="navbar" style="padding:0; margin:0;">
      <div class="navbar-inner" style="padding-left:15px; border-bottom:1px solid #ccc">
        <div class="container">
          <div class="nav-collapse collapse navbar-responsive-collapse">
            <ul class="nav subnav">
            <li>
                <button class="btn" href="<?=$module;?>"><i class="icon-list"></i></button>
                <button class="btn" href="<?=$module;?>delete/<?=$data['id'];?>"><i class="icon-trash"></i></button>
                <span class="divider"></span>
                <button class="btn" href="apa2/" id="button_submit"><i class="icon-save green"></i>&nbsp;Save</button>
            </li>
          </div><!-- /.nav-collapse -->
        </div>
      </div><!-- /navbar-inner -->
    </div><!-- /navbar -->
    
<div style="padding:10px">
  <form id="fdata" action="<?=$module;?>edit" method="post" enctype="multipart/form-data" >
    <input type="hidden" name="reg_id" value="<?=$_SESSION['s_regid'];?>" />
    <input type="hidden" name="id" value="<?=$data['id'];?>" />
    <table>
      
      <tr>
        <td valign="top">
        <table cellpadding="4" cellspacing="0">
        <tr>
              <td class="formdata_header" colspan="2" width="120">Title</td>
             </tr>
             <tr>
              <td colspan="2"><input id="title" name="title" type="text" maxlength="150" style="width:99%" class="required" rel="Judul Berita" value="<?=$data['title'];?>" /></td>
          </tr>
         <tr>
              <td class="formdata_header" width="120">Change Image</td>
              <td class="formdata_header">Headline</td>
             </tr>
             <tr>
              <td><input type="hidden" name="MAX_FILE_SIZE" value="<?=$max_newsfoto_size;?>" /><input id="fotohead" type="file" name="file[]" size="30" style="width:290px" /></td>
          	<td><label for="label" style="display:inline-block">
              <input id="label" name="is_headline" type="radio" value="1" />
              Ya</label>
                <label for="label" style="display:inline-block">
                  <input id="label" name="is_headlines" type="radio" value="0" checked="checked" />
                  Tidak</label></td>
          </tr>
            <tr>
              <td class="formdata_header" colspan="2" valign="top">Clip</td>
            </tr>
            <tr>
              <td colspan="2"><textarea name="clip" style="width:99%; height:60px" class="required" rel="Potongan Berita"><?=$data['clip'];?></textarea></td>
          </tr>
            <tr>
              <td class="formdata_header" colspan="2">Content</td>
            </tr>
            <tr>
            <td colspan="2" width="800">
            <div id="alerts"></div>
    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor" style="background-color:#eee; margin:0; padding:2px">
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
          </ul>
        </div>
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
      </div>
      <div class="btn-group">
		  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
		    <div class="dropdown-menu input-append">
			    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
			    <button class="btn" type="button">Add</button>
        </div>
        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

      </div>
      
      <div class="btn-group">
        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
      </div>
      <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
    </div>

    <div id="editor">
      <?=$data['content'];?>
    </div>
            <?
				$checked=($data['status'])?" checked":"";
			?>
            <label for="publish_news"><input id="publish_news" name="status" type="checkbox" value="1"<?=$checked;?> /> Publish</label>            </td>
            </tr>
        </table>        </td>
        <td width="20">&nbsp;</td>
        <td width="20">&nbsp;</td>
      </tr>
    </table>
    <br />
    <br />
  </form>
</table>
</div>
<script>  
    $(document).ready(function () {
		$("li[rel~='cms1']").addClass("mmenuactive");
		$("#button_submit").click(function(e){
			$("#fdata").submit();
			e.preventDefault();
		});
		function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
	})
</script>
<? }  ?>
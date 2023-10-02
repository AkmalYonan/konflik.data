<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function left_menu($active="home"){
	ob_start();
	?>
<div class="sidebar-nav">
      	<div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list"> 
          <li class="nav-header">Main</li>        
          <li class="active"><a href="/" data-id="home"><i class="icon-home"></i>Home</a></li>
          <li><a href="blogpost.html"><i class="icon-edit"></i> Add Blog Post</a></li>
          <li><a href="members.html"><i class="icon-user"></i> Members</a></li>
          <li><a href="comments.html"><i class="icon-comment"></i> Comments</a></li>
          <li><a href="gallery.html"><i class="icon-picture"></i> Gallery</a></li>
          <li><a href="calendar.html"><i class="icon-calendar"></i> Calendar</a></li>
          <li class="nav-header">Typography</li>
          <li><a href="typography.html"><i class="icon-font"></i> Typography</a></li>
          <li><a href="grid.html"><i class="icon-th-large"></i> Grid</a></li>
          <li><a href="portlets.html"><i class="icon-th"></i> Portlets</a></li>
          <li><a href="forms.html"><i class="icon-th"></i> Forms</a></li>
          <li><a href="tables.html"><i class="icon-align-justify"></i> Tables</a></li>
          <li><a href="other.html"><i class="icon-gift"></i> Other</a></li>
          <li class="nav-header">Settings</li>
          <li><a class="cookie-delete" href="#"><i class="icon-wrench"></i> Delete Cookies</a></li>
          <li><a class="sidenav-style-1" href="#"><i class="icon-align-left"></i> Side Menu Style 1</a></li>
          <li><a class="sidenav-style-2" href="#"><i class="icon-align-right"></i> Side Menu Style 2</a></li>
          <li><a href="login.html"><i class="icon-off"></i> Logout</a></li>
        </ul>
    </div>
</div><!--/.well -->
    <?php
	$html=ob_get_clean();
	return $html;
}

function header_menu(){
	ob_start();
	
	$arr=get_menu_data();
	echo build_menu_bootstrap($arr);
	$html=ob_get_contents();
	return $html;
}


function header_menu_old(){
	ob_start();
	?>
	<!-- Top navigation bar -->
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="index.html"> Simplenso</a>
      <div class="btn-group pull-right">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="icon-user"></i>John Doe
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#">Profile</a></li>
          <li><a href="#">Settings</a></li>
          <li><a class="cookie-delete" href="#">Delete Cookies</a></li>
          <li class="divider"></li>
          <li><a href="login.html">Logout</a></li>
        </ul>
      </div>
      <div class="nav-collapse">
        <ul class="nav">
          <li class="dropdown">
              <a href="#"
                    class="dropdown-toggle"
                    data-toggle="dropdown">
                    Messages <span class="label label-info">100</span>
                    <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                  <li><a href="#">Menu</a></li>
                  <li><a href="#">User</a></li>
                  <li><a href="#">User ACL</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Older messages...</a></li>
              </ul>
          </li>
          <li class="dropdown">
                <a href="#"
                      class="dropdown-toggle"
                      data-toggle="dropdown">
                      Settings
                      <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?=base_url()?>setting/menu">Menu</a></li>
                    <li><a href="<?=base_url()?>setting/user">User</a></li>
                    <li><a href="#">User ACL</a></li>
                </ul>
          </li>
          <li class="dropdown">
                <a href="#"
                      class="dropdown-toggle"
                      data-toggle="dropdown">
                      Theme
                      <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                	<li><a class="theme-switch-default" href="#">Default</a></li>
                    <li><a class="theme-switch-amelia" href="#">Amelia</a></li>
                    <li><a class="theme-switch-cerulean" href="#">Cerulean</a></li>
                    <li><a class="theme-switch-journal" href="#">Journal</a></li>                        
                    <li><a class="theme-switch-readable" href="#">Readable</a></li>
                    <li><a class="theme-switch-simplex" href="#">Simplex</a></li>
                    <li><a class="theme-switch-slate" href="#">Slate</a></li>
                    <li><a class="theme-switch-spacelab" href="#">Spacelab</a></li>
                    <li><a class="theme-switch-spruce" href="#">Spruce</a></li>
                    <li><a class="theme-switch-superhero" href="#">Superhero</a></li>
                    <li><a class="theme-switch-united" href="#">United</a></li>
                </ul>
          </li>
          <li><a href="#">Help</a></li>  
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
    <?php
	$html=ob_get_clean();
	return $html;
}


function portlet($str="",$header="",$headerContent="",$subHeaderContent="",$button="ct"){ //c=close,t=toggle,f=config
		ob_start();
		$strSub="";
		if($subHeaderContent!=""):
			$strSub="<p class='help-block'>$subHeaderContent</p>";
		endif;
		?>
		<!-- Portlet: Collapsible -->
             <div class="box">
              <h4 class="box-header round-top"><?php echo $header;?>&nbsp;
              	  <? if(strpos($button,"c")!==false):?>
                  <a class="box-btn a_close" title="close"><i class="icon-remove" style="margin-top:0"></i></a>
                  <? endif; ?>
                  <? if(strpos($button,"t")!==false):?>
                  <a class="box-btn a_toggle" title="toggle"><i class="icon-minus" style="margin-top:0"></i></a>
                   <? endif; ?> 
                   <? if(strpos($button,"f")!==false):?>    
                  <a class="box-btn a_config" title="config" data-toggle="modal" href="#box-config-modal"><i class="icon-cog"></i></a>
                   <? endif; ?>
              </h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                    <?php echo $headerContent!=""?"<h3 class='title' style='margin-bottom:15px'>".$headerContent.$strSub."</h3>":"";?>  
                     <?php echo $str;?>       
                  </div>
              </div>
   <?php
	$html=ob_get_clean();
	return $html;
}

/*
	example //$button="ct" c=close,t=toggle,f=config
*/
function portlet_start($header="",$button="",$addclass="",$addprop=""){
		ob_start();
		?>
		<!-- Portlet: Collapsible -->
             <div class="box <?=$addclass?>" <?=$addprop?>>
              <h4 class="box-header round-top"> 
			  	  <?php echo $header;?>&nbsp;
              	  <? if(strpos($button,"c")!==false):?>
                  <a class="box-btn close" title="close" style="text-align:center"><i class="icon-remove"></i></a>
                  <? endif; ?>
                  <? if(strpos($button,"t")!==false):?>
                  <a class="box-btn toggle" title="toggle"><i class="icon-minus"></i></a>
                   <? endif; ?> 
                   <? if(strpos($button,"f")!==false):?>    
                  <a class="box-btn config" title="config" data-toggle="modal" href="#box-config-modal"><i class="icon-cog"></i></a>
                   <? endif; ?>
              </h4>         
              <div class="box-container-toggle">
                  <div class="box-content">
                   
   <?php
	$html=ob_get_clean();
	return $html;
}


function portlet_end(){//c=close,t=toggle,f=config
		ob_start();
		?>
		    </div>
        </div>
        </div>
   <?php
	$html=ob_get_clean();
	return $html;
}


function portlet_simple($str="",$headerContent="",$subHeaderContent=""){
	ob_start();
		$strSub="";
		if($subHeaderContent!=""):
			$strSub="<p class='help-block'>$subHeaderContent</p>";
		endif;
		?>
     <div class="box border-solid round-all">
           <div class="box-content">
           		<?php echo $headerContent!=""?"<h3 class='title' style='margin-bottom:15px'>".$headerContent.$strSub."</h3>":"";?>  
           		 <?php echo $str;?>
                    
       		   </div>
     </div>
     
	 <?php
	$html=ob_get_clean();
	return $html;
}


function portlet_simple_start(){
	ob_start();
	?>
	 <div class="box border-solid round-all">
        <div class="box-content">
    <?php
	$html=ob_get_clean();
	return $html;
}


function portlet_simple_end(){
 ob_start();
	?>	
    	</div> <!-- /box content -->
     </div><!-- /portlet simple -->
    
 <?php
	$html=ob_get_clean();
	return $html;
}




/*
File: MY_form_helper

Creates HTML5 extensions for the standard CodeIgniter form helper.

These functions also wrap the form elements as necessary to create
the styling that the Bootstrap-inspired admin theme requires to
make it as simple as possible for a developer to maintain styling
with the core. Also makes changing the core a snap.

All methods (including overriden versions of the originals) now
support passing a final 'label' attribute that will create the
label along with the field.
*/

/*
Function: _form_common()

Used by many of the new functions to wrap the input in the correct
tags so that the styling is automatic.

Parameters:
$type - A string with the name of the element type.
$data - Either a string with the element name, or an array of
key/value pairs of all attributes.
$value - Either a string with the value, or blank if an array is
is passed to the $data param.
$label - A string with the label of the element.
$extra - A string with any additional items to include, like Javascript.
$tooltip - A string for inline help or a tooltip icon

Returns:
A string with the formatted input element, label tag and wrapping divs.
*/


if (!function_exists('_form_common'))
{
function _form_common($type='text', $data='', $value='', $label='', $extra='', $tooltip = '')
{
$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

// If name is empty at this point, try to grab it from the $data array
if (empty($defaults['name']) && is_array($data) && isset($data['name']))
{
$defaults['name'] = $data['name'];
unset($data['name']);
}

$output = array_merge($defaults, $data);
$output = <<<EOL

<div class="control-group">
<label class="control-label" for="{$defaults['name']}">{$label}</label>
<div class="controls">
<input {$output} {$extra} />
{$tooltip}
</div>
</div>

EOL;

return $output;
}
}

//--------------------------------------------------------------------

if (!function_exists('form_input'))
{
function form_input($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('text', $data, $value, $label, $extra);
}
}

//--------------------------------------------------------------------

if (!function_exists('form_email'))
{
function form_email($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('email', $data, $value, $label, $extra);
}
}

//--------------------------------------------------------------------

if (!function_exists('form_password'))
{
function form_password($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('password', $data, $value, $label, $extra);
}
}

//--------------------------------------------------------------------

if (!function_exists('form_url'))
{
function form_url($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('url', $data, $value, $label, $extra);
}
}

//--------------------------------------------------------------------

if ( ! function_exists('form_telephone'))
{
function form_telephone($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('tel', $data, $value, $label, $extra);
}
}

//--------------------------------------------------------------------

if ( ! function_exists('form_number'))
{
function form_number($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('number', $data, $value, $label, $extra);
}
}

//--------------------------------------------------------------------

if ( ! function_exists('form_color'))
{
function form_color($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('color', $data, $value, $label, $extra);
}
}

//--------------------------------------------------------------------

if ( ! function_exists('form_search'))
{
function form_search($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('search', $data, $value, $label, $extra);
}
}

//--------------------------------------------------------------------

if ( ! function_exists('form_date'))
{
function form_date($data='', $value='', $label='', $extra='', $tooltip = '' )
{
return _form_common('date', $data, $value, $label, $extra);
}
}

//========================================================================================================================


//===============================================================
/*MESSAGFE BOOOOOOOOOOXX */
//===============================================================

if (!function_exists('message_box')) {
    function message_box($message_type=FALSE, $close_button = TRUE)
    {
        $CI =& get_instance();
		if(!$message_type):
			$message_type=$CI->session->flashdata("message_type");
		endif;
        $message = $CI->session->flashdata($message_type);
		$retval = '';
        if($message){
            switch($message_type){
                case 'success':
                    $retval .= '<div class="div_message alert alert-success">';
                    break;
                case 'error':
                    $retval .= '<div class="div_message alert alert-error">';
                    break;
                case 'info':
                    $retval .= '<div class="div_message alert alert-info">';
                    break;
                case 'warning':
                    $retval .= '<div class="div_message alert">';
                    break;
            }

            if($close_button)
                $retval .= '<a class="close" data-dismiss="alert" href="#">&times;</a>';

            $retval .= $message;
            $retval .= '</div>';
            return $retval;
        }
    }
}

if (!function_exists('alert_box')) {
    function alert_box($message_type=FALSE,$message="", $close_button = TRUE)
    {
		$retval = '';
        if($message){
            switch($message_type){
                case 'success':
                    $retval .= '<div class="alert alert-success">';
                    break;
                case 'error':
                    $retval .= '<div class="alert alert-error">';
                    break;
                case 'info':
                    $retval .= '<div class="alert alert-info">';
                    break;
                case 'warning':
                    $retval .= '<div class="alert">';
                    break;
            }

            if($close_button)
                $retval .= '<a class="close" data-dismiss="alert" href="#">&times;</a>';

            $retval .= $message;
            $retval .= '</div>';
            return $retval;
        }
    }
}

if (!function_exists('set_message')){
    function set_message($type, $message)
    {
        $CI =& get_instance();
        $CI->session->set_flashdata($type, $message);
		$CI->session->set_flashdata("message_type", $type);
		
    }
}

// END MESSAGE BOX
//======================================================================================================================

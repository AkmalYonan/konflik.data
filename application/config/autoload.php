<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Helper files
| 4. Custom config files
| 5. Language files
| 6. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packges
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/

$autoload['packages'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in the system/libraries folder
| or in your application/libraries folder.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'session', 'xmlrpc');
*/


//$autoload['libraries'] = array();
$autoload['libraries'] = array('session','token','curl');
$autoload['libraries'][]='adodbx';
$autoload['libraries'][]='Ion_auth';
$autoload['libraries'][]='bootstrapped';
$autoload['libraries'][]='user_agent';
$autoload['libraries'][]='cms';
//$autoload['libraries'][]='geoPHP';

//$autoload['libraries'][]='LAuth';
$autoload['libraries'][]='Lat_auth';

//$autoload['libraries'][]='REST_Controller';
//$autoload['libraries'][]='format';



/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/

$autoload['helper'] = array('url','member','phpmail','encrypt','network','server','global_function_helper','news_subscriber_helper');
$autoload['helper'][]='global';
$autoload['helper'][]='flash';
$autoload['helper'][]='asset';
$autoload['helper'][]='query';
$autoload['helper'][]='path';
$autoload['helper'][]='debug';
$autoload['helper'][]='ext_db';
//$autoload['helper'][]='geo';
$autoload['helper'][]='security';
$autoload['helper'][]='bootstrap';
// $autoload['helper'][]='util_helper';
$autoload['helper'][]='file';
$autoload['helper'][]='bnn';
$autoload['helper'][]='rh';




/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/
//$autoload['config'] = array();
$autoload['config'] = array('lauth','app');
//$autoload['config'][]="p2hp_excel"; //xls config
$autoload['config'][]="pagination"; //pagination
$autoload['config'][]="rest"; //pagination

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/

$autoload['language'] = array();


/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('model1', 'model2');
|
*/

$autoload['model'] = array("ADODBX_Model","LAT_Model");


/* End of file autoload.php */
/* Location: ./application/config/autoload.php */
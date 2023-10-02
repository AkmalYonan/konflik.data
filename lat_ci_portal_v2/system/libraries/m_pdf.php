<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once BASEPATH."libraries/mpdf60/mpdf.php";

class m_pdf extends mPDF{
	public function __construct() { 
        parent::__construct(); 
    } 
}
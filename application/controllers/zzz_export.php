<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class export extends CI_Controller {
	function xls(){
		$this->load->helper("export");
		export2xls();
	}
	
	
	function csv(){
		$this->load->helper("download");
		$data=$this->input->post("tbl",true);
		$name=$this->input->post("filename",true);
		force_download($name,$data);
	}
	
	function html(){
		//error_reporting(E_ALL);
		$post=$_POST["tbl"];
		$data["data"]=rawurldecode($post);
		$this->load->view("content_print",$data);
	}
    
    function html_print(){
        //error_reporting(E_ALL);
        $post=$_POST["tbl"];
        $data["data"]=rawurldecode($post);
        $html=$this->load->view("content_print",$data,true);
        $addJS="
            <script>
            $(function(){
                $(window).load(function(){
                    window.print();   
                });
            });
            </script>
        ";
        $html=preg_replace("/\<\/body\>/",$addJS."</body>",$html);
        echo $html;
    }
	
	function pdf(){
		$this->load->helper("mpdf");
		//$data=$this->input->post("tbl",true);
		$header_height=$this->input->get_post("header_height",TRUE);
		$post=rawurldecode($_POST["tbl"]);
		//$pdf=$post;
		$data["header_height"]=$header_height?$header_height:"50";
		$data["data"]=$post;
		
		$name=$this->input->post("filename",true);
		//print $data;
		$pdf=$this->load->view("content_print_pdf",$data,true);
		//print $pdf;
		//$pdf=file_get_contents("http://localhost:90".base_url()."export/get_contents/");
		//print $pdf;
		SimpleMPDF($pdf);
		//Export2MPDF($pdf,$name.".pdf");
		
	}
	
	function pdf_setting(){
		$post=rawurldecode($_POST["tbl"]);
		$file_name=$this->input->post("filename",true);
		$postData["tbl"]=$post;
		$postData["filename"]=$file_name;
		$data["data"]=$postData;
		
		$this->load->view("pdf_setting",$data);
	}
	
	function proxy_pdf(){

        // pre($_POST);
        // exit();
		ini_set("memory_limit",-1);
	    $serverUrl=$this->config->item("pdf_server");
        $serverUrl=$serverUrl?$serverUrl:"";
        //if server is local just runt the method pdf;
        if(empty($serverUrl)||($serverUrl=='local')):
            //print "local";
            $this->pdf();
            exit();
        endif;
        //print "remote";
        
		//$req=get_post();
		$req=$_POST;
		//$req["tbl"]=rawurldecode($req["tbl"]);
		$postdata = http_build_query(
			$_POST
		);
		
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		
		$context  = stream_context_create($opts);
		
		$filename=( (isset($req["filename"])) && (!empty($req["filename"])) )?preg_replace("/(\s+)|(\.html$)/","",$req["filename"]):date("Y_m_d");
		
		//chose one
		//$serverUrl="http://localhost:90/import_ikan/";
		//$serverUrl="http://gis.bkipm.kkp.go.id/budidaya_new/";
		
		$result = file_get_contents($serverUrl.'export/pdf', false, $context);
		header('Content-disposition: inline; filename='.$filename.'.pdf');
		//header('Content-disposition: attachment; filename='.$filename.'.pdf');
		header('Content-type: application/pdf');
		print $result;
	}
	
	function init_folder(){
		//require_once APPPATH."/third_party/mpdf54/mpdf.php";
		$this->load->library("m_pdf");
		//$this->load->helper("mpdf");
		print (mPDF_VERSION);
		//pre(_MPDF_PATH);
		//chmod($target_path,0777);
	}
	
	/*
	function get_contents(){
		$post=rawurldecode($this->input->get_post("tbl"));
		//$pdf=$post;
		$data["data"]=$post;
		$name=$this->input->post("filename",true);
		//print $data;
		$this->load->view("content_print_pdf",$data);
	}
	*/
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

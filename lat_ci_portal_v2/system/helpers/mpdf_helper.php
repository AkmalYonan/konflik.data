<?php 
if ( ! function_exists('Export2MPDF'))
{
			//I or D for output download of F for file created
			//P or L for lanscape
            function Export2MPDF($htmView,$fileName,$output='I',$orientation='P') {

                        $CI =& get_instance();
                        $CI->load->library('m_pdf');
                        
						//$CI->mpdf=new mPDF('UTF-8','A4','','',32,25,27,25,16,13,$orientation);
						$CI->mpdf = new mPDF('UTF-8', 'A4', 8, 'Arial', 12, 12, 10, 10, 5, 5,$orientation);
                        $CI->mpdf->AliasNbPages('[pagetotal]');
                        $CI->mpdf->SetHTMLHeader('{PAGENO}/{nb}', '1',true);
                        $CI->mpdf->SetDisplayMode('fullpage');
                        $CI->mpdf->pagenumPrefix = 'Page number ';
                        $CI->mpdf->pagenumSuffix = ' - ';
                        $CII->mpdf->nbpgPrefix = ' out of ';
                        $CI->mpdf->nbpgSuffix = ' pages';
                        $CI->mpdf->SetHeader('{PAGENO}{nbpg}');
                        
                        //$style = base_url().'/source/template/css/stylesheet.css';
                        //$stylesheet = file_get_contents( $style);
                        //$CI->mpdf->WriteHTML($stylesheet,1);                        
                        $CI->mpdf->WriteHTML($htmView,2);                        
                        $CI->mpdf->Output($fileName,$output);
            }
			
			
			function SimpleMPDF($html,$paper='folio',$orientation='P',$namaFile)
			 {
				 $CI =& get_instance();
                 $CI->load->library('m_pdf');    
				 $top=$CI->input->get_post("t",true);
				 $top2=$CI->input->get_post("t2",true);
				 $bottom=$CI->input->get_post("b",true);
				 $left=$CI->input->get_post("l",true);
				 $right=$CI->input->get_post("r",true);
				 $postOrientation=$CI->input->get_post("o",true);
				 //$data=$_POST;
				 //pre($data);
				 //exit();
				 $postPaper=$CI->input->get_post("p",true);
				 $fontSize=$CI->input->get_post("fz",true);
				 $fontSize=$fontSize?$fontSize:0;
				 $fontFamily=$CI->input->get_post("ff",true);
				 $fontFamily=$fontFamiliy?$fontFamily:'';
				 
				 $paper=$postPaper?$postPaper:$paper;
				 $orientation=$postOrientation?$postOrientation:$orientation;
				 $top=$top?$top:30;
				 $bottom=$bottom?$bottom:20;
				 $left=$left?$left:20;
				 $right=$right?$right:20;
				 $top2=$top2?$top2:30;
				 //$mpdf = new mPDF('utf-8', $paper, $fontSize, $fontFamily, $left, $right, $top, $bottom, 8, 8,$orientation);
				 if(strtolower($orientation)=='l'):
				 $mpdf = new mPDF('utf-8', $paper."-".$orientation, $fontSize, $fontFamily, $left, $right, $top2, $bottom, 8, 8,$orientation);
				 else:
				  $mpdf = new mPDF('utf-8', $paper, $fontSize, $fontFamily, $left, $right, $top2, $bottom, 8, 8,$orientation);
				 endif;
				 //$mpdf = new mPDF('','A4-P');
				 /*$mpdf->useOddEven = 1;	
				 $mpdf->autoPageBreak = true;	*/
				 $style = '<style>
				 	@page { 
						margin-top: '.$top2.'mm;
					}
					@page :first { 
						margin-top: '.$top.'mm;
					}
				</style>';
				$html=str_replace("<hr class=\"no_print\">","",$html);
				$html=$style.$html;
				//print $html;
				//$mpdf=new mPDF('utf-8',$paper);
				$mpdf->mirrorMargins = 1;
				$mpdf->AddPage();
				$mpdf->setFooter('{PAGENO}');
				$mpdf->WriteHTML($html);
				
				// $mpdf->AddPage('','','','','on');
				// $mpdf->AddPage('','NEXT-ODD','1','i','on');
				// $mpdf->WriteHTML('<pagebreak type="NEXT-ODD" pagenumstyle="1" />');
				
				// $mpdf->PageNumSubstitutions[] = ['from' => 1, 'reset' => 0, 'type' => 'I', 'suppress' => 'on'];
				// $mpdf->Output();
				$mpdf->Output($namaFile, 'I');
			 	 
			 } 
} 
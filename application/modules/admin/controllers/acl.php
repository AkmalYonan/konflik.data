<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class acl extends Admin_Controller {
	 function __construct(){
        parent::__construct();
        
        $this->load->helper(array('form', 'url','file'));
$this->load->helper(array('form', 'url','file','language','lookup','bootstrap_helper'));    	$this->folder="admin/";
		$this->module=$this->folder."acl/";
        $this->http_ref=base_url().$this->module;
		
		$this->load->model("acl_model");
        $this->model=$this->acl_model;
        $this->model=new acl_model();
		$this->acc_active="acl_list";
        $this->module_title="ACL";
        $this->msg_ok="Data Saved Successfully!!";
        $this->msg_fail="Unable to save data!!";
        
	}
    
    function index(){
		$this->acl_list2();
    }
	
	function acl_list(){
		
		$arrRights=$this->adodbx->search_record($this->model->tbl_rights);
		$arrGroups=$this->adodbx->search_record($this->model->tbl_groups);
		$find["active"]=1;
		$arrModules=$this->adodbx->search_record($this->model->tbl_modules,$find,'order by parent_idx');
		$arrGroup2Modules=$this->adodbx->search_record($this->model->tbl_group_to_modules);
 		$data["acc_active"]='account_manager';//$this->acc_active; //komeng add
		$data["arrRights"]=$arrRights;
		$data["arrGroups"]=$arrGroups;
		$data["arrModules"]=$arrModules;
		$data["arrGroup2Modules"]=$arrGroup2Modules;
		$this->_render_page($this->module."acl_list",$data,true);
				
	}
	
	function acl_list2(){
		
		$arrRights=$this->adodbx->search_record($this->model->tbl_rights);
		$arrGroups=$this->adodbx->search_record($this->model->tbl_groups);
		$find["active"]=1;
		$arrModules=$this->adodbx->search_record($this->model->tbl_modules,$find,'order by order_num');
		$arrGroup2Modules=$this->adodbx->search_record($this->model->tbl_group_to_modules);
		/*if (cek_array($arrModules)) {
			foreach($arrModules as $k=>$v) {
				if (!$v['parent_idx']) {
					$arr[$v['idx']]=$v;	
				}
				else {
					if ($arr[$v['parent_idx']]) $arr[$v['parent_idx']]['child'][]=$v;
				}
			}
		}*/
		if(cek_array($arrGroup2Modules)):
			foreach($arrGroup2Modules as $x=>$val):
				$this->dataACL[$val["group_id"]][$val["module_id"]]=$val["rights"];
			endforeach;
		endif;
		$this->arrRights=$arrRights;
		
		foreach($arrGroups as $group):
			$arr.='<div class="panel box box-primary">
					<div class="box-header with-borders" data-toggle="collapse" data-parent="#accordion" href="#'.$group["id"].'">
						<h4 class="box-title">
							<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$group["id"].'">
								'.$group["name"].'
							</a>
						</h4>
					</div>
					<div id="'.$group["id"].'" class="panel-collapse collapse '.($group["id"] == 1?"in":"").'">
						<div class="box-body no-paddings">
							<table class="table table-condensed">
								<thead class="box_quote">
									<tr>
										<th>Module</th>';
										foreach($arrRights as $right):
											$arr.='<th><label class="radio inline"><input type="radio" name="rb_all['.$group["id"].']" data-right="'.$right["right_id"].'" data-group="'.$group["id"].'" class="rb inline all"> '.$right["description"].'</label></th>';
										endforeach;
									$arr.='</tr>
								</thead>';
			$arr.=$this->build_tree2($arrModules,0,0,$group);
			$arr.='</table></div></div></div>';
		endforeach;
		$data["arr"]=$arr;
		$data["acc_active"]='account_manager';//$this->acc_active; //komeng add
		$data["arrRights"]=$arrRights;
		$data["arrGroups"]=$arrGroups;
		$data["arrModules"]=$arrModules;
		$data["arrGroup2Modules"]=$arrGroup2Modules;
		$this->_render_page($this->module."v_list",$data,true);
				
	}
	
	function build_tree2($rows,$parent=0,$r=0,$group=array())
	{  
		foreach ($rows as $row)
		{
       		$dash = 20*$r;
			if ($row['parent_idx'] == $parent) {
				$result.= "<tr style='background-color:".($row["is_group"]?"#f4f4f4":"")."'>\n";
				$result.= "<td><span style='padding-left:".$dash."px; font-weight:".($row["is_group"]?"bold":"normal")."'>{$row['module_name']}</span></td>\n";
				
				foreach($this->arrRights as $right):
                    $checked="";
                    if(isset($this->dataACL[$group["id"]][$row["idx"]])):
                        $dataACLRight=$this->dataACL[$group["id"]][$row["idx"]];
						
                        if($right["right_id"]==$dataACLRight):
                            $checked="checked='checked'";
                        endif;
                    endif;
					if($row["is_group"]):
                		$result.= '<td><input type="radio" name="rb['.$group["id"].']['.$row["idx"].']" class="rb inline g_'.$group["id"].' m_'.$row["idx"].' r_'.$right['right_id'].' child" data-group="'.$group["id"].'" data-module="'.$row["idx"].'" data-right="'.$right["right_id"].'"  value="'.$right["right_id"].'"  '.$checked.'></td>'."\n";
                	else:
                		$result.= '<td><input type="radio" name="rb['.$group["id"].']['.$row["idx"].']" class="rb inline g_'.$group["id"].' m_'.$row["idx"].' r_'.$right['right_id'].' p_'.$row['parent_idx'].'" data-group="'.$group["id"].'" data-module="'.$row["idx"].'" data-right="'.$right["right_id"].'"  value="'.$right["right_id"].'"  '.$checked.'></td>'."\n";
                	endif;
				endforeach;
                
				$result.= "</tr>\n";
				if ($this->has_children($rows,$row['idx'])){
					$result.= $this->build_tree2($rows,$row['idx'],$r+1,$group);
				}
			}
		}
		
		return $result;
	}
	function build_tree($rows,$parent=0)
	{  
		$result = "<ul>";
		foreach ($rows as $row)
		{
			if ($row['parent_idx'] == $parent) {
				$result.= "<li>{$row['module_name']}";
				if ($this->has_children($rows,$row['idx'])){
					$result.= $this->build_tree($rows,$row['idx']);
				}
				$result.="</li>";
			}
		}
		$result.= "</ul>";
		
		return $result;
	}
	
	function has_children($rows,$id) {
	  foreach ($rows as $row) {
		if ($row['parent_idx'] == $id)
		  return true;
	  }
	  return false;
	}
	
	function buildTreex(Array $data, $parent = 0) {
		$tree = array();
		foreach ($data as $d) {
			if ($d['parent_idx'] == $parent) {
				$children = $this->buildTreex($data, $d['idx']);
				// set a trivial key
				if (!empty($children)) {
					$d['children'] = $children;
				}
				$tree[] = $d;
			}
		}
		return $tree;
	}
	
	
	
	function _render_page($view, $data=null, $render=false)
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $render);
        if($render):
            $datam["acc_active"]=$this->acc_active;
			
			$datam["acc_active"]='account_manager';//komeng fix
            $datam["content"]=$view_html;
            $this->load->view("admin_lte_layout/main_layout",$datam);
        endif;
    }
	
	function acl_save(){
		$req=get_post();
		foreach($req["rb"] as $gid =>$rights):
			$data_tmp=array();
			$data_group[]=$gid;
			$data_tmp["group_id"]=$gid;
			foreach($rights as $mid=>$val):
				$data_tmp["module_id"]=$mid;
				$data_tmp["rights"]=$val;
				$arrData[]=$data_tmp;
			endforeach;
		endforeach;
		$in_group=join(",",$data_group);
        $this->conn->StartTrans();
        $this->adodbx->Delete($this->model->tbl_group_to_modules," group_id in ($in_group)");
		
        foreach($arrData as $x=>$data):
            $this->adodbx->Insert($this->model->tbl_group_to_modules, $data);
        endforeach;
        $ok=$this->conn->CompleteTrans();
        $this->_proses_message($ok,$this->agent->referrer(),$this->agent->referrer());
	}
    
    function _proses_message($ok,$url_ok=false,$url_error=false){
        $url_ok=$url_ok?$url_ok:$this->module;
        $url_error=$url_error?$url_error:$this->module;
        if(!$this->input->is_ajax_request()):    
            if($ok):
                    set_message("success", $this->msg_ok);
                    redirect($url_ok);
            else:
                    set_message("error",$this->msg_fail);
                    redirect($url_error);
            endif;  
        else:
            if($ok):
                 print "ok";
            else:
                print "failed";
            endif;    
        endif;
    }
    
    function test_cms_library(){
        $this->load->library("cms");
		//$this->cms=Cms->factory();
		//$this->cms=new Cms();
		//pre($this->cms);
        //$this->cms=new Cms();
		//$this->cms->init_user();
		//$this->cms=$this->cms->factory();
       // $this->cms->factory();
		pre($this->cms->user_group);
		exit();
        if($this->cms->has_read("admin/dms/")){
            print "anda berhak read";
        }else{
            print "anda tidak berhak membaca";
        }
         
         //pre($cms->get_module_right_max("admin/dms"));
    }


}
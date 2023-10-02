<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms{

    var $NONE_RIGHT = 0;
    var $VIEW_RIGHT = 1;
    var $READ_RIGHT = 2;
    var $WRITE_RIGHT = 3;
    var $ADMIN_RIGHT = 4;
    var $user_data=array();
    var $user_group=array();
    
    
	public function factory(){
		$class=__CLASS__;
		return new $class();
	}
	
	public function __construct()
	{
		$CI =& get_instance();
		
		$this->load->model("LAT_Model");
	    $this->load->model("user/acl_model");
		$this->acl_model=new acl_model();
		$this->init_user();
		return $this;
		//$this->init_user();
	}
	
	/**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     **/
  
    public function __call($method, $arguments)
    {
        if (!method_exists( $this->ion_auth_model, $method) )
        {
            throw new Exception('Undefined method Ion_auth::' . $method . '() called');
        }

        return call_user_func_array( array($this->ion_auth_model, $method), $arguments);
    }

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access  public
     * @param   $var
     * @return  mixed
     */
	
    public function __get($var)
    {
        return get_instance()->$var;
    }
    
	
	public function init(){
		$this->init_user();
	}
	
    public function init_user(){
		$CI=& get_instance();
		$this->user_data=$CI->data['users']['user'];
        $this->user_group=$CI->data['users']['groups'];
       //pre($this->user_group);
    }
	
	public function get_group(){
		return $this->user_group;
	}
	
	public function get_user(){
		return $this->user_data;
	}
    
    
    function has_none($module=false){
        if(!$module):
            $module=$this->module;
        endif;
        $module_id=$this->conn->GetOne("select idx from ".$this->acl_model->tbl_modules." where active=1 and (module_path='".$module."' or module_url='".$module."')");
        if($module_id):
        foreach($this->user_group as $x=>$group):
            $group_id=$group["id"];
            $right=$this->get_module_right($module_id, $group_id);
            if($right>=$this->NONE_RIGHT):
                return TRUE;
            endif;
        endforeach;
        endif;
        return FALSE;
    }
    
    
    function has_view($module=false){
        if(!$module):
            $module=$this->module;
        endif;
        $module_id=$this->conn->GetOne("select idx from ".$this->acl_model->tbl_modules." where active=1 and (module_path='".$module."' or module_url='".$module."')");
        if($module_id):
        foreach($this->user_group as $x=>$group):
            $group_id=$group["id"];
            $right=$this->get_module_right($module_id, $group_id);
            if($right>=$this->VIEW_RIGHT):
                return TRUE;
            endif;
        endforeach;
        endif;
        return FALSE;
    }
    
    function has_read($module=false){
        if(!$module):
            $module=$this->module;
        endif;
        $module_id=$this->conn->GetOne("select idx from ".$this->acl_model->tbl_modules." where active=1 and (module_path='".$module."' or module_url='".$module."')");
        if($module_id):
        foreach($this->user_group as $x=>$group):
            $group_id=$group["id"];
            $right=$this->get_module_right($module_id, $group_id);
            if($right>=$this->READ_RIGHT):
                return TRUE;
            endif;
        endforeach;
        endif;
        return FALSE;
    }

    function has_write($module=false){
        if(!$module):
            $module=$this->module;
        endif;
        
        $module_id=$this->conn->GetOne("select idx from ".$this->acl_model->tbl_modules." where active=1 and (module_path='".$module."' or module_url='".$module."')");
        if($module_id):
        foreach($this->user_group as $x=>$group):
            $group_id=$group["id"];
            $right=$this->get_module_right($module_id, $group_id);
            if($right>=$this->WRITE_RIGHT):
                return TRUE;
            endif;
        endforeach;
        endif;
        return FALSE;
    }
    
    function has_admin($module=false){
        if(!$module):
            $module=$this->module;
        endif;
        $module_id=$this->conn->GetOne("select idx from ".$this->acl_model->tbl_modules." where active=1 and (module_path='".$module."' or module_url='".$module."')");
        if($module_id):
        foreach($this->user_group as $x=>$group):
            $group_id=$group["id"];
            $right=$this->get_module_right($module_id, $group_id);
            if($right>=$this->ADMIN_RIGHT):
                return TRUE;
            endif;
            
        endforeach;
        endif;
        return FALSE;
    }
    
    function _get_module_id($module=false){
        if(!$module):
            $module=$this->module;
        endif;
        
        $module_id=$this->conn->GetOne("select idx from ".$this->acl_model->tbl_modules." where active=1 and (module_path='".$module."' or module_url='".$module."')");
        return $module_id;
    }

    
    function get_module_right($module_id,$group_id){
        return $this->conn->GetOne("select rights from ".$this->acl_model->tbl_group_to_modules." where module_id=$module_id and group_id=$group_id");
    }
    
    
    function get_module_right_max($module_path_or_url=false){
        if(!$module_path_or_url):
            $module_path_or_url=$this->module;
        endif;    
        //debug();
        //pre($this->user_group);
        //exit();
        $module_id=$this->_get_module_id($module_path_or_url);
        if($module_id):
            foreach($this->user_group as $group):
                $group_id=$group["id"];
                $data[]=$this->get_module_right($module_id, $group_id);
            endforeach;
            return max($data);
        endif;
        return 0;
    }
    
    function get_module_right_min($module_path_or_url=false){
        if(!$module_path_or_url):
            $module_path_or_url=$this->module;
        endif;
        $module_id=$this->_get_module_id($module_path_or_url);
        if($module_id):
        foreach($this->user_group as $group):
            $group_id=$group["id"];
            $data[]=$this->get_module_right($module_id, $group_id);
        endforeach;
        return min($data);
        endif;
        return 0;
    }
    
    
    /* ACL */
    function get_modules(){
		$this->arr_modules=$this->acl_model->get_modules();
	   return $this->arr_modules;
    }
    
    function get_rights(){
        $this->arr_rights=$this->acl_model->get_rights();
        return $this->arr_rights;
    }
    
    function get_group_to_modules(){
        $this->arr_group_2_modules=$this->get_group_to_modules();
        return $this->arr_group_2_modules;
    }
    
    
    
    
    
    

}
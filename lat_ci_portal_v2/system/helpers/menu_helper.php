<?
	function get_menu_data(){
		$CI=& get_instance();
		$conn=$CI->conn;
		/*
		$appname=$CI->lauth->appname;
		if(isset($_SESSION[$appname]["userdata"])):
			$userLevelID=$_SESSION[$appname]["userdata"]["user_level_id"];
		else:
			$userLevelID=99;
		endif;
		$sql="select * from t_level_menu_acl a left join t_menu b on a.menu_id=b.hierarchy_id ";
		$sql.=" where ";
		$sql.="  a.kd_level=$userLevelID ";
		$sql.=" and ";
		$sql.=" flag_view=1 ";
		$sql.=" order by order_num ";
		*/
		$sql="select * from t_menu where flag_view=1 order by order_num";
		$arr=$conn->GetAll($sql);
		return $arr;
	}
	
	function build_menu_bootstrap($rows,$parent=0){
		$CI=& get_instance();
		$appname=$CI->lauth->appname;
		$menu_title="";
		if(!$CI->config->item("menu_title")):
			$CI->config->load("app");
		endif;
		$menu_title=$CI->config->item("menu_title");
		
		ob_start();
		?>
		<div class="navbar navbar-inverse navbar-fixed-top">
  			<div class="navbar-inner">
    			<div class="container-fluid">
                	 <!-- where collapse show this -->	
                	 <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </a>
                      <a class="brand" href="<?php echo base_url()?>"><i class="icon-home"></i> <?=$menu_title?> </a>
                      <!-- button user-->
                      <div class="btn-group pull-right">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                          <i class="icon-user"></i> 
						  <?php
                          		$name=isset($_SESSION[$appname]["userdata"]["name"])?$_SESSION[$appname]["userdata"]["name"]:"";
								echo $name;
						  ?>
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a href="<?php echo base_url();?>setting/user/change_password/"><i class="icon-lock"></i> Change Password</a></li>
                          <li><a href="<?php echo base_url();?>setting/user/profiles/"><i class="icon-user"></i> Profiles</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo base_url()?>login/logout/"><i class="icon-off"></i> Logout</a></li>
                        </ul>
                        </div>
                        <!-- menu from t_menu-->
                        
                        <div class="nav-collapse">
        					<ul class="nav">
                            	
                            	<? build_menu_detail($rows);?>
                            </ul>
                        </div> <!-- /nav-->
                        
                     
                </div><!-- /container -->
            </div><!-- /navbar inner -->
        </div><!-- /nav bar -->
	<?
		$html=ob_get_clean();
		return $html;
    }
	
	function build_menu_detail($rows,$parent=0)
	{   
		foreach ($rows as $row):
			if ($row['menu_parent_id'] == $parent):
		?>
        <? if (has_children($rows,$row['hierarchy_id'])):?>    
	 	<li class="dropdown">
               <a href="#"
                      class="dropdown-toggle"
                      data-toggle="dropdown">
                      <?php echo $row["menu_text"]; ?>
                      <b class="caret"></b>
                      </a>
               
               <ul class="dropdown-menu">
               	   <?php build_menu_detail($rows,$row['hierarchy_id']);?>
               </ul>
              
         </li>
          <? else: ?>
          		<li><a href="<?=base_url()?><?=$row["menu_url"]?>"><?=$row["menu_text"]?></a></li>
		  <? endif; ?>
         
		<?
				endif; 
			endforeach;
	}

	function build_menu($rows,$parent=0)
	{  
	  $result = "<ul>";
	  foreach ($rows as $row)
	  {
		if ($row['menu_parent_id'] == $parent){
		  $result.= "<li>{$row['menu_text']}";
		  if (has_children($rows,$row['hierarchy_id']))
			$result.= build_menu($rows,$row['hierarchy_id']);
		  $result.= "</li>";
		}
	  }
	  $result.= "</ul>";
	
	  return $result;
	}
	
	function has_children($rows,$id) {
	  foreach ($rows as $row) {
		if ($row['menu_parent_id'] == $id)
		  return true;
	  }
	  return false;
	}


	function print_menu(){
		global $homeUrl;
		$idx=array();
		$menu_id=array();
		$header=array();
		$obj =& get_instance();
		$conn=$obj->conn;
		//$userID=$_SESSION['user_id'];
		//$_SESSION['kd_level']=0;
		//$userLevelID=$conn->GetOne("select user_level_id from t_user where id='".$_SESSION['userdata']['id']."'");
		$userLevelID=$_SESSION["userdata"]["user_level_id"];
		$conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$sql="select * from t_level_menu_acl a left join t_menu b on a.menu_id=b.hierarchy_id where a.kd_level=$userLevelID and menu_parent_id=0 and flag_view=1 order by order_num";
		
		
		//$sql="select * from t_menu where menu_parent_id=0 and kd_level=0  and flag_view=1 order by order_num";
		$arrData=$conn->GetAll($sql);
		foreach($arrData as $x=>$value):
			$header[]=$value["menu_text"];
			//$idx[]=$value["idx"];
			$menu_id[]=$value["hierarchy_id"];
		endforeach;
		ob_start();
    	?>
        <ul id="nav">
        <?php 
        echo "<li><a id=\"Home\" class=\"a_menu\" rel=\"".$homeUrl."dashboard/dashboard/\" href=\"#\">".loadImage("home.png","width=15px height=15px")."&nbsp;&nbsp;Home</a></li>";
        ?>
        <? for($i=0;$i<count($header);$i++):?>
        <li class=""><a href="#"><?=$header[$i]?></a>
            <? display_children($conn,$menu_id[$i],$userLevelID); ?>
        </li>       
        <? endfor; ?>
        </ul>
    	<?
		$html=ob_get_contents();
		ob_end_clean();
		return $html;
	}
	
	function display_children($conn,$parent,$level) {
		global $homeUrl;
	   //$sql="select * from t_menu where menu_parent_id=".$parent."  and flag_view=1 order by order_num";
	   //$userID=$_SESSION['user_id'];
	   //$userLevelID=$_SESSION['user_level_id'];
	   
	  $sql="select * from t_level_menu_acl a left join t_menu b on a.menu_id=b.hierarchy_id where menu_parent_id='".$parent."' and flag_view=1 and a.kd_level=$level order by order_num";
	 // $sql="select * from t_level_menu_acl a left join t_menu b on a.menu_id=b.hierarchy_id where menu_parent_id='".$parent."' and flag_view=1 order by order_num";
	   $result=$conn->Execute($sql);
	   if ($result):
			
			echo "<ul>";
			while ($row = $result->FetchRow()):
				 echo "<li><a id=\"".$row["hierarchy_id"]."\" class=\"a_menu\" rel=\"".getModules($row["menu_url"])."\" href=\"#\">".loadImage("table.png","width=15px height=15px")."&nbsp;&nbsp;".$row['menu_text']."</a></li>";
				 display_children($conn,$row['hierarchy_id'], $level+1);
			endwhile;
			echo "</ul>";
		endif;
	} 

	function getModules($get_str){
		//$imp_str= str_replace(':',SEP,$get_str);
		$the_page= base_url().$get_str;
		return $the_page;
	}

?>

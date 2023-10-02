<?php
/**
 * Class db for Ajax Auto Refresh - Volume II - demo
 *
 * @author Eliza Witkowska <kokers@codebusters.pl>
 * @link http://blog.codebusters.pl/en/entry/ajax-auto-refresh-volume-ii
 */
class dbautochecker{

	/**
	 * db
	 *
	 * @var $	public $db;
	 */
	public $db;
	public $con = '';
	public $serverurl = '';
	/**
	 * __construct
	 *
	 * @return void
	 */
	function __construct(){
		$this->db_connect('localhost','root','Root@123456','bnn_rehab_db_v2');
		
	}


	/**
	 * db_connect
	 *
	 * Connect with database
	 *
	 * @param mixed $host
	 * @param mixed $user
	 * @param mixed $pass
	 * @param mixed $database
	 * @return void
	 */
	function db_connect($host,$user,$pass,$database){
		$this->db = new mysqli($host, $user, $pass, $database);
		$this->con = mysqli_connect($host, $user, $pass, $database);
		if($this->db->connect_errno > 0){
			die('Unable to connect to database [' . $this->db->connect_error . ']');
		}
	}


	/**
	 * check_changes image registerasi apakah udah terupload atau belum
	 *
	 * Get update value from database
	 *
	 * @return void
	 */
	function check_changes($idx_pasien,$id_jari){
		$result = $this->db->query("SELECT img FROM t_pasien_finger_foto WHERE idx_pasien = $idx_pasien and id_jari = $id_jari and flag_default = 1");
		//$result = mysqli_query($con,"SELECT img FROM t_pasien_finger_foto WHERE idx_pasien = $idx_pasien and id_jari = $id_jari and flag_default = 1");
		//if($result = $result->fetch_object()){
			if (!empty($result)) {
					if (mysqli_num_rows($result) > 0) {
						$result = mysqli_fetch_array($result,MYSQLI_ASSOC);			
						$img=$result['img'];
						/*while($r = $result->fetch_object()){
							$img = $r->img;
						}*/
						return $serverurl.'/fingerprint_headoffice_webservice/finger_image/'.$img;
					}
		}
		return "assets/images/pic.jpg";
	}
	
	/**
	 * check_changes image verifikasi apakah terverifikasi atau belum jika sudah image akan diganti dengan gambar ceklist
	 *
	 * Get update value from database
	 *
	 * @return void
	 */
	function check_changes_verification($idx_pasien,$id_jari){
		$result = $this->db->query("SELECT flag_status_verification FROM t_pasien_finger_verification WHERE idx_pasien = $idx_pasien and id_jari = $id_jari and flag_status_verification  = 1");
		//$result = mysqli_query($con,"SELECT img FROM t_pasien_finger_foto WHERE idx_pasien = $idx_pasien and id_jari = $id_jari and flag_default = 1");
		//if($result = $result->fetch_object()){
			if (!empty($result)) {
					if (mysqli_num_rows($result) > 0) {
						$result = mysqli_fetch_array($result,MYSQLI_ASSOC);			
						$flag_status_verification=$result['flag_status_verification'];
						if($flag_status_verification == 1){
							return "assets/images/ijo_bagus.jpg";		
						}						
						//return $serverurl.'/fingerprint_headoffice_webservice/finger_image/'.$img;
					}
		}
		return "assets/images/pic.jpg";
	}
	
	
	/**
	 * check_changes image identifikasi apakah teridentifikasi atau belum jika sudah image akan diganti dengan gambar ceklist
	 *
	 * Get update value from database
	 *
	 * @return void
	 */
	function check_changes_identification($idx_pasien,$id_jari){
		$result = $this->db->query("SELECT flag_status_identification FROM t_pasien_finger_identification WHERE idx_pasien = $idx_pasien and id_jari = $id_jari and flag_status_identification  = 1");
		//$result = mysqli_query($con,"SELECT img FROM t_pasien_finger_foto WHERE idx_pasien = $idx_pasien and id_jari = $id_jari and flag_default = 1");
		//if($result = $result->fetch_object()){
			if (!empty($result)) {
					if (mysqli_num_rows($result) > 0) {
						$result = mysqli_fetch_array($result,MYSQLI_ASSOC);			
						$flag_status_identification=$result['flag_status_identification'];
						if($flag_status_identification == 1){
							return "assets/images/ijo_bagus.jpg";		
						}						
						//return $serverurl.'/fingerprint_headoffice_webservice/finger_image/'.$img;
					}
		}
		return "assets/images/pic.jpg";
	}

	/**
	 * register_changes
	 *
	 * Increase value of counter in database. Should be called everytime when
	 * something change (add,edit or delete)
	 *
	 * @return void
	 */
	function register_changes(){
		$this->db->query('UPDATE news SET counting = counting + 1 WHERE id=1');
	}


	/**
	 * get_news
	 *
	 * Get list of news
	 *
	 * @return void
	 */
	function get_news(){
		if($result = $this->db->query('SELECT * FROM news WHERE id<>1 ORDER BY add_date DESC LIMIT 50')){
			$return = '';
			while($r = $result->fetch_object()){
				$return .= '<p>id: '.$r->id.' | '.htmlspecialchars($r->title).'</p>';
				$return .= '<hr/>';
			}
			return $return;
		}
	}


	/**
	 * add_news
	 *
	 * Add new message
	 *
	 * @param mixed $title
	 * @return void
	 */
	function add_news($title){
		$title = $this->db->real_escape_string($title);
		if($this->db->query('INSERT into news (title) VALUES ("'.$title.'")')){
			$this->register_changes();
			return TRUE;
		}
		return FALSE;
	}
}
/* End of file db.php */

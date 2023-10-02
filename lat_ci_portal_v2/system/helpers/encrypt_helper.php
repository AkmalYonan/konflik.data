<?
    /* Safely encrypts data for POST transport
     * URL issues
     *  transforms + to spaces
     *  / are param value separators
     *  = are param value separators
     *
     *  we process the string on reverse
     * @param string $string
     */
    function b64encode($string)
    {
        $data = base64_encode($string);
        //$data = str_replace(array('+','/','='),array('-','_','.'),$data);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
    
    /**
     *
     * The encoding string had to be specially encoded to be transported
     * over the HTTP
     *
     * The reverse function has to be executed on the client
     *
     * @param string $string
     */
    function b64decode($string)
    {
      //$data = str_replace(array('-','_','.'),array('+','/','='),$string); 
      $data = str_replace(array('-','_'),array('+','/'),$string);
      $mod4 = strlen($data) % 4;
      if ($mod4) {
        $data .= substr('====', $mod4);
      }
      
      return base64_decode($data);
    }
    
    //othere base64 safe url and file but add allowed ! character in config
    function sb64encode($input,$padstr='')
    {
        $data=strtr(base64_encode($input), '+/', '-_');
        $data=str_replace('=',$padstr,$data);
        return $data;
        
    }
    
    function sb64decode($input,$padstr='')
    {
        $data=strtr($input, '-_', '+/'); 
        $data=str_replace($padstr,'=',$data);
        
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
    
    //without mcrcypt
    function enc_encrypt($key, $string) {
        $result = '';
        for($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
    
        return base64_encode($result);
    }
    
    function enc_decrypt($key, $string) {
        $result = '';
        $string = base64_decode($string);
    
        for($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
    
        return $result;
    }
    
    //without mcrypt
    function RotEncrypt($pass, $str){
       $pass = str_split(str_pad('', strlen($str), $pass, STR_PAD_RIGHT));
       $stra = str_split($str);
       foreach($stra as $k=>$v){
         $tmp = ord($v)+ord($pass[$k]);
         $stra[$k] = chr( $tmp > 255 ?($tmp-256):$tmp);
       }
       return join('', $stra);
    }
    
    function RotDecrypt($pass, $str){
       $pass = str_split(str_pad('', strlen($str), $pass, STR_PAD_RIGHT));
       $stra = str_split($str);
       foreach($stra as $k=>$v){
         $tmp = ord($v)-ord($pass[$k]);
         $stra[$k] = chr( $tmp < 0 ?($tmp+256):$tmp);
       }
       return join('', $stra);
    }
    
    function encrypt($string) {
        //Key
        //$key = "WhogetOyhacrun12345";
        $CI=& get_instance();
        $key=$CI->config->item("app_key");
        //Encryption
        if(function_exists("mcrypt_encrypt")):
            $cipher_alg = MCRYPT_TRIPLEDES;
            $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg,MCRYPT_MODE_ECB), MCRYPT_RAND); 
            $encrypted_string = mcrypt_encrypt($cipher_alg, $key, $string, MCRYPT_MODE_ECB, $iv);
        else:
            $encrypted_string = RotEncrypt($key,$string);
        endif;
        return b64encode(b64encode($encrypted_string));
        return $encrypted_string;
    }

    function decrypt($string) {
            $string = b64decode(b64decode($string));
            $CI=& get_instance();
            //key
            $key=$CI->config->item("app_key");

            if(function_exists("mcrypt_encrypt")):
                $cipher_alg = MCRYPT_TRIPLEDES;
    
                $iv = mcrypt_create_iv(mcrypt_get_iv_size($cipher_alg,MCRYPT_MODE_ECB), MCRYPT_RAND); 
    
                $decrypted_string = mcrypt_decrypt($cipher_alg, $key, $string, MCRYPT_MODE_ECB, $iv);
            else:
                $decrypted_string = RotDecrypt($key,$string);
            endif;
            return trim($decrypted_string);
    }
    
    
    /**
 * Generates a Universally Unique IDentifier, version 4.
 *
 * RFC 4122 (http://www.ietf.org/rfc/rfc4122.txt) defines a special type of Globally
 * Unique IDentifiers (GUID), as well as several methods for producing them. One
 * such method, described in section 4.4, is based on truly random or pseudo-random
 * number generators, and is therefore implementable in a language like PHP.
 *
 * We choose to produce pseudo-random numbers with the Mersenne Twister, and to always
 * limit single generated numbers to 16 bits (ie. the decimal value 65535). That is
 * because, even on 32-bit systems, PHP's RAND_MAX will often be the maximum *signed*
 * value, with only the equivalent of 31 significant bits. Producing two 16-bit random
 * numbers to make up a 32-bit one is less efficient, but guarantees that all 32 bits
 * are random.
 *
 * The algorithm for version 4 UUIDs (ie. those based on random number generators)
 * states that all 128 bits separated into the various fields (32 bits, 16 bits, 16 bits,
 * 8 bits and 8 bits, 48 bits) should be random, except : (a) the version number should
 * be the last 4 bits in the 3rd field, and (b) bits 6 and 7 of the 4th field should
 * be 01. We try to conform to that definition as efficiently as possible, generating
 * smaller values where possible, and minimizing the number of base conversions.
 *
 * @copyright  Copyright (c) CFD Labs, 2006. This function may be used freely for
 *              any purpose ; it is distributed without any form of warranty whatsoever.
 * @author      David Holmes <dholmes@cfdsoftware.net>
 *
 * @return  string  A UUID, made up of 32 hex digits and 4 hyphens.
 */

    function uuid() {
  
   // The field names refer to RFC 4122 section 4.1.2

   return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
       mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
       mt_rand(0, 65535), // 16 bits for "time_mid"
       mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
       bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
           // 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
           // (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
           // 8 bits for "clk_seq_low"
       mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node" 
        ); 
    }
    
    function generate_token($userID,$password="",$email=""){
            $currTime=time();
            $tokenTime=time() + 1800;
            $token=$currTime."|".$userID."|".$password."|".$email."|".$tokenTime;
            
            return encrypt($token);
    }
    
    function validate_token($token=false){
        try{
            if(($token==false)||($token=="")){
                return false;
            }
            $sesToken=$_SESSION["token"];
            if($token==$sesToken){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            return false;
        }
    }
    
    function parse_token($token=false){
        $parseToken=decrypt($token);
        $arr=explode("|",$parseToken);
        return $arr;        
    }
    
    
    function generate_key($userID='')  
    {  
        //Get the IP-address of the user  
        $ip = $_SERVER['REMOTE_ADDR'];  
  
        //We use mt_rand() instead of rand() because it is better for generating random numbers.  
        //We use 'true' to get a longer string.  
        //See http://www.php.net/mt_rand for a precise description of the function and more examples.  
        $uniqid = uniqid(mt_rand(), true);  
        
        $token= md5($ip.$uniqid.$userID);  
        $tokenTime=time() + 1800;
        $arr["token"]=$token;
        $arr["token_time"]=$tokenTime;
        $_SESSION['token'] = $token;
        $_SESSION['token_time'] = $tokenTime;//30 minutes expire
        return $token;
    }  
    
    function validate_key($token,$clearAfterValidate=true)  
    {   
        if (!isset($_SESSION['token'], $_SESSION['token_time']))
        {
            return false;
        }
    
        if($token == $_SESSION["token"])  
        {  
            return true;  
        }else{
            return false;
        }  
        
        $sesToken = $_SESSION['token'];
        $expires = $_SESSION['token_time'];
        
        // Clear the tokens, they are single use.
        if($clearAfterValidate):
            $_SESSION['token'] = NULL;
            $_SESSION['token_time'] = 0;
        endif;
        
        if ($expires < time() || $sesToken != $token)
        {
            return false;
        }
        else
        {
            return true;
        }
        
    }  
    
    
    
    /*
    $arrToken=generate_key();
    print_r($arrToken);
    print validate_key($arrToken["token"]);
    echo "<br>";
    */
    /*
    $x=generate_token("test");
    echo $x;
    $arr=parse_token($x);
    print_r( $arr);
    */
    
?>
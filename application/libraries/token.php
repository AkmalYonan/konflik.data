<?php
class Token {
	private static $algo = "sha1";
	function createToken($salt = "", $name = "", $expire = 300) {
		// generate the token
		if ($salt === "") {
			$token = hash(self::$algo, uniqid(rand(), true), false);
		} else {
			$token = hash(self::$algo, $salt . session_id(), false);
		}
		// in case we already created that token, it is again valid
		if (isset($_SESSION['tokens_used'][$token])) {
			unset($_SESSION['tokens_used'][$token]);
		}
		$token0=$token;
		// create timestamp
		$time = time() + $expire;
		//$_SESSION['tokens_used'][$token]=$time;
		// calculate HMAC
		$hmac = self::createHmac($token, $time, strtolower($name));
		// glue all together
		$token .= "-" . $time . "-" . $hmac;
		if ($name !== "") {
			$token .= "-" . strtolower($name);
		}
		return $token;
	}

	public function checkToken($token, $name = "", $delete = true) {
		$token = explode('-', $token);
		$token[3] = (isset($token[3])) ? $token[3] : "";
		// check if token was used
		if (isset($_SESSION['tokens_used'][$token[0]])) {
			return false;
		}
		// check token integrity
		$hmac = self::createHmac($token[0], $token[1], $token[3]);
		if ($hmac !== $token[2]) {
			return false;
		}
		// check expiry time
		if ($token[1] < time()) {
			return false;
		}
		// check form name
		if ($token[3] !== strtolower($name)) {
			return false;
		}
		// token was not used, is not expired and the form name matches
		if ($delete === true) {
			self::deleteToken($token[0]);
		}
		return true;
	}
	public function createHmac($token, $time, $name) {
		$secret = "WhOgEt019283";
		return hash(self::$algo, $token . $time . $name . $secret . session_id(), false);
	}
	public function deleteToken($token) {
		if (!is_array($token)) {
			$token = explode('-', $token);
		}
		$_SESSION['tokens_used'][$token[0]] = "";
	}
}

/**
	This is our final class for using tokens all over your site, most cases where you could need special tokens should be covered. It is optimized for memory usage, if you want to optimize it for CPU usage, step back to the point before we introduced the HMAC (you have to save all tokens, not only the used ones but do not have to compute the HMAC).
If you want further optimization for less memory usage, you can set a expiry time for the used tokens. After this time passed the used tokens will be cleared and the tokens may be reused. But beware: replay attacks are then possible (after the time for which you hold used tokens to detect replays).
All used tokens are cleared automatically when the user quits his session but will not work in another session.

For completeness...some usage samples:
Simple one-time token for usage as page token or posting-token (prevents double form submissions as well):

<input type="hidden" name="token" value="<?php echo Token::createToken();?>" />
...
if (Token::checkToken($_POST['token'])) {
...

Simple token for usage as session token (i would not use that kind of token):

<input type="hidden" name="token" value="<?php echo Token::createToken();?>" />
...
if (Token::checkToken($_POST['token'], false)) {
...

Salted token, for forms that should be submittable only on one tab if several tabs are open:

<input type="hidden" name="token" value="<?php echo Token::createToken("login");?>" />
...
if (Token::checkToken($_POST['token'])) {
...

Form-aware token. You can use this as extra to secure restricted forms. A user could craft a form he isn’t allowed to use but would never gain a valid token for that form (if you don’t display it to him…):

<input type="hidden" name="token" value="<?php echo Token::createToken("", "secureForm");?>" />
...
if (Token::checkToken($_POST['token'], "secureForm")) {
...

Or a combination of the two above:

<input type="hidden" name="token" value="<?php echo Token::createToken("deleteUser", "adminOnly");?>" />
...
if (Token::checkToken($_POST['token'], "adminOnly")) {
...

Finally I have to admit that I only thought about that for my own. If you see any possibilities to improve that token system in matters of security or performance feel free to leave a comment.
*/
?>

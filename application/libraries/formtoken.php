<?php
class formtoken
{
    const FIELDNAME = 'tok';
    const DO_NOT_CLEAR = FALSE;

    public static function getField()
    {
        $token = self::_generateToken();
        return "<input name='" . self::FIELDNAME . "' value='{$token}' type='hidden' />";
    }

    public static function validateToken($request, $clear = true)
    {
        $valid = false;
        $posted = isset($request[self::FIELDNAME]) ? $request[self::FIELDNAME] : '';

        if (!empty($posted)) {
            if (isset($_SESSION['formtoken'][$posted])) {
                 if ($_SESSION['formtoken'][$posted] >= time() - 7200) {
                    $valid = true;
                 }
                 if ($clear) unset($_SESSION['formtoken'][$posted]);
            }
        }

        return $valid;
    }

    protected static function _generateToken()
    {
        $time = time();
        $token = sha1(mt_rand(0, 1000000));
        $_SESSION['formtoken'][$token] = $time;
        return $token;
    }
}

/*
<form action="process.php" method="post">
<label>What is your name? <input name="name" /></label>
<input type="submit" />
<?php echo formtoken::getField() ?>
</form>
*/

/*
if (formtoken::validateToken($_POST)) {
 	//do it
}
else {
 die('The form is not valid or has expired.');
}
*/
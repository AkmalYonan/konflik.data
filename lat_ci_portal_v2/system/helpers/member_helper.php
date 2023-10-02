<?php
function MakeConfirmationCode($email)
    {
		$rand_key="A33I83Bk11msX3xE";
        $randno1 = rand();
        $randno2 = rand();
        return md5($email.$rand_key.$randno1.''.$randno2);
    }

?>

<?php

function export2xls(){
	$file=$_POST["filename"];
    $xlsContent=$_POST["tbl"];
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file");
	header("Pragma: ");
	header("Cache-Control: ");
    echo $xlsContent;
}



<?php
function ArrPHP2JS($phpArray, $jsArrayName, &$html = '') {
        $html .= $jsArrayName . " = new Array(); \r\n ";
        foreach ($phpArray as $key => $value) {
                $outKey = (is_int($key)) ? '[' . $key . ']' : "['" . $key . "']";
 
                if (is_array($value)) {
                        ArrPHP2JS($value, $jsArrayName . $outKey, $html);
                        continue;
                }
                $html .= $jsArrayName . $outKey . " = ";
                if (is_string($value)) {
                        $html .= "'" . $value . "'; \r\n ";
                } else if($value === FALSE) {
                        $html .= "false; \r\n";
                } else if ($value === NULL) {
                        $html .= "null; \r\n";
                } else if ($value === TRUE) {
                        $html .= "true; \r\n";
                } else {
                        $html .= $value . "; \r\n";
                }
        }
 
        return $html;
}



//
//  makeJavaScriptArray - Returns a JavaScript array constant created from the provided PHP nested array.
//                        this function is typically called to create a response to an Ajax request. 
//
//  Note: While this function will protect the JavaScript code from special characters, the calling code
//        still needs to encode any HTML entities before sending the result to the browser.
//

function makeJavaScriptArray( $phpArray )
{
    $arrayConstant = '{';
    $delimiter = '';
    
    foreach ($phpArray as $fieldName => $fieldValue)
    {
        if (is_bool( $fieldValue ))                                    // Boolean data type
            if ($fieldValue) $fieldConstant = 'true';
            else $fieldConstant = 'false';
        
        elseif (is_numeric( $fieldValue ))                            // Numeric data type
            $fieldConstant = $fieldValue;
        
        elseif (is_string( $fieldValue ))                            // String data type
            $fieldConstant = "'" . addSlashes( $fieldValue ) . "'";
            
        elseif (is_array( $fieldValue ))                            // Array data type
            $fieldConstant = makeJavaScriptArray( $fieldValue );
            
        else                                                        // Unknown data type
            $fieldConstant = '';
        
        if ($fieldConstant > '')
        {
            $arrayConstant .= $delimiter . " '$fieldName': $fieldConstant";
            $delimiter = ',';
        }
    } 
	$arrayConstant .= "}";
	return $arrayConstant."\n";
}
/*
$phpArray = array();
$phpArray['string'] = 'text string';
$phpArray['number'] = 1234;
$phpArray['boolean'] = FALSE;
$subArray = array();
$subArray[] = 'text string';
$subArray[] = 1234;
$subArray[] = TRUE;
$phpArray['array'] = $subArray;
$javaScriptCode = 'javaScriptVariable = ' . htmlentities( makeJavaScriptArray( $phpArray ) );
*/
<?php

function set_flash($name,$data){
    $CI=& get_instance();
    $CI->session->set_flashdata($name,$data);
}

function get_flash($name){
    $CI=& get_instance();
    $data=$CI->session->flashdata($name)?$CI->session->flashdata($name):FALSE;
    return $data;
}

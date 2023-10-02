<?php

function news_send($data){
    
    $ci =   & get_instance();
    
    $sql        =   "select email from news_subscriber where status='1' group by email";
    
    $recipient  =   $ci->conn->GetAll($sql);
   
    $ci->load->library('email');
    
    foreach($recipient as $k=>$v):
    
        $ci->email->clear();
        $ci->email->from('lingkardevel@gmail.com', 'MESI - OTDA (Media Sistem Informasi - Otonomi Daerah)');
        $ci->email->to($v['email']);

        $ci->email->subject("Otda News - ".$data['title']);
        $ci->email->message("<h4>".$data['title']."</h4>".$data['content']);

        $ci->email->send();  
        
    endforeach;    
    
}

function cek_email($email){
    
    $ci     =   & get_instance();
    
    $sql    =   "select email from news_subscriber where status='1' and email='".$email."'";
    
    $data   =   $ci->conn->GetOne($sql);
    
    if($data):
        return 1;
    else:
        return 0;
    endif;
    
}

function email_validation($email){
    
    $ci     =   & get_instance();
    
    $sql    =   "select email from news_subscriber where status='0' and email='".$email."'";
    
    $data   =   $ci->conn->GetOne($sql);
    
    if($data):
        return 1;
    else:
        return 0;
    endif;
}

function send_activation_email($email,$id){
    
    $ci     =   & get_instance();
    
    $ci->load->helper(array('url'));
    
    $ci->email->clear();
    $ci->email->from('lingkardevel@gmail.com', 'MESI - OTDA (Media Sistem Informasi - Otonomi Daerah)');
    $ci->email->to($email);

    $ci->email->subject("Subscribe Otda News Activation");
    
    
    $message    =   "<h4>Aktivasi Untuk Berlangganan Berita Otonomi Daerah</h4>";
    $message    .=  "<br />";
    $message    .=  "Dapatkan Berita - berita terbaru seputar Otonomi Daerah";
    $message    .=  "<br />";
    
    $link       =   "http://".$_SERVER['SERVER_NAME'].$ci->config->item('base_url')."home/subcribe_activate/".$id;
    
    $message    .=  "<h3>Activation Email <a href='".$link."'>".$email."</a></h3>";
    
    $ci->email->message($message);

    $ci->email->send(); 
    
}

function send_deactivation_email($email,$id){
    
    $ci     =   & get_instance();
    
    $ci->load->helper(array('url'));
    
    $ci->email->clear();
    $ci->email->from('lingkardevel@gmail.com', 'MESI - OTDA (Media Sistem Informasi - Otonomi Daerah)');
    $ci->email->to($email);

    $ci->email->subject("Subscribe Otda News Deactivation");
    
    
    $message    =   "<h4>Berhenti Berlangganan Berita Otonomi Daerah</h4>";
    $message    .=  "<br />";
    
    $link       =   "http://".$_SERVER['SERVER_NAME'].$ci->config->item('base_url')."home/subcribe_deactivate/".$id;
    
    $message    .=  "<h3>Deactivation Email <a href='".$link."'>".$email."</a></h3>";
    
    $ci->email->message($message);

    $ci->email->send(); 
    
}

?>
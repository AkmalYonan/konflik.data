
             $(function(){
               
                $(document).ready(function(){
// alert(basedomain);
                   $('.ajax-spinner-bars').css("display","block"); 
                        $.post(basedomain+urlPageList+"dataAjax/0/10/1", {actionfunction: 'showData',page:'1',kategori:'a'}, function(data){
                            // console.log(data);
                            if (data.status==true) {
                               // console.log(data.data);
                                    $('#dataAjax').html(data.data); 

                                   
                                    $('.ajax-spinner-bars').css("display","none");
                            }else{
                                 $('.ajax-spinner-bars').css("display","none"); 
                            }
                        }, "JSON")
                    
                    })
                
                $('#dataAjax').on('click','.page-numbers',function(){
             
                
                   $('.ajax-spinner-bars').css("display","block"); 
                   $page = $(this).attr('href');
                 
                   $pageind = $page.indexOf('q=');
                   // alert($pageind);
                   $sPageURL = $page.substring(($pageind));
                   var pageAjax = $page.replace("index", "dataAjax");
                   // alert(pageAjax);
                   

                    $.post(basedomain+pageAjax, {actionfunction: 'showData'}, function(data){
                            
                            if (data.status==true) {
                               
                                    $('#dataAjax').html(data.data); 

                                    $('.ajax-spinner-bars').css("display","none"); 
                                
                            }else{
                                 $('.ajax-spinner-bars').css("display","none"); 
                            }
                        }, "JSON")

                return false;
                });
                  $('#dataAjax').on('click','#btnsearch',function(){

                   var parameter =$('#parameter').val();
                   var valueparameter =$('#valueparameter').val();

                   $page = $(this).attr('href');
                   // alert($page);
                   var pageAjax = $page.replace("index", "dataAjax");
              // alert(pageAjax);
                    $.post(pageAjax, {actionfunction: 'showDataAjax',q:valueparameter}, function(data){
                            
                            if (data.status==true) {
                               
                                    $('#dataAjax').html(data.data); 

                                 $('.ajax-spinner-bars').css("display","none"); 
                                
                            }else{
                                   $('.ajax-spinner-bars').css("display","none"); 
                            }
                        }, "JSON")

                return false;
                });

                $('#dataAjax').on('change','#select',function(){

                   var parameter =$('#select').val();
                   // alert(parameter);
                   var valueparameter =$('#valueparameter').val();

                    $.post(basedomain+urlPageList+'dataAjax/0/'+parameter+'/1/'+valueparameter, {actionfunction: 'showDataAjax'}, function(data){
                            
                            if (data.status==true) {
                               
                                    $('#dataAjax').html(data.data); 

                                 $('.ajax-spinner-bars').css("display","none"); 
                                
                            }else{
                                   $('.ajax-spinner-bars').css("display","none"); 
                            }
                        }, "JSON")

                return false;
                });
                $('#dataAjax').on('click','#refresh',function(){
             
                
                   $('.ajax-spinner-bars').css("display","block"); 
                   $page = $(this).attr('href');
                 // alert($page);
                   $pageind = $page.indexOf('q=');

                   // alert($pageind);

                   $sPageURL = $page.substring(($pageind));
                   
                   // var pageAjax = $page.replace("index", "dataAjax");
                   // alert(pageAjax);
                 
                    $.post(basedomain+$page+"dataAjax/0/10/1", {actionfunction: 'showData'}, function(data){
                            
                            if (data.status==true) {
                               
                                    $('#dataAjax').html(data.data); 

                                    $('.ajax-spinner-bars').css("display","none"); 
                                
                            }else{
                                 $('.ajax-spinner-bars').css("display","none"); 
                            }
                        }, "JSON")

                return false;
                });

                $('#dataAjax').on('click','#addData',function(){
             
                
                   $('.ajax-spinner-bars').css("display","block"); 
                   $page = $(this).attr('href');
                 // alert($page);
                   $pageind = $page.indexOf('q=');
                   // alert($pageind);
                   $sPageURL = $page.substring(($pageind));
                   var pageAjax = $page.replace("index", "dataAjax");
                   // alert(pageAjax);
                   var sURLVariables = $sPageURL.split('/');
                  // alert($page);
                    for (var i = 0; i < sURLVariables.length; i++) 
                    {   
                        var sParameterName = sURLVariables[i].split('=');
                        if (sParameterName[0] == 'page') 
                        {   
                           
                           var paging =sParameterName[1];

                        }else if (sParameterName[0] == 'kategori') {

                           var kategori =sParameterName[1];
                        }
                    }

                    $.get(basedomain+$page+"addAjax", {actionfunction: 'showData', q:paging ,kategori:kategori}, function(data){
                            
                            if (data.status==true) {
                               
                                    $('#dataAjax').html(data.data); 

                                    $('.ajax-spinner-bars').css("display","none"); 
                                    
                                
                            }else{
                                 $('.ajax-spinner-bars').css("display","none"); 
                                 
                            }
                        }, "JSON")

                return false;
                });
                
                 $('#dataAjax').on('click','#deleteData',function(){
                  
                   $page = $(this).attr('href');
               
                    if(confirm('Anda yakin akan menghapus data ini?')==true){
                      
                      $('.ajax-spinner-bars').css("display","block"); 
                      $.post(basedomain+$page, {actionfunction: 'showData'}, function(data){
                                
                                if (data.status==true) {
                                   
                                        $('#dataAjax').html(data.data); 

                                        $('.ajax-spinner-bars').css("display","none"); 
                                    
                                }else{
                                     $('.ajax-spinner-bars').css("display","none"); 
                                }
                            }, "JSON")
                    }

                return false;
                });

                 $('#dataAjax').on('click','#editData',function(){
                  
                   $page = $(this).attr('href');
               
                    if(confirm('Anda yakin akan Mengubah data ini?')==true){
                      
                      $('.ajax-spinner-bars').css("display","block"); 
                      $.get(basedomain+$page, {actionfunction: 'showData'}, function(data){
                                
                                if (data.status==true) {
                                   
                                        $('#dataAjax').html(data.data); 

                                        $('.ajax-spinner-bars').css("display","none"); 
                                    
                                }else{
                                     $('.ajax-spinner-bars').css("display","none"); 
                                }
                            }, "JSON")
                    }

                return false;
                });
                
            });

         
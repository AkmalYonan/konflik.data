<script>
            function submit_form(url,strConfirm){
                var dataString=$("#frm").serialize()+"&time="+(new Date).getTime();
                apprise(strConfirm, {'verify':true}, function(r) {
                    if(r) { 
                        //$("#frm").attr("action",url);
                        //$("#frm").submit();
                        
                         $.ajax({
                            type: "POST",
                            url: url,
                            data: dataString,
                            success: function(msg){
                            if($.trim(msg)=="ok"){
                                $.sticky("<b>Konfirmasi</b><p>Data Telah Tersimpan</p>",stickyoptions,function(response){
                                var time=parseFloat(response.timedelay);
                                setTimeout(function(){
                                                    //location=base_url+module;
                                                    location=location;
                                                },time);
                                            });
                                                        
                                }else{
                                            Alert("Warning","Proses penyimpanan tidak berhasil,kontak Admin!")
                                            }   
                                    }
                        }); //end ajax
                        
                    }else{ //else aprise
                        return false;
                    } //end aprise
                });
            
            }
            
            
             function delete_form(url,strConfirm){
                var dataString="&time="+(new Date).getTime();
                url=url+dataString;
                apprise(strConfirm, {'verify':true}, function(r) {
                    if(r) { 
                        //$("#frm").attr("action",url);
                        //$("#frm").submit();
                        
                         $.ajax({
                            type: "POST",
                            url: url,
                            /*data: dataString,*/
                            success: function(msg){
                            if($.trim(msg)=="ok"){
                                $.sticky("<b>Info</b><p>Data berhasil di hapus</p>",stickyoptions,function(response){
                                var time=parseFloat(response.timedelay);
                                setTimeout(function(){
                                                    location=location;
                                                },time);
                                            });
                                                        
                                }else{
                                            Alert("Warning","Proses hapus data tidak berhasil,kontak Admin!")
                                            }   
                                    }
                        }); //end ajax
                        
                    }else{ //else aprise
                        return false;
                    } //end aprise
                });
            
            }
            
            
</script>
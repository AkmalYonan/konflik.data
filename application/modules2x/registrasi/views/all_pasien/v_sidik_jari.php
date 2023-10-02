<?
	
	$arrGroup=$this->lat_auth->groups('id','name');
 	$id=$this->encrypt_status==TRUE?encrypt($data[$this->tbl_idx]):$data[$this->tbl_idx];
	$idxx = $data[$this->tbl_idx];
	//$ipserver = GetServerURL();
	//$this->dbautochecker->serverurl = $ipserver;
	//pre($ipserver);
	//pre($this->dbautochecker);
	
	$sql="select * from t_pasien_finger_foto where idx_pasien=$idxx";
	$data_finger_foto=$this->conn->GetAll($sql);
	$data_finger=array();
	$data_finger2=array();
	for($i=0;$i<=9;$i++):
		$data_finger[$i]="assets/images/scan_x.jpg";
		$data_finger2[$i]=0;
	endfor;
	
	if(cek_array($data_finger_foto)):
	foreach($data_finger_foto as $x=>$val):
		$data_finger[$val["id_jari"]]=$val["path"];
		$data_finger2[$val["id_jari"]]=1;
	endforeach;
	endif;
	
	$data_pasien=$this->conn->GetRow("select * from t_pasien where idx=$idxx");
	
?>


<style>
.fingerbox{
	border: 1px solid #ddd;width: 75px;height: 75px;
	cursor:pointer;
	
}

.finger {
	position:absolute;
	border:2px solid transparent;
	border-radius:50%;
	width:50px;
	height:50px;	
	cursor:pointer
}
</style>



				    
                    <div class="row">
                    <div class="col-md-12">
                    	<div class="row">
                        	<div class="col-md-6">
                            	<table class="table table-condensed">
                                	<tr>
                                        <th colspan="5" style="text-align:center; font-size:x-large">KIRI</th>
                                    </tr>	
                                	<tr>
                                	<!-- jari tangan kiri -->
                                    <td>
                                        <div id="scanJariKelingkingKiri">
                                        <label for="nama">Kelingking</label>
                                           	<div id="r9" title="Kelingking Kiri" class="img-circle fingerbox reg" data-id_jari="9" style="background:url(<?=$data_finger[9]?>) center; background-size:100px 100px"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div id="scanJariManisKiri">
                                        <label for="nama">Jari Manis</label>
                                           	<div id="r8" title="Jari Manis Kiri" class="img-circle fingerbox reg" data-id_jari="8" style="background:url(<?=$data_finger[8]?>) center; background-size:100px 100px"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div id="scanJariTengahKiri">
                                        <label for="nama">Jari Tengah</label>
                                           	<div id="r7" title="Jari Tengah Kiri" class="img-circle fingerbox reg" data-id_jari="7" style="background:url(<?=$data_finger[7]?>) center; background-size:100px 100px"></div>
                                        </div>					
                                    </td>
                                    <td>
                                        <div id="scanJariTelunjukKiri">
                                        <label for="nama">Telunjuk</label>
                                           	<div id="r6" title="Jari Telunjuk Kiri" class="img-circle fingerbox reg" data-id_jari="6" style="background:url(<?=$data_finger[6]?>) center; background-size:100px 100px"></div>
                                        </div>					
                                    </td>
                                    <td>
                                        <div id="scanJariJempolKiri">
                                        <label for="nama">Ibu Jari</label>
                                           	<div id="r5" title="Jempol Kiri" class="img-circle fingerbox reg" data-id_jari="5" style="background:url(<?=$data_finger[5]?>) center; background-size:100px 100px"></div>
                                        </div>					
                                    </td>
                                    <!-- end jari tangan kiri -->
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                            	<table class="table table-condensed">
                                	<tr>
                                        <th colspan="5" style="text-align:center; font-size:x-large">KANAN</th>
                                    </tr>	
                                	<tr>
                                    	<!-- Jari Tangan Kanan -->
                                        <td>
                                            <div id="scanJariJempolKanan">
                                            <label for="nama">Ibu Jari</label>
                                            	<div  id="r0" title="Jempol Kanan" class="img-circle fingerbox reg" data-id_jari="0"  style="background:url(<?=$data_finger[0]?>) center; background-size:100px 100px"></div>
                                            </div>					
                                        </td>
                                        <td>
                                            <div id="scanJariTelunjukKanan">
                                            <label for="nama">Telunjuk</label>
                                             	<div id="r1" title="Telunjuk Kanan" class="img-circle fingerbox reg" data-id_jari="1"  style="background:url(<?=$data_finger[1]?>) center; background-size:100px 100px"></div>
                                            </div>					
                                        </td>
                                        <td>
                                            <div id="scanJariTengahKanan">
                                            <label for="nama">Jari Tengah</label>
                                             	<div id="r2" title="Jari Tengah Kanan" class="img-circle fingerbox reg" data-id_jari="2" style="background:url(<?=$data_finger[2]?>) center; background-size:100px 100px"></div>
                                            </div>					
                                        </td>
                                        <td>
                                            <div id="scanJariManisKanan">
                                            <label for="nama">Jari Manis</label>
                                             	<div id="r3" title="Jari Manis Kanan" class="img-circle fingerbox reg" data-id_jari="3" style="background:url(<?=$data_finger[3]?>) center; background-size:100px 100px"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div id="scanJariKelingkingKanan">
                                            <label for="nama">Kelingking</label>
                                             	<div id="r4" title="Kelingking Kanan" class="img-circle fingerbox reg" data-id_jari="4" style="background:url(<?=$data_finger[4]?>) center; background-size:100px 100px"></div>
                                            </div>
                                        </td>
                
                                        <!-- End Jari Tangan Kanan -->
                                    </tr>
                                </table>
                            </div>
                        </div>
                       <!-- <table>
						<tr>
						<td><button class="btn btn-primary btn-scan" id="btn-regist">Registerasi Fingerprint</button></td>
						</tr>
						</table><br />-->	
						<!--<div class="row">
                        	<div class="col-md-6">
                            	<table>
                                	<tr>
                                        <th colspan="5" style="text-align:center; font-size:x-large">KIRI</th>
                                    </tr>	
                                	<tr>
                                    <td>
                                        <div id="scanJariKelingkingKiri">
                                        <label for="nama">Kelingking</label>
                                            <img src="<?=$data_finger[9]?>" id="r9" title="Kelingking Kiri" class="fingerbox reg" data-id_jari="9">
                                        </div>
                                    </td>
                                    <td>
                                        <div id="scanJariManisKiri">
                                        <label for="nama">Jari Manis</label>
                                            <img src="<?=$data_finger[8]?>" id="r8" title="Jari Manis Kiri" class="fingerbox reg" data-id_jari="8">
                                        </div>
                                    </td>
                                    <td>
                                        <div id="scanJariTengahKiri">
                                        <label for="nama">Jari Tengah</label>
                                            <img src="<?=$data_finger[7]?>" id="r7" title="Jari Tengah Kiri" class="fingerbox reg" data-id_jari="7">
                                        </div>					
                                    </td>
                                    <td>
                                        <div id="scanJariTelunjukKiri">
                                        <label for="nama">Telunjuk</label>
                                            <img src="<?=$data_finger[6]?>" id="r6" title="Jari Telunjuk Kiri" class="fingerbox reg" data-id_jari="6">
                                        </div>					
                                    </td>
                                    <td>
                                        <div id="scanJariJempolKiri">
                                        <label for="nama">Ibu Jari</label>
                                            <img src="<?=$data_finger[5]?>" id="r5" title="Jempol Kiri" class="fingerbox reg" data-id_jari="5">
                                        </div>					
                                    </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                            	<table>
                                	<tr>
                                        <th colspan="5" style="text-align:center; font-size:x-large">KANAN</th>
                                    </tr>	
                                	<tr>
                                        <td>
                                            <div id="scanJariJempolKanan">
                                            <label for="nama">Ibu Jari</label>
                                                <img src="<?=$data_finger[0]?>" id="r4" title="Jempol Kanan" class="fingerbox reg" data-id_jari="0">
                                            </div>					
                                        </td>
                                        <td>
                                            <div id="scanJariTelunjukKanan">
                                            <label for="nama">Telunjuk</label>
                                                <img src="<?=$data_finger[1]?>" id="r3" title="Telunjuk Kanan" class="fingerbox reg" data-id_jari="1">
                                            </div>					
                                        </td>
                                        <td>
                                            <div id="scanJariTengahKanan">
                                            <label for="nama">Jari Tengah</label>
                                                <img src="<?=$data_finger[2]?>" id="r2" title="Jari Tengah Kanan" class="fingerbox reg" data-id_jari="2">
                                            </div>					
                                        </td>
                                        <td>
                                            <div id="scanJariManisKanan">
                                            <label for="nama">Jari Manis</label>
                                                <img src="<?=$data_finger[3]?>" id="r1" title="Jari Manis Kanan" class="fingerbox reg" data-id_jari="3">
                                            </div>
                                        </td>
                                        <td>
                                            <div id="scanJariKelingkingKanan">
                                            <label for="nama">Kelingking</label>
                                                <img src="<?=$data_finger[4]?>" id="r0" title="Kelingking Kanan" class="fingerbox reg" data-id_jari="4">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>-->
						
                    </div><!-- end form-->                                      
                    </div><!-- end row-->
				   <!-- end Scan FingerPrint -->
				   
				   
				   <!-- start Verifikasi FingerPrint -->
				   	<h4 class="heading hidden">Verifikasi 10 Jari</h4>
                    <div class="row hidden">
                    <div class="col-md-6">
                    <div class="form-group">
                      <!--  <table>
						<tr>
						<td><button class="btn btn-primary btn-scan" id="btn-verifikasi" >Verifikasi Fingerprint</button></td>
						</tr>
						</table><br />-->
                        <table>
						<tr>
						<!-- jari tangan kiri -->
						<td>
							<div id="scanVerifikasiJariKelingkingKiri" class="pull-right" style="margin-right:20px">
							<label for="nama">Klingking Kiri</label>
								<img src="" id="v9" title="Kelingking Kiri" class="fingerbox">
							</div>
						</td>
						<td>
							<div id="scanVerifikasiJariManisKiri" class="pull-right" style="margin-right:20px">
							<label for="nama">Jari Manis Kiri</label>
								<img src="" id="v8" title="Jari Manis Kiri" class="fingerbox">
							</div>
						</td>
						<td>
							<div id="scanVerifikasiJariTengahKiri" class="pull-right" style="margin-right:20px">
							<label for="nama">Jari Tengah Kiri</label>
								<img src="" id="v7" title="Jari Tengah Kiri" class="fingerbox">
							</div>					
						</td>
						<td>
							<div id="scanVerifikasiJariTelunjukKiri" class="pull-right" style="margin-right:20px">
							<label for="nama">Jari Telunjuk Kiri</label>
								<img src="" id="v6" title="Jari Telunjuk Kiri" class="fingerbox">
							</div>					
						</td>
						<td>
							<div id="scanVerifikasiJariJempolKiri" class="pull-right" style="margin-right:20px">
							<label for="nama">Jempol Kiri</label>
								<img src="" id="v5" title="Jempol Kiri" class="fingerbox">
							</div>					
						</td>
						<!-- end jari tangan kiri -->

						<!-- Jari Tangan Kanan -->
						<td>
							<div id="scanVerifikasiJariJempolKanan" class="pull-right" style="margin-right:20px">
							<label for="nama">Jempol Kanan</label>
								<img src="" id="v4" title="Jempol Kanan" class="fingerbox">
							</div>					
						</td>
						<td>
							<div id="scanVerifikasiJariTelunjukKanan" class="pull-right" style="margin-right:20px">
							<label for="nama">Telunjuk Kanan</label>
								<img src="" id="v3" title="Telunjuk Kanan" class="fingerbox">
							</div>					
						</td>
						<td>
							<div id="scanVerifikasiJariTengahKanan" class="pull-right" style="margin-right:20px">
							<label for="nama">Tengah Kanan</label>
								<img src="" id="v2" title="Jari Tengah Kanan" class="fingerbox">
							</div>					
						</td>
						<td>
							<div id="scanVerifikasiJariManisKanan" class="pull-right" style="margin-right:20px">
							<label for="nama">Jari Manis Kanan</label>
								<img src="" id="v1" title="Jari Manis Kanan" class="fingerbox">
							</div>
						</td>
						<td>
							<div id="scanVerifikasiJariKelingkingKanan" class="pull-right" style="margin-right:20px">
							<label for="nama">Klingking Kanan</label>
								<img src="" id="v0" title="Kelingking Kanan" class="fingerbox">
							</div>
						</td>

						<!-- End Jari Tangan Kanan -->
						</tr>						
						</table>
                    </div><!-- end form-->                                      
                    </div></div><!-- end row-->
				   <!-- end Verifikasi FingerPrint -->

				   
				   				   						
					
 
    
    <script>
	var now = new Date();
	var data_finger=<?=json_encode($data_finger2)?>||0;
	console.log(data_finger);
	$(function(){
		$.each(data_finger,function(i,d){
			if(d*1==1){
				$("#f"+i).addClass("active");
			}
		});
		$(".fingerbox.reg").click(function(){
				//alert("test");
				var that=$(this);
				var data_pasien="<?php echo $idxx;?>";
				var fingerId=that.data("id_jari");
				var myip="127.0.0.1";
				var fingerProcessType='enrollment';
				var data={
						id_jari : fingerId, 
						idx_pasien :data_pasien,
						processtype :fingerProcessType,
						"base_url":"<?=base_url()?>",
						"root_url":"<?=dirname(base_url());?>",
						"server_url":"<?=GetServerURL()?>",
						"pasien":<?=json_encode($data_pasien)?>
					};
				//var data= { id_jari : fingerId, idx_pasien :data_pasien,processtype :fingerProcessType};
					//alert(fingerId);
				$.post("http://"+myip+":8090/fingerprint_local_webservice/callagent.php",data,function(ret){
					//console.log(ret);
					//that.addClass("active");
					$.getJSON("<?=$this->module?>get_fmd/"+data_pasien+"/"+fingerId,function(data_ret){
							console.log(data_ret);
							//$("#r"+fingerId).attr("src","pasien_files/finger_scan/"+data_ret.img);
							var img="pasien_files/finger_scan/"+data_ret.img;
							var style="background:url("+img+") center; background-size:100px 100px";
							//$("#r"+fingerId).attr("style",style);
							
							$("#r"+fingerId).css({"background-color":"red","background-image":"url("+img+")","background-position":"center","background-size":"100px 100px"});
							
							that.addClass("active");
							//if(data_ret.flag_status_identification*1==1){
								//$("#i0").attr("src","assets/images/scan_1.jpg");
							//}
						});
				});
				
		});
		
		
		
		
		$(".fingerbox.ident,.btn-scan").click(function(){
				
				//alert("test");
				var that=$(this);
				var data_pasien="<?php echo $idxx;?>";
				var fingerId=0;
				var myip="127.0.0.1";
				var fingerProcessType='identification';
				//var data= { id_jari : fingerId, idx_pasien :data_pasien,processtype :fingerProcessType};
				var data={
						id_jari : fingerId, 
						idx_pasien :data_pasien,
						processtype :fingerProcessType,
						"base_url":"<?=base_url()?>",
						"root_url":"<?=dirname(base_url());?>",
						"server_url":"<?=GetServerURL()?>",
						"pasien":<?=json_encode($data_pasien)?>
					};
					
					//alert(fingerId);
				var url1= "<?=base_url()?>" + "../fingerprint_headoffice_webservice/insert_pasien_finger_identification.php";
				var data1= { idx_pasien :'<?php echo $idxx;?>', id_jari : fingerId, flag_status_identification :'0', flag_status_process_identification :'1', message :'waiting identification'};
				
				$.post(url1,data1,function(ret){
					console.log(ret);
					$.post("http://"+myip+":8090/fingerprint_local_webservice/callagent.php",data,function(ret){
					    
						$.getJSON("<?=$this->module?>get_identify/"+data_pasien,function(data_ret){
							if(data_ret.flag_status_identification*1==1){
								$("#i0").attr("src","assets/images/scan_1.jpg");
							}
						});
						
						
					});
				});								
				
				
		});
		
		//bindingElementClick();
		//klo mau debug javascript auto refresh content di remark dulu 
		//autoRefreshContent();
	});
	
	
</script>      
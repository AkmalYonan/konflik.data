<style>
.table{
	font-size:13px;
}
.paging{
	font-size:13px;
}
</style>

<div class="main-container container">
    <div class="row">
    	<div class="col-sm-12 col-xs-12">
            <div class="main-container container text-center-xs">
                <div class="row">
					<div class="container text-center-xs">
						<ol class="breadcrumb flat">
							<li><a href="home">Beranda</a></li>
							<li class="active">List Data</li>
						</ol>
					</div>
					<div class="col-sm-12 col-xs-12">
						<div class="text-uppercase block-2">
							<h6 style=" border:none !important" class="sub-heading-1 text-center-xs text-spl-color"><strong>List Data</strong></h6>
						</div>
						
						<div class="media ">
							<div class="row">
                                <div class="col-sm-12">
									
									<div class="row">
										<div class="col-sm-12">
											<form class="form-inline" action="<?=$this->module?>list_data" method="get">
											
												<div class="form-group">
													<?php
														$y	=	date("Y");
															
														for($i=0; $i<10; $i++):
															$tahun[$i]	=	$y-$i;
														endfor;
													?>
													<select name="tahun" class="form-control">
														<?php foreach($tahun as $k=>$v): ?>
															<option value="<?=$v?>" <?=($_GET['tahun']==$v)?"selected":""?>><?=$v?></option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<select name="sektor" class="form-control">
														<option value="">Semua Sektor</option>
														<?php foreach($this->lookup_sektor as $k=>$v): ?>
															<option value="<?=$k?>" <?=($_GET['sektor']==$k)?"selected":""?>><?=$v?></option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<select name="konflik" class="form-control">
														<option value="">Semua Konflik</option>
														<?php foreach($this->lookup_konflik as $k=>$v): ?>
															<option value="<?=$v?>" <?=($_GET['konflik']==$v)?"selected":""?>><?=$v?></option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<input type="text" name="q" class="form-control" placeholder="Kata Kunci" value="<?=$_GET['q']?>" />
												</div>
												<button type="submit" class="btn btn-primary"><i class="fa fa-search">&nbsp;</i>Search</button>
												<a href="<?=$this->module?>list_data">
													<button type="button" class="btn btn-default" data-toggle='tooltip' title="Reset"><i class="fa fa-refresh">&nbsp;</i>Refresh</button>
												</a>
											</form>
										</div>
									</div>
									<hr />
									
									<?php 
										$page_link=$this->pagination->create_links(); 
										$offset=$this->pagination->cur_page>0?($this->pagination->cur_page-1) * $this->pagination->per_page:0;
									?>
									
									<div class="row table-responsive">
										<div class="col-sm-12">
											<table class="table table-condensed table-bordered">
												<thead class="well">
													<tr>
														<th><p align="center">No</p></th>
														<th><p align="center">Tahun</p></th>
														<th><p align="center">Judul</p></th>
														<th><p align="center">Klip</p></th>
														<th><p align="center">Konflik</p></th>
														<th><p align="center">Sektor</p></th>
														<th><p align="center">&nbsp;</p></th>
													</tr>
												</thead>
												<tbody>
													<?php if(cek_array($arrData)):?>
														<?php foreach($arrData as $x=>$val):
																$id	=	encrypt($val[$this->tbl_idx]);
														?>
															<tr>
																<td align="center"><?php echo $offset+$x+1?></td>
																<td><?=$val["tahun"]?></td>
																<td><?=$val["judul"]?></td>
																<td><?=$val["clip"]?></td>
																<td>
																	<?php
																		if($val["kd_konflik"]):
																			$arr_konflik	=	explode(",",$val["kd_konflik"]);
																		endif;
																	?>
																	<?php if($val["kd_konflik"]): ?>
																		<table class="table table-condensed">
																			<?php foreach($arr_konflik as $k=>$v): ?>
																				<tr>
																					<td><?=$v?></td>
																				</tr>
																		<?php endforeach; ?>
																		</table>
																	<?php endif; ?>
																</td>
																<td><span class="badge" style="background-color:<?=$this->sektor_color[$val["kd_sektor"]]?>"><?=$val["sektor"]?></span></td>
																<td align="center">
																	<a href="<?=$this->module?>index/<?=$id?>">
																		<button class="btn btn-info btn-xs"><i class="fa fa-search">&nbsp;</i>Detail</button>
																	</a>
																</td>
															</tr>
														<?php endforeach;?>
													<?php endif;?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 col-xs-12">
											<div class="paging pull-left">
												<?php 
													$to_page=$this->pagination->cur_page * $this->pagination->per_page;
													$from_page=($to_page-$this->pagination->per_page+1);
													if($from_page>$to_page):
														$from_page=1;
														$to_page=$from_page;
													endif;
													$total_rows=$this->pagination->total_rows;
													if($to_page>1):
														echo "Displaying : ".$from_page." - ".$to_page." of ". 
																$this->pagination->total_rows." entries";
													endif;
													if($to_page<=1):
														echo "Displaying : 1 of ". 
														$this->pagination->total_rows." entries";		
													endif;		
												?>,
												<?php
													$arrPerPageSelect=array(
														5	=>	5,
														10	=>	10,
														25	=>	25,
														50	=>	50,
														-1	=>	"All"
													);
													$pp=$perPage;
												?>
												Rows/page: <label><?=form_dropdown("pp_select",$arrPerPageSelect,$pp,"id='pp_select' class='form-control input-sm'")?></label>
												<input type="hidden" id="pp" name="pp" value="" />
											</div>
										</div>

										<div class="col-sm-12 col-xs-12">
											<div class="paging pull-right">
												<?php echo $page_link; ?>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(function(){
		var act_link="<?=$this->module?>";		
		$(".sdb_h_active").next().find("a[href*='"+act_link+"']").parent("li").addClass("active");
	
		$(".pagination .active a").click(function(e){
			e.preventDefault();
		});
		
		$("#pp_select").change(function(){
			var pp=parseInt($(this).find("option:selected").val());
			if(pp<0){
				location=document.URL.split("?")[0];
				return false;
			}
			get_query();
		});
	});
	
	
	function get_query(){
			var q =$("#q").val()||"";
			var perPage=$("#pp_select option:selected").val();
			$("#pp").val(perPage);
			var pp =$("#pp").val()||"";
			
			
			var data=[];
			if(q){
				data.push("q="+q);
			}
			
			if((pp)&&(pp!=25)){
				data.push("pp="+pp);
			}
			var param='';
			if(data){
				param="?"+data.join("&");
			}
			var url=document.URL.split("?")[0];
			location=url+param;
	}
</script>
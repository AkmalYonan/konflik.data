<div class="row">
    <div class="scol-sm-12 col-lg-12">
        <div class="page-header">
            <div class="row"> 
                <div class="col-md-6">
                    <h1>
                        <i class="icon-dashboard"></i> &nbsp;Dashboard
                        <small>Statistic, Chart and more..
                        </small>
                    </h1>
                </div><!-- col -->
                <div class="col-md-3">
                        <div id="daterange" class="section pull-right">
                            <i class="icon-time"></i>
                            <input type="hidden" class="form-control" id="daterange-val">
                            <span>09/09/2013 - 09/28/2013</span>
                            <b class="caret"></b>     
                        </div>
                  </div><!-- col -->
                  <div class="col-md-3">
                        <div class="section date">
                            Nov 19, 2013 11:23<sup>am</sup>
                        </div>
                  </div><!-- col -->
              </div><!-- row-->
        </div><!-- page-header -->
        <ol class="breadcrumb">
            <li><a href="index.html#">&nbsp;Home</a></li>
          <li><a href="index.html#">Genius</a></li>
          <li class="active" >Dashboard</li>
        </ol>
        <!--<div class="row">
            <div class="col-md-9">
                <div class="box">
                    <div id="daterange" class="box-header no-bg">
                                <h2>
                                    <i class="icon-exchange"></i>
                                    <span>09/09/2013 - 09/28/2013</span>
                                    <i class="icon-chevron-down pull-right"></i>      
                                </h2>
                    </div>
              </div>
            </div>
        </div>-->
	</div>
</div>     
<div class="row topbar">
    <div class="col-md-12">
    	<div class="pull-left">
            <ul class="tab-bar grey-tab">
                <li class="active">
                    <a href="setting/group">
                        <span class="block text-center">
                            <i class="icon-user"></i> 
                        </span>
                        About
                    </a>
                </li>
                <li>
                    <a href="#edit" data-toggle="tab">
                        <span class="block text-center">
                            <i class="icon-plus"></i> 
                        </span>
                        Add
                    </a>
                </li>
                <li>
                    <a href="#message">
                        <span class="block text-center">
                            <i class="icon-refresh"></i> 
                        </span>	
                        Refresh
                    </a>
                </li>
            </ul>
        </div>
    	<form class="search_form col-md-3 pull-right" action="<?=$this->module?>group_list" method="get">
        	<?php $this->load->view("widget/search_box_db"); ?>
        </form>
    </div>
</div>
<div class="row">
    <div class="scol-sm-12 col-lg-12">   
        
    </div><!--/col-->    
</div><!--/row-->	
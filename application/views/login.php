<? $this->load->view("admin_layout/lookup_header");?>
<? echo js_asset("jquery.cookie.js");?>
<? echo js_asset("lingkar/app.pack.js");?>
        
<div class="row">
	<div class="col-sm-offset-3 col-sm-6">
    
    <form id="frmlogin" class="form-horizontal form-search" action="<?=base_url()."login/auth/"?>" method="post">
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-3">Username</label>
				<div class="col-xs-9">
					<input type="text" name="username" class="form-control" id="username" placeholder="User Name">
				</div>
		</div>

        <div class="form-group">
		    <label for="inputPassword" class="control-label col-xs-3">Password</label>
        	    <div class="col-xs-9">
            	    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            	</div>
		</div>

        <div class="form-group">
    		<div class="col-md-offset-3 col-md-9">
	                <div class="checkbox">
            	        <label><input type="checkbox" class="sCheck" name="check" id="check" value="1"> Remember me</label>
                	</div>
            </div>
        </div>

        <div class="form-group">
			<div class="col-md-offset-3 col-md-9">
			    <button type="submit" id="a_login" class="btn btn-primary">Login</button>
			</div>
		</div>

    </form>
</div></div>

       <div class="clearfix"></div>      
            
<? $this->load->view("admin_layout/lookup_footer");?>            
            
            
            
<? $this->load->view($this->admin_layout."/login/login_header");?>
<div class="login-box">
  <!--<div class="login-logo">SIM-PILKADA
    <img src="assets/images/logo.png"><img id="previewplay" src="<?=$this->config->item("dir_pasangan").$pasangan?>" class="img-thumbnail" width="75"><br>
  </div>--><!-- /.login-logo -->
  <p class="login-box-msg"><?php echo message_box();?></p>
  <div class="login-box-body">
    <br />
    <form action="<?=base_url()."admin/login"?>" method="post">
      <input type="hidden" name="last_url" value="<?php echo get_flash("LAST_URL")?>" />
      <div class="form-group has-feedback">
        <input type="text" name="uid" id="username" class="form-control" placeholder="<?php echo $this->config->item("identity","lat_auth")?>">
        <span class="glyphicon glyphicon-<?php echo $this->config->item("identity","lat_auth")=='email'?'envelope':'user'?> form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="pwd" id="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <?php if ($this->config->item("remember_me","lat_auth")):?>
      <div class="form-group">
          <label>
              <input type="checkbox" name="remember" value="1" class="flat-red">
              Remember me
          </label>
      </div>
      <?php endif;?>
      <div class="row">
        <div class="col-xs-8">
         
        </div><!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div><!-- /.col -->
      </div>
    </form>

  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
        
<? $this->load->view($this->admin_layout."/login/login_footer")?>
<div class="page-header">
  <h1>Login</h1>
</div>
<div class="row">
  <div class="span12">
    <form action="<?=$this->make_route('/login')?>" method='post'>
      <?=Bootstrap::make_input('username', "Username");?>
      <?=Bootstrap::make_input('password', "Password","password");?>
      <div class="form-actions">
        <button class="btn btn-primary ">Login</button>
      </div>
    </form>
  </div>
</div>
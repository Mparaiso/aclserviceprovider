<div class="page-header">
  <h1>Signup</h1>
</div>
<div class="row">
  <div class="span12">
    <form method="post" action="<?= $this->make_route('/signup') ?>" class="form-vertical">
      <fieldset>
        <label for="full_name">Full Name</label>
        <input id="full_name" name="full_name" type="text" class="input-large" />
        <label for="email">Email</label>
        <input type="text" id='email' name="email" class="input-large" />
        <?= Bootstrap::make_input("username", "Username")?>
        <?= Bootstrap::make_input("password", "Password","password")?>
        <div class="form-actions">
          <button class="btn-primary btn">Sign Up!</button>
        </div>
      </fieldset>
    </form>
  </div>
</div>
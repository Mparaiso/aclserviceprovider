
<div class="page-header">
  <h1><?= $user->full_name?>
  <? if($is_current_user):?>
    <code>This is you</code>
    <?endif;?>
  </h1>
</div>
<div class="container">
  <div class="row">
    <span4>
      <div class="sidebar-nav well">
        <ul class="nav nav-list">
          <li>
            <h3>User information</h3>
          </li>
          <li><b>Username:</b><?=$user->username?></li>
          <li><b>Email: </b><?=$user->email?></li>
        </ul>
      </div>
      <div class="span8">
        <h2>Posts</h2>
      </div>
    </span4>
  </div>
</div>

<div class="page-header">
  <h1><?= $user->full_name ?>
    <? if ($is_current_user): ?>
      <code>This is you</code>
    <? endif; ?>
  </h1>
</div>
<div class="container">
  <div class="row">
    <div class="span4">
      <div class="sidebar-nav well">
        <ul class="nav nav-list">
          <li>
            <h3>User information</h3>
          </li>
          <li><b>Username: </b><?= $user->name ?></li>
          <li><b>Email: </b><?= $user->email ?></li>
        </ul>
      </div>
    </div>

    <div class="span8">
      <? if ($is_current_user): ?>
        <h2>Create a new post</h2>
        <form action="<?= $this->make_route('/post') ?>" method="post">
          <textarea name="content" id="content" rows="3" class="span8"></textarea>
          <button id="create_post" type="submit" class="btn btn-primary">Submit</button>
        </form>
      <? endif; ?>
      <h2>Posts (<?=$post_count?>)</h2>
      <? foreach ($posts as $post): ?>
        <div class="post-item row">
          <div class="span7">
            <strong><?= $user->name ?></strong>
            <p><?= $post->content ?></p>
            <?= $post->date_created ?>
          </div>
          <div class="span1"><a href="#">(Delete)</a></div>
          <div class="span8"></div>
        </div>
      <? endforeach ?>
    </div>
  </div>
</div>
<!DOCTYPE HTML>
<html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <title>Verge</title>
    <link rel="stylesheet" href="<? echo $this->make_route('/css/bootstrap.min.css') ?>" />
    <!--[if lt IE9]>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js
"></script>
    <script type="text/javascript"
    src=' <?=$this->make_route('/js/bootstrap.js')?> '>
    </script>
    <link href="<?= $this->make_route('/css/master.css') ?>" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= $this->make_route('/css/bootstrap-responsive.min.css') ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  </head>
  <body>
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <a data-toggle="collapse" data-target=".nav-collapse" href="" class="btn btn-navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a href="<?= $this->make_route('/') ?>" class="brand">Verge</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><a href="<?= $this->make_route('/') ?>">Home</a></li>
              <? if(User::is_authenticated()): ?>
              <li>
                <a href="<?=$this->make_route('/logout')?>">Logout</a>
              </li>
              <? else: ?>
              <li>
                <a href="<?= $this->make_route('/signup') ?>">Signup</a>
              </li>
              <li>
                <a href="<?= $this->make_route('/login') ?>">Login</a>
              </li>
              <? endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <?=$this->display_alert('error')?>
      <?=$this->display_alert('success')?>
      <? include($this->content); ?>
    </div>

  </body>
</html>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="description" content="Login dashboard">
    <meta name="keywords" content="login admin, login page, login dashboard, dashboard">
    <meta name="author" content="ahmed hassan">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="<?php echo adminAssets('images/icons/locked-padlock.png'); ?>">
    <link rel="stylesheet" href="<?php echo pluginsAssets('bootstrap-4.0.0/dist/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo pluginsAssets('fontawesome-free-5.1.0-web/css/all.css'); ?>">
    <link rel="stylesheet" href="<?php echo adminAssets('css/login.css'); ?>">
  </head>
  <body>
    <div class="login-box">
      <div class="logo text-center p-2 pb-4">
        <a href="javascript:void(0)" class="d-block">
          AD<strong>CMS</strong>
        </a>
        <small class="d-block">Power full admin panel</small>
      </div>
      <div class="card">
        <form action="<?php echo setLink('admin/login/submit'); ?>" method="POST" class="ajaxForm" autocomplete="off">
          <div class="text-center mb-3 msg">Sign in to start your session</div>
          <div class="body pt-2">
            <div class="form-group">
              <label for="email">Email address</label>
              <input value="ahmed@gmail.com" name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input value="ahmed000#" name="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group form-check">
              <input name="rememberMe" type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Remember Me</label>
              <a href="#" class="d-inline-block fp float-right">Forgot Password ?</a>
            </div>
            <button type="submit" class="btn">Login</button>
          </div>
        </form>
      </div>
    </div>
    <script src="<?php echo pluginsAssets('jquery-3.2.1/jquery-3.2.1.min.js') ; ?>"></script>
    <script src="<?php echo pluginsAssets('popper/popper.js') ; ?>"></script>
    <script src="<?php echo pluginsAssets('bootstrap-4.0.0/dist/js/bootstrap.min.js'); ; ?>"></script>
    <script>
      $(function() {
          var form = $('.ajaxForm');
          var email = form.find('#email');
          var password = form.find('#password');
          form.on('submit', function(e) {
              e.preventDefault();
              if (email.val().length < 1 || password.val().length < 1) {
                  return false
              }
              data = new FormData(form[0]);
              url = form.attr('action');
              type = form.attr('method');
              $.ajax({
                  url: url,
                  type: type,
                  data: data,
                  dataType: 'json',
                  beforeSend: function() {
                      $('.msg').text('Loading...').addClass('font-weight-bold color');
                  },
                  success: function(result){
                      if (result.success) {
                          $('.msg').text('Success Login').removeClass('color').addClass('text-success');
                          window.location.href = result.redirectDashboard;
                      }else if (result.errors) {
                          $('.msg').text(result.errors).removeClass('color text-success').addClass('text-danger');
                      }
                  },
                  cache: false,
                  contentType: false,
                  processData: false
              });
              return ;
          });

          //validate form
          var regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

          email.on('keyup' , function () {
              if (email.val().length <= 0) {
                  $(this).parent().addClass('error');
              }else {
                  if (!(regexEmail.test($(this).val()))) {
                      $(this).parent().removeClass('error').addClass('success');
                      if (!$(this).parent().next('label').length) {
                          $(this).parent().removeClass('success').addClass('error');
                      }
                      $(this).parent().removeClass('success').addClass('error');
                  }else {
                      $(this).parent().removeClass('error').addClass('success');
                  }
              }
          });

          password.on('keyup' , function () {
              if (password.val().length <= 6) {
                  $(this).parent().addClass('error').removeClass('success');
              }else {
                  $(this).parent().addClass('success').removeClass('error');
              }
          });

      });
    </script>
  </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?= $this->include('layout/css_plugins') ?>
</head>
<body>

<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
          <span class="mdi mdi-menu"></span>
          </button>
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="../../index.html">
            <!-- <img src="../../../../images/logo.svg" alt="logo" /> -->
           BANTAY BAHA
          </a>
          <a class="navbar-brand brand-logo-mini" href="../../index.html">
            <!-- <img src="../../../../images/logo-mini.svg" alt="logo" /> -->
            
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top"> 
        <ul class="navbar-nav">
          <li class="nav-item">
            <h1 class="welcome-text"><span class="text-black fw-bold">Setting</span></h1>
          </li>
          
        </ul>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            WELCOME, <?=session('fname') ?> (<?= strtoupper(session('user_type')) ?>)
          </li>
        </ul>
        
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
    <?= $this->include('Admin/sidebar') ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Account Information</h4>
                  <form class="pt-3">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg userinput" id="f_name" placeholder="First name">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg userinput" id="l_name" placeholder="Last name">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg userinput" id="m_name" placeholder="Middle name">
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-lg userinput" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg userinput" id="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="number" class="form-control form-control-lg userinput" id="phone_number" placeholder="Phone number">
                    </div>
                    <div class="mt-3">
                      <a class="btn btn-block btn-primary font-weight-medium" id="save_account" href="javascript:void(0)">Save changes</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Change password</h4>

                  <form class="pt-3">
                    <div class="form-group">
                      <input type="password" class="form-control form-control-lg passinput" id="current_pass" placeholder="Current password">
                    </div>
                    <div class="form-group">
                    <input type="password" class="form-control form-control-lg passinput" id="new_password" placeholder="New password">
                    </div>
                    <div class="form-group">
                    <input type="password" class="form-control form-control-lg passinput" id="confirm_pass" placeholder="Confirm password">
                    </div>
                    <div class="mt-3">
                      <a class="btn btn-block btn-primary font-weight-medium" id="save_pass" href="javascript:void(0)">Save changes</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <!-- <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash.</span> -->
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
    

  <?= $this->include('layout/js_plugins') ?>
</body>
</html>

<script>
  $(function() {

    $.get('<?=base_url('Admin/GetProfile') ?>', function(response) {
         $('#f_name').val(response[0].firtname);
         $('#l_name').val(response[0].lastname);
         $('#m_name').val(response[0].middlename);
         $('#email').val(response[0].email);
         $('#username').val(response[0].username);
         $('#phone_number').val(response[0].phone_number);
     }, 'json');


     $('#save_pass').click(function() {

      if($('.userinput').val() == '') {
            swal.fire('Please fill out all fields!', '', 'error');
            return false
        }

        if($('#new_password').val() != $('#confirm_pass').val()) {
            swal.fire('New password and Confirm password not match!', '', 'error');
            return false
        }

        $.post('<?= base_url('Admin/UpdatePassword') ?>', {
            current_pass: $('#current_pass').val(),
            new_pass: $('#new_password').val(),
            confirm_pass: $('#confirm_pass').val(),
        }, function(response) {
            if(response.msg == 'success') {
                swal.fire('Successfully Updated!', '', 'success');
            } else {
                swal.fire(response.msg, '', 'error');
            }
            $('.passinput').val('');
        }, 'json');
       
     });

     $('#save_account').click(function() {
        $.post('<?=base_url('Admin/UpdateProfile') ?>', {
            firstname: $('#f_name').val(),
            lastname: $('#l_name').val(),
            middlename: $('#m_name').val(),
            email: $('#email').val(),
            username: $('#username').val(),
            phone_number: $('#phone_number').val(),
        }, function(response) {
            if(response.msg == 'success') {
                swal.fire('Successfully Updated!', '', 'success');
            } else {
                swal.fire(response.msg, '', 'error');
            }
        }, 'json');
     });
  })
</script>
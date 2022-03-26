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

<style>
 .content-wrapper {
  background-color: #ffaa00 !important;
 }
 #title {
   font-size: 40px;
   font-weight: bold;
   color: #ffaa00;
 }
 #logo_img {
  mix-blend-mode: multiply;
  height: 90px;
 }
</style>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <center><h4 id="title">BANTAY BAHA</h4> <img src="<?= base_url('public/assets/img/logo_report_app.jpg') ?>" id="logo_img" alt="logo"></center>
              <div class="brand-logo">
                <!-- <img src="../../images/logo.svg" alt="logo"> -->
              </div>
              <!-- <h4>Hello! let's get started</h4> -->
              <h6 class="fw-light">Sign up to continue.</h6>
              <form class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg userinput" id="fname" placeholder="Firstname">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg userinput" id="mname" placeholder="Middlename">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg userinput" id="lname" placeholder="Lastname">
                </div>

                <div class="form-group">
                  <input type="email" class="form-control form-control-lg userinput" id="email" placeholder="Email">
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg userinput" id="username" placeholder="Username">
                </div>

                <div class="form-group">
                  <input type="number" class="form-control form-control-lg userinput" value="63" max="12" min="12" id="phone_number" placeholder="Phone Number">
                </div>
                <div class="form-group">
                    <select class="form-control form-control-lg" id="location">
                       <option value=""> Select Address </option>
                    </select>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg userinput" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg userinput" id="cpassword" placeholder="Confirm password">
                </div>
                <div class="mt-3">
                  <a class="btn btn-block btn-primary font-weight-medium" id="CreateAccount" href="javascript:void(0)">SIGN UP</a>
                </div>
                <div class="text-center mt-4 fw-light">
                  Back to login <a href="<?= base_url('/') ?>" class="text-primary">Login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <input type="hidden" id="lat">
  <input type="hidden" id="lang">
    

  <?= $this->include('layout/js_plugins') ?>
  
</body>
</html>

<script>

  function showPosition(position) {

      $('#lat').val(position.coords.latitude);
      $('#lang').val(position.coords.longitude);

  }

  $(function() {
     
     $.get('<?=base_url('Home/GetAddress') ?>').then(function(result) {
         if(result.length > 0) {
            result.forEach(function(row) {
                $('#location').append('<option value='+row.RecID+'>'+row.address+'</option>');
            });
         }
     },'json');
    
    if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
      alert('Geolocation is not supported by this browser.');
    }

    $('#CreateAccount').click(function() {

      var reg_exp_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

      if($('.userinput').val() == '') {
            Swal.fire('Please fill out all fields!','','warning');
            return false;
      }

      if(reg_exp_email.test($('#email').val()) == false) {
           Swal.fire('Please enter valid email!','','warning');
            return false;
      }

      if($('#password').val() != $('#cpassword').val()) {
            Swal.fire('Password and Confirm Password do not match!','','warning');
            return false;
        }

        if($('#phone_number').val().length > 12) {
            Swal.fire('Please enter valid number!','','warning');
            return false;
        }

        $('#CreateAccount').attr('disabled','disabled').html('Please wait...');

        $.ajax({
            type: 'POST',
            url: '<?=base_url('Home/RegisterAccount') ?>',
            data: {
                fname: $('#fname').val(),
                mname: $('#mname').val(),
                lname: $('#lname').val(),
                username: $('#username').val(),
                email: $('#email').val(),
                phone_number: $('#phone_number').val(),
                password: $('#password').val(),
                lat: $('#lat').val(),
                lang: $('#lang').val(),
                location: $('#location').val()
            },
            dataType: 'json',
            success: function(result) {
               if(result.msg == 'success') {

                   $('.form-control').val('');
                   Swal.fire('Account Successfully Created!','','success');

                   database.ref('/users/'+result.user_id).set({
                        username: result.username,
                        name: result.name,
                        email: result.email,
                        user_type: result.user_type,
                        phone_number: result.phone_number,
                        date: new Date().toUTCString(),
                        isLogin: 0,
                        Messages: 0,
                        NewMessage: ' '
                    });

                   setTimeout(() => window.location = '<?= base_url('Home/VerifyOtp') ?>',1500);
                   
               } else {
                  Swal.fire(result.msg,'','error');
               }

               $('#CreateAccount').removeAttr('disabled').html('Create Account');
            }
        })

    });
  });
</script>
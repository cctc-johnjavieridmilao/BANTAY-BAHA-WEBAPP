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
              <h6 class="fw-light">Sign in to continue.</h6>
              <form class="pt-3">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg userinput" id="u_email" placeholder="Email/Username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg userinput" id="u_pass" placeholder="Password">
                </div>
                <div class="mt-3">
                  <a class="btn btn-block btn-primary font-weight-medium" id="sign_in" href="javascript:void(0)">SIGN IN</a>
                </div>
                <!-- <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div> -->
                <!-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="ti-facebook me-2"></i>Connect using facebook
                  </button>
                </div> -->
                <div class="text-center mt-4 fw-light">
                  Don't have an account? <a href="<?= base_url('Home/RegisterView') ?>" class="text-primary">Create</a>
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
    

  <?= $this->include('layout/js_plugins') ?>

  <input type="hidden" id="lat">
  <input type="hidden" id="lang">
  
</body>
</html>

<script>

    function showPosition(position) {
        $('#lat').val(position.coords.latitude);
        $('#lang').val(position.coords.longitude);
    }

    $(function() {

        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
        alert('Geolocation is not supported by this browser.');
        }

        $('#sign_in').click(function() {
            if($('.userinput').val() == '') {
            Swal.fire('Please fill out all fields!','','warning');
            return false;
        }

        $('#sign_in').attr('disabled','disabled').html('Please wait...');

            $.ajax({
                type: 'POST',
                url: '<?=base_url('Home/Login') ?>',
                data: {
                    u_email: $('#u_email').val(),
                    u_pass: $('#u_pass').val(),
                    lat: $('#lat').val(),
                    lang: $('#lang').val()
                },
                dataType: 'json',
                success: function(result) {
                    if(result.msg == 'success') {
                        $('.userinput').val('');
                        Swal.fire('Welcome ' + result.fname,'','success');

                        database.ref('users').child(result.user_id).update({
                            isLogin: 1
                        });

                        setTimeout(() => {
                            if(result.user_type == 'user') {
                                window.location = '<?= base_url('Home/DashBoard') ?>'
                            } else {
                                window.location = '<?= base_url('Admin/Dashboard') ?>'
                            }
                        },2000);
                        
                    } else {
                        Swal.fire(result.msg,'','warning');
                    }

                    $('#sign_in').removeAttr('disabled').html('Sign In');
                }
            })
        });
    });
</script>
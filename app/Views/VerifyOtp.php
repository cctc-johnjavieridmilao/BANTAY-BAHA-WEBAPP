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
              
              <center><h4 id="title">BANTAY BAHA</h4> <img src="<?= base_url('public/assets/img/logo_3.png') ?>" id="logo_img" alt="logo"></center>
              <br>
              <h6 class="fw-light">OTP VERIFICATION</h6>
              <form class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg userinput" id="code" placeholder="Enter OTP CODE">
                </div>
                <div class="mt-3">
                  <a class="btn btn-block btn-primary font-weight-medium" id="verify_code" href="javascript:void(0)">VERIFY</a>
                  <a class="btn btn-block btn-primary font-weight-medium" id="resent_code" href="javascript:void(0)">RESEND CODE</a>
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
                <!-- <div class="text-center mt-4 fw-light">
                  Don't have an account? <a href="<?= base_url('Home/RegisterView') ?>" class="text-primary">Create</a>
                </div> -->
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

        $('#verify_code').click(function() {

        if($('#code').val() == '') {
            Swal.fire('Code is required!','','warning');
            return false;
        }
        
        $('#verify_code').attr('disabled','disabled').html('Please wait...');

            $.ajax({
                type: 'POST',
                url: '<?=base_url('Home/VerifyOtpCode') ?>',
                data: {
                    code: $('#code').val(),
                },
                dataType: 'json',
                success: function(result) {
                    if(result.msg == 'success') {

                        Swal.fire('Account Successfully Verified','','success');

                        setTimeout(() => {
                            window.location = '<?= base_url('/') ?>'
                        },1500);
                        
                    } else {
                        Swal.fire(result.msg,'','warning');
                    }

                    $('#verify_code').removeAttr('disabled').html('VERIFY')
                }
            })
        });

        $('#resent_code').click(function() {

            $('#resent_code').attr('disabled','disabled').html('Please wait...');

            $.ajax({
                type: 'POST',
                url: '<?=base_url('Home/ReSendCode') ?>',
                data: {},
                dataType: 'json',
                success: function(result) {
                    if(result.msg == 'success') {

                        Swal.fire('Code Successfully Sent!','','success');
                        
                    } else {
                        Swal.fire(result.msg,'','warning');
                    }

                    $('#resent_code').removeAttr('disabled').html('VERIFY')
                }
            })

        })
    });
</script>
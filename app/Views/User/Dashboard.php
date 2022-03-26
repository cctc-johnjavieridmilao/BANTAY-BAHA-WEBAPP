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
            <h1 class="welcome-text"><span class="text-black fw-bold">Dashboard</span></h1>
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
    <?= $this->include('User/sidebar') ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">REPORT/MESSAGE</h4>
                  <!-- <p class="card-description">
                    Add class <code>.table</code>
                  </p> -->

                  <div class="row" id="azChatBody">
                     
                   </div>
                  
                </div>
                <div class="card-footer">
                <div class="row">

                   <div class="col-md-12">
                        <input type="text" class="form-control form-control-lg" placeholder="Type your message here..." id="chat_msg">
                        <input type="file" accept="image/*" style="display: none;" id="file">
                        <br>
                    </div>

                    <div class="col-md-12">
                        <select id="message_type" class="form-control form-control-lg">
                             <option value=""> Select situation in the area </option>
                        </select><br>
                    </div>

                    <div class="col-md-5">
                      <!-- <a href="javascript:void(0)"  id="choose_file"><i class="far fa-file"></i></a> -->
                      <!-- <a href="javascript:void(0)"  id="save_to_fire_base"><i class="far fa-paper-plane "></i></a> -->
                      <button type="button" id="save_to_fire_base" class="btn btn-primary">Send <i class="far fa-paper-plane "></i></button>

                    </div>

                </div>
                
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

  <input type="hidden" id="lat">
  <input type="hidden" id="lang">
  <input id="user_id" type="hidden">
    

  <?= $this->include('layout/js_plugins') ?>
</body>
</html>
<script>

function showPosition(position) {
  $('#lat').val(position.coords.latitude);
  $('#lang').val(position.coords.longitude);
}

function uniqueID() {
   return Math.floor(Math.random() * Date.now())
}

function SendSms(msg) {
    $.ajax({
            type: 'POST',
            url: '<?=base_url('Home/SendSms') ?>',
            data: {
                msg: msg,
                lat: $('#lat').val(),
                lang: $('#lang').val()
            },
            dataType: 'json',
            success: function(result) {
              console.log(result);
            }
    });
}

function SendMessage(msg_type, message) {
  $.ajax({
            type: 'POST',
            url: '<?=base_url('Home/SendMessage') ?>',
            data: {
                msg_type: msg_type,
                message: message
            },
            dataType: 'json',
            success: function(result) {
              console.log(result);
            }
    });
}

$(function() {

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    alert('Geolocation is not supported by this browser.');
  }
  
  $.get('<?=base_url('Home/GetMessageType') ?>').then(function(result) {
         if(result.length > 0) {
            result.forEach(function(row) {
                $('#message_type').append('<option value='+row.RecID+'>'+row.Message+'</option>');
            });
         }
     },'json');
  
  var messages = database.ref('message').orderByChild('date');

    messages.on("value", function(snapshot) {

        $('#azChatBody').empty();

       
        snapshot.forEach(function(element) {
            var chat_pos = '';
            var user_id = '<?=session('u_id') ?>';

            if(element.val().send_by == 'Admin') {
                chat_pos = 'left';
            } else {
                chat_pos = 'right';
            }

            if((element.val().receive_by == user_id || element.val().receive_by == 'Admin') 
                    && (element.val().send_by == user_id || element.val().send_by == 'Admin')) {

                      $('#azChatBody').append(`
                      <div class="col-md-12 mt-2">
                         <div class="card" style="float: ${chat_pos};width: 70%">
                          <div class="card-body">
                          <h6 style="font-weight: bold;">${element.val().send_by == 'Admin' ? 'Admin' : element.val().username}</h6>
                            <h6>${element.val().chat_msg == 'Image' ? `<a href="<?= base_url('public/message_uploads') ?>/${element.val().file}" target="_blank"><img class="img-thumbnail" width="250px" height="180px"  src="<?= base_url('public/message_uploads') ?>/${element.val().file}"></a>` : element.val().chat_msg}</h6>
                            <small style="float: right;">${new Date(element.val().date).toUTCString()}</small>
                          </div>
                         </div>
                      </div>
                  `);   
            }

            $('#azChatBody').scrollTop($('#azChatBody').prop('scrollHeight'));
        });
       
    });

    $('#save_to_fire_base').click(function(e) {
      e.preventDefault();
      var to_user = '<?= session('u_id') ?>';
      var chat_msg = $('#chat_msg').val();
      var random_id = uniqueID();
      var message_type = $('#message_type').val();
      var username = '<?=session('fname') .' '. session('middlename') . ' ' . session('lastname') ?>';

      if($('#chat_msg').val() == '' || $('#message_type').val() == '') {
          Swal.fire('All fields are required!','','warning');
          return false;
      }

      database.ref('/message/'+random_id).set({
          receive_by: 'Admin',
          username: username,
          send_by: to_user,
          chat_msg: chat_msg,
          date: Date.now(),
          isView: 0,
          lat: parseFloat($('#lat').val()),
          lang: parseFloat($('#lang').val())
      })

      database.ref('message').orderByChild('send_by').equalTo(to_user).on('value', (snap) => {
        var count = 0;
      
        snap.forEach(function(elem) {

          if(elem.val().isView == 0 && elem.val().send_by == to_user) {
            count++;
            console.log(elem.val().isView)
          } 
        })

        database.ref('users').child(to_user).update({
            Messages: count,
            NewMessage: $('#chat_msg').val()
        });
      
      });

      SendMessage(message_type, chat_msg);

      SendSms(chat_msg);

      $('#chat_msg').val('');
    });

})
</script>
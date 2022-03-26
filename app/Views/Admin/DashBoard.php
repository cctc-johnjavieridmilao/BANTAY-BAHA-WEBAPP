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
    <?= $this->include('Admin/sidebar') ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

        <div class="row">
           <div class="col-md-12" >
              <button class="btn btn-success" id="send_to_all" style="float: right;">SEND TO ALL</button>
           </div>
        </div>
      
          <div class="row">

            <div class="col-lg-4 grid-margin stretch-card">
            <div class="card card-rounded">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                              <h4 class="card-title card-title-dash">USERS</h4>
                            </div>
                          </div>

                          <div id="azChatList"></div>
                          
                         
                        </div>
                      </div>
                    </div>
                </div>
            </div>
           
            <div class="col-lg-8 grid-margin stretch-card">

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">MESSAGES/REPORT <span style="float: right;" id="user_header"></span></h4>

                   <div class="row" id="azChatBody">
                     
                   </div>
                </div>
                <div class="card-footer">
                <div class="row">

                   <div class="col-md-11">
                    <input type="text" class="form-control" placeholder="Type your message here..." id="chat_msg">
                    <input type="file" accept="image/*" style="display: none;" id="file">
                    </div>

                    <div class="col-md-1">
                      <!-- <a href="javascript:void(0)"  id="choose_file"><i class="far fa-file"></i></a> -->
                      <a href="javascript:void(0)"  id="save_to_fire_base"><i class="far fa-paper-plane "></i></a>
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

  <div id="MessageToAllModal" class="modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">MESSAGE</h6>
            <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('MessageToAllModal')" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                     <label>Message Here</label>
                     <input type="text" class="form-control form-control-lg" id="message_all_text">
                </div>
              
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_send_all">SEND <span class="fas fa-paper-plane"></span></button>
            <button type="button" data-dismiss="modal" onclick="CloseModal('MessageToAllModal')" class="btn btn-outline-light">Close</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
  
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

  function viewLocation(lat, lang) {
     window.open(`https://www.google.com/maps/dir/${lat},${lang}/@${lat},${lang},12z`)
  }

  function SendSms(msg, userid) {
    $.ajax({
            type: 'POST',
            url: '<?=base_url('Admin/SendSmsToUser') ?>',
            data: {
                msg: msg,
                lat: $('#lat').val(),
                lang: $('#lang').val(),
                userid: userid
            },
            dataType: 'json',
            success: function(result) {
              console.log(result);
            }
    });
}

function ViewChat(user_id,name) {

var messages = database.ref('message').orderByChild('date');

  messages.on("value", function(snapshot) {

      $('#azChatBody').empty();
      //var count_unseen = 0;
          snapshot.forEach(function(element) {

              var chat_pos = '';

              if(element.val().send_by == 'Admin') {
                  chat_pos = 'right';
              } else {
                  chat_pos = 'left';
              }
  
              if((element.val().receive_by == user_id || element.val().receive_by == 'Admin') 
              && (element.val().send_by == user_id || element.val().send_by == 'Admin')) {

                  //$('#chat_body').empty()

                  $('#azChatBody').append(`
                      <div class="col-md-12 mt-2">
                         <div class="card" style="float: ${chat_pos};width: 70%">
                          <div class="card-body">
                          <h6 style="font-weight: bold;">${element.val().send_by == 'Admin' ? 'Admin' : element.val().username}</h6>
                            <h6>${element.val().chat_msg == 'Image' ? `<a href="<?= base_url('public/message_uploads') ?>/${element.val().file}" target="_blank"><img class="img-thumbnail" width="250px" height="180px"  src="<?= base_url('public/message_uploads') ?>/${element.val().file}"></a>` : element.val().chat_msg}</h6>
                            ${element.val().send_by == 'Admin' ? '' : `<button class="btn btn-primary btn-block btn-sm" onclick="viewLocation(${element.val().lat},${element.val().lang})">VIEW LOCATION</button>`}
                            <small style="float: right;">${new Date(element.val().date).toUTCString()}</small>
                          </div>
                         </div>
                      </div>
                  `);   
                            
              } 

          });

  });

  messages.once("value", function(snapshot) {

      snapshot.forEach(function(element) {

          if((element.val().receive_by == user_id || element.val().receive_by == 'Admin') 
          && (element.val().send_by == user_id || element.val().send_by == 'Admin')) {

              database.ref('message').child(element.key).update({
                isView: 1
              });
                        
          } 
      });

  });

  messages.limitToLast(1).once("value", function(snapshot) {

    snapshot.forEach(function(element) {

    if((element.val().receive_by == user_id || element.val().receive_by == 'Admin') 
    && (element.val().send_by == user_id || element.val().send_by == 'Admin')) {

        database.ref('users').child(user_id).update({
            Messages: 0,
            NewMessage: element.val().chat_msg
        });
                  
      } 
    });

  })

  $('#azChatBody').scrollTop(0); // RESET

  setTimeout(() => {
    $('#azChatBody').scrollTop($('#azChatBody').prop('scrollHeight'));
  },200)

  $('#user_id').val(user_id);
  $('#user_header').html(name);
}

function getusers() {
  var users = database.ref('users').orderByChild('date');

    users.on("value", function(snapshot) {

      $('#azChatList').empty();

        snapshot.forEach(function(element) {

          var key = element.key;

          if(element.val().user_type === 'user' && element.val().name != undefined) {
              $('#azChatList').append(`

                    <div class="mt-3 userlist" onclick="ViewChat(${key},'${element.val().name}')">
                      <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                          <div class="d-flex">
                          <img class="img-sm rounded-10" src="<?= base_url('public/assets/img/default_image.png') ?>" alt="profile">
                          <div class="wrapper ms-3">
                              <p class="ms-1 mb-1 fw-bold">${element.val().name}  ${element.val().Messages == 0 || element.val().Messages == undefined ? '' : `<span>${element.val().Messages}</span>`}</p>
                              <small class="text-muted mb-0">${element.val().NewMessage == undefined ? '' : (element.val().NewMessage.length > 25 ? element.val().NewMessage.substring(0,25) : element.val().NewMessage)}</small>
                          </div>
                          </div>
                          <div class="text-muted text-small">
                            ${element.val().isLogin == 1 ? 'Online' : 'Offline'}
                          </div>
                      </div>
                    </div>
                  `);
              }
        });

    });

}

function CloseModal(elem) {
    $('#'+elem).modal('hide');
  }


    $(function() {

      $('#send_to_all').click(function() {
        $('#MessageToAllModal').modal('show')
      });

      if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(showPosition);
      } else { 
        alert('Geolocation is not supported by this browser.');
      }

      getusers();

    });

    $('#btn_send_all').click(function() {
      var message_all_text = $('#message_all_text').val();

      var phone_number = [];

      $('#btn_send_all').attr('disabled','disabled').html('Please wait...');

      $.get('<?=base_url('Admin/GetUsers') ?>', function(result) {

         if(result.length > 0) {
            result.forEach(function(row) {
               if(row.user_type == 'user') {
                var random_id = uniqueID();
                phone_number.push(row.phone_number);
                
                database.ref('/message/'+random_id).set({
                    receive_by: row.RecID,
                    username: row.firtname + ' ' + row.middlename + ' ' + row.lastname,
                    send_by: 'Admin',
                    chat_msg: message_all_text,
                    date: Date.now(),
                    isView: 0,
                    lat: parseFloat($('#lat').val()),
                    lang: parseFloat($('#lang').val())
                });
                
               }
            });
          }
      },'json');
     
      setTimeout(() => {

         $.post('<?=base_url('Admin/SendBulk') ?>',{msg: message_all_text, phone_number: phone_number.join(',')}, function(res) {
           console.log(res);
             if(res.msg == 'success') {
               Swal.fire('Successfully Send!','','success');
             } else {
              Swal.fire(res.msg,'','error');
             }
             $('#btn_send_all').removeAttr('disabled').html('SEND <span class="fas fa-paper-plane"></span>');
             CloseModal('MessageToAllModal')
         },'json');
        
      },500);
         
    });

    $('#save_to_fire_base').click(function() {
      
     var to_user = $('#user_id').val();
     var chat_msg = $('#chat_msg').val();
     var random_id = uniqueID();
  
      if($('#chat_msg').val() == '') {
          return false;
      }

      database.ref('/message/'+random_id).set({
          receive_by: to_user,
          username: $('#user_header').text(),
          send_by: 'Admin',
          chat_msg: chat_msg,
          date: Date.now(),
          isView: 0,
          lat: parseFloat($('#lat').val()),
          lang: parseFloat($('#lang').val())
      });

      SendSms($('#chat_msg').val(), to_user);

      $('#azChatBody').scrollTop($('#azChatBody').prop('scrollHeight'));

     $('#chat_msg').val('');
  });

</script>

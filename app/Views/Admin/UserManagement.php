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
            <h1 class="welcome-text"><span class="text-black fw-bold">User Management</span></h1>
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
            <div class="col-md-5">
            <button class="btn btn-primary font-weight-medium mb-2" id="create_account">CREATE ACCOUNT</button>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <!-- <h4 class="card-title">Basic Table</h4> -->
  
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="users_table">
                      <thead>
                        <tr>
                          <th>FULLNAME</th>
                          <th>USERNAME</th>
                          <th>PHONE NUMBER</th>
                          <th>ROLE</th>
                          <th>EMAIL</th>
                          <th>STATUS</th>
                          <th>CREATE_AT</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
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
    

  <?= $this->include('layout/js_plugins') ?>
</body>
</html>


<!-- LARGE MODAL -->
<div id="ViewUserModal" class="modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">View</h6>
            <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('ViewUserModal')" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                     <label>Firstname</label>
                     <input type="text" class="form-control" id="fname" readonly>
                </div>
                <div class="col-md-12">
                     <label>Lastname</label>
                     <input type="text" class="form-control" id="lname" readonly>
                </div>
                <div class="col-md-12">
                     <label>Middlename</label>
                     <input type="text" class="form-control" id="mname" readonly>
                </div>
                <div class="col-md-12">
                     <label>Username</label>
                     <input type="text" class="form-control" id="username" readonly>
                </div>
                <div class="col-md-12">
                     <label>Email</label>
                     <input type="text" class="form-control" id="email" readonly>
                </div>
                <div class="col-md-12">
                     <label>Phone Number</label>
                     <input type="text" class="form-control" id="cpnumber" readonly>
                </div>
                <div class="col-md-12">
                     <label>Role</label>
                     <input type="text" class="form-control" id="role" readonly>
                     <input type="hidden" class="form-control" id="u_id">
                </div>
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="approved">Approved</button>
            <button type="button" class="btn btn-primary" id="dis_approved">Disaaproved</button>
            <button type="button" data-dismiss="modal" onclick="CloseModal('ViewUserModal')" class="btn btn-outline-light">Close</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

    <div id="CreateAccountModal" class="modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">CREATE ACCOUNT</h6>
            <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('CreateAccountModal')" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg cuserinput" id="cfname" placeholder="Firstname">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg cuserinput" id="cmname" placeholder="Middlename">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg cuserinput" id="clname" placeholder="Lastname">
                </div>

                <div class="form-group">
                  <input type="email" class="form-control form-control-lg cuserinput" id="cemail" placeholder="Email">
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg cuserinput" id="cusername" placeholder="Username">
                </div>

                <div class="form-group">
                  <select class="form-control form-control-lg cuserinput" id="crole">
                      <option value="">Select Role</option>
                      <option value="user">User</option>
                      <option value="admin">Admin</option>
                  </select>
                </div>

                <div class="form-group">
                  <input type="number" class="form-control form-control-lg cuserinput" value="63" id="cphone_number" placeholder="Phone Number">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg cuserinput" id="cpassword" placeholder="Password">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg cuserinput" id="ccpassword" placeholder="Confirm password">
                </div>
          </form>
          </div><!-- modal-body -->
          <div class="modal-footer">
             <button type="button" class="btn btn-primary" id="add_account">Save</button>
            <button type="button" data-dismiss="modal" onclick="CloseModal('CreateAccountModal')" class="btn btn-outline-light">Close</button>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->

<script>
  var users_table = $('#users_table').DataTable();

  function viewUser(id,fname,lname,mname,username,email,role,cpnum) {
     $('#fname').val(fname);
     $('#lname').val(lname);
     $('#mname').val(mname);
     $('#username').val(username);
     $('#email').val(email);
     $('#role').val(role);
     $('#cpnumber').val(cpnum);
     $('#u_id').val(id);
     $('#ViewUserModal').modal('show');
  }

  function CloseModal(elem) {
    $('#'+elem).modal('hide');
  }

  function DeleteUser(id) {
      if(confirm('Are you sure you want to delete this user?') == false) {
        return false;
      }

      $.post('<?= base_url('Admin/DeleteUser') ?>', {id: id}, function(result) {
           if(result.msg == 'success') {
            Swal.fire('Successfully Deleted','','success');
           } else {
            Swal.fire(result.msg,'','error');
           }
           GetUsersData();
      }, 'json');
  }

  function Status(stat) {
    if(stat == 1) {
       return 'Approved';
    } else if(stat == 2) {
      return 'Disapproved';
    } else if(stat == 0) {
      return 'Pending';
    }
  }
  
    function GetUsersData() {
      $.get('<?= base_url('Admin/GetUsers') ?>',(result) => {

        users_table.clear().draw();

          result.forEach((row) => {
              var tr = $(`
                <tr>
                    <td>${row.firtname}  ${row.middlename} ${row.lastname}</td>
                    <td>${row.username}</td>
                    <td>${row.phone_number}</td>
                    <td>${row.user_type}</td>
                    <td>${row.email}</td>
                    <td>${Status(row.Status)}</td>
                    <td>${row.created_at}</td>
                    <td align="center" width="12%">
                      <button class="btn btn-outline-danger btn-sm" onclick="DeleteUser(${row.RecID})"><span class="fas fa-trash"></span></button>
                      <button class="btn btn-outline-success btn-sm" onclick="viewUser(${row.RecID},'${row.firtname}','${row.lastname}','${row.middlename}','${row.username}','${row.email}','${row.user_type}','${row.phone_number}')"><span class="fas fa-search"></span></button>
                    </td>
                   
                </tr>
              `);
              users_table.row.add(tr);
          });

          users_table.draw();
        },'json');
    }


   $(function() {
      GetUsersData();

      $('#create_account').click(function() {
        $('#CreateAccountModal').modal('show');
      });

      $('#add_account').click(function() {

        var reg_exp_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

      if($('.cuserinput').val() == '') {
            Swal.fire('Please fill out all fields!','','warning');
            return false;
      }

      if(reg_exp_email.test($('#cemail').val()) == false) {
          Swal.fire('Please enter valid email!','','warning');
            return false;
      }

      if($('#cpassword').val() != $('#ccpassword').val()) {
            Swal.fire('Password and Confirm Password do not match!','','warning');
            return false;
        }

        $('#add_account').attr('disabled','disabled').html('Please wait...');

        $.ajax({
            type: 'POST',
            url: '<?=base_url('Admin/RegisterAccount') ?>',
            data: {
                fname: $('#cfname').val(),
                mname: $('#cmname').val(),
                lname: $('#clname').val(),
                username: $('#cusername').val(),
                email: $('#cemail').val(),
                phone_number: $('#cphone_number').val(),
                password: $('#cpassword').val(),
                role: $('#crole').val()
            },
            dataType: 'json',
            success: function(result) {
              if(result.msg == 'success') {

                  $('.cuserinput').val('');
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

              } else {
                  console.log(result);
              }

              GetUsersData();

              $('#add_account').removeAttr('disabled').html('Save');
            }
        })

      });

      $('#approved').click(function() {

        $('#approved').attr('disabled','disabled').html('Please wait...');

        $.ajax({
            type: 'POST',
            url: '<?=base_url('Admin/ApprovedAccount') ?>',
            data: {
              u_id: $('#u_id').val(),
            },
            dataType: 'json',
            success: function(result) {
              if(result.msg == 'success') {
                  Swal.fire('Account Successfully Approved!','','success');

              } else {
                  console.log(result);
              }

              GetUsersData();

              $('#approved').removeAttr('disabled').html('Approved');
            }
        })

      });

      $('#dis_approved').click(function() {

        $('#dis_approved').attr('disabled','disabled').html('Please wait...');

        $.ajax({
            type: 'POST',
            url: '<?=base_url('Admin/DisApprovedAccount') ?>',
            data: {
              u_id: $('#u_id').val(),
            },
            dataType: 'json',
            success: function(result) {
              if(result.msg == 'success') {
                  Swal.fire('Account Successfully DisApproved!','','success');

              } else {
                  console.log(result);
              }

              GetUsersData();

              $('#dis_approved').removeAttr('disabled').html('Disapproved');
            }
        })

      });
   });
</script>


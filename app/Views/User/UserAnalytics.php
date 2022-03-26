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
            <h1 class="welcome-text"><span class="text-black fw-bold">Analytics</span></h1>
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
                  <div id="col-md-12">
                    <div class="card">
                        <div class="card-body">
                          <h4 class="card-title"> REPORTS</h4><br>

                           <canvas id="chart_1"></canvas>
                        </div>
                    </div>
                  </div>

                  <div id="col-md-12" style="margin-top: 12px">
                    <div class="card">
                        <div class="card-body">
                          <h4 class="card-title"> FLOOD REPORTS</h4><br>

                           <canvas id="chart_2"></canvas>
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


function LoadChart(label, datas, colors, type = 'bar', elem) {

      const data = {
            labels: label,
                datasets: [{
                    data: datas, 
                    label: 'Flooding',
                    borderColor: colors,
                    backgroundColor: colors,
                    hoverOffset: 4
                }]
        }

        var ctx = $('#'+elem);

    new Chart(ctx, {
          type: type,
          data: data,
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
      });
}


function LoadChart2(label,baha_count,umulan_count,umulan_lakas,colors,type = 'bar',elem) {

    const data = {
        labels: label,
        datasets: [
            {
                data: baha_count, 
                label: 'Floods (Pag-baha)',
                borderColor: 'rgb(14,60,111)',
                backgroundColor: 'rgb(14,60,111)',
                hoverOffset: 4
           },
           {
                data: umulan_count, 
                label: 'Continuous rains (Tuloy-tuloy na pag-ulan)',
                borderColor: 'rgb(168,21,240)',
                backgroundColor: 'rgb(168,21,240)',
                hoverOffset: 4
           },
           {
                data: umulan_lakas, 
                label: 'Heavy rains (Malakas na pag-ulan)',
                borderColor: 'rgb(50,32,237)',
                backgroundColor: 'rgb(50,32,237)',
                hoverOffset: 4
           },
      ]
    }

    var ctx = $('#'+elem);

    new Chart(ctx, {
        type: type,
        data: data,
        options: {
        responsive: true,
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
}

$(function() {

    $.get('<?=base_url('Admin/GetAnalyticsFloods') ?>', function(result) {

        var label = [];
        var data = [];
        var colors = [];

        result.forEach(function(row, index) {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 100);
            var b = Math.floor(Math.random() * 300);
            
            label.push(row.label);

            data.push(row.count_baha);

            colors.push(`rgb(${r},${g},${b})`);
        });
    

       LoadChart(label, data, colors, 'bar', 'chart_2');

    },'json');


    $.get('<?=base_url('Admin/GetAnalyticsAll') ?>', function(result) {

        var label = [];
        var baha_count = [];
        var umulan_count = [];
        var umulan_lakas = [];
        var colors = [];

        result.forEach(function(row, index) {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 100);
            var b = Math.floor(Math.random() * 300);
            
            label.push(row.label);

            baha_count.push(row.count_baha);
            umulan_count.push(row.umulan);
            umulan_lakas.push(row.count_malakas_ulan);

            console.log(colors)

            colors.push(`rgb(${r},${g},${b})`);
        });


        LoadChart2(label,baha_count,umulan_count,umulan_lakas,colors, 'bar', 'chart_1');

    },'json');

});
 

</script>

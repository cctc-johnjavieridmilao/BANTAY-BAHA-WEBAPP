<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?= base_url('public/assets/js/jquery-3.3.1.js') ?>"></script>
<script src="<?= base_url('public/assets/js/vendor.bundle.base.js') ?>"></script>
<script src="<?= base_url('public/assets/js/sweetalert2.js') ?>"></script>
<script src="<?= base_url('public/assets/js/template.js') ?>"></script>
<script src="<?= base_url('public/assets/js/settings.js') ?>"></script>
<script src="<?= base_url('public/assets/js/off-canvas.js') ?>"></script>
<script src="<?= base_url('public/assets/js/bootstrap-4.min.js') ?>"></script>
<script src="<?= base_url('public/assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('public/assets/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('public/assets/chart.js/dist/Chart.min.js') ?>"></script>
  <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-database.js"></script>

<script>
      
      // Your web app's Firebase configuration
      // For Firebase JS SDK v7.20.0 and later, measurementId is optional
      const firebaseConfig = {
        apiKey: "AIzaSyDjYUH3BqL2naV3wur5M3bKA0avnMIV30w",
        authDomain: "bantaybaha-a3d4f.firebaseapp.com",
        databaseURL: "https://bantaybaha-a3d4f-default-rtdb.asia-southeast1.firebasedatabase.app/",
        projectId: "bantaybaha-a3d4f",
        storageBucket: "bantaybaha-a3d4f.appspot.com",
        messagingSenderId: "918813264398",
        appId: "1:918813264398:web:f3d7999dccbec86782ca5f",
        measurementId: "G-F5MJCC9KXE"
      };
      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
      firebase.analytics();
  
      var database = firebase.database();
      
        function Logout() {
        var user_id = "<?= session('u_id') ?>";
  
        database.ref('users').child(user_id).update({
            isLogin: 0
        });
  
        setTimeout(() => {
            window.location.href = "<?= base_url('Home/Logout') ?>";
        },2000);
      }
      </script>

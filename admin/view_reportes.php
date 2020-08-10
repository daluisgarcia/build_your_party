<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="./plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="./plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="./plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="./plugins/summernote/summernote-bs4.css">
  <!-- datatable -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../#" class="nav-link">Contact</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item dropdown">

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="../#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="../#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="../#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="../#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index" class="brand-link">
      <img src="./dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- SIDEBAR -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="./dist/img/person_outline-white.svg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="../#" class="d-block">Nombre Usuario</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
   
          <li class="nav-item option">
            <a href="../admin/#" id="notaria" class="nav-link">
              <img src="./dist/img/building.svg" class="nav-icon">
              <p>
                Notarias
<!--                <span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          <li class="nav-item option">
            <a href="../admin/#" id="cliente" class="nav-link">
              <img src="./dist/img/person_outline-white.svg" class="nav-icon">
              <p>
                Clientes
                <!--                <span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          <li class="nav-item option">
            <a href="../admin/#" id="posts" class="nav-link">
              <img src="./dist/img/notas.svg" class="nav-icon">
              <p>
                Posts
                <!--                <span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          <li class="nav-item option">
            <a href="view_reportes" id="reportes" class="nav-link">
              <img src="./dist/img/notas.svg" class="nav-icon">
              <p>
                Reportes
                <!--                <span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
        </ul>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

            <h1 id="title" class="m-0 text-dark">Reportes</h1><br><br>


            <form action="../reporte1_pdf.php" method="post">
            <div class="row">
            <div class="col"><h5>Reporte 1:</h5> cantidad de fiestas por mes</div>
              <div class="col"><input type="submit" class="btn btn-success delete-btn disabled"></div>
            </div>
            </form>
            
            <br><br>

            <form action="../reporte2_pdf.php" method="post">
            <div class="row">
            <div class="col"><h5>Reporte 2:</h5> servicios contratados</div>
              <div class="col">Inicio: <input type="date" name="inicio"></div>
              <div class="col">Fin: <input type="date" name="fin"></div>
              <div class="col"><input type="submit" class="btn btn-success delete-btn disabled"></div>
            </div>
            </form>

            <br><br>

            <form action="../reporte3_pdf.php" method="post">
            <div class="row">
            <div class="col"><h5>Reporte 3:</h5> ingresos-egresos</div>
              <div class="col">Inicio: <input type="date" name="inicio"></div>
              <div class="col">Fin: <input type="date" name="fin"></div>
              <div class="col"><input type="submit" class="btn btn-success delete-btn disabled"></div>
            </div>
            </form>

            <br><br>

            <form action="../reporte4_pdf.php" method="post">
            <div class="row">
            <div class="col"><h5>Reporte 4:</h5> top 10 servicios</div>
              <div class="col">Inicio: <input type="date" name="inicio"></div>
              <div class="col">Fin: <input type="date" name="fin"></div>
              <div class="col"><input type="submit" class="btn btn-success delete-btn disabled"></div>
            </div>
            </form>

            <br><br>

            <form action="../reporte5_pdf.php" method="post">
            <div class="row">
            <div class="col"><h5>Reporte 5:</h5> descuentos</div>
              <div class="col">Inicio: <input type="date" name="inicio"></div>
              <div class="col">Fin: <input type="date" name="fin"></div>
              <div class="col"><input type="submit" class="btn btn-success delete-btn disabled"></div>
            </div>
            </form>
            
        </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div id="container" class="container-fluid">
        <table id="table_id" class="display">
<!--          INFO DE LAS TABLAS AQUI-->
        </table>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="./plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="./plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="./plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="./plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="./plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="./plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="./plugins/moment/moment.min.js"></script>
<script src="./plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="./plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="./plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="./plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="./dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
<!-- CRUD NOTARIAS-->
<script src="./dist/js/admin_notaries.js"></script>
<!-- CRUD Clientes-->
<script src="./dist/js/admin_clients.js"></script>
<!-- CRUD Posts-->
<script src="./dist/js/admin_posts.js"></script>
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
</body>
</html>


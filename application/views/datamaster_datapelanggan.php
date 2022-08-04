<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengguna</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <?php $this->load->view('partials/head'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php $this->load->view('includes/nav'); ?>

  <?php $this->load->view('includes/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">Pengguna</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <button class="btn btn-success" data-toggle="modal" data-target="#modal" onclick="add()">Add</button>
          </div>
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="paket">
              <thead>
                <th style="width: 17px;">No</th>
                <th style="width: 37px;">Nomor Tagihan</th>
                <th style="width: 37px;">Nama</th>
                <th style="width: 76px;">Alamat</th>
                <th style="width: 68px;">No. Telp.</th>
                <th style="width: 35px;">Paket</th>
                <th style="width: 37px;">Harga</th>
                <th style="width: 79px;">Tanggal Pemasangan</th>
                <th style="width: 42px;">Jatuh Tempo</th>
                <th style="width: 40px;">Akun PPPoE</th>
                <th style="width: 49px;">IP Address</th>
                <th style="width: 49px;">Status</th>
                <th style="width: 55px;">Aksi</th>
              </thead>
            </table>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>

<div class="modal fade" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title_modal">Save Data</h5>
        <button class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>email</label>
          <input type="text" class="form-control" placeholder="email" id="email">
        </div>
        <div class="form-group">
          <label>username</label>
          <input type="text" class="form-control" placeholder="username" id="username">
        </div>
        <div class="form-group">
          <label>password</label>
          <input type="text" class="form-control" placeholder="password" id="password">
        </div>
        <div class="form-group">
          <label>nama pelanggan</label>
          <input type="text" class="form-control" placeholder="nama pelanggan" id="nama_pelanggan">
        </div>
        <div class="form-group">
          <label>alamat</label>
          <textarea class="form-control" id="alamat"></textarea>
        </div>
        <div class="form-group">
          <label>nomor telepon</label>
          <input type="text" class="form-control" id="nomor_telepon" placeholder="no telepon">
        </div>
        <div class="form-group">
          <label>id telegram</label>
          <input type="text" class="form-control" placeholder="id telegram" id="id_telegram">
        </div>
        <div class="form-group">
          <label>paket</label>
          <div class="input-group mb-3">
            <select class="custom-select" id="list_paket">
              <option selected>Choose...</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>tanggal pemasangan</label>
          <input type="date" class="form-control" placeholder="tanggal pemasangan" id="tanggal_pemasangan">
        </div>
        <div class="form-group">
          <label>jatuh tempo</label>
          <input type="text" class="form-control" placeholder="jatuh tempo" id="jatuh_tempo">
        </div>
        <div class="form-group">
          <label>akun pppoe</label>
          <input type="text" class="form-control" placeholder="akun pppoe" id="akun_pppoe">
        </div>
        <div class="form-group">
          <label>ip address</label>
          <input type="text" id="ip_address" class="form-control" placeholder="xxx.xxx.xxx.xx" autocomplete="off">
        </div>
        <div class="form-group">
          <label>status</label>
          <div class="input-group mb-3">
            <select class="custom-select" id="status_user">
            </select>
          </div>        
        </div>
        <button class="btn btn-success" onclick="save()">Save</button>
        <button class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
  var readUrl = '<?php echo site_url('datamaster/read_pelanggan/1') ?>';
  var readUrlpaket = '<?php echo site_url('datamaster/read/1') ?>';
  var getUrlUser = '<?php echo site_url('datamaster/get_user_by_id/1') ?>';
  var addUrlUser = '<?php echo site_url('datamaster/add_user/1') ?>';
</script>
<script src="<?php echo base_url('assets/js/datamaster_datapelanggan.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/ip_mask.js') ?>"></script>
</body>
</html>

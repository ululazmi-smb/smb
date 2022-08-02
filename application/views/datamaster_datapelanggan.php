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
    <h5 class="modal-title">Save Data</h5>
    <button class="close" data-dismiss="modal">
      <span>&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form id="form">
      <input type="hidden" name="id">
      <div class="form-group">
        <label>email</label>
        <input type="text" class="form-control" placeholder="email" name="email" required>
      </div>
      <div class="form-group">
        <label>username</label>
        <input type="text" class="form-control" placeholder="username" name="username" required>
      </div>
      <div class="form-group">
        <label>password</label>
        <input type="text" class="form-control" placeholder="password" name="nama">
      </div>
      <!-- <div class="form-group">
        <label>Image</label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="inputGroupFile01">
          <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
      </div> -->
      <button class="btn btn-success" type="submit">Save</button>
      <button class="btn btn-danger" data-dismiss="modal">Close</button>
    </form>
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
  var addUrl = '<?php echo site_url('pengguna/add') ?>';
  var deleteUrl = '<?php echo site_url('pengguna/delete') ?>';
  var editUrl = '<?php echo site_url('pengguna/edit') ?>';
  var getPenggunaUrl = '<?php echo site_url('pengguna/get_pengguna') ?>';
</script>
<script src="<?php echo base_url('assets/js/datamaster_datapelanggan.min.js') ?>"></script>
</body>
</html>

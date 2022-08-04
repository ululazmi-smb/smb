<?php
  $bulan = array("januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transaksi</title>
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
            <h1 class="m-0 text-dark">Tagihan</h1>
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
            <div class="input-group mb-3">
            <select class="custom-select" id="bulan_id">
                <?php
                for($i = 1; $i <= 12; $i++)
                {
                  if($i < 10){
                    $bul = "0".$i;
                  } else {
                    $bul = $i;
                  }
                  if($bul == date("m"))
                  {
                    echo '<option value="'.$bul.'" selected>'.$bulan[$i-1].'</option>';
                  } else {
                    echo '<option value="'.$bul.'">'.$bulan[$i-1].'</option>';
                  }
                }
                ?>
              </select>
              <select class="custom-select" id="tahun_id">
                <?php
                for($i = 2020; $i <= date('Y'); $i++)
                {
                  if($i == date("Y"))
                  {
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                  } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                }
                ?>
              </select>
              <div class="input-group-prepend">
                <button class="btn btn-success" onclick="start()">ambil tagihan</button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#modal" onclick="add()">buat tagihan</button>
                <button class="btn btn-success" onclick="generate()">Generate</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="pengguna">
              <thead>
                <tr>
                  <th>No</th>
                  <th>No Tagihan</th>
                  <th>Nama</th>
                  <th>Nama Paket</th>
                  <th>bulan/tahun</th>
                  <th>tagihan</th>
                  <th>jatuh tempo</th>
                  <th>status bayar</th>
                  <th class="col-1">Action</th>
                </tr>
              </thead>
            </table>
            <button class="btn btn-success">Kirim Pesan Semua</button>

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
        <h5 class="modal-title">Buat Tagihan</h5>
        <button class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="input-group mb-3">
            <select class="custom-select" id="inputGroupSelect01">
                <?php
                for($i = 1; $i <= 31; $i++)
                {
                  if($i < 10){
                    $bul = "0".$i;
                  } else {
                    $bul = $i;
                  }
                  if($bul == date("d"))
                  {
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                  } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                }
                ?>
              </select>
              <select class="custom-select" id="inputGroupSelect01">
                <?php
                for($i = 1; $i <= 12; $i++)
                {
                  if($i < 10){
                    $bul = "0".$i;
                  } else {
                    $bul = $i;
                  }
                  if($bul == date("m"))
                  {
                    echo '<option value="'.$i.'" selected>'.$bulan[$i-1].'</option>';
                  } else {
                    echo '<option value="'.$i.'">'.$bulan[$i-1].'</option>';
                  }
                }
                ?>
              </select>
              <select class="custom-select" id="inputGroupSelect01">
                <?php
                for($i = 2020; $i <= date('Y'); $i++)
                {
                  if($i == date("Y"))
                  {
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                  } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                }
                ?>
              </select>
            </div>
        </div>
        <div class="form-group">
        <label>user</label>
          <select class="custom-select" id="inputGroupSelect01">
                <?php
                for($i = 2020; $i <= date('Y'); $i++)
                {
                  if($i == date("Y"))
                  {
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                  } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                }
                ?>
              </select>
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
  var getDataStart = '<?php echo site_url('transaksi/read_transaksi/1') ?>';
  var urlGenerate = '<?php echo site_url('transaksi/generate/1') ?>';
</script>
<script src="<?php echo base_url('assets/js/transaksi.min.js') ?>"></script>
</body>
</html>

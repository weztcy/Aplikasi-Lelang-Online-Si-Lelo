<?php
  $id       = $this->session->userdata('id');
  $sql_user = "SELECT * FROM users WHERE id = '$id'";
  $bidder   = $this->db->query($sql_user)->row_array();
  $kelamin  = $bidder['gender'];

  $sql_deposit = "SELECT * FROM abe_deposit WHERE id_user = '$id' AND status = 'oke'";
  $deposit     = $this->db->query($sql_deposit)->row_array();
  $jumlah = $deposit['jumlah'];
?>
      
      <div id="heading-breadcrumbs">
        <div class="container">
          <div class="row d-flex align-items-center flex-wrap">
            <div class="col-md-7">
              <h1 class="h2">My Orders</h1>
            </div>
            <div class="col-md-5">
              <ul class="breadcrumb d-flex justify-content-end">
                <li class="breadcrumb-item"><a href="#">Profile</a></li>
                <li class="breadcrumb-item active">My Orders</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="content">
        <div class="container">
          <div class="row bar mb-0">
            <div id="customer-orders" class="col-md-9">
              <p class="text-muted lead">If you have any questions, please feel free to <a href="#">contact us</a>, our customer service center is working for you 24/7.</p>
              <?php if($this->session->flashdata('sukses')){ ?>
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><center><?php echo $this->session->flashdata('sukses'); ?></center></p>
                  </div>
                <?php }elseif($this->session->flashdata('gagal')){?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p><center><?php echo $this->session->flashdata('gagal'); ?></center></p>
                  </div>
                <?php } ?>
              <div class="box mt-0 mb-lg-0">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Produk</th>
                        <th>Jumlah Penawaran</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $id_user = $this->session->userdata['id'];
                        //$sql_bidder = "SELECT * FROM abe_lelang_bidder WHERE id_bidder = '$id_user'";
                        $sql_invoice = "SELECT * FROM abe_invoice WHERE id_user = '$id_user'";
                        $sql_payment = "SELECT * FROM abe_invoice WHERE id_user = '$id_user' AND status = 'belum bayar'";
                        $payment = $this->db->query($sql_payment)->num_rows();
                        $bidder = $this->db->query($sql_invoice)->result();
                        $bidder2 = $this->db->query($sql_invoice)->num_rows();
                        $no = 1;
                        if($bidder2 == ''){
                          ?>
                        <tr><td colspan="5"><center>belum ada penawaran masuk / tidak ada data</center> </td></tr>
                        <?php
                          }else{
                        foreach ($bidder as $row) {
                          $produk = $row->id_produk;
                          $user_bidder = "SELECT * FROM abe_produk WHERE id_produk = '$produk'";
                          $sql_produk = $this->db->query($user_bidder)->row_array();
                      ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= date('d M Y / H:i:s', strtotime($row->tgl_buat)) ?></td>
                        <td><a href="<?= base_url('profile/invoice/').$sql_produk['id_produk'] ?>"> <?= $sql_produk['nama_produk'] ?> </a></td>
                        <td>Rp. <?= number_format($row->harga_produk,2,',','.') ?></td>
                        <?php
                          if($row->status == 'belum bayar'){
                        ?>
                          <td><span class="badge badge-warning"><?= $row->status ?></span></td>
                        <?php
                          }else{
                        ?>
                          <td><span class="badge badge-success"><?= $row->status ?></span></td>
                        <?php
                          }
                        ?>
                        
                      </tr>
                      <?php
                          $no ++;
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-3 mt-4 mt-md-0">
              <!-- CUSTOMER MENU -->
              <div class="panel panel-default sidebar-menu">
                <div class="panel-heading">
                  <h3 class="h4 panel-title">Customer section</h3>
                </div>
                <div class="panel-body">
                  <ul class="nav nav-pills flex-column text-sm">
                    <li class="nav-item"><a href="<?= base_url('profile') ?>" class="nav-link "><i class="fa fa-user"></i> My account</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/rekomendasi') ?>" class="nav-link"><i class="fa fa-list"></i> My Interest</a></li>
                    <li class="nav-item"><a href="<?= base_url('profile/orders') ?>" class="nav-link "><i class="fa fa-list"></i> My orders</a></li>
                    <li class="nav-item">
                      <a href="<?= base_url('profile/payment') ?>" class="nav-link active"><i class="fa fa-credit-card"></i> My payment 
                        <?php
                          if($payment == '0'){
                            echo "";
                          }else{
                        ?>
                          <span class="btn btn-sm btn-danger"><?= $payment ?></span>
                        <?php
                          }
                        ?>
                      </a>
                    </li>
                    <li class="nav-item"><a href="<?= base_url('home/logout') ?>" class="nav-link"><i class="fa fa-sign-out"></i> Logout</a></li>
                    <?php
                      if($jumlah == ''){
                    ?>
                        <div class="alert alert-danger" role="alert">
                          <p><center>Saldo Deposit Anda <br>Rp. 0 <br> Silahkan isi terlebih dahulu agar dapat mengikuti lelang</center></p>
                        </div>
                        <li class="nav-item"><a href="#" class="nav-link active"><i class="fa fa-money"></i> Top Up Deposit</a></li>
                    <?php
                      }else{
                    ?>
                      <div class="alert alert-info" role="alert">
                          <p><center>Saldo Deposit Anda <br>Rp. <?= number_format($jumlah,2,',','.') ?></center></p>
                      </div>
                    <?php
                      }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
   
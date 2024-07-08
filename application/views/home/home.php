      <section style="background: url('<?= base_url('assets/front_end/') ?>img/photogrid.jpg') center center repeat; background-size: cover;" class="relative-positioned">
        <!-- Carousel Start-->
        <div class="home-carousel">
          <div class="dark-mask mask-primary"></div>
          <div class="container">
            <div class="homepage owl-carousel">
              <div class="item">
                <div class="row">
                  <div class="col-md-5 text-right">
                    <p><img src="<?= base_url('assets/front_end/') ?>img/logo.png" alt="" class="ml-auto"></p>
                    <h1>Multipurpose responsive theme</h1>
                    <p>Business. Corporate. Agency.<br>Portfolio. Blog. E-commerce.</p>
                  </div>
                  <div class="col-md-7"><img src="<?= base_url('assets/front_end/') ?>img/template-homepage.png" alt="" class="img-fluid"></div>
                </div>
              </div>
              <div class="item">
                <div class="row">
                  <div class="col-md-7 text-center"><img src="<?= base_url('assets/front_end/') ?>img/template-mac.png" alt="" class="img-fluid"></div>
                  <div class="col-md-5">
                    <h2>46 HTML pages full of features</h2>
                    <ul class="list-unstyled">
                      <li>Sliders and carousels</li>
                      <li>4 Header variations</li>
                      <li>Google maps, Forms, Megamenu, CSS3 Animations and much more</li>
                      <li>+ 11 extra pages showing template features</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="row">
                  <div class="col-md-5 text-right">
                    <h1>Design</h1>
                    <ul class="list-unstyled">
                      <li>Clean and elegant design</li>
                      <li>Full width and boxed mode</li>
                      <li>Easily readable Roboto font and awesome icons</li>
                      <li>7 preprepared colour variations</li>
                    </ul>
                  </div>
                  <div class="col-md-7"><img src="<?= base_url('assets/front_end/') ?>img/template-easy-customize.png" alt="" class="img-fluid"></div>
                </div>
              </div>
              <div class="item">
                <div class="row">
                  <div class="col-md-7"><img src="<?= base_url('assets/front_end/') ?>img/template-easy-code.png" alt="" class="img-fluid"></div>
                  <div class="col-md-5">
                    <h1>Easy to customize</h1>
                    <ul class="list-unstyled">
                      <li>7 preprepared colour variations.</li>
                      <li>Easily to change fonts</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Carousel End-->
      </section>
      <section class="bar no-mb">
        <div class="container">
          <div class="col-md-12">
            <div class="heading text-center">
              <h2>Products</h2>
            </div>
            <div class="row text-center">
              <?php
                $sql    = "SELECT * FROM abe_produk WHERE status = 'lelang' ORDER BY rand() LIMIT 8";
                $produk = $this->db->query($sql)->result();
                foreach ($produk as $row) {
                  $id_kategori  = $row->id_kategori;
                  $id_produk    = $row->id_produk;
                  $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id_kategori'")->row_array();
                  $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk' LIMIT 1")->row_array();
              ?>
                <div class="col-md-3">
                  <div data-animate="fadeInUp" class="team-member">
                    <div class="image">
                      <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>">
                      <img width="200" height="200" class="img-circle" src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" ></a>
                    </div>
                    <h3><a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>"><?= $row->nama_produk ?></a></h3>
                    <p class="role"><?= $kategori['nama_kategori'] ?></p>
                    <div class="text">
                      <p><strong> Rp. <?= number_format($row->harga_produk,2,',','.') ?> </strong></p>
                    </div>
                    <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>" class="btn btn-template-main">Bid Now..!!</a>
                    
                  </div>
                </div>

              <?php
                 } 
              ?>

            </div>
          </div>
        </div>

        <?php
          if($this->session->userdata('id') == ''){
            echo "";
          }else{
        ?>
          <div class="container">
            <div class="col-md-12">
              <div class="heading text-center">
                <h2>Maybe Your Likes</h2>
              </div>
              <div class="row text-center">
                <?php
                  $user   = $this->session->userdata('id');
                  $query  = $this->db->query("SELECT MAX(jumlah_klik) as max_klik, id_kategori FROM abe_kategori_klik WHERE id_bidder = '$user'")->row_array(); 
                  $kategori_klik = $query['id_kategori']; 

                  $sql    = "SELECT * FROM abe_produk WHERE status = 'lelang' AND id_kategori = '$kategori_klik' ORDER BY rand() LIMIT 8 ";
                  $produk = $this->db->query($sql)->result();
                  foreach ($produk as $row) {
                    $id_kategori  = $row->id_kategori;
                    $id_produk    = $row->id_produk;
                    $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id_kategori'")->row_array();
                    $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk' LIMIT 1")->row_array();
                    $bidder = $this->db->query("SELECT * FROM abe_lelang_bidder WHERE id_barang = '$id_produk'")->num_rows();
                ?>
                  <div class="col-md-3">
                    <div data-animate="fadeInUp" class="team-member">
                      <div class="image">
                        <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>">
                        <img width="200" height="200" class="img-circle" src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" ></a>
                      </div>
                      <h3><a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>"><?= $row->nama_produk ?></a></h3>
                      <p class="role"><?= $kategori['nama_kategori'] ?></p>
                      <div class="text">
                        <p><strong> Rp. <?= number_format($row->harga_produk,2,',','.') ?> </strong></p>
                      </div>
                      <div class="ribbon-holder">
                        <div class="ribbon new"><?= $bidder ?> bid</div>
                      </div>
                      <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>" class="btn btn-template-main">Bid Now..!!</a>
                      
                    </div>
                  </div>
                <?php
                   } 
                ?>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="col-md-12">
              <div class="heading text-center">
                <h2>Recomended Bid</h2>
              </div>
              <div class="row text-center">
                <?php
                  $user   = $this->session->userdata('id');
                  $query2  = $this->db->query("SELECT id_kategori, count(id_kategori) AS jumlah FROM abe_lelang_bidder WHERE id_bidder = '$user' group by id_kategori ORDER BY jumlah DESC limit 1")->row_array(); 
                  $kategori_bid = $query2['id_kategori']; 

                  $sql2    = "SELECT * FROM abe_produk WHERE status = 'lelang' AND id_kategori = '$kategori_bid' ORDER BY rand() LIMIT 8 ";
                  $produk2 = $this->db->query($sql2)->result();
                  foreach ($produk2 as $row) {
                    $id_kategori  = $row->id_kategori;
                    $id_produk    = $row->id_produk;
                    $kategori = $this->db->query("SELECT * FROM abe_kategori WHERE id_kategori = '$id_kategori'")->row_array();
                    $foto = $this->db->query("SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk' LIMIT 1")->row_array();
                    $bidder = $this->db->query("SELECT * FROM abe_lelang_bidder WHERE id_barang = '$id_produk'")->num_rows();
                ?>
                  <div class="col-md-3">
                    <div data-animate="fadeInUp" class="team-member">
                      <div class="image">
                        <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>">
                        <img width="200" height="200" class="img-circle" src="<?= base_url('assets/foto_produk/').$foto['file_foto'] ?>" ></a>
                      </div>
                      <h3><a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>"><?= $row->nama_produk ?></a></h3>
                      <p class="role"><?= $kategori['nama_kategori'] ?></p>
                      <div class="text">
                        <p><strong> Rp. <?= number_format($row->harga_produk,2,',','.') ?> </strong></p>
                      </div>
                      <div class="ribbon-holder">
                        <div class="ribbon new"><?= $bidder ?> bid</div>
                      </div>
                      <a href="<?= base_url('home/produk/').$kategori['url_kategori'].'/'.$row->id_produk ?>" class="btn btn-template-main">Bid Now..!!</a>
                      
                    </div>
                  </div>
                <?php
                   } 
                ?>
              </div>
            </div>
          </div>
        <?php
          }
        ?>


      </section>
      <section class="bar no-mb">
        <div data-animate="fadeInUp" class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="heading text-center">
                <h3>Latest from category</h3>
              </div>
              <div class="row portfolio text-center no-space">
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/Painting Logo.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/painting') ?>" class="color-white">Painting</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Pellentesque habitant morbi tristique senectus et netus et malesuada</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/painting') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/Wooden Craft Logo.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/woodencraft') ?>" class="color-white">WoodenCraft</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Pellentesque habitant morbi tristique senectus et netus et malesuada</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/woodencraft') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/Mixed Media Logo.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/mixedmedia') ?>" class="color-white">Mixed Media</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Pellentesque habitant morbi tristique senectus et netus et malesuada</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/mixedmedia') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/Wooden Cut Logo.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/woodcut') ?>" class="color-white">Wood Carving</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Pellentesque habitant morbi tristique senectus et netus et malesuada</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/woodcut') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/Fine Art Logo.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/fineart') ?>" class="color-white">Fine Art</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Pellentesque habitant morbi tristique senectus et netus et malesuada</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/fineart') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-image">
                    <div class="image"><img src="<?= base_url('assets/front_end/') ?>img/Sculpture Logo.png" alt="" class="img-fluid">
                      <div class="overlay d-flex align-items-center justify-content-center">
                        <div class="content">
                          <div class="name">
                            <h3><a href="<?= base_url('home/kategori/sculpture') ?>" class="color-white">Sculpture</a></h3>
                          </div>
                          <div class="text">
                            <p class="d-none d-sm-block">Pellentesque habitant morbi tristique senectus et netus et malesuada</p>
                            <p class="buttons"><a href="<?= base_url('home/kategori/sculpture') ?>" class="btn btn-template-outlined-white">View</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
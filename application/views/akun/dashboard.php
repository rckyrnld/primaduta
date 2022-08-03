<!-- main content start -->
<section id="main-content">
    <div class="wrapper site-min-height">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <div class="card rounded-0">
                        <div class="card-body">
                            <div class="bc">
                                <ul>
                                    <li>Dashboard</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">DASHBOARD</p>
                                <div class="row">
                                    <p>Selamat datang di pendaftaran Primaduta <?php echo date("Y"); ?>.</p>
                                    <p>Silahkan daftarkan data peserta Primaduta di menu <a href="<?php echo base_url('main/buyer'); ?>">Pendaftaran Peserta</a></p>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="py-2" style="font-size: 16px;">PENDAFTARAN KATEGORI PERWAKILAN PENDUKUNG EKSPOR INDONESIA</p>
                                    <?php
                                    //ambil data kategori perwakilan pendukung ekspor
                                    $pe = $this->dutamod->ambilkategoriperwakilan()->row();
                                    ?>
                                    <p><b>Penjelasan Kategori</b></p>
                                    <?php echo $pe->keterangan; ?>
                                    <p><b>Kriteria</b></p>
                                    <span><?php echo $pe->kriteria; ?></span>
                                    <p><b>Pendaftaran</b></p>
                                    <p>Untuk pendaftaran Primaduta kategori Perwakilan Pendukung Ekspor Indonesia daftar <a href="<?php echo base_url('main/perwakilan'); ?>">disini</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- main content end -->
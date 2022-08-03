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
                                    <li><a href="<?php echo base_url('main/dashboard'); ?>">Dashboard</a></li>
                                    <li><a href="<?php echo base_url('main/buyer'); ?>">Pendaftaran Buyer</a></li>
                                    <li>Kategori Primaduta</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">KATEGORI PRIMADUTA</p>
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <?php $this->load->view('akun/tpl_buyermenu'); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="row mb-2">
                                                    <label for="nmperusahaan" class="col-md-3 mb-2">Kategori Primaduta Yang dipilih</label>
                                                    <div class="col-md-9">
                                                        <b><?php echo $vnmkategori; ?></b>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label for="nmperusahaan" class="col-md-3 mb-2">Penjelasan Kategori</label>
                                                    <div class="col-md-9">
                                                        <?php echo $vketerangan; ?>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label for="nmperusahaan" class="col-md-3 mb-2">Kriteria</label>
                                                    <div class="col-md-9">
                                                        <?php echo $vkriteria; ?>
                                                    </div>
                                                </div>
                                                <div class="row mb-2" style="border-top: 1px solid #121212;">
                                                    <p>Untuk mengganti kategori Primaduta harap hubungi panitia di <span class="text-danger">primaduta.award@kemendag.go.id</span></p>
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
        </div>
    </div>
</section>
<!-- main content end -->

<script>
    // validasi form
    $("#frmbuy").validate({
        rules: {
            nmperusahaan: "required",
            idnegara: "required", 
            alamat: "required",
            telepon: "required",
            email: {
                required: true,
                email: true
            },
            tahunimpor: {
                required: true,
                number: true
            }
        },
        messages: {
            nmperusahaan: "Harap diisi",
            idnegara: "Harap dipilih",
            alamat: "Harap diisi",
            telepon: "Harap diisi",
            email: {
                required: "Harap diisi",
                email: "Email harap diisi dengan benar"
            },
            tahunimpor: {
                required: "Harap diisi",
                number: "Harap diisi dengan angka"
            }
        }
    });
</script>
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
                                    <li><a href="<?php echo base_url('main/buyer'); ?>">Daftar Peserta</a></li>
                                    <li>Tambah Data Peserta</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">TAMBAH DATA PESERTA</p>
                                <div class="row">
                                    <div class="col">
                                        <form id="frmbuy" name="frmbuy" method="post" action="<?php echo base_url('main/simpanbuyer'); ?>">
                                            <div class="card bg-success text-white bg-opacity-75 text-center mb-4 rounded-0">
                                                <div class="card-header">
                                                    <b>PILIH KATEGORI PRIMADUTA</b>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label for="nmperusahaan" class="col-md-3 mb-2">Pilih Kategori</label>
                                                <div class="col-md-4">
                                                    <select class="form-control rounded-0" id="idkategori" name="idkategori" onchange="ambilketerangan()" required>
                                                        <option value=""></option>
                                                        <?php
                                                        $d = $kat->result();
                                                        $n = $kat->num_rows();
                                                        if($n > 0) {
                                                            for ($i = 0; $i < count($d); ++$i) {
                                                            ?>
                                                            <option value="<?php echo $d[$i]->idkategori; ?>"><?php echo $d[$i]->nmkategori; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-8 offset-md-3 mt-2" id="ketkatduta" style="display: none;"></div>
                                            </div>
                                            <div class="card bg-success text-white bg-opacity-75 text-center my-4 rounded-0">
                                                <div class="card-header">
                                                    <b>ISI PROFIL PESERTA</b>
                                                </div>
                                            </div> 
                                            <div class="row mb-2">
                                                <label for="nmperusahaan" class="col-md-3 mb-2">Nama Perusahaan</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control rounded-0" id="nmperusahaan" name="nmperusahaan" maxlength="200" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label for="telepon" class="col-md-3 mb-2">Negara</label>
                                                <div class="col-md-4">
                                                    <select class="form-control rounded-0" id="idnegara" name="idnegara">
                                                        <option value=""></option>
                                                        <?php
                                                        $d = $neg->result();
                                                        $n = $neg->num_rows();
                                                        if($n > 0) {
                                                            for ($i = 0; $i < count($d); ++$i) {
                                                            ?>
                                                            <option value="<?php echo $d[$i]->idnegara; ?>" <?php if($this->dutamod->neguser($this->decrypt_id)==$d[$i]->idnegara) echo "selected"; ?>><?php echo $d[$i]->negara; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="alamat" class="col-md-3 mb-2">Alamat</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control rounded-0" id="alamat" name="alamat" maxlength="200" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="telepon" class="col-md-3 mb-2">Telepon</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control rounded-0" id="telepon" name="telepon" maxlength="50" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="fax" class="col-md-3 mb-2">Fax</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control rounded-0" id="fax" name="fax" maxlength="50">
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="email" class="col-md-3 mb-2">Email</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control rounded-0" id="email" name="email" maxlength="200" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="website" class="col-md-3 mb-2">Website</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control rounded-0" id="website" name="website" maxlength="200">
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="website" class="col-md-3 mb-2">Awal Tahun Impor</label>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control rounded-0" id="tahunimpor" name="tahunimpor" maxlength="4">
                                                </div>
                                            </div>
                                            <div class="form-group py-2">
                                                <button type="submit" class="btn btn-success form-control rounded-0" name="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Submit</button>
                                            </div>
                                        </form>
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
    function ambilketerangan() {
        var xid = document.getElementById("idkategori").value;
        var xdv = document.getElementById("ketkatduta");

        if (xid === "") {
            xdv.style.display = "none";
        } else {
            xdv.style.display = "block";
        }

        $.ajax({
            url: "<?php echo base_url('main/ambilketerangan'); ?>",
            type: "POST",
            data: {
               idkat: xid
            },
            dataType: "json",
            success: function(res) {
                $("#ketkatduta").html(res);
            }
        });

    }
    
    // validasi form
    $("#frmbuy").validate({
        rules: {
            idkategori: "required",
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
            idkategori: "Harap dipilih",
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
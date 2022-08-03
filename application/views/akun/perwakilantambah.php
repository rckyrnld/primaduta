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
                                    <li><a href="<?php echo base_url('main/perwakilan'); ?>">Perwakilan Pendukung Ekspor</a></li>
                                    <li>Tambah Data Perwakilan</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">TAMBAH DATA PERWAKILAN</p>
                                <div class="row">
                                    <div class="col">
                                        <form id="frmwakil" name="frmwakil" method="post" action="<?php echo base_url('main/simpanperwakilanprofil'); ?>">
                                            <div class="row mb-2">
                                                <label for="nama" class="col-md-3 mb-2">Nama</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control rounded-0" id="nama" name="nama" maxlength="200" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label for="jabatan" class="col-md-3 mb-2">Jabatan</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control rounded-0" id="jabatan" name="jabatan" maxlength="200" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label for="telepon" class="col-md-3 mb-2">Negara Penempatan</label>
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
                                                <label for="masa" class="col-md-3 mb-2">Masa Jabatan</label>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control rounded-0" id="datepicker" name="masa1" maxlength="10" placeholder="Tanggal awal">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control rounded-0" id="datepicker2" name="masa2" maxlength="10" placeholder="Tanggal akhir">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="pic" class="col-md-3 mb-2">Nama PIC</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control rounded-0" id="pic" name="pic" maxlength="200" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="picphone" class="col-md-3 mb-2">Telepon PIC</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control rounded-0" id="picphone" name="picphone" maxlength="20">
                                                </div>
                                            </div>
                                            <div class="row mb-2">                                    
                                                <label for="picemail" class="col-md-3 mb-2">Email PIC</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control rounded-0" id="picemail" name="picemail" maxlength="200" required>
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
    $( function() {
        $( "#datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            changeYear: true,
            changeMonth: true
        });
        
        $( "#datepicker2").datepicker({
            dateFormat: 'dd/mm/yy',
            changeYear: true,
            changeMonth: true
        });
    } );
    
    
    // validasi form
    $("#frmwakil").validate({
        rules: {
            nama: "required",
            jabatan: "required",
            idnegara: "required", 
            masa1: "required",
            masa2: "required",
            pic: "required",
            picphone: "required",
            picemail: {
                required: true,
                email: true
            }
        },
        messages: {
            nama: "Harap diisi",
            jabatan: "Harap diisi",
            idnegara: "Harap dipilih",
            masa1: "Harap diisi",
            masa2: "Harap diisi",
            pic: "Harap diisi",
            picphone: "Harap diisi",
            picemail: {
                required: "Harap diisi",
                email: "Email harap diisi dengan benar"
            }
        }
    });
</script>
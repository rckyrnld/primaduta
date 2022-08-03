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
                                    <li>Profil Perwakilan</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">PROFIL PERWAKILAN</p>
                                <?php
                                if(!empty($this->session->sessperwakilanprofil)) {
                                    ?>
                                    <div class="alert alert-primary rounded-0" role="alert">
                                        <?php echo $this->session->sessperwakilanprofil; ?>
                                    </div>
                                    <?php
                                    $this->session->unset_userdata('sessperwakilanprofil');
                                }
                                ?>
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <?php $this->load->view('akun/tpl_perwakilanmenu'); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <form id="frmwakil" name="frmwakil" method="post" action="<?php echo base_url('main/updateperwakilanprofil'); ?>">
                                                    <input type="hidden" id="idprofil" name="idprofil" value="<?php echo $idprofil; ?>">
                                                    <div class="row mb-2">
                                                        <label for="nama" class="col-md-3 mb-2">Nama</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control rounded-0" id="nama" name="nama" maxlength="200" value="<?php echo $vnama; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="jabatan" class="col-md-3 mb-2">Jabatan</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control rounded-0" id="jabatan" name="jabatan" maxlength="200" value="<?php echo $vjabatan; ?>" required>
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
                                                                    <option value="<?php echo $d[$i]->idnegara; ?>" <?php if($vidnegara==$d[$i]->idnegara) { echo "selected"; } ?>><?php echo $d[$i]->negara; ?></option>
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
                                                                    <input type="text" class="form-control rounded-0" id="datepicker" name="masa1" maxlength="10" value="<?php echo $vmasa1; ?>">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control rounded-0" id="datepicker2" name="masa2" maxlength="10" value="<?php echo $vmasa2; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">                                    
                                                        <label for="pic" class="col-md-3 mb-2">Nama PIC</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control rounded-0" id="pic" name="pic" maxlength="200" value="<?php echo $vpic; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">                                    
                                                        <label for="picphone" class="col-md-3 mb-2">Telepon PIC</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control rounded-0" id="picphone" name="picphone" value="<?php echo $vpicphone; ?>" maxlength="20">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">                                    
                                                        <label for="picemail" class="col-md-3 mb-2">Email PIC</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control rounded-0" id="picemail" name="picemail" maxlength="200" value="<?php echo $vpicemail; ?>" required>
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
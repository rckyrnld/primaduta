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
                                    <li>Profil Peserta</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">PROFIL PESERTA</p>
                                <?php
                                if(!empty($this->session->sessbuyerprofil)) {
                                    ?>
                                    <div class="alert alert-primary rounded-0" role="alert">
                                        <?php echo $this->session->sessbuyerprofil; ?>
                                    </div>
                                    <?php
                                    $this->session->unset_userdata('sessbuyerprofil');
                                }
                                ?>
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <?php $this->load->view('akun/tpl_buyermenu'); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <form id="frmbuy" name="frmbuy" method="post" action="<?php echo base_url('main/updateprofil'); ?>">
                                                    <input type="hidden" id="idprofil" name="idprofil" value="<?php echo $idprofil; ?>">
                                                    <div class="row mb-2">
                                                        <label for="nmperusahaan" class="col-md-3 mb-2">Nama Perusahaan</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="nmperusahaan" name="nmperusahaan" maxlength="200" value="<?php echo $vnmperusahaan; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="telepon" class="col-md-3 mb-2">Negara</label>
                                                        <div class="col-md-4">
                                                            <select class="form-control" id="idnegara" name="idnegara">
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
                                                        <label for="alamat" class="col-md-3 mb-2">Alamat</label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" id="alamat" name="alamat" maxlength="200" required><?php echo $valamat; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">                                    
                                                        <label for="telepon" class="col-md-3 mb-2">Telepon</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control rounded-0" id="telepon" name="telepon" maxlength="50" value="<?php echo $vtelepon; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">                                    
                                                        <label for="fax" class="col-md-3 mb-2">Fax</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control rounded-0" id="fax" name="fax" maxlength="50" value="<?php echo $vfax; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">                                    
                                                        <label for="email" class="col-md-3 mb-2">Email</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control rounded-0" id="email" name="email" maxlength="200" value="<?php echo $vemail; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">                                    
                                                        <label for="website" class="col-md-3 mb-2">Website</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control rounded-0" id="website" name="website" maxlength="200" value="<?php echo $vwebsite; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">                                    
                                                        <label for="website" class="col-md-3 mb-2">Awal Tahun Impor</label>
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control rounded-0" id="tahunimpor" name="tahunimpor" maxlength="4" value="<?php echo $vtahunimpor; ?>" required>
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
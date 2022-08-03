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
                                    <li>Kisah Keberhasilan</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">KISAH KEBERHASILAN</p>
                                <?php
                                if(!empty($this->session->sessperwakilankisah)) {
                                    ?>
                                    <div class="alert alert-primary rounded-0" role="alert">
                                        <?php echo $this->session->sessperwakilankisah; ?>
                                    </div>
                                    <?php
                                    $this->session->unset_userdata('sessperwakilankisah');
                                }
                                ?>
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <?php $this->load->view('akun/tpl_perwakilanmenu'); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <form id="frmkon" name="frmkon" method="post" action="<?php echo base_url('main/updatekisahperwakilan'); ?>">
                                                    <input type="hidden" id="idprofil" name="idprofil" value="<?php echo $idprofil; ?>">
                                                    <input type="hidden" id="idkisah" name="idkisah" value="<?php echo $idkisah; ?>">
                                                    <div class="row mb-2">
                                                        <label for="textkisah">Ceritakan kisah keberhasilan perwakilan pendukung ekspor</label>
                                                        <div class="col-lg-12 py-2">
                                                            <textarea class="form-control rounded-0" id="editor" name="kisah"><?php echo $vkisah; ?></textarea>
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
    $("#frmkon").validate({
        rules: {
            nmkontak: "required",
            jabatan: "required", 
            email: "email",
            telepon: "number"
        },
        messages: {
            nmperusahaan: "Harap diisi",
            jabatan: "Harap diisi",
            email: "Email harap diisi dengan benar",
            telepon: "Harap diisi dengan angka"
        }
    });
</script>
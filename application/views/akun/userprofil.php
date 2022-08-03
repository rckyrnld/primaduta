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
                                    <li>Profil User</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">PROFIL USER</p>
                                <div class="row">
                                    <div class="col">
                                        <form id="frmprof" name="frmprof" method="post" action="<?php echo base_url('main/updateprofil'); ?>">
                                            <div class="row mb-2">
                                                <label for="nmpejabat" class="col-md-3 mb-2">Nama Pejabat</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control rounded-0" id="nmpejabat" name="nmpejabat" maxlength="200" value="<?php echo $vnama; ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label for="nmkantor" class="col-md-3 mb-2">Nama Kantor Perwakilan</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control rounded-0" id="nmkantor" name="nmkantor" maxlength="200" value="<?php echo $vkantor; ?>" required>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label for="idnegara" class="col-md-3 mb-2">Negara Kantor Perwakilan</label>
                                                <div class="col-md-4">
                                                    <select class="form-control rounded-0" id="idnegara" name="idnegara">
                                                        <option value=""></option>
                                                        <?php
                                                        $d = $neg->result();
                                                        $n = $neg->num_rows();
                                                        if($n > 0) {
                                                            for ($i = 0; $i < count($d); ++$i) {
                                                            ?>
                                                            <option value="<?php echo $d[$i]->idnegara; ?>" <?php if($vidnegara==$d[$i]->idnegara) echo "selected"; ?>><?php echo $d[$i]->negara; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label for="email" class="col-md-3 mb-2">Email</label>
                                                <div class="col-md-4">
                                                    <input type="email" class="form-control rounded-0" id="email" name="email" value="<?php echo $vemail; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group py-2">
                                                <button type="submit" class="btn btn-success form-control rounded-0" name="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Update Data</button>
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
    // validasi form
    $("#frmprof").validate({
        rules: {
            nmpejabat: "required",
            nmkantor: "required",
            idnegara: "required", 
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            nmpejabat: "Harap diisi",
            nmkantor: "Harap diisi",
            idnegara: "Harap dipilih",
            email: {
                required: "Harap diisi",
                email: "Email harap diisi dengan benar"
            }
        }
    });
</script>
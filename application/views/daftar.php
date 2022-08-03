<!-- main content start -->
<section class="container my-5">
    <div class="row">
        <div class="col-lg-7 my-4">
            <div class="alert alert-danger rounded-0 mb-4" role="alert">
              Pendaftaran Akun Primaduta hanya untuk pejabat perwakilan RI di luar negeri
            </div>
            <img src="<?php echo base_url('assets/images/undraw_publish_post_re_wmql.svg'); ?>" style="width: 80%;" class="img-fluid" />
        </div>
        <div class="col-lg-5">
            <div class="card rounded-0">
                <div class="card-body">
                    <p class="fs-5" style="border-bottom: 1px solid #1F1F1F"><i class="fa-solid fa-right-to-bracket"></i> DAFTAR AKUN PRIMADUTA</p>
                    <form method="post" name="frmlogin" id="frmlog" action="<?php echo base_url('main/simpanperwakilan'); ?>">
                        <div class="form-group py-2">
                            <label for="email" class="mb-2">Nama Lengkap</label>
                            <input type="text" class="form-control rounded-0" id="nama" name="nama" required>
                        </div>
                        <div class="form-group py-2">
                            <label for="email" class="mb-2">Nama Kantor Perwakilan</label>
                            <input type="text" class="form-control rounded-0" id="kantor" name="kantor" required>
                            <label class="form-text">Diisi dengan nama kantor, contoh: KBRI [Nama Kota] / KJRI [Nama Kota] / Atdag [Nama Kota] / ITPC [Nama Kota]</label>
                        </div>
                        <div class="form-group py-2">
                            <label for="email" class="mb-2">Negara Kantor Perwakilan</label>
                            <select class="form-control rounded-0" id="idnegara" name="idnegara">
                                <option value=""></option>
                                <?php
                                $d = $neg->result();
                                $n = $neg->num_rows();
                                if($n > 0) {
                                    for ($i = 0; $i < count($d); ++$i) {
                                    ?>
                                    <option value="<?php echo $d[$i]->idnegara; ?>"><?php echo $d[$i]->negara; ?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group py-2">
                            <label for="email" class="mb-2">Email</label>
                            <input type="email" class="form-control rounded-0" id="email" name="email" required>
                        </div>
                        <div class="form-group py-2">
                            <label for="password" class="mb-2">Password</label>
                            <div class="input-icons" id="show_hide_password">
                                <i class="fas fa-eye icon" id="show_eye" onclick="password_show_hide()" title="Tampilkan password"></i>
                                <i class="fas fa-eye-slash icon d-none" id="hide_eye" onclick="password_show_hide()" title="Sembunyikan password"></i>
                                <input type="password" class="form-control rounded-0" id="password" name="password" required>
                                <label class="form-text">Password minimal 8 karakters</label>
                            </div>
                        </div>
                        <div class="form-group py-2">
                            <button type="submit" class="btn btn-success form-control rounded-0" name="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Daftar</button>
                        </div>
                        <hr>
                        <p class="text-center" style="font-size: 14px;">Sudah punya akun?
                        <a href="<?php echo base_url('main'); ?>" style="text-decoration: none">Login disini</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- main content end -->

<script>
    function password_show_hide() {
        var x = document.getElementById("password");
        var show_eye = document.getElementById("show_eye");
        var hide_eye = document.getElementById("hide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }

    // validasi form
    $("#frmlog").validate({
        rules: {
            nama: "required",
            kantor: "required",
            idnegara: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            }
        },
        messages: {
            nama: "Nama lengkap harap diisi",
            kantor: "Nama kantor perwakilan harap diisi",
            idnegara: "Negara kantor perwakilan harap dipilih",
            email: {
                required: "Email harap diisi",
                email: "Email harap diisi dengan benar"
            },
            password: {
                required: "Password harap diisi",
                minlength: "Password minimal 8 karakter"
            }
        }
    });
</script>
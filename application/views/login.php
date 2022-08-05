<!-- main content start -->
<section class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <!--<img src="<?php echo base_url('assets/images/undraw_login_re_4vu2.svg'); ?>" style="width: 80%;" class="img-fluid" />-->
	    <div class="card rounded-0">
                <div class="card-header">PENGUMUMAN</div>
                <div class="card-body">
                    <p style="font-size: 20px;" class="text-center"><b><span style="color: red;">PENGUMUMAN</span></b></p> 
		    <p style="font-size: 20px;" class="text-center mb-5"><b>Perpanjangan Pendaftaran Primaduta 2022</b></p>
                    <p style="font-size: 18px;" class="text-center">Pendaftaran Penghargaan Primaduta 2022 <b>diperpanjang</b> sampai <b>5 Agustus 2022</b></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card rounded-0">
                <div class="card-body">
                    <p class="fs-5" style="border-bottom: 1px solid #1F1F1F"><i class="fa-solid fa-right-to-bracket"></i> LOGIN PRIMADUTA</p>
                    <form method="post" name="frmlogin" id="frmlog" action="<?php echo base_url('main/ceklogin'); ?>">
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
                            </div>
                            <!--<p class="text-end"><a href="#" style="text-decoration: none; ">Lupa Password</a></p>-->
                        </div>
                        <div class="form-group py-2">
                            <button type="submit" class="btn btn-primary form-control rounded-0" name="submit" id="submit"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
                        </div>
                        <hr>
                        <p class="text-center" style="font-size: 14px;">Belum punya akun?</p>
                        <a class="btn btn-success form-control rounded-0" href="<?php echo base_url('main/daftar'); ?>"s>Buat Akun</a>
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
            email: "required",
            password: "required"
        },
        messages: {
            email: "Email harap diisi",
            password: "Password harap diisi"
        }
    });
</script>
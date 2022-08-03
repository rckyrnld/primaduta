<!-- main content start -->
<section class="container my-5">
    <div class="row">
        <div class="col-lg-7 my-4">
            <img src="<?php echo base_url('assets/images/undraw_login_re_4vu2.svg'); ?>" style="width: 80%;" class="img-fluid" />
        </div>
        <div class="col-lg-5">
            <div class="card rounded-0">
                <div class="card-body">
                    <p class="fs-5" style="border-bottom: 1px solid #1F1F1F"><i class="fa-solid fa-user"></i> AKUN PRIMADUTA</p>
                    <p>Hi, <b><?php echo $this->decrypt_nama; ?></b><br>
                    Silahkan menuju halaman Pendaftaran Primaduta</p>
                    <a href="<?php echo base_url('main/dashboard'); ?>" class="btn btn-success rounded-0">PENDAFTARAN PRIMADUTA</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- main content end -->
<!-- main content start -->
<section class="container my-2">
    <div class="row">
        <div class="col-lg-12 my-4">
            <div class="card">
                <div class="card-body">
                    <p class="fs-5" style="border-bottom: 1px solid #1F1F1F"><i class="fa-solid fa-pen-to-square"></i> VERIFIKASI AKUN</p>
                    <p>Harap periksa email untuk memverifikasi akun Anda. Kami telah mengirimkan link verifikasi ke email <b><?php echo $this->session->sessemaildaftar; ?></b></p>
                </div>
            </div>
            <div class="my-4">
                <img src="<?php echo base_url('assets/images/undraw_mail_sent_re_0ofv-300.png'); ?>" class="mx-auto d-block  img-fluid" />
            </div>
        </div>
    </div>
</section>
<!-- main content end -->
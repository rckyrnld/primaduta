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
                                    <li><a href="<?php echo base_url('main/buyer'); ?>">Daftar Buyer</a></li>
                                    <li>Informasi Kontak</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">INFORMASI KONTAK</p>
                                <?php
                                if(!empty($this->session->sessbuyerkontak)) {
                                    ?>
                                    <div class="alert alert-primary rounded-0" role="alert">
                                        <?php echo $this->session->sessbuyerkontak; ?>
                                    </div>
                                    <?php
                                    $this->session->unset_userdata('sessbuyerkontak');
                                }
                                ?>
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <?php $this->load->view('akun/tpl_buyermenu'); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <form id="frmkon" name="frmkon" method="post" action="<?php echo base_url('main/updatekontak'); ?>">
                                                    <input type="hidden" id="idprofil" name="idprofil" value="<?php echo $idprofil; ?>">
                                                    <input type="hidden" id="idkontak" name="idkontak" value="<?php echo $idkontak; ?>">
                                                    <div class="row mb-2">
                                                        <label for="nmkontak" class="col-md-3 mb-2">Nama</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control rounded-0" id="nmkontak" name="nmkontak" maxlength="200" value="<?php echo $vnmkontak; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="jabatan" class="col-md-3 mb-2">Jabatan</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control rounded-0" id="jabatan" name="jabatan" maxlength="200" value="<?php echo $vjabatan; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="email" class="col-md-3 mb-2">Email</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control rounded-0" id="email" name="email" maxlength="200" value="<?php echo $vemail; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="telepon" class="col-md-3 mb-2">Telepon</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control rounded-0" id="telepon" name="telepon" maxlength="200" value="<?php echo $vtelepon; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group py-2">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <button type="submit" class="btn btn-success form-control rounded-0" name="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Submit</button>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a class="btn btn-warning form-control rounded-0" href="<?php echo base_url('main/kontakbuyer/'.$this->secure->encrypt_url($idprofil)); ?>"><i class="fa-solid fa-rotate"></i> Reset</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="table-responsive py-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Nama</th>
                                                            <th scope="col">Jabatan</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Telepon</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $d = $kon->result();
                                                        $n = $kon->num_rows();
                                                        if($n > 0) {
                                                            for ($i = 0; $i < count($d); ++$i) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i+1; ?></td>
                                                                    <td><?php echo $d[$i]->nmkontak; ?></td>
                                                                    <td><?php echo $d[$i]->jabatan; ?></td>
                                                                    <td><?php echo $d[$i]->email; ?></td>
                                                                    <td><?php echo $d[$i]->telepon; ?></td>
                                                                    <td class="text-end">
                                                                        <a href="<?php echo base_url('main/kontakbuyer/'.$this->secure->encrypt_url($d[$i]->idprofil).'/'.$this->secure->encrypt_url($d[$i]->idkontak)); ?>" class="text-success">Edit</a> |
                                                                        <a href="" class="text-danger" data-bs-toggle="modal" data-bs-target="#modalhapus<?php echo $i; ?>">Hapus</a>
                                                                    </td>
                                                                </tr>
                                                                <!-- modal hapus start -->
                                                                <div class="modal fade rounded-0" tabindex="-1" id="modalhapus<?php echo $i; ?>" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
                                                                    <div class = "modal-dialog">
                                                                      <div class = "modal-content">
                                                                        <form role="form" method="post" action="<?=base_url()?>main/hapuskontakbuyer">
                                                                            <input type="hidden" name="idprofil" id="idprofil" value="<?=$d[$i]->idprofil; ?>" />
                                                                            <input type="hidden" name="idkontak" id="idkontak" value="<?=$d[$i]->idkontak; ?>" />
                                                                              <div class = "modal-header">
                                                                                <p class = "modal-title" id = "modallabel"><i class="fa fa-trash"></i> HAPUS DATA</p>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                                                              </div>
                                                                              <div class = "modal-body">
                                                                                 <p>YAKIN DATA AKAN <span class="text-danger">DIHAPUS</span> ?</p>
                                                                              </div>
                                                                              <div class = "modal-footer">
                                                                                 <button type = "submit" class = "btn btn-success"><i class="fa fa-check"></i> Ya</button>
                                                                                 <button type = "button" class = "btn btn-danger" data-dismiss = "modal" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
                                                                              </div>
                                                                            </form>   
                                                                        </div><!-- /.modal-content -->
                                                                    </div><!-- /.modal-dialog -->   
                                                                </div><!-- modal hapus end -->
                                                                <?php
                                                            }
                                                        }
                                                        else { 
                                                            ?>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
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
            email: "email"
        },
        messages: {
            nmperusahaan: "Harap diisi",
            jabatan: "Harap diisi",
            email: "Email harap diisi dengan benar"
        }
    });
</script>
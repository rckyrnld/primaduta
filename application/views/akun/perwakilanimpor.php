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
                                    <li>Nilai Impor</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">NILAI IMPOR</p>
                                <?php
                                if(!empty($this->session->sessperwakilanimpor)) {
                                    ?>
                                    <div class="alert alert-primary rounded-0" role="alert">
                                        <?php echo $this->session->sessperwakilanimpor; ?>
                                    </div>
                                    <?php
                                    $this->session->unset_userdata('sessperwakilanimpor');
                                }
                                ?>
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <?php $this->load->view('akun/tpl_perwakilanmenu'); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <form id="frmimp" name="frmimp" method="post" action="<?php echo base_url('main/updateimporperwakilan'); ?>">
                                                    <input type="hidden" id="idprofil" name="idprofil" value="<?php echo $idprofil; ?>">
                                                    <input type="hidden" id="idimpor" name="idimpor" value="<?php echo $idimpor; ?>">
                                                    <div class="row mb-2">
                                                        <label for="produk" class="col-md-3 mb-2">Impor 2021 (US$)</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control rounded-0" id="impor2021" name="impor2021" maxlength="20" value="<?php echo $vimpor2021; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="produk" class="col-md-3 mb-2">Impor 2020 (US$)</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control rounded-0" id="impor2020" name="impor2020" maxlength="20" value="<?php echo $vimpor2020; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="produk" class="col-md-3 mb-2">Impor 2019 (US$)</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control rounded-0" id="impor2019" name="impor2019" maxlength="20" value="<?php echo $vimpor2019; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group py-2">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <button type="submit" class="btn btn-success form-control rounded-0" name="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Submit</button>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a class="btn btn-warning form-control rounded-0" href="<?php echo base_url('main/imporperwakilan/'.$this->secure->encrypt_url($idprofil)); ?>"><i class="fa-solid fa-rotate"></i> Reset</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="table-responsive py-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" rowspan="2">#</th>
                                                            <th scope="col" colspan="3" class="text-center">Nilai Impor (US$)</th>
                                                            <th scope="col" rowspan="2"></th>
                                                        </tr>
                                                        <tr>
                                                            <?php
                                                            $dt = date("Y");
                                                            for($i=$dt-3; $i<$dt; $i++) {
                                                                ?>
                                                                <th scope="col" class="text-center"><?php echo $i; ?></th>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $d = $imp->result();
                                                        $n = $imp->num_rows();
                                                        if($n > 0) {
                                                            for ($i = 0; $i < count($d); ++$i) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i+1; ?></td>
                                                                    <td class="text-center"><?php echo number_format($d[$i]->nilai3); ?></td>
                                                                    <td class="text-center"><?php echo number_format($d[$i]->nilai2); ?></td>
                                                                    <td class="text-center"><?php echo number_format($d[$i]->nilai1); ?></td>
                                                                    <td class="text-end">
                                                                        <a href="<?php echo base_url('main/imporperwakilan/'.$this->secure->encrypt_url($d[$i]->idprofil).'/'.$this->secure->encrypt_url($d[$i]->idimpor)); ?>" class="text-success">Edit</a> |
                                                                        <a href="" class="text-danger" data-bs-toggle="modal" data-bs-target="#modalhapus<?php echo $i; ?>">Hapus</a>
                                                                    </td>
                                                                </tr>
                                                                <!-- modal hapus start -->
                                                                <div class="modal fade rounded-0" tabindex="-1" id="modalhapus<?php echo $i; ?>" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
                                                                    <div class = "modal-dialog">
                                                                      <div class = "modal-content">
                                                                        <form role="form" method="post" action="<?=base_url()?>main/hapusimporperwakilan">
                                                                            <input type="hidden" name="idprofil" id="idprofil" value="<?=$d[$i]->idprofil; ?>" />
                                                                            <input type="hidden" name="idimpor" id="idimpor" value="<?=$d[$i]->idimpor; ?>" />
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
                                                                <td colspan="3"></td>
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
    $("#frmimp").validate({
        rules: {
            tahun: "required",
            nilai: {
                required: true,
                number: true
            }
        },
        messages: {
            tahun: "Harap dipilih",
            nilai: {
                required: "Harap diisi",
                number: "Harap diisi dengan angka"
            }
        }
    });
</script>
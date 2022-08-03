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
                                    <li>Perwakilan Pendukung Ekspor</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">PERWAKILAN PENDUKUNG EKSPOR</p>
                                <div class="row">
                                    <div class="col">
                                        <a href="<?php echo base_url('main/tambahperwakilan'); ?>" class="btn btn-success rounded-0">Tambah Data Perwakilan Pendukung Ekspor</a>
                                    </div>
                                </div>
                                <div class="table-responsive py-3">
                                    <p class="form-text pt-2">Klik link <span class="text-success">Edit</span> untuk input/edit data nilai impor, kisah keberhasilan dan dokumen pendukung</p>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Perwakilan</th>
                                                <th scope="col">Jabatan</th>
                                                <th scope="col">Negara</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $d = $profil->result();
                                            $n = $profil->num_rows();
                                            if($n > 0) {
                                                for ($i = 0; $i < count($d); ++$i) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i+1; ?></td>
                                                        <td><?php echo $d[$i]->nama; ?></td>
                                                        <td><?php echo $d[$i]->jabatan; ?></td>
                                                        <td><?php echo $d[$i]->negara; ?></td>
                                                        <td class="text-end">
                                                            <a href="<?php echo base_url('main/editperwakilan/'.$this->secure->encrypt_url($d[$i]->idprofil)); ?>" class="text-success">Edit</a> |
                                                            <a href="" class="text-danger" data-bs-toggle="modal" data-bs-target="#modalhapus<?php echo $i; ?>">Hapus</a>
                                                        </td>
                                                    </tr>
                                                    <!-- modal hapus start -->
                                                    <div class="modal fade rounded-0" tabindex="-1" id="modalhapus<?php echo $i; ?>" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
                                                        <div class = "modal-dialog">
                                                          <div class = "modal-content">
                                                            <form role="form" method="post" action="<?=base_url()?>main/hapusperwakilan">
                                                                <input type="hidden" name="idprofil" id="idprofil" value="<?=$d[$i]->idprofil; ?>" />
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
</section>
<!-- main content end -->
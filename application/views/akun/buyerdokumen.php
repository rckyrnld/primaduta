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
                                    <li>Dokumen Pendukung</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">DOKUMEN PENDUKUNG</p>
                                <?php
                                if(!empty($this->session->sessbuyerdok)) {
                                    ?>
                                    <div class="alert alert-primary rounded-0" role="alert">
                                        <?php echo $this->session->sessbuyerdok; ?>
                                    </div>
                                    <?php
                                    $this->session->unset_userdata('sessbuyerdok');
                                }
                                ?>
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <?php $this->load->view('akun/tpl_buyermenu'); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <form id="frmdok" name="frmdok" method="post" action="<?php echo base_url('main/updatedokumen'); ?>" enctype="multipart/form-data">
                                                    <input type="hidden" id="idprofil" name="idprofil" value="<?php echo $idprofil; ?>">
                                                    <input type="hidden" id="iddok" name="iddok" value="<?php echo $iddok; ?>">
                                                    <input type="hidden" id="status" name="status" value="<?php echo $status; ?>">
                                                    <div class="row mb-2">
                                                        <label for="nmkontak" class="col-md-3 mb-2">Nama Dokumen</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control rounded-0" id="nmfile" name="nmfile" maxlength="200" value="<?php echo $vnmfile; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="nmkontak" class="col-md-3 mb-2">Dokumen</label>
                                                        <div class="col-md-9" id="divup">
                                                            <input type="file" class="form-control rounded-0" id="file" name="file">
                                                            <label class="col-md-9 form-text">Maksimal ukuran file 5 MB dengan tipe file .pdf .doc .docx atau .jpg</label>
                                                            <?php
                                                            if(!empty($vfile)) {
                                                                ?>
                                                                <label class="col-md-9">File Sebelumnya: <br>
                                                                <span><a href="<?php echo base_url('assets/uploads/dokumen/'.$vfile); ?>"><?php echo $vnmfile; ?></a></span>
                                                                </label>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                        $disp = "none";
                                                        $ck = "";
                                                        if(!empty($vlink)) { $disp = "block"; $ck = "checked"; }
                                                        ?>
                                                        <div class="col-md-9 offset-md-3 my-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input rounded-0" type="checkbox" name="link" id="link" value="1" onclick="tampillink()" <?php echo $ck; ?>>
                                                                <label class="form-check-label" for="link">Klik disini apabila file lebih besar dari 5 MB</label>
                                                            </div>
                                                            <div id="divlink" style="display: <?php echo $disp; ?>">
                                                                <label for="linkdownload" class="mb-2 form-text">Isi dengan link download dokumen yang sudah diupload di filehosting (Google Drive/One Drive/Dropbox)</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control rounded-0" id="linkdownload" name="linkdownload" value="<?php echo $vlink; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group py-2">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <button type="submit" class="btn btn-success form-control rounded-0" name="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Submit</button>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a class="btn btn-warning form-control rounded-0" href="<?php echo base_url('main/dokbuyer/'.$this->secure->encrypt_url($idprofil)); ?>"><i class="fa-solid fa-rotate"></i> Reset</a>
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
                                                            <th scope="col">Nama Dokumen</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $d = $dok->result();
                                                        $n = $dok->num_rows();
                                                        if($n > 0) {
                                                            for ($i = 0; $i < count($d); ++$i) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i+1; ?></td>
                                                                    <td><?php echo $d[$i]->nmfile; ?></td>
                                                                    <td class="text-end">
                                                                        <a href="<?php echo base_url('main/dokbuyer/'.$this->secure->encrypt_url($d[$i]->idprofil).'/'.$this->secure->encrypt_url($d[$i]->iddokumen)); ?>" class="text-success">Edit</a> |
                                                                        <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#modalhapus<?php echo $i; ?>">Hapus</a>
                                                                    </td>
                                                                </tr>
                                                                <!-- modal hapus start -->
                                                                <div class="modal fade rounded-0" tabindex="-1" id="modalhapus<?php echo $i; ?>" role="dialog" aria-labelledby="modallabel" aria-hidden="true">
                                                                    <div class = "modal-dialog">
                                                                      <div class = "modal-content">
                                                                        <form role="form" method="post" action="<?=base_url()?>main/hapusdokbuyer">
                                                                            <input type="hidden" name="idprofil" id="iddok" value="<?=$d[$i]->idprofil; ?>" />
                                                                            <input type="hidden" name="iddok" id="iddok" value="<?=$d[$i]->iddokumen; ?>" />
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
    function tampillink() {
        var xlink = document.getElementById("link");
        var xdv = document.getElementById("divlink");
        //var xdu = document.getElementById("divup");

        if (xlink.checked) {
            xdv.style.display = "block";
            //xdu.style.display = "none";
        } 
        else {
            xdv.style.display = "none";
            //xdu.style.display = "block";
        }

    }
    
    // validasi form
    $("#frmdok").validate({
        rules: {
            nmfile: "required",
            //file: "required",
            //linkdownload: "required"
        },
        messages: {
            nmfile: "Harap diisi",
            //file: "Harap dipilih",
            //linkdownload: "Harap diisi"
        }
    });
</script>
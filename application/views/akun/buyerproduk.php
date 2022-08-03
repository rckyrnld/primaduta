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
                                    <li>Nilai Impor</li>
                                </ul>
                            </div>
                            <div>
                                <p class="py-2" style="font-size: 16px;">PRODUK BUYER</p>
                                <?php
                                if(!empty($this->session->sessbuyerimpor)) {
                                    ?>
                                    <div class="alert alert-primary rounded-0" role="alert">
                                        <?php echo $this->session->sessbuyerimpor; ?>
                                    </div>
                                    <?php
                                    $this->session->unset_userdata('sessbuyerimpor');
                                }
                                ?>
                                <div class="card rounded-0">
                                    <div class="card-header">
                                        <?php $this->load-view('akun/tpl_buyermenu'); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <form id="frmimp" name="frmimp" method="post" action="<?php echo base_url('main/updateimpor'); ?>">
                                                    <input type="hidden" id="idprofil" name="idprofil" value="<?php echo $idprofil; ?>">
                                                    <input type="hidden" id="idimpor" name="idimpor" value="<?php echo $idimpor; ?>">
                                                    <div class="row mb-2">
                                                        <label for="nmperusahaan" class="col-md-3 mb-2">Tahun Impor</label>
                                                        <div class="col-md-2">
                                                            <select class="form-control rounded-0" id="tahun" name="tahun">
                                                                <option value="">Pilih Tahun</option>
                                                                <?php
                                                                $dt = date("Y");
                                                                $dt1 = $dt-1;
                                                                $dt2 = $dt-6; 
                                                                if(!empty($idimpor)) {
                                                                    ?>
                                                                    <option value="<?php echo $vtahun; ?>" selected><?php echo $vtahun; ?></option>
                                                                    <?php
                                                                }
                                                                for ($i = $dt1; $i > $dt2; --$i) {
                                                                    if($this->dutamod->cektahunimpor($idprofil, $i)==FALSE) {
                                                                        ?>
                                                                        <option value="<?php echo $i; ?>" <?php if($vtahun==$i) echo "selected"; ?>><?php echo $i; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label for="telepon" class="col-md-3 mb-2">Nilai Impor (US$)</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control rounded-0" id="nilai" name="nilai" maxlength="20" value="<?php echo $vnilai; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group py-2">
                                                        <button type="submit" class="btn btn-success form-control rounded-0" name="submit" id="submit"><i class="fa-solid fa-pen-to-square"></i> Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="table-responsive py-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Tahun</th>
                                                            <th scope="col">Nilai Impor (US$)</th>
                                                            <th scope="col"></th>
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
                                                                    <td><?php echo $d[$i]->tahun; ?></td>
                                                                    <td><?php echo number_format($d[$i]->nilai); ?></td>
                                                                    <td class="text-end">
                                                                        <a href="<?php echo base_url('main/imporbuyer/'.$this->secure->encrypt_url($d[$i]->idprofil).'/'.$this->secure->encrypt_url($d[$i]->idimpor)); ?>" class="text-success">Edit</a> |
                                                                        <a href="" class="text-danger">Hapus</a>
                                                                    </td>
                                                                </tr>
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
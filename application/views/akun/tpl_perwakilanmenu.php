<ul class="nav nav-tabs card-header-tabs" id="nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="profil") echo "active"; ?>"  href="<?php echo base_url('main/editperwakilan/'.$this->secure->encrypt_url($idprofil)); ?>">PROFIL PERWAKILAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="impor") echo "active"; ?>" href="<?php echo base_url('main/imporperwakilan/'.$this->secure->encrypt_url($idprofil)); ?>">NILAI IMPOR</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="kisah") echo "active"; ?>" href="<?php echo base_url('main/kisahperwakilan/'.$this->secure->encrypt_url($idprofil)); ?>">KISAH KEBERHASILAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="dokumen") echo "active"; ?>" href="<?php echo base_url('main/dokperwakilan/'.$this->secure->encrypt_url($idprofil)); ?>">DOKUMEN PENDUKUNG</a>
    </li>
</ul>
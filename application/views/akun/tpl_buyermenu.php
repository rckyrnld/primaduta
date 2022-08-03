<ul class="nav nav-tabs card-header-tabs" id="nav-tabs">
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="kategori") echo "active"; ?>"  href="<?php echo base_url('main/kategoribuyer/'.$this->secure->encrypt_url($idprofil)); ?>">KATEGORI PRIMADUTA</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="profil") echo "active"; ?>"  href="<?php echo base_url('main/editbuyer/'.$this->secure->encrypt_url($idprofil)); ?>">PROFIL BUYER</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="kontak") echo "active"; ?>" href="<?php echo base_url('main/kontakbuyer/'.$this->secure->encrypt_url($idprofil)); ?>">INFORMASI KONTAK</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="impor") echo "active"; ?>" href="<?php echo base_url('main/imporbuyer/'.$this->secure->encrypt_url($idprofil)); ?>">NILAI IMPOR</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="kisah") echo "active"; ?>" href="<?php echo base_url('main/kisahbuyer/'.$this->secure->encrypt_url($idprofil)); ?>">KISAH KEBERHASILAN</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($this->page=="dokumen") echo "active"; ?>" href="<?php echo base_url('main/dokbuyer/'.$this->secure->encrypt_url($idprofil)); ?>">DOKUMEN PENDUKUNG</a>
    </li>
</ul>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dutamod extends CI_Model {
    
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('secure');
        $this->load->database();
        
        $this->decrypt_profilid = $this->secure->decrypt_url($this->session->sessprofilid);
        $this->decrypt_userid = $this->secure->decrypt_url($this->session->sessuserid);
        $this->decrypt_email = $this->secure->decrypt_url($this->session->sessemail);;
    }
    
    function ceklogin($email, $password) {
        $encrypt_pass = $this->secure->encrypt_url($password);
        $this->db->select('idperwakilan, email, nmpejabat, nmkantor, status');
        $this->db->from('pmd_perwakilan');
        $this->db->where('email', $email);
        $this->db->where('password', $encrypt_pass);
        $q = $this->db->get();
        $n = $q->num_rows();
        if($n>0) {
            $r = $q->row();
            if($r->status==1) {
                $this->session->set_userdata('sessemail', $this->secure->encrypt_url($email));
                $this->session->set_userdata('sessid', $this->secure->encrypt_url($r->idperwakilan));
                $this->session->set_userdata('sessnama', $this->secure->encrypt_url($r->nmpejabat));
                $this->session->set_userdata('sesskantor', $this->secure->encrypt_url($r->nmkantor));
                $this->session->set_userdata('sessstatus', $this->secure->encrypt_url($r->status));

                $this->update_log($email);
                redirect('main/dashboard');
            }
            else {
                redirect('main/belumaktivasi');
            }
        }
        else {
            redirect('main/logingagal');
        }
    }
    
    //ambil data negara
    function ambilnegara() {
        $this->db->select('*');
        $this->db->from('pma_mst_negara');
        $q = $this->db->get();

        return $q;
    }
    
    //simpan data pendaftaran akun perwakilan
    function simpanperwakilan($data) {
        $data1 = array(
            'nmpejabat' => $data['nama'],
            'nmkantor' => $data['kantor'],
            'idnegara' => $data['idnegara'],
            'email' => $data['email'],
            'password' => $this->secure->encrypt_url($data['password']),
            'status' => '1',
            'tgldaftar' => date("Y-m-d H:i:s")
        );
        
        $this->db->insert('pmd_perwakilan', $data1);
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessemaildaftar', $data['email']);
            
            $iduser = $this->db->insert_id();
            $encrypt_id  = $this->secure->encrypt_url($iduser);
            
            //kirim email verifikasi
            /*$from = "djpen.prima@gmail.com";
            $nmfrom = "Primaduta ".date("Y");
            $to = $data['email'];
            $subject = "Verifikasi Pendaftaran Akun Primaduta 2022";
            $body = "
            <html>
            <head>
            <style>
            .btn {
                margin: 5px 0px;
                padding: 5px 10px;
                color: #fffff;
                background-color: green;
                text-decoration: none;
            }
            </style>
            </head>
            <body>
            <p>Hi ".$data['nama'].",</p>
            <p>Terima kasih sudah mendaftar akun Pengharagaan Primaduta 2022.<br>
            Silahkan klik tombol dibawah untuk aktivasi akun Anda.</p>
            <p><a class='btn' href='".base_url('aktivasi/'.$encrypt_id)."'>AKTIVASI AKUN</a></p>
            </body>
            </html>";

            //$this->kirimemail($from, $nmfrom, $to, $subject, $body);
            $this->kirimemailnoreply($subject, $body, $to);*/
            
            //redirect('main/daftarsukses');
            redirect('main/registrasisukses');
        }
        else {
            redirect('main/daftargagal');
        }
    }
    
    //ambil data perwakilan
    function ambilperwakilan($email) {
        $this->db->select('*');
        $this->db->from('pmd_perwakilan');
        $this->db->where('email', $email);
        $q = $this->db->get();
        
        return $q;
    }
    
    //ambil data profil buyer
    function ambilbuyerprofil($idprofil, $iduser) {
        $this->db->select('idprofil, nmperusahaan, pmd_profil.idnegara, negara, alamat, telepon, fax, email, website, tahunimpor');
        $this->db->from('pmd_profil');
        $this->db->join('pma_mst_negara', 'pma_mst_negara.idnegara=pmd_profil.idnegara');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        if(!empty($iduser)) {
            $this->db->where('iduser', $iduser);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //simpan data buyer
    function simpanbuyer($data) {
        $data1 = array(
            'nmperusahaan' => $data['nmperusahaan'],
            'idnegara' => $data['idnegara'],
            'alamat' => $data['alamat'],
            'telepon' => $data['telepon'],
            'fax' => $data['fax'],
            'email' => $data['email'],
            'website' => $data['website'],
            'tahunimpor' => $data['tahunimpor'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $this->db->insert('pmd_profil', $data1);
        if($this->db->affected_rows()>0) {
            $id = $this->db->insert_id();
            $encrypt_id = $this->secure->encrypt_url($id);
            
            //input data pilihan kategori primaduta
            $data2 = array(
                'idprofil' => $id,
                'idkategori' => $data['idkategori'],
                'tahun' => date("Y"),
                'iduser' => $this->secure->decrypt_url($this->session->sessid),
                'tglinput' => date("Y-m-d H:i:s"),
                'tgledit' => date("Y-m-d H:i:s")
            );
            
            $this->db->insert('pmd_kategori_pilih', $data2);
            
            $this->session->set_userdata('sessbuyerprofil', 'Data profil peserta berhasil diinput');
            
            redirect('main/editbuyer/'.$encrypt_id);
        }
        else {
            redirect('main/buyer');
        }
        
    }
    
    //update data profil buyer
    function updateprofil($data) {
        $data1 = array(
            'nmperusahaan' => $data['nmperusahaan'],
            'idnegara' => $data['idnegara'],
            'alamat' => $data['alamat'],
            'telepon' => $data['telepon'],
            'fax' => $data['fax'],
            'email' => $data['email'],
            'website' => $data['website'],
            'tahunimpor' => $data['tahunimpor'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $this->db->where('idprofil', $idprofil);
        $this->db->update('pmd_profil', $data1);
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessbuyerprofil', 'Berhasil update data profil peserta');
            
            redirect('main/editbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessbuyerprofil', 'Gagal update data profil peserta');
            
            redirect('main/editbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //hapus data buyer
    function hapusbuyer($idprofil) {
        //hapus profil
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_profil');
        
        //hapus kategori
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_kategori_pilih');
        
        //hapus kontak
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_kontak');
        
        //hapus impor
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_impor');
        
        //hapus kisah keberhasilan
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_kisah');
        
        //hapus dokumen
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_dokumen');
        
        redirect('main/buyer');
    }
    
    //ambil data kontak buyer
    function ambilbuyerkontak($idprofil, $idkontak) {
        $this->db->select('*');
        $this->db->from('pmd_kontak');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        if(!empty($idkontak)) {
            $this->db->where('idkontak', $idkontak);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //update kontak buyer
    function updatekontak($data) {
        $data1 = array(
            'idprofil' => $data['idprofil'],
            'nmkontak' => $data['nmkontak'],
            'jabatan' => $data['jabatan'],
            'email' => $data['email'],
            'telepon' => $data['telepon'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $data2 = array(
            'idprofil' => $data['idprofil'],
            'nmkontak' => $data['nmkontak'],
            'jabatan' => $data['jabatan'],
            'email' => $data['email'],
            'telepon' => $data['telepon'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tgledit' => date("Y-m-d H:i:s")
        );
            
        if(!empty($data['idkontak'])) {
            $this->db->where('idkontak', $data['idkontak']);
            $this->db->update('pmd_kontak', $data2);
        }
        else {
            $this->db->insert('pmd_kontak', $data1);
        }
        
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessbuyerkontak', 'Berhasil update informasi kontak buyer');
            
            redirect('main/kontakbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessbuyerkontak', 'Gagal update data informasi kontak buyer');
            
            redirect('main/kontakbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //hapus data kontak buyer
    function hapuskontakbuyer($idprofil, $idkontak) {
        $this->db->where('idkontak', $idkontak);
        $this->db->delete('pmd_kontak');
        
        redirect('main/kontakbuyer/'.$this->secure->encrypt_url($idprofil));
        
        
    }
    
    //cek data tahun impor buyer
    function cektahunimpor($idprofil, $tahun) {
        $this->db->select('tahun');
        $this->db->from('pmd_impor');
        $this->db->where('idprofil', $idprofil);
        $this->db->where('tahun', $tahun);
        $q = $this->db->get();
        $nq = $q->num_rows();
        if($nq>0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //ambil data nilai impor buyer
    function ambilbuyerimpor($idprofil, $idimpor) {
        $this->db->select('*');
        $this->db->from('pmd_impor');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        if(!empty($idimpor)) {
            $this->db->where('idimpor', $idimpor);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //ambil data nilai impor berdasarkan tahun
    function ambilimportahun($idprofil, $idproduk, $tahun) {
        $this->db->select('nilai');
        $this->db->from('pmd_impor');
        $this->db->where('idprofil', $idprofil);
        $this->db->where('idproduk', $idproduk);
        $this->db->where('tahun', $tahun);
        $q = $this->db->get();

        return $q;
    }
    
    //update nilai impor buyer
    function updateimpor($data) {
        $nilai1 = 0; $nilai2 = 0; $nilai3 = 0; $nilai4 = 0; $nilai5 = 0;
        if(!empty($data['impor2021'])) { $nilai1 = $data['impor2021']; }
        if(!empty($data['impor2020'])) { $nilai2 = $data['impor2020']; }
        if(!empty($data['impor2019'])) { $nilai3 = $data['impor2019']; }
        if(!empty($data['impor2018'])) { $nilai4 = $data['impor2018']; }
        if(!empty($data['impor2017'])) { $nilai5 = $data['impor2017']; }
        $data1 = array(
            'idprofil' => $data['idprofil'],
            'produk' => $data['produk'],
            'hscode' => $data['hscode'],
            'nilai1' => $nilai1,
            'nilai2' => $nilai2,
            'nilai3' => $nilai3,
            'nilai4' => $nilai4,
            'nilai5' => $nilai5,
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $data2 = array(
            'idprofil' => $data['idprofil'],
            'produk' => $data['produk'],
            'hscode' => $data['hscode'],
            'nilai1' => $nilai1,
            'nilai2' => $nilai2,
            'nilai3' => $nilai3,
            'nilai4' => $nilai4,
            'nilai5' => $nilai5,
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tgledit' => date("Y-m-d H:i:s")
        );
            
        if(!empty($data['idimpor'])) {
            //echo $data['idimpor']." ".$data['idprofil']." ".$data['tahun']." ".$data['nilai']." ".$this->secure->decrypt_url($this->session->sessid);
            //exit;
            $this->db->where('idimpor', $data['idimpor']);
            $this->db->update('pmd_impor', $data2);
        }
        else {
            $this->db->insert('pmd_impor', $data1);
        }
        
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessbuyerimpor', 'Berhasil update data nilai impor');
            
            redirect('main/imporbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessbuyerimpor', 'Gagal update data nilai impor');
            
            redirect('main/imporbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //hapus data impor buyer
    function hapusimporbuyer($idprofil, $idimpor) {
        $this->db->where('idimpor', $idimpor);
        $this->db->delete('pmd_impor');
        
        redirect('main/imporbuyer/'.$this->secure->encrypt_url($idprofil));
        
        
    }
    
    //ambil data kisah buyer
    function ambilbuyerkisah($idprofil) {
        $this->db->select('*');
        $this->db->from('pmd_kisah');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //update kisah buyer
    function updatekisah($data) {
        $data1 = array(
            'idprofil' => $data['idprofil'],
            'kisah' => $data['kisah'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $data2 = array(
            'idprofil' => $data['idprofil'],
            'kisah' => $data['kisah'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        //echo $data['idprofil']; exit;
            
        if(!empty($data['idkisah'])) {
            $this->db->where('idkisah', $data['idkisah']);
            $this->db->update('pmd_kisah', $data2);
        }
        else {
            $this->db->insert('pmd_kisah', $data1);
        }
        
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessbuyerkisah', 'Berhasil update data kisah keberhasilan');
            
            redirect('main/kisahbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessbuyerkisah', 'Gagal update data kisah keberhasilan');
            
            redirect('main/kisahbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //ambil data dokumen pendukung buyer
    function ambilbuyerdok($idprofil, $iddok) {
        $this->db->select('*');
        $this->db->from('pmd_dokumen');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        if(!empty($iddok)) {
            $this->db->where('iddokumen', $iddok);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //update dokumen pendukung buyer
    function updatedok($data) {
        if(!empty($data['file'])) {
            $filename = $data['idprofil']."-".str_replace(" ", "_", $data['file']);
        }
        else {
            $filename = "";
        }
    
        $data1 = array(
            'idprofil' => $data['idprofil'],
            'nmfile' => $data['nmfile'],
            'file' => $filename,
            'linkdownload' => $data['linkdownload'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        if(empty($data['file'])) {
            $data2 = array(
                'idprofil' => $data['idprofil'],
                'nmfile' => $data['nmfile'],
                'linkdownload' => $data['linkdownload'],
                'iduser' => $this->secure->decrypt_url($this->session->sessid),
                'tgledit' => date("Y-m-d H:i:s")
            );
        }
        else {
            $data2 = array(
                'idprofil' => $data['idprofil'],
                'nmfile' => $data['nmfile'],
                'file' => $filename,
                'linkdownload' => $data['linkdownload'],
                'iduser' => $this->secure->decrypt_url($this->session->sessid),
                'tgledit' => date("Y-m-d H:i:s")
            );
        }
        
            
        if(!empty($data['iddok'])) {
            $this->db->where('iddokumen', $data['iddok']);
            $this->db->update('pmd_dokumen', $data2);
        }
        else {
            $this->db->insert('pmd_dokumen', $data1);
        }
        
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessbuyerdok', 'Berhasil update data dokumen pendukung');
            
            redirect('main/dokbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessbuyerdok', 'Gagal update data dokumen pendukung');
            
            redirect('main/dokbuyer/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //hapus dokumen pendukung buyer
    function hapusdokbuyer($idprofil, $iddok) {
        $nmfile = $this->ambilbuyerdok($idprofil, $iddok)->row()->nmfile;
        if(!empty($nmfile)) {
            unlink('../assets/uploads/dokumen/'.$nmfile);
        }
        
        $this->db->where('iddokumen', $iddok);
        $this->db->delete('pmd_dokumen');
        
        redirect('main/dokbuyer/'.$this->secure->encrypt_url($idprofil));
    }
    
    //fungsi ambil data kategori primaduta
    function ambilkategori($ex) {
        $this->db->select('*');
        $this->db->from('pmd_kategori');
        if(!empty($ex)) {
            $this->db->where('idkategori!=', '8');
        }
        $this->db->order_by('idkategori');
        $q = $this->db->get();
        
        return $q;
    }
    
    //fungsi ambil data kategori perwakilan pendukung ekspor
    function ambilkategoriperwakilan() {
        $this->db->select('*');
        $this->db->from('pmd_kategori');
        $this->db->where('idkategori', '8');
        $q = $this->db->get();
        
        return $q;
    }
    
    //fungsi ambil data kriteria impor
    function kriteriaimpor($idprofil) {
        $this->db->select('kriteria');
        $this->db->from('pmd_impor_kriteria');
        $this->db->join('pmd_kategori_pilih', 'pmd_kategori_pilih.idkategori=pmd_impor_kriteria.idkategori');
        $this->db->where('idprofil', $idprofil);
        $q = $this->db->get();
        
        return $q;
    }
    
    //fungsi ambil data kategori primaduta yang dipilih
    function ambilkategoripilih($idprofil) {
        $this->db->select('pmd_kategori.idkategori, nmkategori, keterangan, kriteria');
        $this->db->from('pmd_kategori');
        $this->db->join('pmd_kategori_pilih', 'pmd_kategori_pilih.idkategori=pmd_kategori.idkategori');
        $this->db->where('idprofil', $idprofil);
        $q = $this->db->get();
        
        return $q;
    }
    
    //ambil data keterangan kategori primaniduta
    function ambilketerangan($idkategori) {
        $this->db->select('keterangan, kriteria');
        $this->db->from('pmd_kategori');
        $this->db->where('idkategori', $idkategori);
        $q = $this->db->get()->row();

        $text ="
        <div class='card rounded-0'>
          <div class='card-body'>
            <p class='text-start pt-2'><b>Penjelasan Kategori</b></p>
            <p class='text-start'>".$q->keterangan."</p>
            <p class='text-start pt-2'><b>Kriteria</b></p>
            <p class='text-start'>".$q->kriteria."</p>
          </div>
        </div>
        ";

        echo json_encode($text);
    }
    
    //ambil data profil perwakilan
    function ambilperwakilanprofil($idprofil, $iduser) {
        $this->db->select('idprofil, nama, jabatan, pmd_perwakilan_profil.idnegara, negara, masa1, masa2, pic, picphone, picemail');
        $this->db->from('pmd_perwakilan_profil');
        $this->db->join('pma_mst_negara', 'pma_mst_negara.idnegara=pmd_perwakilan_profil.idnegara');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        if(!empty($iduser)) {
            $this->db->where('iduser', $iduser);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //simpan data perwakilan pendukung ekspor
    function simpanperwakilanprofil($data) {
        $data1 = array(
            'nama' => $data['nama'],
            'jabatan' => $data['jabatan'],
            'idnegara' => $data['idnegara'],
            'masa1' => $this->ubahtanggal("/",$data['masa1']),
            'masa2' => $this->ubahtanggal("/",$data['masa2']),
            'pic' => $data['pic'],
            'picphone' => $data['picphone'],
            'picemail' => $data['picemail'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $this->db->insert('pmd_perwakilan_profil', $data1);
        if($this->db->affected_rows()>0) {
            $id = $this->db->insert_id();
            $encrypt_id = $this->secure->encrypt_url($id);
            
            $this->session->set_userdata('sessbuyerprofil', 'Data profil perwakilan berhasil diinput');
            
            redirect('main/editperwakilan/'.$encrypt_id);
        }
        else {
            redirect('main/perwakilan');
        }
        
    }
    
    //update data profil pendukung ekspor
    function updateperwakilanprofil($data) {
        $data1 = array(
            'nama' => $data['nama'],
            'jabatan' => $data['jabatan'],
            'idnegara' => $data['idnegara'],
            'masa1' => $this->ubahtanggal("/",$data['masa1']),
            'masa2' => $this->ubahtanggal("/",$data['masa2']),
            'pic' => $data['pic'],
            'picphone' => $data['picphone'],
            'picemail' => $data['picemail'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $this->db->where('idprofil', $data['idprofil']);
        $this->db->update('pmd_perwakilan_profil', $data1);
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessperwakilanprofil', 'Berhasil update data profil perwakilan');
            
            redirect('main/editperwakilan/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessperwakilanprofil', 'Gagal update data profil perwakilan');
            
            redirect('main/editperwakilan/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //hapus data perwakilan pendukung ekspor
    function hapusperwakilan($idprofil) {
        //hapus profil
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_perwakilan_profil');
        
        //hapus kontak
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_perwakilan_kontak');
        
        //hapus impor
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_perwakilan_impor');
        
        //hapus kisah keberhasilan
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_perwakilan_kisah');
        
        //hapus dokumen
        $this->db->where('idprofil', $idprofil);
        $this->db->delete('pmd_perwakilan_dokumen');
        
        redirect('main/perwakilan');
    }
    
    //ambil data nilai impor perwakilan pendukung ekspor
    function ambilperwakilanimpor($idprofil, $idimpor) {
        $this->db->select('*');
        $this->db->from('pmd_perwakilan_impor');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        if(!empty($idimpor)) {
            $this->db->where('idimpor', $idimpor);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //ambil data nilai impor berdasarkan tahun
    function ambilperwakilanimportahun($idprofil, $idproduk, $tahun) {
        $this->db->select('nilai');
        $this->db->from('pmd_perwakilan_impor');
        $this->db->where('idprofil', $idprofil);
        $this->db->where('idproduk', $idproduk);
        $this->db->where('tahun', $tahun);
        $q = $this->db->get();

        return $q;
    }
    
    //update nilai impor perwakilan pendukung ekspor
    function updateimporperwakilan($data) {
        $nilai1 = 0; $nilai2 = 0; $nilai3 = 0;
        if(!empty($data['impor2021'])) { $nilai1 = $data['impor2021']; }
        if(!empty($data['impor2020'])) { $nilai2 = $data['impor2020']; }
        if(!empty($data['impor2019'])) { $nilai3 = $data['impor2019']; }
        $data1 = array(
            'idprofil' => $data['idprofil'],
            'nilai1' => $nilai1,
            'nilai2' => $nilai2,
            'nilai3' => $nilai3,
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $data2 = array(
            'idprofil' => $data['idprofil'],
            'nilai1' => $nilai1,
            'nilai2' => $nilai2,
            'nilai3' => $nilai3,
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tgledit' => date("Y-m-d H:i:s")
        );
            
        if(!empty($data['idimpor'])) {
            //echo $data['idimpor']." ".$data['idprofil']." ".$data['tahun']." ".$data['nilai']." ".$this->secure->decrypt_url($this->session->sessid);
            //exit;
            $this->db->where('idimpor', $data['idimpor']);
            $this->db->update('pmd_perwakilan_impor', $data2);
        }
        else {
            $this->db->insert('pmd_perwakilan_impor', $data1);
        }
        
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessperwakilanimpor', 'Berhasil update data nilai impor');
            
            redirect('main/imporperwakilan/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessperwakilanimpor', 'Gagal update data nilai impor');
            
            redirect('main/imporperwakilan/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //hapus data impor perwakilan pendukung ekspor
    function hapusimporperwakilan($idprofil, $idimpor) {
        $this->db->where('idimpor', $idimpor);
        $this->db->delete('pmd_perwakilan_impor');
        
        redirect('main/imporperwakilan/'.$this->secure->encrypt_url($idprofil));
        
        
    }
    
    //ambil data kisah perwakilan pendukung ekspor
    function ambilperwakilankisah($idprofil) {
        $this->db->select('*');
        $this->db->from('pmd_perwakilan_kisah');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //update kisah perwakilan pendukung ekspor
    function updatekisahperwakilan($data) {
        $data1 = array(
            'idprofil' => $data['idprofil'],
            'kisah' => $data['kisah'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        $data2 = array(
            'idprofil' => $data['idprofil'],
            'kisah' => $data['kisah'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        //echo $data['idprofil']; exit;
            
        if(!empty($data['idkisah'])) {
            $this->db->where('idkisah', $data['idkisah']);
            $this->db->update('pmd_perwakilan_kisah', $data2);
        }
        else {
            $this->db->insert('pmd_perwakilan_kisah', $data1);
        }
        
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessperwakilankisah', 'Berhasil update data kisah keberhasilan');
            
            redirect('main/kisahperwakilan/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessperwakilanrkisah', 'Gagal update data kisah keberhasilan');
            
            redirect('main/kisahperwakilan/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //ambil data dokumen pendukung perwakilan pendukung ekspos
    function ambilperwakilandok($idprofil, $iddok) {
        $this->db->select('*');
        $this->db->from('pmd_perwakilan_dokumen');
        if(!empty($idprofil)) {
            $this->db->where('idprofil', $idprofil);
        }
        if(!empty($iddok)) {
            $this->db->where('iddokumen', $iddok);
        }
        $q = $this->db->get();
        
        return $q;
    }
    
    //update dokumen pendukung perwakilan pendukung ekspor
    function updatedokperwakilan($data) {
        if(!empty($data['file'])) {
            $filename = $data['idprofil']."-".str_replace(" ", "_", $data['file']);
        }
        else {
            $filename = "";
        }
    
        $data1 = array(
            'idprofil' => $data['idprofil'],
            'nmfile' => $data['nmfile'],
            'file' => $filename,
            'linkdownload' => $data['linkdownload'],
            'iduser' => $this->secure->decrypt_url($this->session->sessid),
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s")
        );
        
        if(empty($data['file'])) {
            $data2 = array(
                'idprofil' => $data['idprofil'],
                'nmfile' => $data['nmfile'],
                'linkdownload' => $data['linkdownload'],
                'iduser' => $this->secure->decrypt_url($this->session->sessid),
                'tgledit' => date("Y-m-d H:i:s")
            );
        }
        else {
            $data2 = array(
                'idprofil' => $data['idprofil'],
                'nmfile' => $data['nmfile'],
                'file' => $filename,
                'linkdownload' => $data['linkdownload'],
                'iduser' => $this->secure->decrypt_url($this->session->sessid),
                'tgledit' => date("Y-m-d H:i:s")
            );
        }
        
            
        if(!empty($data['iddok'])) {
            $this->db->where('iddokumen', $data['iddok']);
            $this->db->update('pmd_perwakilan_dokumen', $data2);
        }
        else {
            $this->db->insert('pmd_perwakilan_dokumen', $data1);
        }
        
        if($this->db->affected_rows()>0) {
            $this->session->set_userdata('sessperwakilandok', 'Berhasil update data dokumen pendukung');
            
            redirect('main/dokperwakilan/'.$this->secure->encrypt_url($data['idprofil']));
        }
        else {
            $this->session->set_userdata('sessperwakilandok', 'Gagal update data dokumen pendukung');
            
            redirect('main/dokperwakilan/'.$this->secure->encrypt_url($data['idprofil']));
        }
    }
    
    //hapus dokumen pendukung buyer
    function hapusdokperwakilan($idprofil, $iddok) {
        $nmfile = $this->ambilbuyerdok($idprofil, $iddok)->row()->nmfile;
        if(!empty($nmfile)) {
            unlink('../assets/uploads/dokumen/'.$nmfile);
        }
        
        $this->db->where('iddokumen', $iddok);
        $this->db->delete('pmd_perwakilan_dokumen');
        
        redirect('main/dokperwakilan/'.$this->secure->encrypt_url($idprofil));
    }
    
    //fungsi kirim email
    function kirimemail($from, $nmfrom, $to, $subject, $body) {
        // Konfigurasi email
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'djpen.prima@gmail.com',  // Email gmail
            'smtp_pass'   => 'psiep2ie',  // Password gmail
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];

        // Load library email dan konfigurasinya
        $this->load->library('email', $config);

        // Email dan nama pengirim
        $this->email->from($from, $nmfrom);

        // Email penerima
        $this->email->to($to); // Ganti dengan email tujuan

        // Lampiran email, isi dengan url/path file
       // $this->email->attach('https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');

        // Subject email
        $this->email->subject($subject);

        // Isi email
        $this->email->message($body);

        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function kirimemailnoreply($subject, $body, $to,$cc=null, $bcc=null) {
	    require 'assets/email/class.phpmailer.php';
	    $mail = new PHPMailer;
	    $mail->SingleTo   = true;
	    $mail->IsSMTP();
	    $mail->Host = '10.30.30.248';
	    $mail->From = 'data.djpen@kemendag.go.id';
	    //    $mail->Username = 'csc@kemendag.go.id';
	    //    $mail->Password = '123456';
	    //    $mail->SMTPSecure = 'tls';

	    $mail->SMTPDebug = 0;
	    // $mail->Host      = 'akmalsqual.com';
	    // $mail->SMTPAuth  = true;
	    // $mail->Username  = 'noreply@akmalsqual.com';
	    // $mail->Password  = '123456';

	    // $mail->Port      = 587;    
	    // $mail->From      = 'noreply@akmalsqual.com';
	    $mail->FromName  = 'DATA P2IE';
	    if(is_array($to)){
	        foreach ($to as $to_value) {
	            $mail->AddAddress($to_value['emailAddress'], $to_value['name']);
	        }
	    }
	    
	    if(is_array($cc)){
	        foreach ($cc as $cc_value) {
	            $mail->AddCC($cc_value['emailAddress'], $cc_value['name']);
	        }
	    }
	    
	    if(is_array($bcc)){
	        foreach ($bcc as $bcc_value) {
	            $mail->AddBCC($bcc_value['emailAddress'], $bcc_value['name']);
	        }
	    }
	    
	//    $mail->AddCC('cc@example.com');
	//    $mail->AddBCC('bcc@example.com');
	    $mail->IsHTML(true);
	    $mail->Subject = $subject;
	    $mail->Body = $body;
	    $mail->Send();
	    $mail->clearAllRecipients();
	    $mail->clearAttachments();
	}
    
    //ambil negara akreditasi user
    function neguser($idperwakilan) {
        $this->db->select('idnegara');
        $this->db->from('pmd_perwakilan');
        $this->db->where('idperwakilan', $idperwakilan);
        $q = $this->db->get()->row()->idnegara;
        
        return $q;
    }
    
    //ubah format tanggal
    function ubahtanggal($format, $tanggal) {
        if($format=="-") {
            $x = explode("-", $tanggal);
            $nx = $x[2]."/".$x[1]."/".$x[0];
        }
        if($format=="/") {
            $x = explode("/", $tanggal);
            $nx = $x[2]."-".$x[1]."-".$x[0];
        }

        return $nx;
    }

    //aktivasi akuns
    function aktivasiakun($idperwakilan) {
        $this->db->set('status', '1');
        $this->db->where('idperwakilan', $idperwakilan);
        $this->db->update('pmd_perwakilan');

        if($this->db->affected_rows()>0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //update log login
    function update_log($email) {
        $this->db->set('loginterakhir', date("Y-m-d H:i:s"));
        $this->db->where('email', $email);
        $this->db->update('pmd_perwakilan'); 
    }
}
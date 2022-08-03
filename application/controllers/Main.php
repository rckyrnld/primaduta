<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('dutamod');
        
        $this->nama = ""; $this->page = "";
        $this->decrypt_id = $this->secure->decrypt_url($this->session->sessid);
        $this->decrypt_email = $this->secure->decrypt_url($this->session->sessemail);
        $this->decrypt_nama = $this->secure->decrypt_url($this->session->sessnama);
        $this->decrypt_kantor = $this->secure->decrypt_url($this->session->sesskantor);

        //ambil data user
        if($this->decrypt_email!="") {
            $u = $this->dutamod->ambilperwakilan($this->decrypt_email)->row();
            $this->nama = $u->nmpejabat;
        }
    }
    
    function index() {
        //title
        $data['title'] = "Primaduta ".date("Y");
        
        //menu aktif
        $data['menu'] = "home";
        
        //view
        $this->load->view('tpl_header', $data);
        if(empty($this->decrypt_id)) {
            $this->load->view('login', $data);    
        }
        else {
            $this->load->view('loginsudah', $data);
        }
        $this->load->view('tpl_footer', $data);
    }
    
    function daftar() {
        //title
        $data['title'] = "Buat Akun Primaduta ".date("Y");
        
        //menu aktif
        $data['menu'] = "daftar";
        
        //ambil data negara
        $data['neg'] = $this->dutamod->ambilnegara();
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('daftar', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    function simpanperwakilan() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->simpanperwakilan($data);
    }
    
    function daftarsukses() {
        //title
        $data['title'] = "Pendaftaran Akun Primaduta Sukses";
        
        //menu aktif
        $data['menu'] = "daftar";
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('daftarsukses', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    function registrasisukses() {
        //title
        $data['title'] = "Pendaftaran Akun Primaduta Sukses";
        
        //menu aktif
        $data['menu'] = "daftar";
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('registrasisukses', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    function daftargagal() {
        //title
        $data['title'] = "Pendaftaran Akun Primaduta Gagal";
        
        //menu aktif
        $data['menu'] = "daftar";
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('daftargagal', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    //halaman aktivasi akun
    function aktivasi() {
        $idperwakilan = $this->uri->segment(2);
        $decrypt_id = $this->secure->decrypt_url($idperwakilan);
        $a = $this->dutamod->aktivasiakun($decrypt_id);

        $this->session->unset_userdata('sessemaidaftar');

        if($a==TRUE) {
            //redirect ke halaman aktivasi sukses
            redirect('main/aktivasisukses');
        }
        else {
            //redirect ke halaman aktivasi sukses
            redirect('main/aktivasigagal');
        }
        
    }
    
    //halaman aktivasi sukses
    function aktivasisukses() {
        //title
        $data['title'] = "Aktivasi Akun Primaduta Sukses";
        
        //menu aktif
        $data['menu'] = "daftar";
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('aktivasisukses', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    //halaman aktivasi sukses
    function aktivasigagal() {
        //title
        $data['title'] = "Aktivasi Akun Primaduta Gagal";
        
        //menu aktif
        $data['menu'] = "daftar";
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('aktivasigagal', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    //cek login
    function ceklogin() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->dutamod->ceklogin($email, $password);
    }
    
    //login gagal
    function logingagal() {
        //title
        $data['title'] = "Login Gagal";
        
        //menu aktif
        $data['menu'] = "login";
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('logingagal', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    //halaman dashboard
    function dashboard() {
        //title
        $data['title'] = "Dashboard | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/dashboard', $data);
    }
    
    //halaman daftar buyer
    function buyer() {
        //title
        $data['title'] = "Input Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //ambil data profil buyer
        $data['profil'] = $this->dutamod->ambilbuyerprofil("", $this->decrypt_id);
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyer', $data);
    }
    
    //ambil data keterangan kategori primaduta
    function ambilketerangan() {
        $idkat = $this->input->post('idkat');
        $ket = $this->dutamod->ambilketerangan($idkat);
    }
    
    //halaman tambahdata buyer
    function tambahbuyer() {
        //title
        $data['title'] = "Tambah Data Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //ambil data negara
        $data['neg'] = $this->dutamod->ambilnegara();
        //ambil data kategori primaduta
        $data['kat'] = $this->dutamod->ambilkategori('1');
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyertambah', $data);
    }
    
    //simpan data buyer
    function simpanbuyer() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->simpanbuyer($data);
    }
    
    //halaman kategori primaduta yang dipilih
    function kategoribuyer() {
        //title
        $data['title'] = "Edit Data Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "kategori";
        
        //ambil data kategori primaduta yang dipilih
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        $p = $this->dutamod->ambilkategoripilih($idprofil)->row();
        
        $data['idprofil'] = $idprofil;
        $data['vidkategori'] = $p->idkategori;
        $data['vnmkategori'] = $p->nmkategori;
        $data['vketerangan'] = $p->keterangan;
        $data['vkriteria'] = $p->kriteria;
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyerkategori', $data);
    }
    
    //halaman edit profil buyer
    function editbuyer() {
        //title
        $data['title'] = "Edit Data Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "profil";
        
        //ambil data negara
        $data['neg'] = $this->dutamod->ambilnegara();
        
        //ambil data profil buyer
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        $p = $this->dutamod->ambilbuyerprofil($idprofil, "")->row();
        
        $data['idprofil'] = $idprofil;
        $data['vnmperusahaan'] = $p->nmperusahaan;
        $data['vidnegara'] = $p->idnegara;
        $data['valamat'] = $p->alamat;
        $data['vtelepon'] = $p->telepon;
        $data['vfax'] = $p->fax;
        $data['vemail'] = $p->email;
        $data['vwebsite'] = $p->website;
        $data['vtahunimpor'] = $p->tahunimpor;
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyerprofil', $data);
    }
    
    //edit data profil buyer
    function updateprofil() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->updateprofil($data);
    }
    
    //hapus data buyer
    function hapusbuyer() {
        $idprofil = $this->input->post('idprofil');
        
        $this->dutamod->hapusbuyer($idprofil);
    }
    
    //data kontak buyer
    function kontakbuyer() {
        //title
        $data['title'] = "Edit Data Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "kontak";
        
        //iduser
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        
        //ambil data kontak untuk ditampilkan ke tabel
        $data['kon'] = $this->dutamod->ambilbuyerkontak($idprofil, "");
        
        //variable boolean
        $bp = FALSE;
        
        //ambil data impor untuk ditampilkan ke form
        $idkontak = $this->secure->decrypt_url($this->uri->segment(4));
        if(!empty($idkontak)) {
            $p = $this->dutamod->ambilbuyerkontak($idprofil, $idkontak)->row();
            $np = $this->dutamod->ambilbuyerkontak($idprofil, $idkontak)->num_rows();
            if($np>0) { $bp = TRUE; }
        }
        
        
        $data['idprofil'] = $idprofil;
        $data['idkontak'] = $idkontak;
        $data['vnmkontak'] = $bp==TRUE ? $p->nmkontak : "";
        $data['vjabatan'] = $bp==TRUE ? $p->jabatan : "";
        $data['vemail'] = $bp==TRUE ? $p->email : "";
        $data['vtelepon'] = $bp==TRUE ? $p->telepon : "";
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyerkontak', $data);
    }
    
    //update data kontak buyer
    function updatekontak() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->updatekontak($data);
    }
    
    //hapus data kontak buyer
    function hapuskontakbuyer() {
        $idprofil = $this->input->post('idprofil');
        $idkontak = $this->input->post('idkontak');
        
        $this->dutamod->hapuskontakbuyer($idprofil, $idkontak);
    }
    
    //data produk buyer
    /*function produkbuyer() {
        //title
        $data['title'] = "Edit Data Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $data['page'] = "produk";
        
        //iduser
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        
        //ambil data produk untuk ditampilkan ke tabel
        $data['prod'] = $this->dutamod->ambilbuyerproduk($idprofil, "");
        
        //variable boolean
        $bp = FALSE;
        
        //ambil data impor untuk ditampilkan ke form
        $idproduk = $this->secure->decrypt_url($this->uri->segment(4));
        if(!empty($idproduk)) {
            $p = $this->dutamod->ambilbuyerproduk($idprofil, $idproduk)->row();
            $np = $this->dutamod->ambilbuyerproduk($idprofil, $idproduk)->num_rows();
            if($np>0) { $bp = TRUE; }
        }
        
        
        $data['idprofil'] = $idprofil;
        $data['idproduk'] = $idproduk;
        $data['vproduk'] = $bp==TRUE ? $p->produk : "";
        $data['vhscode'] = $bp==TRUE ? $p->hscode : "";
        $data['vimpor2017'] = "";
        $data['vimpor2018'] = "";
        $data['vimpor2019'] = "";
        $data['vimpor2020'] = "";
        $data['vimpor2021'] = "";
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyerproduk', $data);
    }*/
    
    //update data produk buyer
    /*function updateproduk() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->updateproduk($data);
    }*/
    
    //data nilai impor buyer
    function imporbuyer() {
        //title
        $data['title'] = "Edit Data Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "impor";
        
        //iduser
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        
        //ambil data impor untuk ditampilkan ke tabel
        $data['imp'] = $this->dutamod->ambilbuyerimpor($idprofil, "");
        
        //variable boolean
        $bp = FALSE;
        
        //ambil data impor untuk ditampilkan ke form
        $idimpor = $this->secure->decrypt_url($this->uri->segment(4));
        if(!empty($idimpor)) {
            $p = $this->dutamod->ambilbuyerimpor($idprofil, $idimpor)->row();
            $np = $this->dutamod->ambilbuyerimpor($idprofil, $idimpor)->num_rows();
            if($np>0) { $bp = TRUE; }
        }
        
        
        /*$data['idprofil'] = $idprofil;
        $data['idimpor'] = $idimpor;
        $data['vtahun'] = $bp==TRUE ? $p->tahun : "";
        $data['vnilai'] = $bp==TRUE ? $p->nilai : "";*/
        $data['idprofil'] = $idprofil;
        $data['idimpor'] = $idimpor;
        $data['vproduk'] = $bp==TRUE ? $p->produk : "";
        $data['vhscode'] = $bp==TRUE ? $p->hscode : "";
        $data['vimpor2021'] = $bp==TRUE ? $p->nilai1 : "";
        $data['vimpor2020'] = $bp==TRUE ? $p->nilai2 : "";
        $data['vimpor2019'] = $bp==TRUE ? $p->nilai3 : "";
        $data['vimpor2018'] = $bp==TRUE ? $p->nilai4 : "";
        $data['vimpor2017'] = $bp==TRUE ? $p->nilai5 : "";
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyerimpor', $data);
    }
    
    //update data nilai impor buyer
    function updateimpor() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->updateimpor($data);
    }
    
    //hapus data impor buyer
    function hapusimporbuyer() {
        $idprofil = $this->input->post('idprofil');
        $idimpor = $this->input->post('idimpor');
        
        $this->dutamod->hapusimporbuyer($idprofil, $idimpor);
    }
    
    //data kisah keberhasilan buyer
    function kisahbuyer() {
        //title
        $data['title'] = "Edit Data Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "kisah";
        
        //iduser
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        
        //variable boolean
        $bp = FALSE;
        
        //ambil data impor untuk ditampilkan ke form
        if(!empty($idprofil)) {
            $p = $this->dutamod->ambilbuyerkisah($idprofil)->row();
            $np = $this->dutamod->ambilbuyerkisah($idprofil)->num_rows();
            if($np>0) { $bp = TRUE; }
        }
        
        
        $data['idprofil'] = $idprofil;
        $data['idkisah'] = $bp==TRUE ? $p->idkisah : "";
        $data['vkisah'] = $bp==TRUE ? $p->kisah : "";
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyerkisah', $data);
    }
    
    //update data nilai impor buyer
    function updatekisah() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->updatekisah($data);
    }
    
    //data dokumen pendukung buyer
    function dokbuyer() {
        //title
        $data['title'] = "Edit Data Buyer | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "dokumen";
        
        //iduser
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        //iddokumen
        $iddok = $this->secure->decrypt_url($this->uri->segment(4));
        
        //ambil data dokumen untuk ditampilkan ke tabel
        $data['dok'] = $this->dutamod->ambilbuyerdok($idprofil, "");
        
        //variable boolean
        $bp = FALSE;
        
        //status form
        $sf = "";
        if(empty($iddok)) { $sf = "tambah"; }
        else { $sf = "edit"; }
        
        //ambil data dokumen untuk ditampilkan ke form
        if(!empty($iddok)) {
            $p = $this->dutamod->ambilbuyerdok($idprofil, $iddok)->row();
            $np = $this->dutamod->ambilbuyerdok($idprofil, $iddok)->num_rows();
            if($np>0) { $bp = TRUE; }
        }
        
        $data['status'] = $sf;
        $data['idprofil'] = $idprofil;
        $data['iddok'] = $iddok;
        $data['vnmfile'] = $bp==TRUE ? $p->nmfile : "";
        $data['vfile'] = $bp==TRUE ? $p->file : "";
        $data['vlink'] = $bp==TRUE ? $p->linkdownload : "";
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/buyerdokumen', $data);
    }
    
    //update data nilai impor buyer
    function updatedokumen() {
        //returns all POST items with XSS filter
        //$data = $this->input->post(NULL, TRUE); 

        //$this->dutamod->updatedok($data);
        
        //filename
        $idprofil = $this->input->post('idprofil');
        $filename = $idprofil."-".str_replace(" ", "_", $_FILES["file"]['name']);

        $data = array(
            'status' => $this->input->post('status'),
            'idprofil' => $this->input->post('idprofil'),
            'iddok' => $this->input->post('iddok'),
            'nmfile' => $this->input->post('nmfile'),
            'file' => $_FILES["file"]['name'],
            'linkdownload' => $this->input->post('linkdownload'),
            'iduser' => $this->decrypt_id,
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s"),
        );

        // Set preference 
        $config['upload_path'] = 'assets/uploads/dokumen/'; 
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg'; 
        $config['max_size'] = '5000'; // max_size in kb 
        $config['file_name'] = $filename;

        // Load upload library 
        $this->load->library('upload',$config);
        
        // File upload
        $linkdownload = $this->input->post('linkdownload');
        $status = $this->input->post('status');
        if(empty($linkdownload)) {
            if($status=="tambah") {
                if($this->upload->do_upload("file")) {
                    // Get data about the file
                    $uploadData = $this->upload->data(); 
                    //$data['filename'] = $uploadData['file_name'];
                    //returns all POST items with XSS filter
                    //$data = $this->input->post(NULL, TRUE); 

                    $this->dutamod->updatedok($data);     
                }
                else {
                    echo 'failed upload'; 
                }
            }
            else {
                if(empty($_FILES['file']['name'])) {
                    $this->dutamod->updatedok($data); 
                }
                else {
                    if($this->upload->do_upload("file")) {
                        // Get data about the file
                        $uploadData = $this->upload->data(); 
                        //$data['filename'] = $uploadData['file_name'];
                        //returns all POST items with XSS filter
                        //$data = $this->input->post(NULL, TRUE); 

                        $this->dutamod->updatedok($data);     
                    }
                    else {
                        echo 'failed upload'; 
                    }
                }
            }
            
        }
        else {
            $this->dutamod->updatedok($data); 
        }
    }
    
    //hapus data dokumen pendukung buyer
    function hapusdokbuyer() {
        $idprofil = $this->input->post('idprofil');
        $iddok = $this->input->post('iddok');
        
        $this->dutamod->hapusdokbuyer($idprofil, $iddok);
    }
    
    //halaman pendaftaran perwakilan pendukung ekspor
    function perwakilan() {
        //title
        $data['title'] = "Input Perwakilan Pendukung Ekspor | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //ambil data profil buyer
        $data['profil'] = $this->dutamod->ambilperwakilanprofil("", $this->decrypt_id);
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/perwakilan', $data);
    }
    
    //halaman tambah data perwakilan pendukung ekspor
    function tambahperwakilan() {
        //title
        $data['title'] = "Tambah Data Perwakilan Pendukung Ekspor | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //ambil data negara
        $data['neg'] = $this->dutamod->ambilnegara();
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/perwakilantambah', $data);
    }
    
    //simpan data perwakilan
    function simpanperwakilanprofil() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->simpanperwakilanprofil($data);
    }
    
    //halaman edit profil buyer
    function editperwakilan() {
        //title
        $data['title'] = "Edit Data Perwakilan Pendukung Ekspor | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "profil";
        
        //ambil data negara
        $data['neg'] = $this->dutamod->ambilnegara();
        
        //ambil data profil perwakilan
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        $p = $this->dutamod->ambilperwakilanprofil($idprofil, "")->row();
        
        $data['idprofil'] = $idprofil;
        $data['vnama'] = $p->nama;
        $data['vjabatan'] = $p->jabatan;
        $data['vidnegara'] = $p->idnegara;
        $data['vmasa1'] = $this->dutamod->ubahtanggal("-", $p->masa1);
        $data['vmasa2'] = $this->dutamod->ubahtanggal("-", $p->masa1);
        $data['vpic'] = $p->pic;
        $data['vpicphone'] = $p->picphone;
        $data['vpicemail'] = $p->picemail;
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/perwakilanprofil', $data);
    }
    
    //edit data profil perwakilan pendukung ekspor
    function updateperwakilanprofil() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->updateperwakilanprofil($data);
    }
    
    //hapus data perwakilan pendukung ekspor
    function hapusperwakilan() {
        $idprofil = $this->input->post('idprofil');
        
        $this->dutamod->hapusperwakilan($idprofil);
    }
    
    //data nilai impor negara perwakilan pendukung ekspor
    function imporperwakilan() {
        //title
        $data['title'] = "Edit Data Perwakilan Pendukung Ekspor | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "impor";
        
        //iduser
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        
        //ambil data impor untuk ditampilkan ke tabel
        $data['imp'] = $this->dutamod->ambilperwakilanimpor($idprofil, "");
        
        //variable boolean
        $bp = FALSE;
        
        //ambil data impor untuk ditampilkan ke form
        $idimpor = $this->secure->decrypt_url($this->uri->segment(4));
        if(!empty($idimpor)) {
            $p = $this->dutamod->ambilperwakilanimpor($idprofil, $idimpor)->row();
            $np = $this->dutamod->ambilperwakilanimpor($idprofil, $idimpor)->num_rows();
            if($np>0) { $bp = TRUE; }
        }
        
        
        /*$data['idprofil'] = $idprofil;
        $data['idimpor'] = $idimpor;
        $data['vtahun'] = $bp==TRUE ? $p->tahun : "";
        $data['vnilai'] = $bp==TRUE ? $p->nilai : "";*/
        $data['idprofil'] = $idprofil;
        $data['idimpor'] = $idimpor;
        $data['vimpor2021'] = $bp==TRUE ? $p->nilai1 : "";
        $data['vimpor2020'] = $bp==TRUE ? $p->nilai2 : "";
        $data['vimpor2019'] = $bp==TRUE ? $p->nilai3 : "";
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/perwakilanimpor', $data);
    }
    
    //update data nilai impor negara perwakilan pendukung ekspor
    function updateimporperwakilan() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->updateimporperwakilan($data);
    }
    
    //hapus data impor buyer
    function hapusimporperwakilan() {
        $idprofil = $this->input->post('idprofil');
        $idimpor = $this->input->post('idimpor');
        
        $this->dutamod->hapusimporperwakilan($idprofil, $idimpor);
    }
    
    //data kisah keberhasilan perwakilan pendukung ekspor
    function kisahperwakilan() {
        //title
        $data['title'] = "Edit Data Perwakilan Pendukung Ekspor | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "kisah";
        
        //iduser
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        
        //variable boolean
        $bp = FALSE;
        
        //ambil data impor untuk ditampilkan ke form
        if(!empty($idprofil)) {
            $p = $this->dutamod->ambilperwakilankisah($idprofil)->row();
            $np = $this->dutamod->ambilperwakilankisah($idprofil)->num_rows();
            if($np>0) { $bp = TRUE; }
        }
        
        
        $data['idprofil'] = $idprofil;
        $data['idkisah'] = $bp==TRUE ? $p->idkisah : "";
        $data['vkisah'] = $bp==TRUE ? $p->kisah : "";
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/perwakilankisah', $data);
    }
    
    //update data nilai impor negara perwakilan pendukung ekspor
    function updatekisahperwakilan() {
        //returns all POST items with XSS filter
        $data = $this->input->post(NULL, TRUE); 

        $this->dutamod->updatekisahperwakilan($data);
    }
    
    //data dokumen pendukung perwakilan pendukung ekspor
    function dokperwakilan() {
        //title
        $data['title'] = "Edit Data Perwakilan Pendukung Ekspor | Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "dokumen";
        
        //iduser
        $idprofil = $this->secure->decrypt_url($this->uri->segment(3));
        //iddokumen
        $iddok = $this->secure->decrypt_url($this->uri->segment(4));
        
        //ambil data dokumen untuk ditampilkan ke tabel
        $data['dok'] = $this->dutamod->ambilperwakilandok($idprofil, "");
        
        //variable boolean
        $bp = FALSE;
        
        //status form
        $sf = "";
        if(empty($iddok)) { $sf = "tambah"; }
        else { $sf = "edit"; }
        
        //ambil data dokumen untuk ditampilkan ke form
        if(!empty($iddok)) {
            $p = $this->dutamod->ambilperwakilandok($idprofil, $iddok)->row();
            $np = $this->dutamod->ambilperwakilandok($idprofil, $iddok)->num_rows();
            if($np>0) { $bp = TRUE; }
        }
        
        $data['status'] = $sf;
        $data['idprofil'] = $idprofil;
        $data['iddok'] = $iddok;
        $data['vnmfile'] = $bp==TRUE ? $p->nmfile : "";
        $data['vfile'] = $bp==TRUE ? $p->file : "";
        $data['vlink'] = $bp==TRUE ? $p->linkdownload : "";
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/perwakilandokumen', $data);
    }
    
    //update data nilai impor perwakilan pendukung ekspor
    function updatedokumenperwakilan() {
        //returns all POST items with XSS filter
        //$data = $this->input->post(NULL, TRUE); 

        //$this->dutamod->updatedok($data);
        
        //filename
        $idprofil = $this->input->post('idprofil');
        $filename = $idprofil."-".str_replace(" ", "_", $_FILES["file"]['name']);

        $data = array(
            'status' => $this->input->post('status'),
            'idprofil' => $this->input->post('idprofil'),
            'iddok' => $this->input->post('iddok'),
            'nmfile' => $this->input->post('nmfile'),
            'file' => $_FILES["file"]['name'],
            'linkdownload' => $this->input->post('linkdownload'),
            'iduser' => $this->decrypt_id,
            'tglinput' => date("Y-m-d H:i:s"),
            'tgledit' => date("Y-m-d H:i:s"),
        );

        // Set preference 
        $config['upload_path'] = 'assets/uploads/perwakilan/'; 
        $config['allowed_types'] = 'pdf|doc|docx'; 
        $config['max_size'] = '5000'; // max_size in kb 
        $config['file_name'] = $filename;

        // Load upload library 
        $this->load->library('upload',$config);
        
        // File upload
        $linkdownload = $this->input->post('linkdownload');
        $status = $this->input->post('status');
        if(empty($linkdownload)) {
            if($status=="tambah") {
                if($this->upload->do_upload("file")) {
                    // Get data about the file
                    $uploadData = $this->upload->data(); 
                    //$data['filename'] = $uploadData['file_name'];
                    //returns all POST items with XSS filter
                    //$data = $this->input->post(NULL, TRUE); 

                    $this->dutamod->updatedokperwakilan($data);     
                }
                else {
                    echo 'failed upload'; 
                }
            }
            else {
                if(empty($_FILES['file']['name'])) {
                    $this->dutamod->updatedokperwakilan($data); 
                }
                else {
                    if($this->upload->do_upload("file")) {
                        // Get data about the file
                        $uploadData = $this->upload->data(); 
                        //$data['filename'] = $uploadData['file_name'];
                        //returns all POST items with XSS filter
                        //$data = $this->input->post(NULL, TRUE); 

                        $this->dutamod->updatedokperwakilan($data);     
                    }
                    else {
                        echo 'failed upload'; 
                    }
                }
            }
            
        }
        else {
            $this->dutamod->updatedokperwakilan($data); 
        }
    }
    
    //hapus data dokumen pendukung perwakilan pendukung ekspor
    function hapusdokperwakilan() {
        $idprofil = $this->input->post('idprofil');
        $iddok = $this->input->post('iddok');
        
        $this->dutamod->hapusdokperwakilan($idprofil, $iddok);
    }
    
    //halaman formulir pendaftaran
    function formulir() {
        //title
        $data['title'] = "Formulir Pendaftaran Primaduta ".date("Y");
        
        //menu aktif
        $data['menu'] = "formulir";
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('formulir', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    //halaman kategori primaduta
    function kategori() {
        //title
        $data['title'] = "Kategori Penghargaan Primaduta ".date("Y");
        
        //menu aktif
        $data['menu'] = "kategori";
        
        //ambil data kategori
        $data['kat'] = $this->dutamod->ambilkategori("");
        
        //view
        $this->load->view('tpl_header', $data);
        $this->load->view('kategori', $data);
        $this->load->view('tpl_footer', $data);
    }
    
    //halaman profil user
    function profil() {
        //title
        $data['title'] = "Profil User| Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "profiluser";
        
        //ambil data negara
        $data['neg'] = $this->dutamod->ambilnegara();
        
        //ambil data profil user
        $idnegara = $this->dutamod->neguser($this->decrypt_id);
        
        //echo $idnegara; exit;
        
        $data['iduser'] = $this->decrypt_id;
        $data['vnama'] = $this->decrypt_nama;
        $data['vkantor'] = $this->decrypt_kantor;
        $data['vidnegara'] = $idnegara;
        $data['vemail'] = $this->decrypt_email;
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/userprofil', $data);
    }
    
    //halaman ganti password user
    function gantipassword() {
        //title
        $data['title'] = "Ganti Password| Primaduta ".date("Y");
        
        //nama user
        $data['nmuser'] = $this->nama;
        
        //halaman aktif
        $this->page = "passworduser";
        
        $data['iduser'] = $this->decrypt_id;
        
        //view
        $this->load->view('akun/tpl_header', $data);
        $this->load->view('akun/tpl_sidemenu', $data);
        $this->load->view('akun/userpassword', $data);
    }
    
    //logout
    function logout() {
        //unset session sessemail
        //$this->session->unset_userdata('sessemail');
        //$this->session->unset_userdata('sessemailada');
        //$this->session->unset_userdata('sessnpwp');
        //$this->session->unset_userdata('sessuserid');
        //$this->session->unset_userdata('sessprofilid');

        $this->session->sess_destroy();

        //redirect ke halaman login
        redirect('main');
    }
}
<?php
    class Admin extends mainController{

        public function logOut(){
            session_start();
            $_SESSION['username'] = '';
            $_SESSION['password'] = '';
            unset($_SESSION['username']);
            unset($_SESSION['password']);
            session_unset();
            session_destroy();
            header("Location:".BASE_URL);
        }

        public function logCheck(){
            session_start();
            if ($_SESSION['username'] == '' && $_SESSION['password'] == '') {
                header('Location:'.BASE_URL);
            }
        }
        //function default
        public function index(){
            $this->logCheck();
            $data = [
                "title" => "Persuratan"
            ];

            $this->view("templates/header", $data);
            $this->view("admin/index");
            $this->view("templates/footer");
        }

        //function lain
        public function addDataSuratMasuk(){
            $this->logCheck();
            if( !empty($_POST) ){
                if($this->model("suratMasukModel")->addSuratMasuk($_POST) > 0){
                    header("Location: " . BASE_URL . "Admin/addDataSuratMasuk");
                }
            //end of if
            }
            else{
                //contoh data array
                //harus bentuk array key => value
                $data = [
                    "title" => "Tambah Surat Masuk",
                    "process" => "admin/AddDataSuratMasuk",
                    "judul" => "Tambah Surat Masuk",
                    "surat" => $this->model("suratMasukModel")->getAllSuratMasuk()
                ];
    
                //data dikirim kesini
                //nanti datanya dipanggil di view pake $data['nama_parameter']
                $this->view("templates/header", $data);
                $this->view("admin/addDataSuratMasuk", $data);
                $this->view("templates/footer");
            }
        //end of addData
        }

        public function addDataSuratKeluar(){
            $this->logCheck();
            if( !empty($_POST) ){
                if($this->model("suratKeluarModel")->addSuratKeluar($_POST) > 0){
                    header("Location: " . BASE_URL . "admin/addDataSuratKeluar");
                    // $this->addDataSuratKeluar();
            }
        }
            else{

            $data = [
                "title" => "Tambah Surat Keluar",
                "process" => "admin/AddDataSuratKeluar",
                "judul" => "Tambah Surat Keluar",
                "surat" => $this->model("suratKeluarModel")->getAllSuratKeluar()
            ];

            $this->view("templates/header", $data);
            $this->view("admin/addDataSuratKeluar", $data);
            $this->view("templates/footer");
            // var_dump($_POST);
            //end of if
            }
        //end of addDataSuratKeluar
    }

        // function buat show disposisi
        public function lihatDisposisiSuratKeluar($id){
            if ($this->model('disposisiSuratKeluarModel')->getValidateDisposisi($id) > 0) {

                $data['disposisi'] = $this->model('disposisiModel')->getDisposisi($id);
                // deklarasi array untuk menampung data
                $asal = [];
                $jenis = [];
                $user = [];
                $status = [];
                foreach ($data['disposisi'] as $disposisi) {
                    //ambil data dari model, coba buka model disposisiModel, disana ada getAsalDisposisi
                    $asal[] =  $this->model('disposisiModel')->getAsalDisposisis($this->model('disposisiModel')->getDisposisi($id));
                    $user[] = $this->model('disposisiModel')->getUser($disposisi['id_user']);
                    $jenis[] = $this->model('disposisiModel')->getJenisDisposisis($disposisi['id_jenis_disposisi']);
                    $status[] = $this->model('disposisiModel')->getStatus($disposisi['id_status']);
                
                }  
                //ga harus [key => value] yang penting ada keynya ($data[key] = value)
                // print_r($perihal);
                // $data['perihal'] = $perihal;
                $data["asal"] = $asal;
                $data["jenis"] = $jenis;
                $data["title"] = "Disposisi";
                $data["id_surat"] = $id;
                $data["user"] = $user;
                $data['status'] = $status;
                // print_r($status);                                  
                // var_dump($data['disposisi']);

                $this->view('templates/header', $data);
                $this->view('admin/lihatDisposisi',$data);
                $this->view('templates/footer', $data);
        }

        else{
            $this->logCheck();
            $data = [
                "surat_masuk" => $this->model("suratMasukModel")->getSuratMasukById($id), //memanggil method di dalam model
                "jDisposisi" => $this->model("jenisDisposisiModel")->getJenis(), //memanggil method di dalam model
                "user"  => $this->model("User_model")->getAllUser(),
                "process" => "admin/addDisposisi",
                "title" => "Add Disposisi"
            ];
            $this->view("templates/header", $data);
            $this->view("admin/disposisi", $data);
            $this->view("templates/footer");
        }
        }

        //nanti diisi function disposisi, itu juga baru buat view untuk disposisi
        public function disposisi($id){
            $data = [
                "surat_masuk" => $this->model("suratMasukModel")->getSuratMasukById($id), //memanggil method di dalam model
                "jDisposisi" => $this->model("jenisDisposisiModel")->getJenis(), //memanggil method di dalam model
                "user"  => $this->model("User_model")->getAllUser($id),
                "process" => "admin/addDisposisi"
            ];
            $this->view("templates/header", $data);
            $this->view("admin/disposisi", $data);
            $this->view("templates/footer");
        }

        public function addDisposisi(){
            $this->logCheck();
            if( !empty($_POST) ){
                if($this->model("disposisiModel")->addDisposisi($_POST) > 0){
                    header("Location: " . BASE_URL . "Admin/addDataSuratMasuk");
                }
            //end of if
            }
        }

        public function deleteSuratMasuk($id){
            if ($this->model("suratMasukModel")->deleteSuratMasuk($id) > 0) {
                    header("Location:" . BASE_URL . "admin/addDataSuratMasuk");
            }
        }

        public function deleteDisposisi($id){
            if ($this->model("disposisiModel")->deleteDisposisi($id) > 0) {
                    header("Location:" . BASE_URL . "admin/addDataSuratKeluar");
            }
        }

        // lihat disposisi
        public function lihatDisposisi($id){
            if ($this->model('disposisiModel')->getValidateDisposisi($id) > 0) {

                    $data['disposisi'] = $this->model('disposisiModel')->getDisposisi($id);
                    // deklarasi array untuk menampung data
                    $asal = [];
                    $jenis = [];
                    $user = [];
                    $status = [];
                    foreach ($data['disposisi'] as $disposisi) {
                        $asal[] =  $this->model('disposisiModel')->getAsalDisposisis($this->model('disposisiModel')->getDisposisi($id));
                        $user[] = $this->model('disposisiModel')->getUser($disposisi['id_user']);
                        $jenis[] = $this->model('disposisiModel')->getJenisDisposisis($disposisi['id_jenis_disposisi']);
                        $status[] = $this->model('disposisiModel')->getStatus($disposisi['id_status']);
                        $perihal[] = $this->model('disposisiModel')->getPerihal($disposisi['id_surat_masuk']);
                    }  
                    // print_r($perihal);
                    $data['perihal'] = $perihal;
                    $data["asal"] = $asal;
                    $data["jenis"] = $jenis;
                    $data["title"] = "Disposisi";
                    $data["id_surat"] = $id;
                    $data["user"] = $user;
                    $data['status'] = $status;
                    // print_r($status);                                  
                    // var_dump($data['disposisi']);

                    $this->view('templates/header', $data);
                    $this->view('admin/lihatDisposisi',$data);
                    $this->view('templates/footer', $data);
            }

            else{
                $this->logCheck();
                $data = [
                    "surat_masuk" => $this->model("suratMasukModel")->getSuratMasukById($id), //memanggil method di dalam model
                    "jDisposisi" => $this->model("jenisDisposisiModel")->getJenis(), //memanggil method di dalam model
                    "user"  => $this->model("User_model")->getAllUser(),
                    "process" => "admin/addDisposisi",
                    "title" => "Add Disposisi"
                ];
                $this->view("templates/header", $data);
                $this->view("admin/disposisi", $data);
                $this->view("templates/footer");
            }
        // end of lihat disposisi
        }

        public function register(){
            if ($_POST) {
                $add = $this->model('registerModel')->register($_POST);
		        if ($add > 0) {
                    header('Location: '.BASE_URL.'admin/showRegister');
                exit();
                }
                else{
                    header('Location: '.BASE_URL.'register/Register');
                exit(); 
                }
            }
            else{
                $data['title'] = 'Register';
                $this->view("templates/header",$data);
                $this->view("admin/registerAdmin");
                $this->view("templates/footer");
            }
        }
        
        public function showRegister(){

            $data['admin'] = $this->model('registerModel')->getRegister();

            $data['title'] = 'Register Admin';
            $this->view("templates/header",$data);
            $this->view("admin/showRegisterAdmin", $data);
            $this->view("templates/footer");
        }

        // //jika gagal update
        // public function showFailedUpdate($fail, $namaModel, $view){

        //     $data['admin'] = $this->model($namaModel)->getRegister();
        //     $data['failed'] = $fail;
        //     $data['title'] = 'Register Admin';
        //     $this->view("templates/header",$data);
        //     $this->view($view, $data);
        //     $this->view("templates/footer");
        // }

        public function deleteAdmin($id){
            $data['title'] = 'Delete Admin';

            if ($this->model('registerModel')->deleteRegister($id) > 0) {

                $this->showRegister();

            }
        }

        public function updateAdmin($id){
            
            // if ($this->model('registerModel')->updateRegister($id) > 0) {
            //     $this->showRegister();

            $data['admin']  = $this->model('registerModel')->getRegister();

            $data['title'] = "update Admin";
            $this->view("templates/header",$data);
            $this->view("admin/updateAdmin", $data);
            $this->view("templates/footer");

            }

        public function processUpdate(){
            if(isset($_POST)){
                if ($this->model("registerModel")->updateRegister() > 0 ) {
                    $this->showRegister();
                }
                else{
                    $notif = "<script>alert('failed to update')</script>";
                    header("Location: " . BASE_URL . "Admin/index");
                    echo $notif;
                }
            }
        }

        

        public function updateDisposisi($id){
                $data['disposisi']=$this->model('disposisiModel')->getDisposisiDetail($id);
                $data["jDisposisi"] = $this->model("jenisDisposisiModel")->getJenis();
                $data["title"] = "Disposisi Surat Masuk Update";
                
                $data["id_surat"] = $id;
                $this->view('templates/header',$data);
                $this->view('admin/updateDisposisi',$data);
                $this->view('templates/footer',$data);

            //}
        }

        public function updateDataDisposisi($id){

            if(isset($_POST)){
                if ($this->model("disposisiModel")->updateDisposisi($id) > 0 ) {
                    $this->lihatDisposisi($_POST["id_surat_masuk"]);
                }
                else{
                    $notif = "<script>alert('failed to update')</script>";
                    echo $notif;
                    $this->lihatDisposisi($_POST["id_surat_masuk"]);

                }
            }
        }

        public function showUser(){

            $data['user'] = $this->model('User_model')->getAllUser();

            $data['title'] = 'List User';
            $this->view("templates/header",$data);
            $this->view("admin/showUser", $data);
            $this->view("templates/footer");
        }

        public function deleteUser($id){
            $data['title'] = 'Delete User';

            if ($this->model('User_model')->deleteUsr($id) > 0) {
                echo "halo";

                header("Location: " . BASE_URL . 'admin/showUser');

            }
        }

        public function updateSuratMasuk($id){
            $data['surat_masuk']=$this->model('suratMasukModel')->getSuratMasukById($id);
            $allsuratmasuk =[];
           
            foreach($data['surat_masuk'] as $updateSuratMasuk){
                $allsuratmasuk[] =  $this->model('suratMasukModel')->getAllSuratMasuk($this->model('suratMasukModel')->getSuratMasukById($id));
        
        
            }
            //bagian controller yang ini masih error
            // $data["upadateSuratMasuk"] = $this->model("suratMasukModel")->getAllSuratMasuk();
            $data["allsuratmasuk"] = $allsuratmasuk;
            // $data["lampiran_surat_masuk"] = $lampiran_surat_masuk;
            $data["title"] = "updateSuratMasuk";
            // $data["surat_masuk"] = surat_masuk;
            // $data["alamat_pengirim"] = $alamat_pengirim;
            // $data['tanggal_surat_masuk'] = $tanggal_surat_masuk;
            // $data['nomor_surat_masuk'] = $nomor_surat_masuk;
            // $data['perihal_surat_masuk'] = $perihal_surat_masuk;
            // $data['nama_instansi_surat_masuk'] = $nama_instansi_surat_masuk;
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit();
            $this->view('templates/header',$data);
            $this->view('admin/updateSuratMasuk',$data);
            $this->view('templates/footer',$data);
        
        }
        
        public function updateDataSuratMasuk($id){
            if(isset($_POST)){
                if ($this->model("suratMasukModel")->updateSuratMasuk($id) > 0 ) {
                    $this->updatesuratmasuk($_POST["id_surat_masuk"]);
                }else{
                    $notif = "<script>alert('failed to update')</script>";
                    $this->showFailedUpdate($notif, "registerModel", "admin/showRegisterAdmin");
        
        
                }
            }
        }
        
}



?>
<?php
    class disposisiSuratKeluarModel{

        private $db, $table = "tbl_disposisi_keluar";

        //function construct database
        public function __CONSTRUCT(){
            $this->db = new Database;
        }

        public function getValidateDisposisi($id){
            //manggil disposisi berdasarkan user yang bersangkutan
            $binded = $id ;
            // ambil disposisi yang berkaitan dengan user yang sudah login aja
            $this->db->query("SELECT * FROM $this->table WHERE id_surat_keluar = :id"); //apa ga gila pake function tuh
            $this->db->bind('id', $binded);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function getDisposisi($id){
            //manggil disposisi berdasarkan user yang bersangkutan
            $binded = $id ;
            //print_r($id);
            // ambil disposisi yang berkaitan dengan user yang sudah login aja
            $this->db->query("SELECT * FROM $this->table WHERE id_surat_keluar = :id ORDER BY id_disposisi_keluar DESC"); //apa ga gila pake function tuh
            $this->db->bind('id', $binded);
            return $this->db->allResult();
        }

        public function getAsalDisposisis($data){
            $user = "SELECT * FROM tbl_surat_keluar WHERE id_surat_keluar =  :id ORDER BY id_surat_keluar DESC";
            // echo $user;
            $this->db->query($user);
            $this->db->bind('id', $data[0]['id_surat_keluar']);
            $a = $this->db->singleResult();
            return $a['nama_instansi_surat_keluar'];
        }

        public function getUser($id){
            $getUser = "SELECT * FROM tbl_user WHERE id_user =  :id ORDER BY id_user DESC";
            $this->db->query($getUser);
            $this->db->bind('id', $id);
            return $this->db->singleResult();
        }

        public function getJenisDisposisi(){
            $query = "SELECT * FROM " . $this->table . "ORDER BY id_disposisi_keluar DESC";
            $this->db->query($query);
            return $this->db->allResult();
        }

        public function getStatus($id){
            $getStatus = "SELECT status FROM tbl_status WHERE id_status = :id ";
            $this->db->query($getStatus);
            $this->db->bind('id', $id);
            return $this->db->singleResult()['status'];
        }

        // prosess add disposisi
        public function addDisposisi(){
            // print_r($_POST);
            //belom buat tampilin user
            if(isset($_POST['submit'])){
                $d = time()+21600;//3600 = 60 menit, 21600 / 3600 = dihitung sendiri ya
                // echo date("H:i:s", $d). " "; 
                $datePost = date('Y-m-d H:i:s', $d);
            }

            $query = "INSERT INTO $this->table 
                    VALUES(
                        '',
                        :tanggal,
                        :tanggal_penyelesaian,
                        :no_agenda,
                        :id_jenis_disposisi,
                        :instruksi,
                        :id_user,
                        :id_status,
                        :id_jenis_surat,
                        :id_surat_keluar,
                        :postedTime
                    )";
            //buat bindingnya
            print_r($_POST);
            $this->db->query($query);
            $this->db->bind(':tanggal', $_POST['tanggal'] );
            $this->db->bind(':tanggal_penyelesaian', $_POST['tanggal_penyelesaian'] );
            $this->db->bind(':no_agenda', $_POST['agenda'] );
            $this->db->bind(':id_jenis_disposisi', $_POST['jenis_disposisi'] );
            $this->db->bind(':instruksi', $_POST['instruksi'] );
            $this->db->bind(':id_user', $_POST['user'] );
            $this->db->bind(':id_status', 1 );
            $this->db->bind(':id_jenis_surat', 1 );
            $this->db->bind(':id_surat_keluar', $_POST['id_surat_keluar'] );
            $this->db->bind(':postedTime', $datePost );
            $this->db->execute();
            return $this->db->rowCount();
        }
        // get disposisi

        // get jenis disposisis
        public function getJenisDisposisis($data){
            // print_r($data);
            $user = "SELECT * FROM tbl_jenis_disposisi WHERE id_jenis_disposisi =  :id ";
            // echo $user;
            $this->db->query($user);
            $this->db->bind('id', $data);
            $a = $this->db->singleResult();
            return $a['jenis_disposisi'];
        }

        public function updateDisposisiKeluar($id){
            // print_r($_POST); die(); 
            $updateDisposisi = "UPDATE $this->table SET tanggal = :tanggal, 
            tanggal_penyelesaian = :tanggal_penyelesaian, 
            no_agenda = :no_agenda, 
            id_jenis_disposisi = :id_jenis_disposisi, 
            instruksi = :instruksi, 
            -- id_user = :id_user, 
            -- id_status = :id_status, 
            -- id_jenis_surat = :id_jenis_surat, 
            id_surat_keluar = :id_surat_keluar where id_disposisi_keluar = :id";

            $this->db->query($updateDisposisi);
            $this->db->bind(':id', $id );
            $this->db->bind(':tanggal', $_POST['tanggal'] );
            $this->db->bind(':tanggal_penyelesaian', $_POST['tanggal_penyelesaian'] );
            $this->db->bind(':no_agenda', $_POST['no_agenda'] );
            $this->db->bind(':id_jenis_disposisi', $_POST['jenis_disposisi'] );
            $this->db->bind(':instruksi', $_POST['instruksi'] );
            // $this->db->bind(':id_user', $_POST['id_user'] );
            // $this->db->bind(':id_status', $_POST['id-status'] );
            $this->db->bind(':id_surat_keluar', $_POST['id_surat_keluar'] );
            $this->db->execute();
            //rowCount dipake buat nunjukkin berapa baris yg kena efek dari query, biasanya buat DELETE, INSERT, UPDATE
            return $this->db->rowCount();

        }

        public function getPerihal($id){
            $user = "SELECT * FROM tbl_surat_keluar WHERE id_surat_keluar =  :id ORDER BY id_surat_keluar DESC";
            // echo $user;
            $this->db->query($user);
            $this->db->bind('id', $id);
            $a = $this->db->singleResult();
            return $a['perihal_surat_keluar'];
        }

            public function getDisposisiDetail($id){
            //manggil disposisi berdasarkan user yang bersangkutan
            $binded = $id ;
            //print_r($id);
            // ambil disposisi yang berkaitan dengan user yang sudah login aja
            $this->db->query("SELECT * FROM $this->table as tbdis LEFT JOIN tbl_surat_keluar as tbsm ON tbsm.id_surat_keluar = tbdis.id_surat_keluar LEFT JOIN tbl_jenis_disposisi as tbjd ON tbjd.id_jenis_disposisi = tbdis.id_jenis_disposisi WHERE id_disposisi_keluar = :id"); //apa ga gila pake function tuh
            $this->db->bind('id', $binded);
            return $this->db->allResult();
        }

        public function deleteDisposisi($id){
            $delete = "DELETE FROM $this->table WHERE id_disposisi_keluar = :id";
            $this->db->query($delete);
            $this->db->bind("id", $id);
            $this->db->execute();
            return $this->db->rowCount();
        }

    }
?>
<?php
    class suratMasukModel{
        private $db, $table = "tbl_surat_masuk";

        //function construct database
        public function __CONSTRUCT(){
            $this->db = new Database;
        }

        public function addSuratMasuk($data){
            // var_dump($_POST);
            $no_surat = $data['nmr_srt_msk'];
            $tanggal_surat = $data['tgl_srt_msk'];
            $alamat_surat = $data['alamat_srt_msk'];
            $perihal_surat = $data['perihal_srt_msk'];
            $lampiran_surat = $data['lampiran_srt_msk'];
            $nama_instansi_surat_masuk = $data['nama_instansi_surat_masuk'];

            $query = "INSERT INTO $this->table
                        VALUES(
                                '',
                                :lampiran_surat_masuk,
                                :alamat_pengirim,
                                :tanggal_surat_masuk,
                                :nomor_surat_masuk,
                                :perihal_surat_masuk,
                                :nama_instansi_surat_masuk
                                )";
                    
            $this->db->query($query);
            // mengkaitkan data untuk di query
            $this->db->bind(':lampiran_surat_masuk', $lampiran_surat );
            $this->db->bind(':alamat_pengirim', $alamat_surat);
            $this->db->bind(':tanggal_surat_masuk', $tanggal_surat);
            $this->db->bind(':nomor_surat_masuk', $no_surat);
            $this->db->bind(':perihal_surat_masuk',$perihal_surat);
            $this->db->bind(':nama_instansi_surat_masuk',$nama_instansi_surat_masuk);

            $this->db->execute();
            // penghitung apakah ada baris yang terpengahruh
            return $this->db->rowCount();
        // end of add surat masuk 
        }
        
        public function getAllSuratMasuk(){
            $query = "SELECT * FROM " . $this->table;
            //function query ada di db-wrapper
            $this->db->query($query);
            //function untuk ambil semua data, ada di file db-wrapper
            return $this->db->allResult();
        // end of surat masuk function
        }

        public function getSuratMasukById($id){
            $query = ("SELECT * FROM " . $this->table . " WHERE id_surat_masuk = :id");
            $this->db->query($query);
            $this->db->bind("id", $id);
            return $this->db->singleResult();
        }

        //delete surat masuk
        public function deleteSuratMasuk($id){
            $delete = "DELETE FROM $this->table WHERE id_surat_masuk = :id";
            $this->db->query($delete);
            $this->db->bind("id", $id);
            $this->db->execute();
            return $this->db->rowCount();
        }

        public function updateSuratMasuk($id){
            $updateSuratMasuk = "UPDATE $this->table SET lampiran_tanggal_masuk = : lampiran_tanggal_masuk, alamat_pengirim = :alamat_pengirim, tanggal_surat_masuk = :tanggal_surat_masuk, nomor_surat_masuk = :nomor_surat_masuk, perihal_surat_masuk = :perihal_surat_masuk, instansi_surat_masuk = :instansi_surat_masuk where id_surat_masuk = :id";

            $this->db->query($updateSuratMasuk);
            $this->db->bind(':id', $id );
            $this->db->bind(':lampiran_tanggal_masuk', $_POST['lampiran_tanggal_masuk'] );
            $this->db->bind(': alamat_pengirim', $_POST[' alamat_pengirim'] );
            $this->db->bind(':tanggal_surat_masuk', $_POST['tanggal_surat_masuk'] );
            $this->db->bind(':nomor_surat_masuk', $_POST['nomor_surat_masuk'] );
            $this->db->bind(':perihal_surat_masuk', $_POST['perihal_surat_masuk'] );
            $this->db->bind(':instansi_surat_masuk', $_POST['instansi_surat_masuk'] );
            $this->db->execute();
            //rowCount dipake buat nunjukkin berapa baris yg kena efek dari query, biasanya buat DELETE, INSERT, UPDATE
            return $this->db->rowCount();

    }
    }    
    
?>
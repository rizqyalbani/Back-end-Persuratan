<h2>edit disposisi</h2>


<form action="<?php echo BASE_URL . "admin/updateDataDisposisi/".$data['disposisi'][0]['id_disposisi'] ?>" method="POST">
    <input value="<?php echo $data['disposisi'][0]['id_disposisi'];?>" name="id_disposisi" type="hidden"> <br>
    <input value="<?php echo $data['disposisi'][0]['id_surat_masuk'];?>" name="id_surat_masuk" type="hidden"> <br>

    <label for="agenda">No Agenda</label>
    <input id="agenda" name="no_agenda" type="number" value="<?php echo $data['disposisi'][0]['no_agenda'];?>"> <br>

    <label for="tanggal">Tanggal</label>
    <input id="tanggal" name="tanggal" type="date" value="<?php echo $data['disposisi'][0]['tanggal'];?>"> <br>

    <label for="tanggal_penyelesaian">Tanggal Penyelesaian</label></label>
    <input id="tanggal_penyelesaian" name="tanggal_penyelesaian" type="date" value="<?php echo $data['disposisi'][0]['tanggal_penyelesaian'];?>"> <br>

    <label for="instruksi">Instruksi</label>
    <input id="instruksi" name="instruksi" type="text" value="<?php echo $data['disposisi'][0]['instruksi'];?>"> <br>

    <label for="perihal">Perihal</label>
    <!-- input di disabled karena yang punya data itu surat masuk, bukan disposisi -->
    <input id="perihal" name="perihal" type="text" value="<?php echo $data['disposisi'][0]['perihal_surat_masuk'];?>" disabled> <br>

    <label for="jenis_disposisi">Jenis Disposisi</label>
    <select id="jenis_disposisi" name="jenis_disposisi" type="text">
        <option selected hidden value="Jenis">-Jenis-</option>
        <?php
            // print_r($data['jDisposisi']);
            foreach($data['jDisposisi'] as $show):
        ?>
        <?php if($show['id_jenis_disposisi'] == $data['disposisi'][0]['id_jenis_disposisi']){ ?>
            <option value="<?= $show['id_jenis_disposisi']?>" selected><?=$show['jenis_disposisi']?></option>
        <?php } else { ?>
            <option value="<?= $show['id_jenis_disposisi']?>"><?=$show['jenis_disposisi']?></option>
        <?php } ?>
        <?php
            endforeach;
        ?>
    </select> <br>
    <button name="submit" type="submit">update</button>
</form>

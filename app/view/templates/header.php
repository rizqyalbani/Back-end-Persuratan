<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <ol>
        <li><a href="<?= BASE_URL?>admin/addDataSuratMasuk">Surat Masuk</a></li>
        <li><a href="<?= BASE_URL?>admin/addDataSuratKeluar">Surat Keluar</a></li>
        <li><a href="<?= BASE_URL?>admin/register">Admin</a></li>
        <li><a href="<?= BASE_URL?>admin/logOut">Logout</a></li>
    </ol>
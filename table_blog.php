<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <?php
        include "db.php";
        include "upload.php";
        $d = new Database(); //mengaktifkan class DB
        $u = new Upload();
        $action = (!isset($_REQUEST["action"])) ? null : $_REQUEST["action"];
        if ($action == null){
    ?>
        <table class="tabel">
            <thead>
                <th>Judul</th>
                <th>Gambar</th>
                <th>Isi</th>
                <th>Tanggal Input</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                    $sql = "select * from blog";
                    $hasil = $d->getList($sql); //ambil data dan tampung pada $hasil
                    // var_dump($hasil);
                    //loop untuk menampilkannya
		            for($i = 0; $i < count($hasil); $i++){
                ?>
                    <tr>
                        <td><a href="index.php?id=<?= $hasil[$i]["id_blog"] ?>"><?= $hasil[$i]["judul"] ?></a></td>
                        <td><a href="index.php?id=<?= $hasil[$i]["id_blog"] ?>"><img src="<? echo "images/". $hasil[$i]["gambar"]; ?>" alt=""></a> </td>
                        <td><?= $hasil[$i]["isi"] ?></td>
                        <td><?= $hasil[$i]["tgl_input"] ?></td>
                        <td><a href="table_blog.php?action=edit&id=<?= $hasil[$i]["id_blog"] ?>" class="btn btn-primary">Edit</a> <a href="table_blog.php?action=delete&id=<?= $hasil[$i]["id_blog"] ?>" class="btn btn-danger">Hapus</a> </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        <a href="index.php">Back</a>
        <a href="add_blog.php">Add Blog</a>
    <?php
        } elseif($action == 'edit') {
            $id = (!isset($_REQUEST["id"])) ? null : $_REQUEST["id"];
            $sql = "select * from blog where id_blog =".$id;
            $hasil = $d->getList($sql);
    ?>
        <form enctype="multipart/form-data" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="text" name='judul' value="<?= $hasil[0]["judul"] ?>"><br>
            <input type="file" name='gambar'><br>
            <img src="<? echo "images/". $hasil[0]["gambar"]; ?>" alt=""><br>
            <a href="table_blog.php?action=HAPUSGAMBAR&gambar=<?= $hasil[0]['gambar'] ?>&id=<?= $hasil[0]['id_blog'] ?>">Hapus Gambar</a><br>
            <input type="text" name='isi' value="<?= $hasil[0]["isi"] ?>" class="btn btn-primary"><br>
            <input type="submit" name="action" value="update" class="btn btn-primary">
        </form>
    <?php
        } elseif($action == 'delete') {
            $id = (!isset($_REQUEST["id"])) ? null : $_REQUEST["id"];
            $sql = "delete from blog where id_blog =".$id;
            $d->query($sql);
            header("location: table_blog.php");
        } elseif($action == 'update') {
            $id = (!isset($_REQUEST["id"])) ? null : $_REQUEST["id"];
            $ukuran = $u->fileSize($_FILES["gambar"]);
            
            if ($ukuran > 0){ 
            
                //kalo ada temporary foto, maka hapus dahulu
                if ($_REQUEST['tempFoto'] != "") $u->hapusFile($_REQUEST['tempFoto']);
                
                //upload foto baru
                $u = new Upload();
                $hasil = $u->uploadFile($_FILES["gambar"]);
    
                print_r($hasil);
    
                if ($hasil["status"] == "0"){
                    die ($hasil["info"]. "<p><a href='#' onClick='window.history.back()'>Coba lagi</a></p>");
                }else{
                    //update data termasuk fotonya
                    $sql = "update blog set judul = '". $_REQUEST['judul'] ."', " 
                            ."gambar = '". $hasil['info'] ."', "
                            ."isi = '". $_REQUEST['isi'] ."' where id_blog =".$id;
                }
            } else{
                //update data kecuali fotonya
                $sql = "update blog set judul = '". $_REQUEST['judul'] ."', "
                            ."isi = '". $_REQUEST['isi'] ."' where id_blog =".$id;
            }
            
            //die($sql);
            $d->query($sql); 
            $d->close();
               
            header("location: table_blog.php"); //redirect
        }elseif($action == "HAPUSGAMBAR"){ 
            $u->hapusFile($_REQUEST["gambar"]);
            $sql = "update blog set gambar = null where id_blog = ". $_REQUEST['id'];
            $d->query($sql); 
            $d->close();
    
            header("location: table_blog.php?action=edit&id=".$_REQUEST['id']); //redirect ke posisi edit
        }
    ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
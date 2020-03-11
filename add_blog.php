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
        $d = new Database();
        $action = (!isset($_REQUEST["action"])) ? null : $_REQUEST["action"];
        if ($action == null){
    ?>
        <form enctype="multipart/form-data" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <input type="text" name='judul' ><br>
            <input type="file" name='gambar'><br>
            <input type="text" name='isi' ><br>
            <input type="submit" name="action" value="save">
        </form>
        <a href="table_blog.php">Back</a>
    <?php
        } elseif($action == 'save') {
            $u = new Upload();
            $hasil = $u->uploadFile($_FILES["gambar"]);
            $tgl = date('Y-m-d');
            if ($hasil["status"] == "0"){
                die ($hasil["info"]. "<p><a href='#' onClick='window.history.back()'>Coba lagi</a></p>");
            }else{
                $sql = "insert into blog (judul, gambar, isi, tgl_input) values ( "
                        ."'".$_REQUEST['judul']."', '".$hasil['info']."', "
                        ."'".$_REQUEST['isi']."', '".$tgl."')";
                $d->query($sql); //jalankan function query u/ eksekusi sql
                
                header("location: table_blog.php"); //redirect
            }
        }
    
    ?>
</body>
</html>
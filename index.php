<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Blog</title>
</head>
<body>
    <?php
        include "db.php";
        $id = (!isset($_REQUEST["id"])) ? null : $_REQUEST["id"];
        $action = (!isset($_REQUEST["action"])) ? null : $_REQUEST["action"];
        if ($action == null){
    ?>
        <?php
            $d = new Database(); //mengaktifkan class DB
            $sql = "select * from blog limit 1";
            if ($id !== null) {
                $sql = "select * from blog where id_blog =".$id;
            }
            $hasil = $d->getList($sql); //ambil data dan tampung pada $hasil
            // var_dump($hasil);
            //loop untuk menampilkannya
            for($i = 0; $i < count($hasil); $i++){
        ?>
            <div class="container-fluid">
                <h1><?= $hasil[$i]["judul"] ?></h1>
                <div><img src="<? echo "images/". $hasil[$i]["gambar"]; ?>" alt=""> </div>
                <p><?= $hasil[$i]["isi"] ?></p>
                <p><?= $hasil[$i]["tgl_input"] ?></p>
            </div>
        <?php
            }
        ?>
        <a href="table_blog.php" class="btn btn-primary">Semua Blog</a>
    <?php
        }
    ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
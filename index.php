<?php
require "db.php";

$mode_edit = false;
$tampil_edit = ['id' => '','nama' => '' ,'harga' => '' ,'stok' => '' ,'suplier' => ''];

if(isset($_POST['delete'])){
  $id_delete = $_POST['delete'];
  $sql = $db->query("DELETE FROM barang WHERE id=$id_delete");
}

  if(isset($_POST['edit'])){
    $mode_edit = true;
    $id_edit = $_POST['edit'];
    $result = $db -> query("SELECT * FROM barang WHERE id=$id_edit")->fetch_assoc();
    $tampil_edit = $result;
  }
  
  if(isset($_POST['submit'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $suplier = $_POST['suplier'];
    
    if($mode_edit == true){
      $id = $tampil_edit['id'];
      $sql = $db ->query("UPDATE barang SET `nama`='$nama', `harga`='$harga', `stok`='$stok', `suplier`='$suplier' WHERE id=$id");
    }else{
      $sql = $db ->query("INSERT INTO `barang`(`nama`, `harga`, `stok`, `suplier`) VALUES('$nama','$harga','$stok','$suplier')");
      if($sql){
        echo "berhasil";
      }
  }
}



$tampil_suplier=$db->query("SELECT * FROM suplier");
$tampil = $db->query("SELECT * ,barang.id as barang_id, barang.nama as barang_nama, suplier.nama as nama_suplier, suplier.id as id_suplier FROM barang JOIN suplier ON suplier.id = barang.suplier");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="" method="post">
    <label for="">nama</label>
    <input type="text" name="nama" value="<?=$tampil_edit['nama']?>">
    <label for="">harga</label>
    <input type="number" name="harga" value="<?=$tampil_edit['harga']?>">
    <label for="">stok</label>
    <input type="number" name="stok" value="<?=$tampil_edit['stok']?>">
    <label for="">suplier</label>
    <select name="suplier" id="">
      <option value="<?=$tampil_edit['suplier']?>" hidden></option>
      <?php foreach($tampil_suplier as $suplier){?>
        <option value="<?=$suplier['id']?>" <?=($suplier['id'] == $tampil_edit['suplier']) ? 'selected' : '' ?>><?=$suplier['nama']?></option>
     <?php 
     }?>
    </select>
    <button type="submit" name="submit">submit</button>
  </form>

  <table border="1px">
    <thead>
      <tr>
        <th>no</th>
        <th>nama</th>
        <th>harga</th>
        <th>stok</th>
        <th>suplier</th>
        <th>aksi</th>
      </tr>
    </thead>

    <tbody>
      <?php $i=1;
      foreach($tampil as $tampil_barang){
        ?>
      <tr>
        <td><?=$i++?></td>
        <td><?=$tampil_barang['barang_nama']?></td>
        <td><?=$tampil_barang['harga']?></td>
        <td><?=$tampil_barang['stok']?></td>
        <td><?=$tampil_barang['nama_suplier']?></td>
        <td>
          <form action="" method="post">
          <button name="edit" value="<?=$tampil_barang['barang_id']?>">edit</button>
          <button name="delete" value="<?=$tampil_barang['barang_id']?>">delete</button>
          </form>
        </td>
      </tr>
      <?php
      }?>
    </tbody>
  </table>

</body>
</html>
<?php
include_once("../connection/connectDB.php");
if (isset($_POST["parkirIn"])) {
  $jamMasuk = $_POST["parkirIn"];
  try {
    $sql = "INSERT INTO parkir (waktu_masuk)
    VALUES ('$jamMasuk')";
    $conn->exec($sql);
    $row = $conn->lastInsertId();
    var_dump($row[0]);
  } catch (\Throwable $th) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Text AZLogistik</title>
</head>

<body>
  <h1>Parkir masuk</h1>
  <form action="" method="post">
    <input type="text" name="parkirIn" value="<?= date("Y-m-d h:i:s"); ?>" hidden>
    <button type="submit">Masuk</button>
  </form>
</body>

</html>
<?php
include_once("../connection/connectDB.php");
if (isset($_POST["idParkir"])) {
  $idParkir = $_POST["idParkir"];
  $platNomor = $_POST["parkirOut"];
  $jamKeluar = date("Y-m-d H:i:s"); // ambil jam masuk sekarang
  // $jamKeluar = date("2023-05-30 12:00:00");
  $checkId = true;
  $durasiParkir = 0;
  $arrayH = [];
  $tarifParkir = 0;
  $biayaParkir = 5000;
  $time1jam = 3600;

  $sqlGetId = "SELECT * FROM parkir WHERE id='$idParkir'";
  $result = $conn->query($sqlGetId);
  if ($result->rowCount() == 0) {
    echo "data tidak ditemukan";
    $checkId = false;
    // return;
  }
  try {
    if ($checkId) {
      $dataParkir = $result->fetch(PDO::FETCH_ASSOC);
      $jamMasuk = strtotime($dataParkir['waktu_masuk']); // Jam masuk di ambil dari database
      $id = $dataParkir['id'];
      $durasiParkir = floor((strtotime($jamKeluar) - $jamMasuk) / $time1jam);

      if ($durasiParkir > 1) { // "0" = ketika masuk di jam ke 2 akan langsung + 4000 // "1" = ketika sudah masuk di jam ke 2 akan langsung + 4000
        for ($i = 0; $i < $durasiParkir; $i++) {
          array_push($arrayH, date("H", $jamMasuk + ($time1jam * $i)));
        }

        foreach ($arrayH as $value) {
          // var_dump((int)$value);
          if ((int)$value >= 6 && (int)$value <= 21) {
            $biayaParkir += 4000;
          } else {
            if ((int)$value === 0) {
              $biayaParkir += 50000;
            }
            $biayaParkir += 25000;
          }
        }
        // var_dump($durasiParkir);
      }
      // var_dump($biayaParkir);

      echo "Jam Masuk Parkir = " . $dataParkir['waktu_masuk'] . '<br>';
      echo "Jam Keluar Parkir = " . $jamKeluar . '<br>';
      echo "Durasi Parkir = " . $durasiParkir . '<br>';
      echo "Biaya Parkir = " . $biayaParkir . '<br>';


      $sql = "UPDATE parkir SET 
        plat_nomor='$platNomor', 
        waktu_keluar='$jamKeluar',
        durasi_parkir='$durasiParkir',
        tarif='$biayaParkir'
      WHERE id='$id'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      echo $stmt->rowCount() . " records UPDATED successfully";
    }
  } catch (\Throwable $e) {
    echo "<br>" . $e->getMessage();
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
  <h1>Parkir Keluar</h1>
  <form action="" method="post">
    <label for="idParkir">ID Parkir</label>
    <input type="text" name="idParkir" id="idParkir" required>
    <br>
    <label for="platNomor">Plat Nomor</label>
    <input type="text" name="parkirOut" id="platNomor" required>
    <br>
    <button type="submit">Keluar</button>
  </form>
</body>

</html>
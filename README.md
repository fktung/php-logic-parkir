# PHP logic parkir

	$dataParkir = $result->fetch(PDO::FETCH_ASSOC);
	$jamMasuk = strtotime($dataParkir['waktu_masuk']); // Jam masuk di ambil dari database
	$id = $dataParkir['id'];
	$durasiParkir = floor((strtotime($jamKeluar) - $jamMasuk) / $time1jam);

	if ($durasiParkir > 1) { // "0" = ketika masuk di jam ke 2 akan langsung + 4000 // "1" = ketika sudah masuk di jam ke 2 akan langsung + 4000
		for ($i = 0; $i < $durasiParkir; $i++) {
			array_push($arrayH, date("H", $jamMasuk + ($time1jam * $i)));
		}

		foreach ($arrayH as $value) {
			if ((int)$value >= 6 && (int)$value <= 21) {
				$biayaParkir += 4000;
			} else {
				if ((int)$value === 0) {
					$biayaParkir += 50000;
				}
				$biayaParkir += 25000;
			}
		}
	}

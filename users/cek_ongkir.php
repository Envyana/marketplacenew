<?php
// API Key RajaOngkir
$apiKey = 'ab636aae726a4a78f4153c5518e6af60'; // Ganti dengan API Key Anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origin = $_POST['origin_city'];
    $destination = $_POST['destination_city'];
    $weight = $_POST['weight'];
    $courier = $_POST['courier'];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ]),
        CURLOPT_HTTPHEADER => [
            "key: $apiKey",
            "Content-Type: application/x-www-form-urlencoded"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);

    if (isset($result['rajaongkir']['results'][0]['costs'])) {
        // Menampilkan semua opsi ongkir dengan checkbox
        foreach ($result['rajaongkir']['results'][0]['costs'] as $cost) {
            $service = $cost['service'];
            $price = $cost['cost'][0]['value'];
            $etd = $cost['cost'][0]['etd'];

            echo "<div class='form-check'>
                    <input class='form-check-input ongkir-option' type='checkbox' name='ongkir[]' value='$price' data-service='$service' data-etd='$etd'>
                    <label class='form-check-label'>
                        $service: Rp " . number_format($price, 0, ',', '.') . " (Estimasi: $etd hari)
                    </label>
                </div>";
        }
    } else {
        echo "<p class='text-danger'>Ongkir tidak ditemukan. Periksa kembali input Anda.</p>";
    }
}
?>

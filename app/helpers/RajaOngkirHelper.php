<?php
class RajaOngkirHelper {

    private static $apiKey = '39dede19ea7eec1743e387dff154883b';

    public static function getProvinces() {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://rajaongkir.komerce.id/api/v1/destination/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "key: " . self::$apiKey
            ],
        ]);

        $response = curl_exec($curl);
        if(curl_errno($curl)){
            curl_close($curl);
            return false;
        }
        curl_close($curl);
        return json_decode($response, true);
    }

}

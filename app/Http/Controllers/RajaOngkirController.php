<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    private $apiKey = '39dede19ea7eec1743e387dff154883b';

    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
            'accept' => 'application/json'
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        return response()->json($response->json());
    }

    public function getCities($province_id)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
            'accept' => 'application/json'
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$province_id}");

        return response()->json($response->json());
    }

    public function getDistricts($city_id)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey,
            'accept' => 'application/json'
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$city_id}");

        return response()->json($response->json());
    }

    public function calculateShipping(Request $request)
    {
        try {
            $validated = $request->validate([
                'origin' => 'required',
                'destination' => 'required',
                'weight' => 'required|numeric',
            ]);

            // Daftar kurir valid (sesuai pesan error)
            $couriers = ['jne','sicepat','ide','sap','jnt','ninja','tiki','lion','anteraja','pos','ncs','rex','rpx','sentral','star','wahana','dse'];

            $results = [];

            foreach ($couriers as $courier) {
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ])->asForm()->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', [
                    'origin' => $validated['origin'],
                    'destination' => $validated['destination'],
                    'weight' => (int) $validated['weight'],
                    'courier' => $courier,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data['data'])) {
                        $results = array_merge($results, $data['data']);
                    }
                }
            }

            if (!empty($results)) {
                return response()->json([
                    'success' => true,
                    'data' => $results,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Tidak ada layanan pengiriman tersedia',
                ], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Exception:', ['message' => $e->getMessage()]);
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    

}

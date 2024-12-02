<?php

use App\Models\Peta;
use App\Models\Artikel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/peta', function (Illuminate\Http\Request $request) {
    $action = $request->input('action');
    if ($action === 'znt') {
        $query = Peta::withDesaJoin()
            ->where('dat_objek_pajak.kd_kecamatan', '160')
            ->where('dat_objek_pajak.kd_kelurahan', '001')
            ->whereRaw('ST_IsValid(dat_objek_pajak.geometry)');
        $data = $query->toGeojsonFeatureCollection();
    } else {
        $query = Peta::query()
            ->where('kd_kecamatan', '160')
            ->where('kd_kelurahan', '001')
            ->whereRaw('ST_IsValid(geometry)');
        $data = $query->toGeojsonFeatureCollection();
    }
    return view('peta', ['data' => $data]);
});

Route::post('/peta', function (Illuminate\Http\Request $request) {
    $action = $request->input('action');
    if ($action === 'join') {
        $geoJson = $request->getContent();

        // Decode the JSON string into an associative array or object
        $decodedGeoJson = json_decode($geoJson, true);

        // Check for JSON decoding errors
        if (json_last_error() === JSON_ERROR_NONE) {
            // Process the decoded GeoJSON data
            $hasilAhkir = $decodedGeoJson; // Replace this with actual processing logic

            return response()->json([
                'message' => 'Iki Mas Datanya',
                'data' => $hasilAhkir
            ], 200);
        } else {
            return response('Invalid GeoJSON data', 400);
        }
    }
    return response('Unsupported action', 400);
});


Route::get('/home', function () {
    return view('home', ['artikel' => Artikel::all()]);
});

Route::get('/detail/{artikel:nama}', function (Artikel $artikel) {

    return view('detail', ['isiDetail' => $artikel]);
});

Route::get('/content', function () {
    return view('content');
});


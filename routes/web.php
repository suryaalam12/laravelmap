<?php

use App\Models\Peta;
use App\Models\Port;
use App\Models\Artikel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Data\Geometries\Polygon;
use Clickbar\Magellan\IO\Parser\WKT\WKTParser;
use Clickbar\Magellan\Data\Geometries\LineString;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Clickbar\Magellan\IO\Generator\WKB\WKBGenerator;
use Clickbar\Magellan\IO\Parser\Geojson\GeojsonParser;

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
        $hasil = $request->getContent();
        $query = Peta::query()
            ->select('dat_objek_pajak.id', 'dat_objek_pajak.geometry')
            ->whereRaw('ST_IsValid(geometry)')
            ->where('kd_kecamatan', '160')
            ->where('kd_kelurahan', '001')
            ->whereRaw("ST_Intersects(geometry, ST_GeomFromGeoJSON(?))", [$hasil]);
        $data = $query->toGeojsonFeatureCollection();
        return response()->json($data, 200);
    }
    return response()->json([
        'message' => 'Unsupported action',
    ], 400);
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


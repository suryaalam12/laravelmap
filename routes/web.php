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
        $parser = app(GeojsonParser::class);
        $hasil = $request->getContent();
        $geojson = json_decode('{
    "type": "Feature",
    "properties": {},
    "geometry": {
        "coordinates": [
         [[112.296962,-7.45351],[112.297429,-7.453749],[112.29734,-7.454175],[112.296772,-7.454005],[112.296962,-7.45351]]
        ],
        "type": "Polygon"
    }
}', true);

        $coordinates = json_encode($geojson['geometry']); // Extract only the geometry part

        $query = Peta::query()
            ->select('dat_objek_pajak.id', 'dat_objek_pajak.geometry')
            ->whereRaw('ST_IsValid(geometry)')
            ->where('kd_kecamatan', '160')
            ->where('kd_kelurahan', '001')
            ->whereRaw("ST_Intersects(geometry, ST_GeomFromGeoJSON(?))", [$coordinates]);
        $data = $query->toGeojsonFeatureCollection();
        return response()->json($data, 200);
        // ->stWhere(ST::contains('dat_objek_pajak.geometry', $polygon), true)->get();
        // $geoJson = json_decode($geoJsonString, true);
        // // Check for JSON decoding errors
        // if (json_last_error() === JSON_ERROR_NONE && isset($geoJson['geometry'])) {
        //     $geometry = json_encode($geoJson['geometry']);
        //     $whereInside = Peta::query()
        //         ->stSelect('kd_kecamatan')
        //         ->stWhere(St::contains('geometry', $geometry), true) // Use only the column name
        //         ->toGeojsonFeatureCollection();

        //     
        // } else {
        //     return response()->json([
        //         'message' => 'Invalid GeoJSON data or missing "geometry" key',
        //     ], 400);
        // }
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


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
        $polygon = $parser->parse('   {
            "type": "Feature",
            "properties": {},
            "geometry": {
              "coordinates": [
                [[112.284994,-7.452433],[112.305593,-7.446901],[112.310829,-7.463581],[112.277956,-7.465624],[112.284994,-7.452433]]
              ],
              "type": "Polygon"
            }
          }');
        $whereInside = Peta::query()
            ->select('dat_objek_pajak.id', 'dat_objek_pajak.geometry')
            ->stWhere(ST::intersects('dat_objek_pajak.geometry', $polygon))->get();

        return response()->json($whereInside, status: 200);



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


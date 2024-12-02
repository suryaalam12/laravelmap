<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;

class Peta extends Model
{
    use HasFactory;
    use HasPostgisColumns;

    // Define the guarded attributes
    protected $guarded = [];

    // Set the table name
    protected $table = 'dat_objek_pajak';

    // Define PostGIS columns
    protected array $postgisColumns = [
        'geometry' => [
            'type' => 'geometry',
            'srid' => 4326,
        ],
    ];

    /**
     * Method to perform a left join with the desa table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withDesaJoin()
    {
        return self::query()
            ->leftJoin('desa', function ($join) {
                $join->on('dat_objek_pajak.kd_kecamatan', '=', 'desa.kec')
                    ->on('dat_objek_pajak.kd_kelurahan', '=', 'desa.desa')
                    ->on('dat_objek_pajak.kd_blok', '=', 'desa.blok')
                    ->on('dat_objek_pajak.no_urut', '=', 'desa.nop');
            })
            ->select(
                'dat_objek_pajak.geometry', // Add the geometry column
                'dat_objek_pajak.*', // Add all other fields from the dat_objek_pajak table if needed
                'desa.znt_edit',
                'desa.nir_edit'
            );
    }
}


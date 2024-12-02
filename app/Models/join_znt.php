<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;

class join_znt extends Model
{
    use HasFactory;
    use HasPostgisColumns;

    protected $guarded = [];
    protected $table = 'desa';


    protected array $postgisColumns = [
        'geometry' => [
            'type' => 'geom',
            'srid' => 4326,
        ],
    ];
}


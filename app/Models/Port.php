<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;

class Port extends Model
{
    use HasFactory;
    use HasPostgisColumns;

    protected $guarded = [];

    protected array $postgisColumns = [
        'location' => [
            'type' => 'geometry',
            'srid' => 4326,
        ],
    ];
}

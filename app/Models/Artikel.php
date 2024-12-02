<?php
namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;
    protected $table = 'artikel';
    protected $fillable = ['nama', 'deskripsi', 'geometry'];
}
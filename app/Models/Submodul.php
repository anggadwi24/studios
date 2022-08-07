<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submodul extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'submoduls';
    protected $primaryKey = 'submodul_id';
    protected $fillable = [
        'submodul_modul_id',
        'submodul_name',
        'submodul_slug',
        'submodul_publish',
    
      

    ];
}

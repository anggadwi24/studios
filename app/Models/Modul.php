<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Modul extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'moduls';
    protected $primaryKey = 'modul_id';
    protected $fillable = [
        'modul_name',
        'modul_order',
        'modul_icon',
        'modul_slug',
        'modul_id',
      

    ];
   
}

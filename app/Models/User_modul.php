<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_modul extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'users_modul';
    protected $primaryKey = 'umod_id';
    protected $fillable = [
        'umod_users_id',
        'umod_moudul_id',
        'umod_submodul_id',
    
    
      

    ];
    public function  modul(){
        return $this->belongsTo(Modul::class, 'umod_modul_id', 'modul_id');
    }
    
    public function submodul(){
        return $this->belongsTo(Submodul::class, 'umod_submodul_id', 'submodul_id');
    }
}

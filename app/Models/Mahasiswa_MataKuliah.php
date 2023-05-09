<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Mahasiswa_MataKuliah extends Pivot
{
    use HasFactory;
    protected $table = "mahasiswa_matakuliah";
    protected $fillable = [
        'mahasiswa_id', 
        'matakuliah_id', 
        'nilai',
    ];
    protected $primaryKey = 'id';

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }

    public function matakuliah(){
        return $this->belongsTo(MataKuliah::class);
    }

}

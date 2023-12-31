<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = ['mood', 'weather', 'gps_location', 'note'];

    public function setNoteAttribute($value)
    {
        $this->attributes['note'] = encrypt($value);
    }
}

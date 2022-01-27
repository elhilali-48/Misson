<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public function getRouteKeyName()
    {
        return 'nom';
    }
    protected $fillable = ['nom','description','debut','fin'];

    
}

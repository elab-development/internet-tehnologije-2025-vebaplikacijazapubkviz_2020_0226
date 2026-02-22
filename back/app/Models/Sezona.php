<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Sezona extends Model
{
    use HasFactory;
    protected $table = 'sezone';
    protected $fillable = ['pocetak', 'kraj'];


    protected $casts = [
        'pocetak' => 'date', 
        'kraj' => 'date', 
    ];

    public function dogadjaji()
    {
        return $this->hasMany(Dogadjaj::class);
    }
}

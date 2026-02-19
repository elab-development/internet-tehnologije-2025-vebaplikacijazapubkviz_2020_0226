<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clan extends Model
{
    use HasFactory;
    protected $table = 'clanovi';
    protected $fillable = ['ime', 'prezime'];

    public function ucescaDogadjaj()
    {
       
        return $this->belongsToMany(Dogadjaj::class, 'clan_ucesce', 'clan_id', 'dogadjaj_id')
                    ->withPivot('tim_id') 
                    ->withTimestamps();
    }
    
    public function ucescaTim()
    {
       
        return $this->belongsToMany(Tim::class, 'clan_ucesce', 'clan_id', 'tim_id')
                    ->withPivot('dogadjaj_id') 
                    ->withTimestamps();
    }
}

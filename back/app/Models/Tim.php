<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Tim extends Model
{
    use HasFactory;
    protected $table = 'timovi'; 
    protected $fillable = ['naziv', 'logo', 'user_id'];

    public function korisnik()
    {
        return $this->belongsTo(User::class);
    }

    public function dogadjaji()
    {
       
        return $this->belongsToMany(Dogadjaj::class, 'dogadjaj_tim')
                    ->withPivot('score','dogadjaj_id')
                    ->withTimestamps();
    }
    
    public function clanoviUcesnici()
    {
       
        return $this->belongsToMany(Clan::class, 'clan_ucesce', 'tim_id', 'clan_id')
                    ->withPivot('dogadjaj_id') 
                    ->withTimestamps();
    }

    public function omiljeniDogadjaji()
    {
        return $this->belongsToMany(Dogadjaj::class,"omiljeni_dogadjaji");
    }
}

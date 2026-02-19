<?php

use App\Models\Clan;
use App\Models\Tim;
use App\Models\Dogadjaj;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('ClanController Testovi', function () {

    beforeEach(function () {
        Sanctum::actingAs(User::factory()->create());
    });

   
    it('može da prikaže listu svih članova', function () {
        Clan::factory()->count(5)->create();

        $response = $this->getJson('/api/clanovi/svi'); 

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Lista članova je uspešno učitana.'
                 ])
                 ->assertJsonCount(5, 'data');
    });

    
    it('vraća članove tima koji učestvuju na specifičnom događaju', function () {
        $tim = Tim::factory()->create();
        $dogadjaj = Dogadjaj::factory()->create();
        $clanovi = Clan::factory()->count(2)->create();

        foreach ($clanovi as $clan) {
            $tim->clanoviUcesnici()->attach($clan->id, ['dogadjaj_id' => $dogadjaj->id]);
        }

        $drugiDogadjaj = Dogadjaj::factory()->create();
        $clanSaDrugogDogadjaja = Clan::factory()->create();
        $tim->clanoviUcesnici()->attach($clanSaDrugogDogadjaja->id, ['dogadjaj_id' => $drugiDogadjaj->id]);

        
        $response = $this->getJson("/api/dogadjaji/{$dogadjaj->id}/timovi/{$tim->id}/clanovi");

        
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Lista članova tima za izabrani događaj je uspešno učitana.'
                 ])
                 ->assertJsonCount(2, 'data'); 
    });

   
    it('vraća 404 ako tim ne postoji', function () {
        $dogadjaj = Dogadjaj::factory()->create();
        
       
        $response = $this->getJson("/api/dogadjaji/{$dogadjaj->id}/timovi/999/clanovi");

        $response->assertStatus(404)
                 ->assertJson([
                     'success' => false,
                     'message' => 'Tim nije pronađen.'
                 ]);
    });

});


it('ne dozvoljava neautorizovan pristup listi članova', function () {
    $this->getJson('/api/clanovi/svi')->assertStatus(401);
});
<?php

use App\Models\User;
use App\Models\Tim;
use App\Models\Dogadjaj;
use App\Models\Clan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Carbon\Carbon;

uses(RefreshDatabase::class);

describe('TimController Testovi', function () {

    beforeEach(function () {
        $this->user = User::factory()->create(['role' => 'tim']);
        $this->tim = Tim::factory()->create(['user_id' => $this->user->id]);
        Sanctum::actingAs($this->user);
    });

   
    it('može da doda događaj u omiljene', function () {
        $dogadjaj = Dogadjaj::factory()->create();

        $response = $this->postJson('api/users/dogadjaji/dodaj-u-omiljene', [
            'dogadjaj_id' => $dogadjaj->id
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        expect($this->tim->omiljeniDogadjaji()->where('dogadjaj_id', $dogadjaj->id)->exists())->toBeTrue();
    });

    it('vraća 400 ako je događaj već u omiljenima', function () {
        $dogadjaj = Dogadjaj::factory()->create();
        $this->tim->omiljeniDogadjaji()->attach($dogadjaj->id);

        $response = $this->postJson('api/users/dogadjaji/dodaj-u-omiljene', [
            'dogadjaj_id' => $dogadjaj->id
        ]);

        $response->assertStatus(400)
                 ->assertJson(['message' => 'Dogadjaj je vec prisustan u listi omiljenih']);
    });

  
    it('može da ukloni događaj iz omiljenih', function () {
        $dogadjaj = Dogadjaj::factory()->create();
        $this->tim->omiljeniDogadjaji()->attach($dogadjaj->id);

        $response = $this->deleteJson("api/users/dogadjaji/ukloni-iz-omiljenih/{$dogadjaj->id}");

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        expect($this->tim->omiljeniDogadjaji()->where('dogadjaj_id', $dogadjaj->id)->exists())->toBeFalse();
    });

 
    it('uspešno prijavljuje tim za događaj sa novim članovima', function () {
        $dogadjaj = Dogadjaj::factory()->create([
            'datumOdrzavanja' => Carbon::now()->addDays(5)
        ]);

        $payload = [
            'dogadjaj_id' => $dogadjaj->id,
            'clanovi' => [
                ['ime' => 'Marko', 'prezime' => 'Marković'],
                ['ime' => 'Janko', 'prezime' => 'Janković']
            ]
        ];

        $response = $this->postJson('api/dogadjaji/prijava', $payload);

        $response->assertStatus(201)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('clanovi', ['ime' => 'Marko']);
        
        expect($dogadjaj->timovi()->where('tim_id', $this->tim->id)->exists())->toBeTrue();
    });

    it('ne dozvoljava prijavu ako je događaj prošao', function () {
        $dogadjaj = Dogadjaj::factory()->create([
            'datumOdrzavanja' => Carbon::now()->subDays(1)
        ]);

        $payload = [
            'dogadjaj_id' => $dogadjaj->id,
            'clanovi' => [['ime' => 'Marko', 'prezime' => 'Marković']]
        ];

        $response = $this->postJson('api/dogadjaji/prijava', $payload);

        $response->assertStatus(400)
                 ->assertJson(['message' => 'Prijava nije moguća. Događaj je već počeo ili je završen.']);
    });

    it('vraća 403 ako korisnik nema ulogu tim', function () {
        $običanKorisnik = User::factory()->create(['role' => 'moderator']);
        Sanctum::actingAs($običanKorisnik);

        $response = $this->postJson('api/dogadjaji/prijava', [
            'dogadjaj_id' => 1,
            'clanovi' => []
        ]);

        $response->assertStatus(403); 
    });
});
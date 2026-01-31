<?php

namespace App\Http\Controllers;

use App\Models\Dogadjaj;
use App\Models\Sezona;
use App\Models\Tim;
use App\Models\Clan;
use App\Http\Resources\DogadjajResource;
use App\Http\Resources\DogadjajTimResource; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DogadjajController extends Controller
{
   


    public function index(Request $request)
    {
        try {
           
            $request->validate([
                'sezona_id' => 'required_without:omiljeni|nullable|integer|exists:sezone,id',
                'omiljeni'=>'required_without:sezona_id|nullable|boolean',
                'naziv' => 'nullable|string|max:255',
                'datumOdrzavanja' => 'nullable|date',
            ]);

            $sezonaId = $request->sezona_id;
            $omiljeni = $request->omiljeni;
            
            if($omiljeni){

                $tim = Tim::where('user_id',Auth::id())->first();
                $query = $tim->omiljeniDogadjaji();
                
            }else{
                   $query = Dogadjaj::where('sezona_id', $sezonaId)
                             ->with('timovi');
            }
         

          
            $filterNaziv = $request->input('naziv');
            $filterDatum = $request->input('datumOdrzavanja');

          
            if ($filterNaziv) {
                $query->where('naziv', 'LIKE', '%' . $filterNaziv . '%');
            }

        
            if ($filterDatum) {
                $query->whereDate('datumOdrzavanja', $filterDatum);
            }

            $now = Carbon::now();

            $query->orderByRaw("CASE WHEN datumOdrzavanja >= '{$now->toDateTimeString()}' THEN 1 ELSE 2 END ASC")
                  ->orderBy('datumOdrzavanja', 'asc');
            
            $dogadjaji = $query->paginate(5);

            return response()->json([
                'success' => true,
                'message' => 'Lista događaja za sezonu uspešno učitana.',
                'data' => DogadjajResource::collection($dogadjaji),
                'meta' => [
                    'total' => $dogadjaji->total(),
                    'per_page' => $dogadjaji->perPage(),
                    'current_page' => $dogadjaji->currentPage(),
                    'last_page' => $dogadjaji->lastPage(),
                ],
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Greška pri validaciji unosa.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Došlo je do greške prilikom obrade zahteva.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

   
   


   
}
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


class TimController extends Controller
{
   
   
    public function dodajUOmiljene(Request $request){
       
        try {
           
            $user = Auth::user();
            if($user->role!=='tim'){
                return response()->json([
                    'error' => 'Nemate dozvolu za ovu funkciju. Samo timovi mogu dodavati dogadjaje u omiljene',
                ], 403); 
            }
            

             $request->validate([
                'dogadjaj_id' => 'required|integer|exists:dogadjaji,id',
            ]);

            $tim = Tim::where('user_id',$user->id)->first();
            $dogadjaj = Dogadjaj::find($request->dogadjaj_id);

         
            if (!$tim->omiljeniDogadjaji->contains($dogadjaj->id)) {
                $tim->omiljeniDogadjaji()->attach($dogadjaj->id);
            }else{
                  return response()->json([
                'success' => false,
                'message' => 'Dogadjaj je vec prisustan u listi omiljenih',
            ], 400);
            }

             return response()->json([
                'success' => true,
                'message' => 'Dogadjaj je uspesno dodat u listu omiljenih',
            ], 200);
           
        }

        catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Greška pri validaciji unosa.',
                'errors' => $e->errors(),
            ], 422); 
            
        } 
        
         catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
              return response()->json([
                'success' => false,
                'message' => 'Događaj ili Tim nije pronađen.',
            ], 404); 
             
        }

        catch (\Exception $e) {
             return response()->json([
                'success' => false,
                'message' => 'Došlo je do greške prilikom obrade zahteva.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    
    }


     public function ukloniIzOmiljenih(Request $request,$id){
       
        try {
           
            $user = Auth::user();
            if($user->role!=='tim'){
                return response()->json([
                    'error' => 'Nemate dozvolu za ovu funkciju. Samo timovi mogu ukloniti dogadjaje iz liste omiljenih',
                ], 403); 
            }
            
              
           
            $tim = Tim::where('user_id',$user->id)->first();
            $dogadjaj = Dogadjaj::findOrFail($id);

            
         
            if ($tim->omiljeniDogadjaji->contains($id)) {
                $tim->omiljeniDogadjaji()->detach($id);
            }else{
                  return response()->json([
                'success' => false,
                'message' => 'Dogadjaj koji pokusavate da uklonite se ne nalazi u listi omiljenih',
            ], 400);
            }

             return response()->json([
                'success' => true,
                'message' => 'Dogadjaj je uspesno uklonjen iz liste omiljenih',
            ], 200);
           
        }
        
         catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
              return response()->json([
                'success' => false,
                'message' => 'Događaj ili Tim nije pronađen.',
            ], 404); 
             
        }

        catch (\Exception $e) {
             return response()->json([
                'success' => false,
                'message' => 'Došlo je do greške prilikom obrade zahteva.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    
    }



   


}
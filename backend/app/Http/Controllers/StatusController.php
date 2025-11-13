<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class StatusController extends Controller

{

    public function list()
    {
        // récupérer toutes les tâches en BDD
        $adopt = DB::table('animals')
            ->where('status', 'Adopté')
            ->get()
            ->map(function ($adopt) {
                // 🔹 On récupère la première image associée à cet animal
                $firstImage = DB::table('animal_images')
                    ->where('animal_id', $adopt->id)
                    ->orderBy('order')
                    ->first();
                if ($firstImage) {
                    $adopt->thumbnail = asset('assets/' . $firstImage->filename);
                } else {
                    // 🔹 Sinon → image par défaut
                    $adopt->thumbnail = asset('assets/default.jpg');
                }

                return $adopt;
            });


        return response()->json($adopt);
    }
}

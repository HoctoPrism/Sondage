<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $reponses = DB::table('reponses')
            ->get()
            ->toArray();
        $reponses = Reponse::with(['questions'])->get();
        $reponses->map(function ($reponse){
            $reponse['reponse'] = DB::table('propositions')
                ->select('id', 'name')
                ->where('id', '=', $reponse['reponse'])
                ->get();
            unset($reponse['question']);
        });
        return response()->json([
            'status' => 'Success',
            'data' => $reponses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        foreach ($request->result as $item){
            Reponse::create([
                'reponse' => $item['response'],
                'question' => $item['ask'],
                'sondage' => $item['sondage']
            ]);
        }


        return response()->json([
            'status' => 'Success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Reponse $reponse
     * @return JsonResponse
     */
    public function show(Reponse $reponse): JsonResponse
    {
        $reponse->question = $reponse->questions()->get();
        $reponse->sondage = $reponse->sondages()->get();
        $reponse['reponse'] = DB::table('propositions')
                ->select('id', 'name')
                ->where('id', '=', $reponse->reponse)
                ->get();

        return response()->json($reponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reponse $reponse
     * @return JsonResponse
     */
    public function update(Request $request, Reponse $reponse): JsonResponse
    {
        $reponse->update([
            'reponse' => $request->reponse
        ]);

        return response()->json([
            'status' => 'Mise à jour avec success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reponse $reponse
     * @return JsonResponse
     */
    public function destroy(Reponse $reponse): JsonResponse
    {
        $reponse->delete();

        return response()->json([
            'status' => 'Supprimer avec success'
        ]);
    }
}

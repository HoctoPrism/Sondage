<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Proposition;
use App\Models\Sondage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SondageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sondages = Sondage::with(['questions'])->get();
        $sondages->map(function ($sondage){
            $sondage['questions']->map(function ($question){
                $question['category'] = $question['categories'];
                $question['propositions'] = DB::table('propositions')
                    ->select('id', 'name')
                    ->where('question', '=', $question['id'])
                    ->get();
                unset($question['categories']);
            });
        });

        return response()->json([
            'status' => 'Success',
            'data' => $sondages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request ,[
            'name' => 'required|max:100'
        ]);

        $sondage = Sondage::create([
            'name' => $request->name,
            'question' => $request->question,
        ]);

        $sondage->questions()->attach($request->question);

        return response()->json([
            'status' => 'Success',
            'data' => $sondage,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Sondage $sondage
     * @return JsonResponse
     */
    public function show(Sondage $sondage): JsonResponse
    {
        $sondage->load(['questions']);
        $sondage['questions']->map(function ($question){
            $question['category'] = $question['categories'];
            $question['propositions'] = DB::table('propositions')
                ->select('id', 'name')
                ->where('question', '=', $question['id'])
                ->get();
            unset($question['categories']);
        });
        return response()->json(['data' => $sondage]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Sondage $sondage
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Sondage $sondage): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);

        $sondage->update([
            'name' => $request->name,
            'question' => $request->question,
        ]);

        $sondage->questions()->sync($request->question);

        return response()->json([
            'status' => 'Mise à jour avec success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sondage $sondage
     * @return JsonResponse
     */
    public function destroy(Sondage $sondage): JsonResponse
    {
        $sondage->questions()->detach();
        $sondage->delete();

        return response()->json([
            'status' => 'Supprimer avec success'
        ]);
    }
}

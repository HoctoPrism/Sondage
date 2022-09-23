<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Proposition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PropositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $proposition = DB::table('propositions')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success',
            'data' => $proposition
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
            'name' => 'required|max:100',
        ]);

        $proposition = Proposition::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $proposition,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Proposition $proposition
     * @return JsonResponse
     */
    public function show(Proposition $proposition): JsonResponse
    {
        return response()->json($proposition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Proposition $proposition
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Proposition $proposition): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);

        $proposition->update([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'Mise à jour avec success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Proposition $proposition
     * @return JsonResponse
     */
    public function destroy(Proposition $proposition): JsonResponse
    {
        $proposition->delete();

        return response()->json([
            'status' => 'Supprimer avec success'
        ]);
    }
}

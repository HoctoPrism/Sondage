<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $questions = Question::with(['questions', 'sondages'])->get();

        return response()->json([
            'status' => 'Success',
            'data' => $questions
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

        $question = Question::create([
            'name' => $request->name,
            'category' => $request->category
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $question,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return JsonResponse
     */
    public function show(Question $question): JsonResponse
    {
        $question->category = $question->categories()->get();
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Question $question
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Question $question): JsonResponse
    {
        $this->validate($request ,[
            'name' => 'required|max:100',
        ]);

        $question->update([
            'name' => $request->name,
            'category' => $request->category
        ]);

        return response()->json([
            'status' => 'Mise à jour avec success',
            'data' => $question
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return JsonResponse
     */
    public function destroy(Question $question): JsonResponse
    {
        $question->delete();

        return response()->json([
            'status' => 'Supprimer avec success'
        ]);
    }
}

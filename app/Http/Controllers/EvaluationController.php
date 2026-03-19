<?php

namespace App\Http\Controllers;

use App\Exports\EvaluationResultsExport;
use App\Imports\EvaluationImport;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $evaluations = Evaluation::query()
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('name', 'like', '%' . $searchTerm . '%');
            })
            // Subquery to check if data exists in factor_student without loading a massive relationship
            ->addSelect(['has_data' => DB::table('factor_student')
                ->selectRaw('1')
                ->whereColumn('evaluation_id', 'evaluations.id')
                ->limit(1)
            ])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return $this->render('evaluations', compact('evaluations', 'searchTerm'));
    }

    public function store(Request $request)
    {
        // Validate that the name is provided and is a string
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Evaluation::create([
            'name' => $request->name,
        ]);

        // Redirect back to the same page with a success message
        return redirect()->back()->with('success', 'Evaluación creada correctamente.');
    }

    public function importExcel(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:10240', // Max 10MB
        ]);

        try {
            Excel::import(new EvaluationImport($evaluation), $request->file('file'));
            return response()->json(['success' => true, 'message' => 'Datos importados y procesados correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al procesar el archivo: ' . $e->getMessage()], 422);
        }
    }

    public function results(Request $request, Evaluation $evaluation)
    {
        // 1. Get the Factors Hashmap (Ordered by Excel Column)
        $factors = $evaluation->factors()->orderBy('excel_column')->get();

        // 2. Capture the return URL, or default back to the index
        $returnTo = $request->query('return_to', route('evaluations.index'));

        // 2. Fetch all raw data using a fast SQL Join
        $rawRecords = DB::table('factor_student')
            ->join('students', 'factor_student.student_id', '=', 'students.id')
            ->where('factor_student.evaluation_id', $evaluation->id)
            ->select('students.id', 'students.student_identifier', 'students.name', 'factor_student.factor_id', 'factor_student.hits')
            ->get();

        // 3. Build the Students Hashmap using Laravel Collections
        $students = $rawRecords->groupBy('id')->map(function ($studentRecords) use ($factors) {
            $first = $studentRecords->first();

            // Creates a simple array of [factor_id => hits]
            $factorHits = $studentRecords->pluck('hits', 'factor_id')->toArray();

            // 4. Calculate Final Score on the fly
            $finalScore = 0;
            foreach ($factors as $factor) {
                $hits = $factorHits[$factor->id] ?? 0;

                // Prevent division by zero
                if ($factor->total_hits > 0) {
                    $weightedScore = ($factor->percentage / 100) * ($hits / $factor->total_hits);
                    $finalScore += $weightedScore;
                }
            }

            // Multiply by 100 to get the final 0-100 scale
            $finalScore *= 100;

            return (object) [
                'identifier' => $first->student_identifier,
                'name' => $first->name,
                'factors' => $factorHits,
                'final_score' => round($finalScore, 2)
            ];
        })->sortBy('name'); // Sort alphabetically by default

        return $this->render('results', compact('evaluation', 'factors', 'students', 'returnTo'));
    }

    public function exportResults(Evaluation $evaluation)
    {
        // We will create this export class in the next step
        return Excel::download(new EvaluationResultsExport($evaluation), 'Resultados_' . $evaluation->name . '.xlsx');
    }
}

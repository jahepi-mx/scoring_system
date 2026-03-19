<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Factor;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    public function index(Request $request, Evaluation $evaluation)
    {
        // Grab the return URL from the query string, or default back to the main index
        $returnTo = $request->query('return_to', route('evaluations.index'));

        // Fetch factors ordered by when they were created
        $factors = $evaluation->factors()->oldest()->get();

        return $this->render('factors', compact('evaluation', 'factors', 'returnTo'));
    }

    public function store(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'excel_column' => 'required|integer|min:1|max:255',
            'total_hits' => 'required|numeric|min:0',
        ]);

        $evaluation->factors()->create($validated);

        return redirect()->back()->with('success', 'Factor agregado correctamente.');
    }

    public function update(Request $request, Evaluation $evaluation, Factor $factor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'excel_column' => 'required|integer|min:1|max:255',
            'total_hits' => 'required|numeric|min:0',
        ]);

        $factor->update($validated);

        return redirect()->back()->with('success', 'Factor actualizado correctamente.');
    }

    public function destroy(Evaluation $evaluation, Factor $factor)
    {
        $factor->delete();

        return redirect()->back()->with('success', 'Factor eliminado correctamente.');
    }
}

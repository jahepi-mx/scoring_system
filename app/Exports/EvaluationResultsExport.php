<?php

namespace App\Exports;

use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EvaluationResultsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $evaluation;
    protected $factors;

    public function __construct(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
        $this->factors = $evaluation->factors()->orderBy('excel_column')->get();
    }

    public function collection()
    {
        $rawRecords = DB::table('factor_student')
            ->join('students', 'factor_student.student_id', '=', 'students.id')
            ->where('factor_student.evaluation_id', $this->evaluation->id)
            ->select('students.id', 'students.student_identifier', 'students.name', 'factor_student.factor_id', 'factor_student.hits')
            ->get();

        $students = $rawRecords->groupBy('id')->map(function ($studentRecords) {
            $first = $studentRecords->first();
            $factorHits = $studentRecords->pluck('hits', 'factor_id')->toArray();

            $finalScore = 0;
            $row = [
                'identifier' => $first->student_identifier,
                'name' => $first->name,
            ];

            foreach ($this->factors as $factor) {
                $hits = $factorHits[$factor->id] ?? 0;
                // Add the hits to this column for the excel sheet
                $row['factor_' . $factor->id] = $hits;

                if ($factor->total_hits > 0) {
                    $weightedScore = ($factor->percentage / 100) * ($hits / $factor->total_hits);
                    $finalScore += $weightedScore;
                }
            }

            $row['final_score'] = round($finalScore * 100, 2);

            return $row;
        })->sortBy('name');

        return collect($students->values());
    }

    public function headings(): array
    {
        $headings = [
            'Matrícula',
            'Nombre',
        ];

        foreach ($this->factors as $factor) {
            $headings[] = $factor->name . ' (' . floatval($factor->percentage) . '%)';
        }

        $headings[] = 'Calificación Final';

        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        // Make the first row (headers) bold
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

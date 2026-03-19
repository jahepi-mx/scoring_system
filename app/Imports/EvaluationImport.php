<?php

namespace App\Imports;

use App\Models\Evaluation;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class EvaluationImport implements ToCollection
{
    protected $evaluation;

    public function __construct(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
    }

    public function collection(Collection $rows)
    {
        // 1. Delete previous data for this evaluation
        DB::table('factor_student')->where('evaluation_id', $this->evaluation->id)->delete();

        // 2. Build the Hashmap (Array Index = excel_column + 1)
        $hashmap = [];
        foreach ($this->evaluation->factors as $factor) {
            $hashmap[$factor->excel_column + 1] = $factor->id;
        }

        $inserts = [];

        // 3. Process row by row
        foreach ($rows as $index => $row) {
            // Skip the header row (row 0)
            if ($index === 0) continue;

            $studentIdentifier = $row[0];
            $studentName = $row[1];

            // Mandatory fields check
            if (empty($studentIdentifier) || empty($studentName)) {
                continue;
            }

            // Find or Create Student
            $student = Student::firstOrCreate(
                ['student_identifier' => $studentIdentifier],
                ['name' => $studentName]
            );

            // Map the factors for this student
            foreach ($hashmap as $colIndex => $factorId) {
                // Read the value, default to 0 if the cell is completely empty
                $hits = isset($row[$colIndex]) ? (float) $row[$colIndex] : 0;

                $inserts[] = [
                    'evaluation_id' => $this->evaluation->id,
                    'student_id' => $student->id,
                    'factor_id' => $factorId,
                    'hits' => $hits,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // 4. Batch Insert (Chunks of 500 to prevent database memory overload on huge files)
        foreach (array_chunk($inserts, 500) as $chunk) {
            DB::table('factor_student')->insert($chunk);
        }
    }
}

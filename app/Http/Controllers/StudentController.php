<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Capture the search term from the URL (e.g., ?search=Javier)
        $searchTerm = $request->input('search');

        $students = Student::query()
            // If there is a search term, filter by the student's name
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('name', 'like', '%' . $searchTerm . '%');
            })
            // Order alphabetically by name
            ->orderBy('name')
            // Paginate with 20 rows per page
            ->paginate(20)
            // This ensures the ?search= parameter stays in the URL when clicking page 2, 3, etc.
            ->withQueryString();

        return $this->render('students', compact('students', 'searchTerm'));
    }
}

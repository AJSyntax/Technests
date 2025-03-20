<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function store(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'location' => 'nullable|string|max:255',
            'order' => 'integer'
        ]);

        $education = $portfolio->education()->create($validated);

        return response()->json($education);
    }

    public function update(Request $request, Portfolio $portfolio, Education $education)
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'location' => 'nullable|string|max:255',
            'order' => 'integer'
        ]);

        $education->update($validated);

        return response()->json($education);
    }

    public function destroy(Portfolio $portfolio, Education $education)
    {
        $this->authorize('update', $portfolio);

        $education->delete();

        return response()->json(['message' => 'Education entry deleted successfully']);
    }

    public function reorder(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'education' => 'required|array',
            'education.*.id' => 'required|exists:education,id',
            'education.*.order' => 'required|integer'
        ]);

        foreach ($validated['education'] as $education) {
            Education::where('id', $education['id'])->update(['order' => $education['order']]);
        }

        return response()->json(['message' => 'Education entries reordered successfully']);
    }
} 
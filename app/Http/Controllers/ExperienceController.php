<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ExperienceController extends Controller
{
    public function index(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $experiences = Cache::remember("portfolio.{$portfolio->id}.experiences", 3600, function () use ($portfolio) {
            return $portfolio->experiences()->orderBy('order')->get();
        });

        return response()->json($experiences);
    }

    public function store(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => [
                'nullable',
                'date',
                'after:start_date',
                Rule::requiredIf(!$request->boolean('is_current'))
            ],
            'is_current' => 'boolean',
            'location' => 'nullable|string|max:255',
            'order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $experience = $portfolio->experiences()->create($validator->validated());

        Cache::forget("portfolio.{$portfolio->id}.experiences");

        return response()->json($experience, 201);
    }

    public function update(Request $request, Portfolio $portfolio, Experience $experience)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => [
                'nullable',
                'date',
                'after:start_date',
                Rule::requiredIf(!$request->boolean('is_current'))
            ],
            'is_current' => 'boolean',
            'location' => 'nullable|string|max:255',
            'order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $experience->update($validator->validated());

        Cache::forget("portfolio.{$portfolio->id}.experiences");

        return response()->json($experience);
    }

    public function destroy(Portfolio $portfolio, Experience $experience)
    {
        $this->authorize('update', $portfolio);

        $experience->delete();

        Cache::forget("portfolio.{$portfolio->id}.experiences");

        return response()->json(['message' => 'Experience deleted successfully']);
    }

    public function reorder(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'experiences' => 'required|array',
            'experiences.*.id' => 'required|exists:experiences,id',
            'experiences.*.order' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($validator->validated()['experiences'] as $experience) {
            Experience::where('id', $experience['id'])->update(['order' => $experience['order']]);
        }

        Cache::forget("portfolio.{$portfolio->id}.experiences");

        return response()->json(['message' => 'Experiences reordered successfully']);
    }

    public function bulkDelete(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'experience_ids' => 'required|array',
            'experience_ids.*' => 'exists:experiences,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Experience::whereIn('id', $validator->validated()['experience_ids'])->delete();

        Cache::forget("portfolio.{$portfolio->id}.experiences");

        return response()->json(['message' => 'Selected experiences deleted successfully']);
    }

    public function search(Request $request, Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $query = $portfolio->experiences();

        if ($request->has('company')) {
            $query->where('company', 'like', "%{$request->company}%");
        }

        if ($request->has('position')) {
            $query->where('position', 'like', "%{$request->position}%");
        }

        if ($request->has('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        if ($request->has('date_range')) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('start_date', [$request->date_range['start'], $request->date_range['end']])
                  ->orWhereBetween('end_date', [$request->date_range['start'], $request->date_range['end']]);
            });
        }

        $experiences = $query->orderBy('order')->paginate($request->per_page ?? 10);

        return response()->json($experiences);
    }
} 
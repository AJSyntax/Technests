<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CertificationController extends Controller
{
    public function index(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $certifications = Cache::remember("portfolio.{$portfolio->id}.certifications", 3600, function () use ($portfolio) {
            return $portfolio->certifications()->orderBy('order')->get();
        });

        return response()->json($certifications);
    }

    public function store(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'issue_date' => 'required|date',
            'expiry_date' => [
                'nullable',
                'date',
                'after:issue_date',
                Rule::requiredIf($request->has('expiry_date'))
            ],
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => [
                'nullable',
                'url',
                'max:255',
                Rule::requiredIf($request->has('credential_id'))
            ],
            'order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $certification = $portfolio->certifications()->create($validator->validated());

        Cache::forget("portfolio.{$portfolio->id}.certifications");

        return response()->json($certification, 201);
    }

    public function update(Request $request, Portfolio $portfolio, Certification $certification)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'issue_date' => 'required|date',
            'expiry_date' => [
                'nullable',
                'date',
                'after:issue_date',
                Rule::requiredIf($request->has('expiry_date'))
            ],
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => [
                'nullable',
                'url',
                'max:255',
                Rule::requiredIf($request->has('credential_id'))
            ],
            'order' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $certification->update($validator->validated());

        Cache::forget("portfolio.{$portfolio->id}.certifications");

        return response()->json($certification);
    }

    public function destroy(Portfolio $portfolio, Certification $certification)
    {
        $this->authorize('update', $portfolio);

        $certification->delete();

        Cache::forget("portfolio.{$portfolio->id}.certifications");

        return response()->json(['message' => 'Certification deleted successfully']);
    }

    public function reorder(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'certifications' => 'required|array',
            'certifications.*.id' => 'required|exists:certifications,id',
            'certifications.*.order' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($validator->validated()['certifications'] as $certification) {
            Certification::where('id', $certification['id'])->update(['order' => $certification['order']]);
        }

        Cache::forget("portfolio.{$portfolio->id}.certifications");

        return response()->json(['message' => 'Certifications reordered successfully']);
    }

    public function bulkDelete(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'certification_ids' => 'required|array',
            'certification_ids.*' => 'exists:certifications,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Certification::whereIn('id', $validator->validated()['certification_ids'])->delete();

        Cache::forget("portfolio.{$portfolio->id}.certifications");

        return response()->json(['message' => 'Selected certifications deleted successfully']);
    }

    public function search(Request $request, Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $query = $portfolio->certifications();

        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->has('issuer')) {
            $query->where('issuer', 'like', "%{$request->issuer}%");
        }

        if ($request->has('date_range')) {
            $query->where(function ($q) use ($request) {
                $q->whereBetween('issue_date', [$request->date_range['start'], $request->date_range['end']])
                  ->orWhereBetween('expiry_date', [$request->date_range['start'], $request->date_range['end']]);
            });
        }

        if ($request->has('expired')) {
            $query->where('expiry_date', '<', now());
        }

        if ($request->has('active')) {
            $query->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>', now());
            });
        }

        $certifications = $query->orderBy('order')->paginate($request->per_page ?? 10);

        return response()->json($certifications);
    }
} 
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOpening;
use Illuminate\Http\Request;

class JobOpeningController extends Controller
{
    public function index()
    {
        $jobOpenings = JobOpening::orderBy('sort_order')->latest()->paginate(25);
        return view('admin.job-openings.index', compact('jobOpenings'));
    }

    public function create()
    {
        return view('admin.job-openings.form', ['jobOpening' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'location'           => 'nullable|string|max:255',
            'type'               => 'required|in:full-time,part-time,contract',
            'description'        => 'nullable|string|max:5000',
            'responsibilities'   => 'nullable|string',
            'requirements'       => 'nullable|string',
            'is_active'          => 'boolean',
            'sort_order'         => 'integer',
        ]);

        $data['responsibilities'] = $this->parseLines($data['responsibilities'] ?? '');
        $data['requirements'] = $this->parseLines($data['requirements'] ?? '');
        $data['is_active'] = $request->boolean('is_active');

        JobOpening::create($data);

        return redirect()->route('admin.job-openings.index')->with('success', 'Job opening created.');
    }

    public function edit(JobOpening $jobOpening)
    {
        return view('admin.job-openings.form', compact('jobOpening'));
    }

    public function update(Request $request, JobOpening $jobOpening)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'location'           => 'nullable|string|max:255',
            'type'               => 'required|in:full-time,part-time,contract',
            'description'        => 'nullable|string|max:5000',
            'responsibilities'   => 'nullable|string',
            'requirements'       => 'nullable|string',
            'is_active'          => 'boolean',
            'sort_order'         => 'integer',
        ]);

        $data['responsibilities'] = $this->parseLines($data['responsibilities'] ?? '');
        $data['requirements'] = $this->parseLines($data['requirements'] ?? '');
        $data['is_active'] = $request->boolean('is_active');

        $jobOpening->update($data);

        return redirect()->route('admin.job-openings.index')->with('success', 'Job opening updated.');
    }

    public function destroy(JobOpening $jobOpening)
    {
        $jobOpening->delete();
        return redirect()->route('admin.job-openings.index')->with('success', 'Job opening deleted.');
    }

    /**
     * Parse newline-separated text into an array, filtering empty lines.
     */
    private function parseLines(?string $text): array
    {
        if (!$text) return [];
        return array_values(array_filter(array_map('trim', explode("\n", $text))));
    }
}

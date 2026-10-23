<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::ordered()->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create', [
            'project' => new Project(),
        ]);
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Project::generateUniqueSlug($data['title']);

        // validated() berisi object file, bukan path. Kita ganti dengan path hasil upload.
        unset($data['image']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('status', 'Project created.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        unset($data['image']);

        // Slug hanya dibuat ulang kalau judul berubah
        if ($data['title'] !== $project->title) {
            $data['slug'] = Project::generateUniqueSlug($data['title'], $project->id);
        }

        $oldImage = null;

        if ($request->hasFile('image')) {
            $oldImage = $project->image;
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($data);

        // Hapus gambar lama SETELAH data baru tersimpan
        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('admin.projects.index')
            ->with('status', 'Project updated.');
    }

        public function destroy(Project $project)
    {
        $image = $project->image;

        $project->delete();

        // Hapus file SETELAH data terhapus dari database
        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return redirect()->route('admin.projects.index')
            ->with('status', 'Project deleted.');
    }
}
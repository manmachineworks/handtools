<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meta;

class PageMetaController extends Controller
{
    public function index()
    {
        $metas = Meta::all();
        return view('admin.metas.index', compact('metas'));
    }

    public function create()
    {
        return view('admin.metas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_slug' => 'required|unique:page_metas',
            'title' => 'nullable|string|max:255',
            'keyword' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Meta::create($request->all());

        return redirect()->route('admin.metas.index')->with('success', 'Meta info added.');
    }

    public function edit(Meta $metas)
    {
        return view('admin.metas.edit', compact('metas'));
    }

    public function update(Request $request, Meta $metas)
    {
        $request->validate([
            'page_slug' => 'required|unique:page_metas,page_slug,' . $metas->id,
            'title' => 'nullable|string|max:255',
            'keyword' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $metas->update($request->all());

        return redirect()->route('admin.metas.index')->with('success', 'Meta updated.');
    }

    public function destroy(Meta $metas)
    {
        $metas->delete();
        return back()->with('success', 'Meta deleted.');
    }
}

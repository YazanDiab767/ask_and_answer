<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollegesController extends Controller
{

    public function index()
    {
        return view('control_panel.colleges',[
            'colleges' => College::orderBy('id', 'DESC')->get()
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
        ]);

        $college = College::create([
            'name' => $request->name,
            'image' => $request->image->store('colleges','public')
        ]);

        return $college;
    }

    public function show(College $college)
    {
        
    }

    public function edit(College $college)
    {
    
    }


    public function update(Request $request, College $college)
    {
        $data = $request->only(['name']);

        if ($request->hasFile('image'))
        {
            $image = $request->image->store('colleges','public');
            Storage::disk('public')->delete($college->image);
            $data['image'] = $image;
        }

        $college->update($data);
        return $college;
    }

    public function destroy(College $college)
    {
        Storage::disk('public')->delete($college->image);
        $college->delete();
    }
}

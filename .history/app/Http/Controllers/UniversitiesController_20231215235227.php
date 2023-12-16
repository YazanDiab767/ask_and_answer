<?php

namespace App\Http\Controllers;

use App\Models\University;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UniversitiesController extends Controller
{


    public function showAll()
    {
        return view('colleges', [
            'colleges' => College::all()
        ]) ;
    }
    
    public function getAllColleges()
    {
        return College::all()->load('courses.questions');
    }

    public function show(College $college)
    {
        return view('courses', [
            'college' => $college,
        ]) ;
    }

    // D A S H - B O A R D
    public function index()
    {
        return view('control_panel.universities',[
            'universities' => University::orderBy('id', 'DESC')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
        ]);

        $college = University::create([
            'name' => $request->name,
        ]);

        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'add',
            'details' => "Added a new university named: " . $request->name
        ]);
        

        return $college;
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

        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'update',
            'details' => "Modified college: " . $college->name  . " to : " . $request->name
        ]);

        $college->update($data);
        return $college;
    }

    public function destroy(College $college)
    {
        Storage::disk('public')->delete($college->image);
        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'delete',
            'details' => 'Deleted college : ' . $college->name
        ]);
        $college->delete();
    }
}


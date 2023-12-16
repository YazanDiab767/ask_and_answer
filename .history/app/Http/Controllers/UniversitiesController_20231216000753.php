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

        $university = University::create([
            'name' => $request->name,
            'add_by' => 'supervsior'
        ]);

        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'add',
            'details' => "Added a new university named: " . $request->name
        ]);
        

        return $university;
    }

    public function update(Request $request, University $university)
    {
        $data = $request->only(['name']);


        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'update',
            'details' => "Modified university: " . $university->name  . " to : " . $request->name
        ]);

        $university->update($data);
        return $university;
    }

    public function approve(Request $request, University $university)
    {
        $data = $request->only(['name']);


        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'update',
            'details' => "Modified university as approved: " . $university->name 
        ]);

        $university->update($data);
        return $university;
    }
    

    public function destroy(University $university)
    {
        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'delete',
            'details' => 'Deleted university : ' . $university->name
        ]);
        $university->delete();
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Operation;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollegesController extends Controller
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
        return view('control_panel.colleges',[
            'colleges' => College::orderBy('id', 'DESC')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'image' => 'required|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        $college = College::create([
            'name' => $request->name,
            'image' => $request->image->store('colleges','public')
        ]);

        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'add',
            'details' => "Added a new college named: " . $request->name
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

    public function getMajors(College $college)
    {
        return $college->majors;
    }

    public function setMajor(Request $request, College $college)
    {
        return Major::create([
            'name' => $request->name,
            'college_id' => $college->id
        ]);
    }

}

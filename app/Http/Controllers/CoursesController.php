<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\College;
use App\Models\Resource;
use Illuminate\Http\Request;

class CoursesController extends Controller
{

    public function index()
    {
        $courses = '';
        if ( College::count() )
        {
            $id = College::all()->first()->id;
            $courses = College::find( $id )->courses()->get() ;
        }
        
        return view('control_panel.courses',[
            'colleges' => College::all() ,
            'courses' => $courses
        ]);
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        if ($request->ajax())
        {
            $course = Course::create([
                'college_id' => $request->college_id ,
                'name' => $request->name
            ]);

            return $course;
        }
    }

    public function show(Course $course)
    {
    }

    public function edit(Course $course)
    {
    }

    public function update(Request $request, Course $course)
    {
        if ($request->ajax())
        {
            $course->name = $request->name;
            $course->college_id = $request->college_id;
            $course->save();
            return $course;
        }
    }

    public function destroy(Course $course)
    {
        if ($request->ajax())
        {
            $course->delete();
        }
    }



    //set new resource
    public function setResource(Request $request , $course_id)
    {
        if ($request->ajax())
        {
            $request->validate([
                'course_id' => 'required',
                'title' => 'required',
                'file' => 'required|file|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip'
            ]);
            
            $resource = Resource::create([
                'user_id' => auth()->user()->id,
                'course_id' => $course_id,
                'title' => $request->title,
                'file' => $request->file->store('resources','public')
            ]);

            return $resource;
        }
    }    

    //get resources for a certain course
    public function getResources(Request $request , $course_id)
    {
        if ($request->ajax())
        {
            $resources = Resource::where('course_id',$course_id)->get();
            return $resources;
        }
    }

    //delete resource
    public function deleteResource(Request $request , Resource $resource)
    {
        if ($request->ajax())
        {
            Storage::disk('public')->delete($resource->file);
            $resource->delete();
        }
    }
}
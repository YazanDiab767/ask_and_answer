<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\College;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class CoursesController extends Controller
{

    public function index()
    {
        $courses = '';
        if ( College::count() )
        {
            $id = College::all()->first()->id;
            $courses = College::find( $id )->courses()->orderBy('id', 'DESC')->get();
        }
        
        return view('control_panel.courses',[
            'colleges' => College::all() ,
            'courses' => $courses
        ]);
    }

    public function getCoursesCollege($college_id)
    {
        return Course::where('college_id',$college_id)->get();
    }


    public function create()
    {
    }

    public function store(Request $request)
    {
        if ($request->ajax())
        {
            $validated = $request->validate([
                'name' => 'required|min:3|max:255',
            ]);

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
 
        $course->delete();
        
    }



    //set new resource
    public function setResource(Request $request , $course_id)
    {
        if ($request->ajax())
        {
            $request->validate([
                'title' => 'required',
                'file' => 'required|file|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip'
            ]);
            
            $resource = Resource::create([
                'user_id' => auth()->user()->id,
                'course_id' => $course_id,
                'title' => $request->title,
                'file' => $request->file->store('resources','public')
            ]);

            return DB::table('resources')
                ->where('course_id',$course_id)
                ->where('resources.id',$resource->id)
                ->leftJoin('users', 'users.id', '=', 'resources.user_id')
                ->get(['resources.*','users.name']);
        }
    }    

    //get resources for a certain course
    public function getResources(Request $request , $course_id)
    {
        if ($request->ajax())
        {
            // $resources = Resource::where('course_id',$course_id)->get()->friends();
           $resources = DB::table('resources')
            ->where('course_id',$course_id)
            ->leftJoin('users', 'users.id', '=', 'resources.user_id')
            ->get(['resources.*','users.name']);
            return $resources;
        }
    }

    //delete resource
    public function deleteResource(Resource $resource)
    {
        Storage::disk('public')->delete($resource->file);
        $resource->delete();
        
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\College;
use App\Models\Resource;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class CoursesController extends Controller
{

    
    public function show(Course $course)
    {
        return view('course',[
            'course' => $course
        ]);
    }

    // add course to user
    public function addUserCourses(Request $request)
    {
        if ($request->ajax())
        {
            $user = User::find( auth()->user()->id );
            if ( ! isset ( $request->courses ) )
            {
                $user->courses = '';
            } else if ( count ( $request->courses ) <= 10 ) {
                $user->courses = implode(',' , $request->courses);
            }
            $user->save();
        }
    }

    // D A S H - B O A R D

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

            Operation::create([
                'user_id' => auth()->user()->id,
                'type' => 'add',
                'details' => "Added a new course named: " . $request->name
            ]);

            

            return $course;
        }
    }

    public function update(Request $request, Course $course)
    {
        if ($request->ajax())
        {
            $course->name = $request->name;
            $course->college_id = $request->college_id;
            $course->save();
        
            Operation::create([
                'user_id' => auth()->user()->id,
                'type' => 'update',
                'details' => "Modified course: " . $course->name  . " to : " . $request->name
            ]);
    

            return $course;
        }
    }

    public function destroy(Course $course)
    {
        
        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'delete',
            'details' => 'Deleted course : ' . $course->name
        ]);
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

            Operation::create([
                'user_id' => auth()->user()->id,
                'type' => 'add',
                'details' => ' Added new resource: ' . $request->title . ' to course:' . $resource->course->name
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
        Operation::create([
            'user_id' => auth()->user()->id,
            'type' => 'delete',
            'details' => ' Deleted resource : ' . $resource->title . ' in course : ' . $resource->course->name
        ]);
        $resource->delete();
        
    }
}
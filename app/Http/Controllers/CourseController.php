<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseEpisodeRequest;
use App\Http\Requests\UpdateCourseEpisodeRequest;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::with('user')->select('courses.*', DB::raw(
        '(SELECT COUNT(DISTINCT(user_id)) FROM completions 
        INNER JOIN episodes ON completions.episode_id = episodes.id 
        WHERE episodes.course_id = courses.id) 
        AS participants'
        ))->withCount('episodes')->latest()->paginate(5);
        $user = auth()->user();
        return Inertia::render('Courses/Index', compact('courses', 'user'));
    }

    public function create() {
        return Inertia::render('Courses/Add');
    }

    public function store(StoreCourseEpisodeRequest $request) {
        $course = Course::create($request->all());
        foreach($request->episodes as $episode) {
            $episode['course_id']  = $course->id;
            Episode::create($episode);
        }
        return Redirect::route('dashboard')->with('message', 'Course created successfuly!');
    }

    public function show($id) {
        $course = Course::with('episodes')->with('user')->withCount('episodes')->findOrFail($id);
        $watched = auth()->user()->episodes;
        return Inertia::render('Courses/Show', compact('course', 'watched'));
    }

    public function edit($id) {
        $course = Course::where('id', $id)->with('episodes')->first();
        $this->authorize('update', $course);
        return Inertia::render('Courses/Edit', compact('course'));
    }

    public function update(UpdateCourseEpisodeRequest $request, $id) {
        $course = Course::where('id', $id)->with('episodes')->first();
        $this->authorize('update', $course);
        $course->update([
            'title'=>$request->title,
            'description'=>$request->description
        ]);
        $course->episodes()->delete();
        foreach($request->episodes as $episode) {
            $episode['course_id'] = $course->id ;
            Episode::create($episode);
        }
        return redirect()->back()->with('message', 'Course updated!');
    }

    public function toggleProgress(Request $request) {
        $user = auth()->user();
        $episodeId = $request->episodeId;
        $user->episodes()->toggle($episodeId);
        return $user->episodes;
    }
}

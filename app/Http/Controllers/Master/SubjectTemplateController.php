<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\SubjectTemplate;
use App\Models\TranscriptTemplate;
use Illuminate\Support\Facades\Validator;

class SubjectTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Master/SubjectTemplate',[
            'gradeCategories'=>json_decode(Config::where('key','grade_categories')->first()->value),
            'subjects'=>SubjectTemplate::all(),
            'subjectTypes'=>json_decode(Config::where('key','subject_types')->first()->value),
            'studyStreams'=>json_decode(Config::where('key','study_streams')->first()->value),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'code' => ['required'],
        ])->validate();

        $subject=new SubjectTemplate;
        $subject->code=$request->code;
        $subject->title_zh=$request->title_zh;
        $subject->title_en=$request->title_en;
        $subject->type=$request->type;
        $subject->stream=$request->stream;
        $subject->elective=$request->elective;
        $subject->description=$request->description;
        $subject->grades=$request->grades;
        $subject->version=$request->version;
        $subject->active=$request->active;
        $subject->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'code' => ['required'],
        ])->validate();
        if($request->has('id')){
            $subject=SubjectTemplate::find($id);
            $subject->code=$request->code;
            $subject->title_zh=$request->title_zh;
            $subject->title_en=$request->title_en;
            $subject->type=$request->type;
            $subject->stream=$request->stream;
            $subject->elective=$request->elective;
            $subject->description=$request->description;
            $subject->grades=$request->grades;
            $subject->version=$request->version;
            $subject->active=$request->active;
            $subject->save();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
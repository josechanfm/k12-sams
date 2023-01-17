<?php

namespace App\Http\Controllers\Essential;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Config;
use App\Models\Klass;
use App\Models\Year;
use App\Models\Grade;
use App\Models\Disciplines;
use Illuminate\Support\Facades\Validator;

class KlassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->yearId){
            $year=Year::find($request->yearId);
        }else{
            $year=Year::where('active',1)->first();
        }
        //$data = Klass::with('grade')->paginate(100);
        $klasses=$year->klasses;
        $grades=Grade::whereBelongsTo($year)->get();
        // echo json_encode($grades);
        // return true;
        //$data=Klass::where('year_id',1)->paginate(5);
        //return response()->json($data);
        return Inertia::render('Essential/Klasses',[
            'selected_year'=>Year::find($year->id),
            'klasses'=>$klasses,
            'school_years'=>Year::get(),
            'klass_letters'=>json_decode(Config::where('key','klass_letters')->first()->value),
            'grades'=>$grades
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
            'grade_id' => ['required'],
            'letter' => ['required'],
        ])->validate();
            $klass=new Klass;
            $klass->grade_id=$request->grade_id;
            $klass->letter=$request->letter;
            $klass->room=$request->room;
            $klass->tag=Grade::find($request->grade_id)->tag.$request->letter;
            $klass->save();
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
        $data=Klass::find($id);
        return response()->json($data);
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
            'grade_id' => ['required'],
            'letter' => ['required'],
        ])->validate();
        
        if($request->has('id')){
            $klass=Klass::find($id);
            $klass->grade_id=$request->grade_id;
            $klass->letter=$request->letter;
            $klass->room=$request->room;
            $klass->tag=Grade::find($request->grade_id)->tag.$request->letter;
            $klass->save();
            //return response()->json($klass);
            return redirect()->back();
            //return redirect()->back();
            //return redirect()->route('settings');
        }else{
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $klass=Klass::find($id);
        if($klass){
            $klass->delete();
            return redirect()->back()
                ->with('message', 'Blog Delete Successfully');

        }
        
    }

    public function disciplines($klassId){
        $klass=Klass::find($klassId);
        $disciplines=$klass->subjects;
        // foreach($klass as $subject){
        //     echo $subject->subjects()->get();
        //     echo '<hr>';
        // }
        //return response()->json($klass);
        return Inertia::render('Admin/Klass_disciplines',[
            'klass'=>$klass,
            'disciplines'=>$disciplines,
        ]);

    }

}

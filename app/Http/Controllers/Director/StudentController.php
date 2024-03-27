<?php

namespace App\Http\Controllers\Director;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\StudentDetail;
use App\Models\Klass;
use App\Models\Relative;
use App\Models\Year;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finder(){
        // $student=Student::find(319);
        // dd($student->relatives());
        // $students=Student::where('id',319)->with('klasses')->with('guardiansWithRelatives')->get();
        // dd($students);
        return Inertia::render('Director/Students',[
            'students'=>Student::all()
        ]);
    }
    public function search(Request $request){
        //return response()->json($request->all());
        //return response()->json("UPPER({$request->column}) LIKE '%".strtoupper($request->content)."%'");
        //return response()->json("{$request->column} LIKE '%{$request->content}%'");
        //$students=Student::all();
        //dd("UPPER('{$request->column}') LIKE '%'");

        switch($request->column){
            case 'name_zh':
                $students=Student::whereRaw(
                    "{$request->column} LIKE '%{$request->content}%'"
                )->with('klasses')->with('guardiansWithRelatives')->get();
                break;
            case 'name_fn':
                $students=Student::whereRaw(
                    "UPPER({$request->column}) LIKE '%".strtoupper($request->content)."%'"
                )->with('klasses')->with('guardians')->get();
                break;
        }
        return response()->json($students);
        
    }

    public function index(Klass $klass, Request $request)
    {
        if($klass->id==null){
            return Inertia::render('Director/Students',[
                'students'=>Student::all()
            ]);
        };
        //$students=Student::paginate(10);
        return Inertia::render('Director/KlassStudents', [
            'klass' => $klass,
            'students' => $klass->studentsWithAvatar(),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //$student->with('address')->with('identity_document')->with('bank')->with('detail')->with('parent')->with('guardian');
        $student->detail;
        $student->address;
        $student->health;
        $student->identity_document;
        $student->bank;
        $student->relatives;
        $student->guardians;
        $student->archives=$student->archives();
        $student->avatars=$student->avatars();
        return Inertia::render('Director/StudentProfile',[
            'student'=>$student
        ]);
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
    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        Relative::upsert(
            $request->relatives,
            uniqueBy:['id'],
            update:['relation','kinship','name_zh','name_fn','birth_year','occupation','mobile']
        );

        if(isset($request->address['id'])){
            $student->address->update($request->address);
        }else{
            $student->address()->create($request->address);
        }
        if(isset($request->bank['id'])){
            $student->bank->update($request->bank);
        }else{
            $student->bank()->create($request->bank);
        }
        

        if(isset($request->detail['id'])){
            $student->detail->update($request->detail);
        }else{
            $student->detail()->create($request->detail);
        }
        if(isset($request->health['id'])){
            $student->health->update($request->health);
        }else{
            $student->health()->create($request->health);
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

    public function getByKlassId(Klass $klass){
        $students=$klass->students;
        foreach($students as $i=>$student){
            $students[$i]->klass=$student->klasses()->latest()->first();
        }
        return response()->json($students);
    }
    public function getByNames(Request $request){
        //$students=Student::whereIn('name_zh',$request->all())->get();
        //return response()->json($request->all());
        $tmpStudents=Year::currentYear()->students->whereIn('name_zh',$request->all());
        //dd($students);
        foreach($tmpStudents as $std){
            $students[]=$std;
        }
        foreach($students as $i=>$student){
            $students[$i]->klass=$student->klasses()->latest()->first();
        }
        return response()->json($students);
    }

}

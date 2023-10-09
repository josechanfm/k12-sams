<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klass extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    use HasFactory;
    protected $fillable=['grade_id','initial','tag','room'];
    protected $casts=['klass_head_ids'=>'json'];
    // public function subjects(){
    //     return $this->belongsToMany(Subject::class);
    // }
   
    protected $appends= ['klass_heads','course_count','student_count','promoted_count','year_code','grade_year'];
    
    public function hasRight(){
        if(auth()->user()->hasRole('master') || auth()->user()->hasRole('admin')){
            return true;
        }
        return false;
    }
    public function isKlassHead(){
        if(empty(auth()->user()->staff)){
            return false;
        }
        if(is_array($this->klass_head_ids)){
            return in_array(auth()->user()->staff->id,$this->klass_head_ids);
        }else{
            return false;
        }
        
    }

    public function getKlassHeadsAttribute(){
        if(is_array($this->klass_head_ids)){
            return Staff::whereIn('id',$this->klass_head_ids)->get();
        };
        return [];
    }
    public function getGradeYearAttribute(){
        return Grade::find($this->grade_id)->grade_year;
    }
    public function getYearCodeAttribute(){
        return Grade::find($this->grade_id)->year->code;
    }
    public function getCourseCountAttribute(){
        return Course::where('klass_id',$this->id)->count();
    }
    public function getStudentCountAttribute(){
        return KlassStudent::where('klass_id',$this->id)->count();
    }
    public function getPromotedCountAttribute(){
        return KlassStudent::where('promote_to',$this->id)->count();
    }
    public function grade(){
        return $this->belongsTo(Grade::class)->with('themes');
    }
    public function students(){
        return $this->belongsToMany(Student::class)
                ->withPivot(['id as pivot_klass_student_id','student_number','stream','state','promote','promote_to']);
    }
    public function behaviours($actor='KLASS_HEAD'){
        $students=$this->students;
        $terms=Config::item('year_terms');
        $staff=auth()->user()->staff;
        //$actor="KLASS_HEAD";
        $klass=$this;

        $referenceId=$this->id;
        collect($students)->map(function($student) use($terms,$staff,$klass, $referenceId, $actor){
            //$klassStudentId=KlassStudent::where('klass_id',$klass->id)->where('student_id',$student->id)->pluck('id')->first();
            $student->behaviours=$student->getBehaviours($student->pivot->klass_student_id, $staff, $terms, $referenceId , $actor);
        });
        return $students;
    }
    public function behaviourSummary(){
        $students=$this->students;
        $terms=Config::item('year_terms');
        $klass=$this;
        //course teacher behaviours scores
        $actor='SUBJECT';
        foreach($students as $student){
            $tmpTerms=[];
            $tmp=[];
            foreach($this->courses as $course){
                $referenceId=$course->id;
                $tmp[$course->id]=array_column(
                    Behaviour::selectRaw('term_id, round(avg(score),0) as score_total')->where('klass_student_id',$student->pivot->klass_student_id)->where('actor',$actor)->where('reference_id',$course->id)->groupBy('term_id','reference_id')->get()->toArray(),
                    null,
                    'term_id'
                );
            };
            $student->courseTeachers=$tmp;
        }
        //Klass Head behaviours scores
        $actor='KLASS_HEAD';
        foreach($students as $student){
            $tmp=[];
            $student->klassHeads=array_column(
                Behaviour::selectRaw('term_id, round(avg(score),0) as score_total')->where('klass_student_id',$student->pivot->klass_student_id)->where('actor',$actor)->where('reference_id',$this->id)->groupBy('term_id','reference_id')->get()->toArray(),
                null,
                'term_id'
            );
        }
        //Director behaviours scores
        $actor='DIRECTOR';
        $referenceId=$this->id;
        $staff=auth()->user()->staff;
        foreach($students as $student){
            $student->director=$student->getBehaviours($student->pivot->klass_student_id, $staff, $terms, $referenceId , $actor);
        }
        //Director behaviours adjustment
        $actor='ADJUST';
        $referenceId=$this->id;
        $staff=auth()->user()->staff;
        foreach($students as $student){
            $student->adjust=$student->getBehaviours($student->pivot->klass_student_id, $staff, $terms, $referenceId , $actor);
        }

        foreach($students as $student){
            foreach($terms as $term){
                $termSum[$term->value]=0;
                $coursesSum=0;
                //dd($termSum);
                foreach($student->courseTeachers as $course){
                    if(isset($course[$term->value])){
                        $coursesSum+=$course[$term->value]['score_total'];
                    }
                }
                $termSum[$term->value]=$coursesSum*$this->grade->behaviour_scheme['SUBJECT'];

                if(isset($student->klassHeads[$term->value])){
                    $termSum[$term->value]+=$student->klassHeads[$term->value]['score_total']*$this->grade->behaviour_scheme['KLASS_HEAD'];
                }
                if(isset($student->director[$term->value])){
                    $termSum[$term->value]+=$student->director[$term->value]['score']*$this->grade->behaviour_scheme['DIRECTOR'];
                }
                if(isset($student->adjust[$term->value])){
                    $termSum[$term->value]+=$student->adjust[$term->value]['score']*$this->grade->behaviour_scheme['ADJUST'];
                }
            }
            $student->sumTerms=$termSum;
        }


        return $students;
    }
    public function promoteTo(){
        return $this->belongsToMany(Student::class,'klass_student','promote_to','student_id')->withPivot(['id as pivot_klass_student_id','student_number','stream','state','promote','promote_to','id as pivot_klass_id']);
    }
    public function courses(){
        return $this->hasMany(Course::class)->with('scoreColumns');
    }
    public function info(){
        return (object)["head"=>"123","subject_head"=>"567"];
    }

    public function coursesStudents(){
        return $this->hasMany(Course::class)->with('students');
    }
    public function coursesScores(){
        return $this->hasMany(Course::class)->with('allScores');
    }
    public function transcriptCoursesScores(){
        return $this->hasMany(Course::class)->where('in_transcript',1)->with('allScores');
        // return $this->hasMany(Course::class)->with('scores')->with('students');
    }
    // public function outcomes(){
    //     return $this->hasManyThrough(Outcome::class, KlassStudent::class,'klass_id', 'klass_student_id')->with('student');
    // }
    public function students_abilities(){
        return $this->belongsToMany(Student::class)->with('abilities')->withPivot('id as pivot_klass_student_id');
    }

    public function themes(){
        return $this->belongsToMany(Theme::class,'grades','id','grade_year','grade_year','grade_year');
    }

    // public static function klass_scores($klassId){
    //     $students=Klass::find($klassId)->students;
    //     foreach($students as $i=>$student){
    //         $student->scores=Score::where('klass_student_id',$student->pivot->klass_student_id)->get();
    //     }
    //     return $students;
    // }
    public function finalScores(){
        //passing score with reference_code "passing" in transcript_templates
        $passing=$this->grade->passingScore();
        $coursesScores = $this->transcriptCoursesScores; //all Courses in transcript with scores
        $students = $this->students; //all student in the klass
        $courses = $this->courses->where('in_transcript', 1); //all Courses in the klass with score_columns
        //rebuild all scores in an array, index with student_id, course_id and score_column_id
        $tmpScores = [];
        foreach ($coursesScores as $course) {
            foreach ($course->allScores as $score) {
                $tmpScores[$score->student_id][$course->id][$score->score_column_id] = $score->point;
            }
        }
        //generate student list with personal info required in transcript
        //loop all scores in term_id==9 in all courses and put it in student array list
        $transcripts = [];
        $scoreColumns = [];
        foreach ($students as $student) {
            $tmp = [
                'student_id' => $student->id,
                'student_name' => $student->name_zh,
                'klass_student_id' => $student->pivot->klass_student_id,
                'fail_units'=>0,
            ];
            foreach ($courses as $course) {
                $scoreColumn = $course->scoreColumns->where('term_id', 9)->first();
                //$transcript[]['scores'][$scoreColumnId]=$tmpScores[$student->id][$course->id][$scoreColumnId];
                if (isset($tmpScores[$student->id][$course->id])) {
                    $tmp['scores'][$scoreColumn->id] = $tmpScores[$student->id][$course->id][$scoreColumn->id];
                    //count number of failed units
                    if($tmpScores[$student->id][$course->id][$scoreColumn->id]<=$passing){
                        $tmp['fail_units']++;
                    }
                } else { //if the student is not in the course
                    $tmp['scores'][$scoreColumn->id] = '--';
                }
                $scoreColumn['course_code'] = $course->code;
                $scoreColumn['course_title'] = $course->title_zh;
                $scoreColumn['course_unit'] = $course->unit;
                $scoreColumn['makeups']=$course->studentsMakeups();
                $scoreColumns[$scoreColumn->id] = $scoreColumn;
            }
            $transcripts['students'][] = $tmp;
        }
        $transcripts['score_columns']=$scoreColumns;
        return $transcripts;
    }

    public function additives($category=null,$termId=null){
        $students=$this->students;
        if($category==null){
            $templates=AdditiveTemplate::all()->toArray();
        }else{
            $templates=AdditiveTemplate::where('category',$category)->get()->toArray();
        }
        
        $data=[];
        foreach($students as $student){
            $data['students'][$student->id]['name_zh']=$student->name_zh;
            $data['students'][$student->id]['klass_student_id']=$student->pivot->klass_student_id;
            foreach($templates as $template){
                $data['students'][$student->id]['additives'][$template['reference_code']]=null;
            }
            $additives=Additive::where('klass_student_id',$student->pivot->klass_student_id)
                                ->whereIn('reference_code',array_keys($data['students'][$student->id]['additives']))
                                ->get();
            $data['students'][$student->id]['records']=$additives;
            foreach($additives as $additive){
                if(array_key_exists($additive->reference_code, $data['students'][$student->id]['additives'])){
                    $data['students'][$student->id]['additives'][$additive->reference_code]+=$additive->value;
                }
            }
        };
        //$templates=AdditiveTemplate::all()->toArray();
        $data['templates']=array_column($templates,null,'reference_code'); 
        // dd($data);
        return $data;
    }


}

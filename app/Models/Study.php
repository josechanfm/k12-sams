<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    use HasFactory;

    public function subjects(){
        return $this->belongsToMany(Subject::class)->withPivot('stream','elective');
    }
    static function versions(){
        //$versions=Study::select('version as value','version as label')->groupBy('version')->get();
        $versions=Study::select('version as value')->groupBy('version')->get();
        $versions[]=["value"=>$versions->count()+1];
        return $versions;
    }
}

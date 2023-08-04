<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    use HasFactory;
    
    protected $casts=['subject_head_ids'=>'array'];

    public function grade(){
        return $this->belongsTo(Grade::class);
    }
    public function study(){
        return $this->belongsToMany(Study::class)->withPivot('subject_head_ids');
    }
}

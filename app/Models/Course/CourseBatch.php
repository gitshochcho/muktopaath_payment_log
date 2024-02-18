<?php

namespace App\Models\Course;

use App\Models\Myaccount\InstitutionInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseBatch extends Model
{
    use HasFactory;
    protected $connection = 'mysql_course';
    protected $table = 'muktopaath_v3_course.course_batches';



    public function institutionInfo(){
    	return $this->belongsTo(InstitutionInfo::class,'owner_id','id');
    }
}

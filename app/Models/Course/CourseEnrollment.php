<?php

namespace App\Models\Course;

use App\Models\Myaccount\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;
    protected $connection = 'mysql_course';
    protected $table = 'muktopaath_v3_course.course_enrollments';

    public function courseBatch(){
    	return $this->belongsTo(CourseBatch::class);
    }

    public function  order() {
        return $this->belongsTo(Order::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}

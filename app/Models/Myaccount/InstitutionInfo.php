<?php

namespace App\Models\Myaccount;

use App\Models\Course\CourseBatch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionInfo extends Model
{
    use HasFactory;
    protected $connection = 'mysql_account';
    protected $table = 'institution_infos';

    public function courseBatche(){
    	return $this->hasMany(CourseBatch::class,'owner_id','id');
    }
}

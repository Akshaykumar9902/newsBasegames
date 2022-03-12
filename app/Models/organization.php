<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\institution;
use OwenIt\Auditing\Contracts\Auditable;

class organization extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    

    protected $fillable = [
        'id','trust_name','gst_no','pincode','taluk','district','created_by','status','state','address1','address2','office_tel1','office_tel2','office_email1','office_email2',

    ];

    public function institution(){
        return $this->hasOne(institution::class,'organization_id','id');
    }
    public function institutions(){
        return $this->hasMany(institution::class,'organization_id','id');
    }
}

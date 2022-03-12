<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\organization;
use OwenIt\Auditing\Contracts\Auditable;


class institution extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    

    protected $table='institutions';

    protected $fillable = [
        'id', 'name','organization_id','logo','fav_icon','timezone','currency','name','board_name','created_by','status','pincode','taluk','district','state','address1','address2','office_tel1','office_tel2','office_email1','office_email2', 'created_by','status','modified_by','post_office',
        'created_at','updated_at',
    ];

    public function organization(){
        return $this->belongsTo(organization::class,'organization_id','id');
    }
}

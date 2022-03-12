<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\institution;
use App\Models\organization;
use Illuminate\Support\Facades\Http;


class OrganizationController extends Controller
{
    public function GetOrganizationWithId($id)
    {
        
        $org = organization::find($id);
        
        echo json_encode($org);
    }
    public function GetAllOrganization(Request $request)
    {
        $org = organization::all()->sortByDesc("id");

        echo json_encode($org);
    }
    public function OrganizationUpdate(Request $request)
    {
        $id = $request->id;
        $org = organization::find($id);
        $org->name = $request->name;
        $org->address1 = $request->address1;
        $org->save();


        echo json_encode($org);
    }
    public function OrganizationDelete($id)
    {
       
        $org = organization::find($id);

        $org->delete();
    }
    public function OrganizationInsert(Request $request)
    {

        $org = new organization;
        $org->name = $request->name;
        $org->address1 = $request->address1;
        $org->save();


        echo json_encode($org);
    }

    public function hasOne(Request $request)
    {
        $id = $request->id;
        $org = organization::find($id);
        //dd($Inst);
        echo json_encode($org->institution->get());
    }
    public function belongsTo()
    {
        $inst = institution::all();
        foreach ($inst as $value) {
            echo json_encode($value->name) . ' : ';
            echo json_encode($value->organization->trust_name) . '<br>';
        }
    }
    public function EagerLoadingOrganization(Request $request)
    {
        $org = institution::with('organization')->get();

        echo json_encode($org);
    }

    public function HasMany(Request $request)
    {
        $org = organization::with('institutions')->get();

        echo json_encode($org);
    }
    public function InstitutionWithorganizationId($id)
    {
        
        $org = organization::find($id);
        $org = $org->with('institutions')->get();

        echo json_encode($org);
    }
}

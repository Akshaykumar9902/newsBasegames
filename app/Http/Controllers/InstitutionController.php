<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\institution;
use Illuminate\Support\Facades\Http;

class InstitutionController extends Controller
{
    public function GetInstitutionWithId($id){
       
      $Inst=institution::find($id);
      
     echo json_encode($Inst);

    }
    public function GetAllInstitution(){
        $Inst=institution::all()->sortByDesc("id");
        
       echo json_encode($Inst);
  
      }
      public function InstitutionUpdate(Request $request){
          
        $id=$request->id;
      $Inst=institution::find($id);
      $Inst->name=$request->name;
      $Inst->address1=$request->address1;
      
      $Inst->save();

      
     echo json_encode($Inst);

  
      }
      public function InstitutionDelete($id){
        // $id=$request->id;
      $Inst=institution::find($id);
      
      $Inst->delete();


  
      }
      public function InstitutionInsert(Request $request){
        
      $Inst= new institution;
      $Inst->name=$request->name;
      $Inst->address1=$request->address1;
      $Inst->save();

      
     echo json_encode($Inst);

  
      }
      
      
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;

class ProjectController extends Controller{
   public function index(Request $req){
        return view('project/editproject');
   }
   public function viewproject(Request $req){
        return view('project/viewproject');
   }
   public function create(Request $request){
     $project = new Project;
     $project->uniq_id = uniqid();
     $project->user_id = $request->session()->get('unid');
     $project->description = $request->description;
     $project->technologies = $request->technologies;
     $project->topic = $request->topic;

     if($project->save()){
          return redirect('home')->withSuccess("Project successfully created");
     }else{
          return redirect('home')->withError("Error occured");
     }
   }
   public function editproject($id){
     $project = Project::where('uniq_id',$id)->first();
     //var_dump($project[0]);die();
     return view('project/editproject',["project"=>$project]);
   }
}

<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\Projects;
use App\ProjectTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $sort_by = "";
        $search_text = "";
        $search_by = "";

        //Pagination show entry
        if (isset($request->paginate_show)) {
            $paginate_show = $request->paginate_show; //Set dynamic value
        } else {
            $paginate_show = 10; //Set Default value
        }

        //project search
        if ($request->search_text && $search_by = $request->search_by) { //Search

            $search_text = $request->search_text;
            $search_by = $request->search_by;

            if ($request->sort_by) { //Search & Sort
                $sort_by = $request->sort_by; //Set sort by

                //Get projects based on search and sort
                $projects = Projects::where($search_by, 'like', '%' . $search_text . '%')->orderBy($sort_by)->paginate($paginate_show);
            } else {
                //Get projects based on only search
                $projects = Projects::where($search_by, 'like', '%' . $search_text . '%')->paginate($paginate_show);
            }

        } elseif ($request->sort_by) { //Sort
            //project sort
            $sort_by = $request->sort_by;

            $projects = Projects::orderBy($sort_by)->paginate($paginate_show);
        } else {
            //Get projects based on default pagination on page load
            $projects = Projects::paginate($paginate_show);
        }

        $data = array('id' => '', 'manager_id' => '', 'project_type' => '', 'project' => '', 'description' => '', 'deadline' => '', 'active' => 'Y');

        $data['project_types'] = ProjectTypes::orderBy('project_types')->pluck('project_types', 'id')->toArray();
        $data['managers'] = User::select(\DB::raw("CONCAT(last_name,', ',first_name) AS name , id"))->onlyManager()->pluck('name', 'id')->toArray();

        $data['current_user_id'] = $current_user_id = Auth::user()->id;

        $data['active'] = ['Y' => 'Yes', 'N' => 'No'];

        //Return View
        return view('projects.grid', compact('projects'))
            ->with('sort_by', $sort_by)
            ->with('search_text', $search_text)
            ->with('paginate_show', $paginate_show)
            ->with('search_by', $search_by)
            ->with('data', $data);
    }

    public function save_project(Request $request)
    {
        $data = $request->input();
        $old_manager_id = '';
        // see if this is an existing project; if it is, locate the record and update it
        if ($data['id']) {
            $project = Projects::find($data['id']);
            $old_manager_id = $project->manager_id;
            $success = 'project successfully edited!';
            $failure = 'Unable to edit project!  Please try again.';
            $action = "edit";
        } else {
            $project = new Projects;
            $success = 'project successfully added!';
            $failure = 'Unable to add project!  Please try again.';
            $action = "add";
        }

        $ret = $project->forceFill([
            'manager_id' => $data['manager_id'],
            'project_type' => $data['project_type'],
            'project' => $data['project'],
            'description' => $data['description'],
            'deadline' => $data['deadline'],
            'active' => $data['active'],
        ])->save();

        if ($ret) {
            //Add / update team

            if ($old_manager_id) {
                $findTeam = Team::where('user_id', $old_manager_id)->where('project_id', $project->id)->first();
                if (!$findTeam) {
                    $findTeam = new Team;
                }
                $findTeam->project_id = $project->id;
                $findTeam->user_id = $data['manager_id'];
                $findTeam->save();
            } else {
                $findTeam = new Team;
                $findTeam->project_id = $project->id;
                $findTeam->user_id = $data['manager_id'];
                $findTeam->save();
            }
            \Session::flash('alert-success', $success);
        } else {
            \Session::flash('alert-danger', $failure);
        }

        return redirect()->route('projects');
    }

    public function destroy($id)
    {
        $response = Projects::destroy($id);

        if ($response) {
            \Session::flash('alert-success', "Project successfully deleted!");
            return redirect()->route('projects');
        } else {
            \Session::flash('alert-danger', 'Unable to delete project!  Please try again.');
        }
    }
}

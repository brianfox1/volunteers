<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamsController extends Controller
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

        //team search
        if ($request->search_text && $search_by = $request->search_by) { //Search

            $search_text = $request->search_text;
            $search_by = $request->search_by;

            if ($request->sort_by) { //Search & Sort
                $sort_by = $request->sort_by; //Set sort by

                //Get teams based on search and sort
                $teams = Team::where($search_by, 'like', '%' . $search_text . '%')->orderBy($sort_by)->paginate($paginate_show);
            } else {
                //Get teams based on only search
                $teams = Team::where($search_by, 'like', '%' . $search_text . '%')->paginate($paginate_show);
            }

        } elseif ($request->sort_by) { //Sort
            //team sort
            $sort_by = $request->sort_by;

            $teams = Team::orderBy($sort_by)->paginate($paginate_show);
        } else {
            //Get teams based on default pagination on page load
            $teams = Team::paginate($paginate_show);
        }

        $data = array('project_id' => '', 'user_id' => '');

        $data['projects'] = Projects::orderBy('project')->pluck('project', 'id')->toArray();
        $data['managers'] = User::select(\DB::raw("CONCAT(last_name,', ',first_name) AS name , id"))->onlyManager()->pluck('name', 'id')->toArray();

        $data['current_user_id'] = $current_user_id = Auth::user()->id;

        $data['active'] = ['Y' => 'Yes', 'N' => 'No'];

        //Return View
        return view('teams.grid', compact('teams'))
            ->with('sort_by', $sort_by)
            ->with('search_text', $search_text)
            ->with('paginate_show', $paginate_show)
            ->with('search_by', $search_by)
            ->with('data', $data);
    }
}

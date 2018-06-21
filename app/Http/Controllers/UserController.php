<?php

namespace App\Http\Controllers;

use App;
use Auth;
use App\User;
use App\User_Level;
use App\SmsGateways;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
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

        //User search
        if ($request->search_text && $search_by = $request->search_by) { //Search

            $search_text = $request->search_text;
            $search_by = $request->search_by;

            if ($request->sort_by) { //Search & Sort
                $sort_by = $request->sort_by; //Set sort by

                //Get users based on search and sort
                $users = User::where($search_by, 'like', '%' . $search_text . '%')->orderBy($sort_by)->paginate($paginate_show);
            } else {
                //Get users based on only search
                $users = User::where($search_by, 'like', '%' . $search_text . '%')->paginate($paginate_show);
            }

        } elseif ($request->sort_by) { //Sort
            //User sort
            $sort_by = $request->sort_by;

            $users = User::orderBy($sort_by)->paginate($paginate_show);
        } else {
            //Get users based on default pagination on page load
            $users = User::paginate($paginate_show);
        }

        $data = array('id' => '', 'first_name' => '', 'last_name' => '', 'email' => '', 'mobile' => '', 'user_level' => 1);

        $data['user_levels'] = User_Level::orderBy('user_level')->pluck('user_level', 'id')->toArray();
        $data['current_user_id'] = $current_user_id = Auth::user()->id;
        $data['mobile_carrier'] = SmsGateways::where('active', 'Y')->where('gateway_type', 1)->orderBy('carrier')->pluck('carrier', 'gateway_id')->toArray();
        $data['mobile_notifications'] = ['Y' => 'Yes', 'N' => 'No'];
        $data['active'] = ['Y' => 'Yes', 'N' => 'No'];
        //Return View
        return view('users.grid', compact('users'))
            ->with('sort_by', $sort_by)
            ->with('search_text', $search_text)
            ->with('paginate_show', $paginate_show)
            ->with('search_by', $search_by)
            ->with('data', $data);
    }

    public function user_export()
    {
        $users = User::select('id', 'user_level', 'first_name', 'last_name', 'email', 'created_at')->get()->toArray();
        foreach (array_keys($users) as $key) {
            unset($users[$key]['id']);
            unset($users[$key]['user_level']);
        }

        // Mattwebsite Excel package - http://www.maatwebsite.nl/laravel-excel/docs
        \Excel::create('users', function ($excel) use ($users) {
            $excel->sheet('Sheet 1', function ($sheet) use ($users) {
                $sheet->fromArray($users);
            });
        })->download('xlsx');

        return redirect()->route('users');
    }

    public function save_user(Request $request)
    {
        $data = $request->input();

        if ($data['password'] != $data['password_confirmation']) {
            \Session::flash('alert-danger', 'Password and password confirmation must match!');
        } else {
            // see if this is an existing user; if it is, locate the record and update it
            if ($data['id']) {
                $user = User::find($data['id']);
                $success = 'User successfully edited!';
                $failure = 'Unable to edit user!  Please try again.';
                $action = "edit";
            } else {
                $user = new User;
                $success = 'User successfully added!';
                $failure = 'Unable to add user!  Please try again.';
                $action = "add";
            }

            if (!isset($data['remember_token'])) {
                $data['remember_token'] = Str::random(60);
            }

            if ($action == 'add') {
                if ($data['password'] == '') {
                    \Session::flash('alert-danger', "Password can't be blank");
                    return redirect()->route('users');
                }
            }

            if ($data['password'] != '') {
                $user->password = bcrypt($data['password']);
            }

            if (!isset($data['mobile_carrier'])) {
                $data['mobile_carrier'] = null;
            }

            $ret = $user->forceFill([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'user_level' => $data['user_level'],
                'mobile' => $data['mobile'],
                'mobile_notifications' => $data['mobile_notifications'],
                'mobile_carrier' => $data['mobile_carrier'],
                'mobile_carrier' => $data['mobile_carrier'],
                'active' => $data['active'],
            ])->save();

            if ($ret) {
                if (App::environment() == 'production') {
                    $data['title'] = 'Welcome to Volunteers!';
                    $data['content'] = '<p>Hello ' . $data['first_name'] . ',</p>Welcome to Volunteers!  You can log into our site using the following ' .
                    'information:<p>URL: <a href="' . url('/') . '" target="_blank">Volunteers</a><br/>Password: ' . $data['password'] .
                        '</p><p>We recommend that you change your password after logging in.</p>';

                    Mail::send(['html' => 'emails.send'], $data, function ($message) use ($data) {
                        $message->from('info@amerilife.com', 'Volunteers');
                        $message->to($data['email']);
                        $message->subject('Welcome to Volunteers!');
                    });
                }

                \Session::flash('alert-success', $success);
                return redirect()->route('users');
            } else {
                \Session::flash('alert-danger', $failure);
            }
        }
        return redirect()->route('users');
    }

    public function check_user(Request $request)
    {
        $email = $request->email;
        $user_id = $request->user_id;

        if ($user_id) {
            //Update
            $user = User::where('id', '!=', $user_id)->where('email', $email)->first();
        } else {
            //Create
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            $response = array(
                'status' => 'user_found',
            );
        } else {
            $response = array(
                'status' => 'user_not_found',
            );
        }

        return \Response::json($response);
    }

    public function destroy($id)
    {
        $response = User::destroy($id);

        if ($response) {
            \Session::flash('alert-success', "User successfully deleted!");
            return redirect()->route('users');
        } else {
            \Session::flash('alert-danger', 'Unable to delete User!  Please try again.');
        }
    }
}

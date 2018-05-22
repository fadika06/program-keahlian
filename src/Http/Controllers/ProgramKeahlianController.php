<?php

namespace Bantenprov\ProgramKeahlian\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Bantenprov\ProgramKeahlian\Facades\ProgramKeahlianFacade;

/* Models */
use Bantenprov\ProgramKeahlian\Models\Bantenprov\ProgramKeahlian\ProgramKeahlian;
use App\User;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\AdminSekolah;

/* Etc */
use Validator;
use Auth;

/**
 * The ProgramKeahlianController class.
 *
 * @package Bantenprov\ProgramKeahlian
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProgramKeahlianController extends Controller
{
    protected $program_keahlian;
    protected $user;
    protected $admin_sekolah;
    protected $user_id;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->program_keahlian = new ProgramKeahlian;
        $this->user             = new User;
        $this->admin_sekolah    = AdminSekolah::where('admin_sekolah_id', $this->user_id)->first();
        $this->user_id          = isset(Auth::User()->id) ? Auth::User()->id : null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->program_keahlian->orderBy($sortCol, $sortDir);

            if (Auth::User()->hasRole(['superadministrator'])) {
                $query = $this->program_keahlian->orderBy($sortCol, $sortDir);
            } else {
                //
            }
        } else {
            $query = $this->program_keahlian->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";

                if (Auth::User()->hasRole(['superadministrator'])) {
                    $q->where('label', 'like', $value)
                        ->orWhere('keterangan', 'like', $value);
                } else {
                    //
                }
            });
        }

        $perPage    = request()->has('per_page') ? (int) request()->per_page : null;
        $response   = $query->with(['user'])->paginate($perPage);

        if (is_null($this->admin_sekolah) && !Auth::User()->hasRole(['superadministrator'])) {
            $response   = (object) [];
        } else {
            $response   = $query->with(['user'])->paginate($perPage);
        }

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        if (Auth::User()->hasRole(['superadministrator'])) {
            $program_keahlians = $this->program_keahlian->with(['user'])->get();
        } else {
            //
        }

        $response['program_keahlians']  = $program_keahlians;
        $response['error']              = false;
        $response['message']            = 'Success.';
        $response['status']             = true;

        if (is_null($this->admin_sekolah) && !Auth::User()->hasRole(['superadministrator'])) {
            return response()->json((object) []);
        } else {
            return response()->json($response);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $program_keahlian   = $this->program_keahlian;
        $users              = $this->user->getAttributes();
        $users_special      = $this->user->all();
        $users_standar      = $this->user->findOrFail($this->user_id);
        $current_user       = Auth::User();

        $program_keahlian->label        = null;
        $program_keahlian->keterangan   = null;
        $program_keahlian->user_id      = null;

        if (Auth::User()->hasRole(['superadministrator'])) {
            $user_special = true;

            foreach ($users_special as $user) {
                array_set($user, 'label', $user->name);
            }

            $users = $users_special;
        } else {
            $user_special = false;

            array_set($users_standar, 'label', $users_standar->name);

            $users = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        $response['program_keahlian']   = $program_keahlian;
        $response['users']              = $users;
        $response['user_special']       = $user_special;
        $response['current_user']       = $current_user;
        $response['error']              = false;
        $response['message']            = 'Loaded.';
        $response['status']             = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $program_keahlian = $this->program_keahlian;

        $validator = Validator::make($request->all(), [
            'label'         => "required|max:64|unique:{$this->program_keahlian->getTable()},label,NULL,id,deleted_at,NULL",
            'keterangan'    => 'required|max:255',
            'user_id'       => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $program_keahlian->label        = $request->input('label');
            $program_keahlian->keterangan   = $request->input('keterangan');

            if (Auth::User()->hasRole(['superadministrator'])) {
                $program_keahlian->user_id  = $request->input('user_id');
            } else {
                $program_keahlian->user_id  = $this->user_id;
            }

            $program_keahlian->save();

            $error      = false;
            $message    = 'Success.';
        }

        $response['program_keahlian']   = $program_keahlian;
        $response['error']              = $error;
        $response['message']            = $message;
        $response['status']             = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgramKeahlian  $program_keahlian
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program_keahlian = $this->program_keahlian->with(['user'])->findOrFail($id);

        $response['program_keahlian']   = $program_keahlian;
        $response['error']              = false;
        $response['message']            = 'Loaded.';
        $response['status']             = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgramKeahlian  $program_keahlian
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program_keahlian   = $this->program_keahlian->with(['user'])->findOrFail($id);
        $users              = $this->user->getAttributes();
        $users_special      = $this->user->all();
        $users_standar      = $this->user->findOrFail($this->user_id);
        $current_user       = Auth::User();

        if ($program_keahlian->user !== null) {
            array_set($program_keahlian->user, 'label', $program_keahlian->user->name);
        }

        if (Auth::User()->hasRole(['superadministrator'])) {
            $user_special = true;

            foreach ($users_special as $user) {
                array_set($user, 'label', $user->name);
            }

            $users = $users_special;
        } else {
            $user_special = false;

            array_set($users_standar, 'label', $users_standar->name);

            $users = $users_standar;
        }

        array_set($current_user, 'label', $current_user->name);

        if (Auth::User()->hasRole(['superadministrator']) || $program_keahlian->user_id == $this->user_id) {
            $error      = false;
            $message    = 'Loaded.';
        } else {
            $error      = true;
            $message    = 'The data can not be loaded because it is not yours.';
        }

        $response['program_keahlian']   = $program_keahlian;
        $response['users']              = $users;
        $response['user_special']       = $user_special;
        $response['current_user']       = $current_user;
        $response['error']              = $error;
        $response['message']            = $message;
        $response['status']             = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgramKeahlian  $program_keahlian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $program_keahlian = $this->program_keahlian->with(['user'])->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'label'         => "required|max:64|unique:{$this->program_keahlian->getTable()},label,{$id},id,deleted_at,NULL",
            'keterangan'    => 'required|max:255',
            'user_id'       => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $program_keahlian->label        = $request->input('label');
            $program_keahlian->keterangan   = $request->input('keterangan');

            if (Auth::User()->hasRole(['superadministrator'])) {
                $program_keahlian->user_id  = $request->input('user_id');
            } else {
                $program_keahlian->user_id  = $this->user_id;
            }

            if (Auth::User()->hasRole(['superadministrator']) || $program_keahlian->user_id == $this->user_id) {
                $program_keahlian->save();

                $error      = false;
                $message    = 'Success.';
            } else {
                $error      = true;
                $message    = 'The data can not be updated because it is not yours.';
            }
        }

        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgramKeahlian  $program_keahlian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $program_keahlian = $this->program_keahlian->findOrFail($id);

        if (Auth::User()->hasRole(['superadministrator']) || $program_keahlian->user_id == $this->user_id) {
            if ($program_keahlian->delete()) {
                $error      = false;
                $message    = 'Success.';
            } else {
                $error      = true;
                $message    = 'Failed';
            }
        } else {
            $error      = true;
            $message    = 'The data can not be deleted because it is not yours.';
        }

        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;

        return json_encode($response);
    }
}

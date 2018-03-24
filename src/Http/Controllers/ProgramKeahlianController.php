<?php

namespace Bantenprov\ProgramKeahlian\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\ProgramKeahlian\Facades\ProgramKeahlianFacade;
use App\User;

/* Models */
use Bantenprov\ProgramKeahlian\Models\Bantenprov\ProgramKeahlian\ProgramKeahlian;

/* Etc */
use Validator;

/**
 * The ProgramKeahlianController class.
 *
 * @package Bantenprov\ProgramKeahlian
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProgramKeahlianController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    public function __construct(ProgramKeahlian $program_keahlian, User $user)
    {
        $this->program_keahlian = $program_keahlian;
        $this->user             = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('sort')) {
            list($sortCol, $sortDir) = explode('|', $request->sort);

            $query = $this->program_keahlian->with('user')->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->program_keahlian->with('user')->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('label', 'like', $value)
                    ->orWhere('keterangan', 'like', $value);
            });
        }


        $perPage = $request->has('per_page') ? (int) $request->per_page : null;
        $response = $query->paginate($perPage);
        
        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users                     = $this->user->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        $response['user'] = $users;
        $response['loaded'] = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgramKeahlian  $program_keahlian
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $program_keahlian = $this->program_keahlian;

        $validator = Validator::make($request->all(), [
            'label'             => 'required',
            'keterangan'        => 'required',
            'user_id'           => 'required|unique:sekolahs,user_id',
        ]);

        if($validator->fails()){
            $check = $program_keahlian->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed' . $request->user_id . ' already exists';

            } else {
                $program_keahlian->label             = $request->input('label');
                $program_keahlian->keterangan        = $request->input('keterangan');
                $program_keahlian->user_id           = $request->input('user_id');
                $program_keahlian->save();

                $response['message'] = 'success';
            }
        } else {
                $program_keahlian->label             = $request->input('label');
                $program_keahlian->keterangan        = $request->input('keterangan');
                $program_keahlian->user_id           = $request->input('user_id');
                $program_keahlian->save();

            $response['message'] = 'success';
        }

        $response['loaded'] = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $program_keahlian = $this->program_keahlian->findOrFail($id);

        array_set($program_keahlian, 'user', $program_keahlian->user->name);

        $response['program_keahlian']   = $program_keahlian;
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
        $program_keahlian = $this->program_keahlian->findOrFail($id);

        array_set($program_keahlian->user, 'label', $program_keahlian->user->name);

        $response['program_keahlian']   = $program_keahlian;
        $response['user']               = $program_keahlian->user;
        $response['loaded']             = true;

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
        $program_keahlian = $this->program_keahlian->findOrFail($id);

        if ($request->input('old_user_id') == $request->input('user_id'))  
        {
            $validator = Validator::make($request->all(), [
                'label'               => 'required',
                'user_id'             => 'required',
                'keterangan'          => 'required',

            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'label'             => 'required',
                'keterangan'        => 'required',
                'user_id'           => 'required|unique:program_keahlians,user_id',
            ]);
        }

        if ($validator->fails()) {
            $check = $program_keahlian->where('user_id',$request->user_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed,Username ' . $request->user_id . ' already exists';
            } else {
                $program_keahlian->label                 = $request->input('label');
                $program_keahlian->user_id               = $request->input('user_id');
                $program_keahlian->keterangan            = $request->input('keterangan');
                $program_keahlian->save();

                $response['message'] = 'success';
            }
        } else {
                $program_keahlian->label                 = $request->input('label');
                $program_keahlian->user_id               = $request->input('user_id');
                $program_keahlian->keterangan            = $request->input('keterangan');
                $program_keahlian->save();

            $response['message'] = 'success';
        }

        $response['loaded'] = true;

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

        if ($program_keahlian->delete()) {
            $response['loaded'] = true;
        } else {
            $response['loaded'] = false;
        }

        return json_encode($response);
    }
}

<?php

namespace Bantenprov\ProgramKeahlian\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\ProgramKeahlian\Facades\ProgramKeahlianFacade;

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
    public function __construct(ProgramKeahlian $program_keahlian)
    {
        $this->program_keahlian = $program_keahlian;
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

            $query = $this->program_keahlian->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->program_keahlian->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('label', 'like', $value)
                    ->orWhere('description', 'like', $value);
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
        $program_keahlian              = $this->program_keahlian;
        $program_keahlian->id          = null;
        $program_keahlian->label       = null;
        $program_keahlian->description = null;

        $response['program_keahlian'] = $program_keahlian;
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
            'label'         => 'required|max:16|unique:program_keahlians,label,NULL,id,deleted_at,NULL',
            'description'   => 'required|max:255',
        ]);

        if($validator->fails()){
            $response['error']  = true;
            $response['message'] = $validator->errors()->first();
        } else {
            $program_keahlian->label       = $request->label;
            $program_keahlian->description = $request->description;
            $program_keahlian->save();

            $response['error'] = false;
            $response['message'] = 'Success';
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

        $response['program_keahlian'] = $program_keahlian;
        $response['loaded'] = true;

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

        $response['program_keahlian'] = $program_keahlian;
        $response['loaded'] = true;

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

        $validator = Validator::make($request->all(), [
            'label'         => 'required|max:16|unique:program_keahlians,label,'.$id.',id,deleted_at,NULL',
            'description'   => 'required|max:255',
        ]);

        if($validator->fails()){
            $response['error']  = true;
            $response['message'] = $validator->errors()->first();
        } else {
            $program_keahlian->label       = $request->label;
            $program_keahlian->description = $request->description;
            $program_keahlian->save();

            $response['error'] = false;
            $response['message'] = 'Success';
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

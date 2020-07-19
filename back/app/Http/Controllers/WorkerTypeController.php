<?php

namespace App\Http\Controllers;

use App\WorkerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib\File\X509;

class WorkerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WorkerType::all();
    }

    public function activeWorkerTypes(){
        return WorkerType::where('isActive', 1)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $workerTypeExists = WorkerType::where('name', $request->name)->first();
        if($workerTypeExists != null){
            if($workerTypeExists->isActive){
                abort(427, "Worker type already exists");
            }else{
                abort(434, "Worker type already exists but it is inactive");
            }
        }

        $worker_type = WorkerType::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return WorkerType::where('id', $worker_type->id)->first();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\WorkerType  $workerType
     * @return \Illuminate\Http\Response
     */
    public function show(WorkerType $workerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkerType  $workerType
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkerType $workerType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkerType  $workerType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkerType $workerType)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $workerTypeExists = WorkerType::where('name', $request->name)->where('id', '!=', $workerType->id)->first();
        if($workerTypeExists != null){
            if($workerTypeExists->isActive){
                abort(427, "Worker type already exists");
            }else{
                abort(434, "Worker type already exists but it is inactive");
            }
        }

        $workerType->update([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'isActive' => $workerType->isActive,
        ]);

        return WorkerType::where('id', $workerType->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkerType  $workerType
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkerType $workerType)
    {
        $workerType->update([
            'isActive' => !$workerType->isActive,
            'user_id' => Auth::id(),
        ]);

        return $workerType;
    }
}

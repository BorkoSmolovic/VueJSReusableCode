<?php

namespace App\Http\Controllers;

use App\Worker;
use App\WorkerTypeWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Worker::all();
//        return Worker::join('worker_type_workers', 'worker_type_workers.worker_id', '=', 'workers.id')
//            ->join('worker_types', 'worker_types.id', '=', 'worker_type_workers.worker_type_id')
//            ->selectRaw("workers.id, concat(workers.name, ' ', workers.surname) as name, group_concat(worker_types.name) as duties")
//            ->groupBy('worker_type_workers.worker_id','workers.id', 'workers.name', 'workers.surname')
//            ->get();
    }

    public function activeWorkers(){
        return Worker::where('isActive', 1)->get();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'worker_types.*.id' => 'required',
        ]);

        $workerExists = Worker::where('name', $request->name)->where('surname', $request->surname)->first();
        if($workerExists != null){
            if($workerExists->isActive){
                abort(427, "Worker already exists");
            }else{
                abort(434, "Worker already exists but it is inactive");
            }
        }

        $worker = Worker::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->worker_types as $worker_type) {
            WorkerTypeWorker::create([
                'worker_id' => $worker->id,
                'worker_type_id' => $worker_type['id'],
                'user_id' => Auth::id()
            ]);
        }

        return Worker::with('worker_type_worker')->where('id', $worker->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Worker $worker
     * @return \Illuminate\Http\Response
     */
    public function show(Worker $worker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Worker $worker
     * @return \Illuminate\Http\Response
     */
    public function edit(Worker $worker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Worker $worker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worker $worker)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'worker_types.*.id' => 'required',
        ]);

        $workerExists = Worker::where('name', $request->name)->where('surname', $request->surname)->where('id', '!=', $worker->id)->first();
        if($workerExists != null){
            if($workerExists->isActive){
                abort(427, "Worker already exists");
            }else{
                abort(434, "Worker already exists but it is inactive");
            }
        }

        $worker->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'user_id' => Auth::id(),
            'isActive' => $worker->isActive
        ]);

        $worker_type_workers = WorkerTypeWorker::where('worker_id', $worker->id)->get();


        foreach ($worker_type_workers as $worker_type_worker) {
            $worker_type_worker->update([
                'isActive' => 0
            ]);
        }

        foreach ($request->worker_types as $worker_type) {
            $id = $worker_type['id'];
            $bool = true;
            foreach ($worker_type_workers as $worker_type_worker) {
                if ($worker_type_worker->worker_type_id == $id) {
                    $worker_type_worker->update([
                        'isActive' => 1
                    ]);
                    $bool = false;
                }
            }
            if ($bool) {
                WorkerTypeWorker::create([
                    'worker_id' => $worker->id,
                    'worker_type_id' => $id,
                    'user_id' => Auth::id()
                ]);
            }


        }

        return Worker::with('worker_type_worker')->where('id', $worker->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Worker $worker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worker $worker)
    {
        $worker->update([
            'user_id' => Auth::id(),
            'isActive' => !$worker->isActive
        ]);

        return Worker::with('worker_type_worker')->where('id', $worker->id)->first();
    }
}

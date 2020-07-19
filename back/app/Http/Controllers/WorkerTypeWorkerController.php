<?php

namespace App\Http\Controllers;

use App\WorkerTypeWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class WorkerTypeWorkerController extends Controller
{
    public function index()
    {
        DB::select('select wtw.id, concat(w.name, \' \', w.surname) as name, group_concat(wt.name) as duties from worker_type_workers wtw inner join worker_types wt on wtw.worker_type_id = wt.id inner join workers w on wtw.worker_id = w.id where w.isActive = 1 and wtw.isActive = 1 and wt.isActive = 1 group by worker_id');
    }



    public function create()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
           'worker_type_id' => 'required',
           'worker_id' => 'required'
        ]);

        $workerTypeWorker = WorkerTypeWorker::create([
            'worker_type_id' => $request->worker_type_id,
            'worker_id' => $request->worker_id,
            'user_id' => Auth::id(),
        ]);

        return WorkerTypeWorker::where('id', $workerTypeWorker->id)->first();
    }

    public function show(WorkerTypeWorker $workerTypeWorker)
    {
        //
    }

    public function edit(WorkerTypeWorker $workerTypeWorker)
    {
        //
    }

    public function update(Request $request, WorkerTypeWorker $workerTypeWorker)
    {
        $request->validate([
            'worker_type_id' => 'required',
            'worker_id' => 'required'
        ]);

        $workerTypeWorker->update([
            'worker_type_id' => $request->worker_type_id,
            'worker_id' => $request->worker_id,
            'user_id' => Auth::id(),
            'isActive' => $workerTypeWorker->isActive
        ]);

        return WorkerTypeWorker::where('id', $workerTypeWorker->id)->first();
    }

    public function destroy(WorkerTypeWorker $workerTypeWorker)
    {
        $workerTypeWorker->update([
            'user_id' => Auth::id(),
            'isActive' => !$workerTypeWorker->isActive
        ]);

        return WorkerTypeWorker::where('id', $workerTypeWorker->id)->first();
    }
}

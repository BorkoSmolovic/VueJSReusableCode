<?php

namespace App\Http\Controllers;

use App\Evidention;
use App\EvidentionWorker;
use App\Worker;
use App\WorkerTypeWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Couchbase\fastlzDecompress;

class EvidentionWorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($evidention_id)
    {
        return EvidentionWorker::with('worker')->with('worker_type')->where('isActive', 1)->where('evidention_id', $evidention_id)->get();
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
            'evidention_id' => 'required',
            'worker_type_id' => 'required',
            'worker_id' => 'required',
            'salary' => 'required',
        ]);

//        Evidention::updatePermissions($request->evidention_id, Auth::id());
        WorkerTypeWorker::workerPerformDuty($request->worker_type_id, $request->worker_id);

        $evidentionWorker = EvidentionWorker::where('evidention_id', $request->evidention_id)->where('worker_id', $request->worker_id)->where('worker_type_id', $request->worker_type_id)->first();
        if ($evidentionWorker != null) {
            if ($evidentionWorker->isActive) {
                abort(427, "Worker already added to perform this action");
            } else {
                $evidentionWorker->isActive = true;
                $evidentionWorker->salary = $request->salary;
                $evidentionWorker->update();
                return EvidentionWorker::with('worker')->with('worker_type')->where('id', $evidentionWorker->id)->first();
            }
        }

        if (WorkerTypeWorker::where('worker_type_id', $request->worker_type_id)->where('worker_id', $request->worker_id)->first() == null) {
            abort(500, "This worker does not perform this duty");
        } else {
            $evidentionWorker = EvidentionWorker::create([
                'evidention_id' => $request->evidention_id,
                'worker_type_id' => $request->worker_type_id,
                'worker_id' => $request->worker_id,
                'salary' => $request->salary,
                'user_id' => Auth::id(),
            ]);
        }

        return EvidentionWorker::with('worker')->with('worker_type')->where('id', $evidentionWorker->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\EvidentionWorker $evidentionWorkers
     * @return \Illuminate\Http\Response
     */
    public function show(EvidentionWorker $evidentionWorker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\EvidentionWorker $evidentionWorkers
     * @return \Illuminate\Http\Response
     */
    public function edit(EvidentionWorker $evidentionWorker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\EvidentionWorker $evidentionWorkers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvidentionWorker $evidentionWorker)
    {
        $request->validate([
            'worker_type_id' => 'required',
            'salary' => 'required',
            'worker_id' => 'required',
        ]);

        DB::beginTransaction();
        //Evidention::updatePermissions($evidentionWorker->evidention_id, Auth::id());
        WorkerTypeWorker::workerPerformDuty($request->worker_type_id, $request->worker_id);

        $evidentionWorkerUpdate = EvidentionWorker::where('evidention_id', $request->evidention_id)->where('worker_id', $request->worker_id)->where('worker_type_id', $request->worker_type_id)->where('id', '!=', $evidentionWorker->id)->first();

        if ($evidentionWorkerUpdate != null) {
            if ($evidentionWorkerUpdate->isActive) {
                abort(427, "Worker already added to perform this action");
            } else {
                $evidentionWorker->isActive = false;
                $evidentionWorker->update();

                $evidentionWorkerUpdate->isActive = true;
                $evidentionWorkerUpdate->salary = $request->salary;
                $evidentionWorkerUpdate->worker_type_id = $request->worker_type_id;
                $evidentionWorkerUpdate->update();
                return EvidentionWorker::with('worker')->with('worker_type')->where('id', $evidentionWorkerUpdate->id)->first();
            }
        }

        if (!WorkerTypeWorker::where('worker_type_id', $request->worker_type_id)->where('worker_id', $request->worker_id)->exists()) {
            abort(500, "This worker does not perform this duty");
        } else {
            $evidentionWorker->update([
                'evidention_id' => $evidentionWorker->evidention_id,
                'worker_type_id' => $request->worker_type_id,
                'worker_id' => $request->worker_id,
                'isActive' => $evidentionWorker->isActive,
                'salary' => $request->salary,
                'user_id' => Auth::id(),
            ]);
        }
        DB::commit();
        return EvidentionWorker::with('worker')->with('worker_type')->where('id', $evidentionWorker->id)->first();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\EvidentionWorker $evidentionWorkers
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvidentionWorker $evidentionWorker)
    {
//        Evidention::updatePermissions($evidentionWorker->evidention_id, Auth::id());

        $evidentionWorker->update([
            'user_id' => Auth::id(),
            'isActive' => false,
        ]);

        return EvidentionWorker::with('worker')->with('worker_type')->where('id', $evidentionWorker->id)->first();
    }
}

<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Evidention;
use App\EvidentionItem;
use App\EvidentionService;
use App\EvidentionStatus;
use App\EvidentionWorker;
use App\User;
use App\WorkerTypeWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EvidentionController extends Controller
{

    public function index()
    {
//        $ev = Evidention::where("id", 3)->first();
//        return $ev->hasManyThrough('App\Service', 'App\EvidentionService', "service_id", "id", "evidention_id", "evidention_id")->toSql();
        $evidentions = Evidention::join('evidention_statuses', 'evidention_statuses.evidention_id', 'evidentions.id');
        $evidentions->select('evidentions.*');
        $evidentions->where(function ($q) {
            $q->where(function ($query) {
                $query->where('evidention_statuses.user_id', Auth::id())
                    ->where('evidention_statuses.status_id', '>', 1);
            })->orWhere('evidention_statuses.status_id', 1);
        });
        $evidentions->whereNotIn('evidention_statuses.status_id', [3, 6]);
        $evidentions->whereRaw('evidention_statuses.status_id = (select max(es1.status_id)
                      from evidention_statuses es1
                      where es1.evidention_id = evidention_statuses.evidention_id
                        and es1.isActive = 1) and evidentions.isActive = 1 and evidention_statuses.isActive = 1');
        $evidentions->with('workers');
        $evidentions->with('items');
        return $evidentions->get();
    }

    public function getbetweenDates(Request $request)
    {
        $request->validate([
            'dateFrom' => 'required',
            'dateTo' => 'required',
        ]);

        return Evidention::where('isActive', 1)->where('date', '>', $request->dateFrom)->where('date', '<', $request->dateTo)->get();
    }

    public function indexFinishedDenied(Request $request)
    {
        $request->validate([
            'dateFrom' => 'required',
            'dateTo' => 'required',
        ]);
        $evidentions = Evidention::where('isActive', 1);
        $evidentions->where('date', '>=', $request->dateFrom);
        $evidentions->where('date', '<=', $request->dateTo);
        $evidentions->select('evidentions.*');
        $evidentions->whereRaw('(select es1.status_id
       from evidention_statuses es1
       where es1.evidention_id = evidentions.id
         and es1.isActive = 1
       ORDER BY es1.updated_at DESC
       LIMIT 1) IN (3, 6)');
        $evidentions->with('workers');
        $evidentions->with('items');
        return $evidentions->get();
    }

    public function getActiveEvidentions()
    {
        return Evidention::with('workers')->with('items')->where('isActive', 1)->get();
    }

    public function create()
    {
        $user = User::where('id', Auth::id())->first();

    }

    public function getByPartnerId()
    {
        $user = User::where('id', Auth::id())->first();
        $contract_ids = Contract::where('partner_id', $user->partner_id)->pluck('id');
        return Evidention::whereIn('contract_id', $contract_ids)->get();
    }

    public function store(Request $request)
    {
        //validacija request-a za sve korisnike
        // (ovo moraju popuniti i radnici info biro-a i partneri prilikom narucivanja)
        $request->validate([
            'event_name' => 'required',
            'date' => 'required',
            'description' => 'present',
            'contract_id' => 'required',
            'city_id' => 'present',
        ]);

        $contract = Contract::where('id', $request->contract_id)->first();
        if ($contract == null) {
            abort(500, "Cannot find contract with this ID");
        }
        if ($contract->recordings_remaining == 0) {
            abort(406, 'There are no recordings left for this partner by the contract');
        }

        $user = User::where('id', Auth::id())->first();
//        return $user->partner_id === null ? "da" : "ne";

        //ako korisnik nema partner_id, znaci da je u pitanju info_biro korisnik, pa je potrebno
        //odraditi validaciju i za korisnike i za item-e i za is_commercial.
        if ($user->partner_id === null) {
            $request->validate([
                'is_commercial' => 'required',
                'items.*.item_id' => 'required',
                'items.*.vehicle_id' => 'present',
                'items.*.value' => 'required',
                'workers.*.worker_type_id' => 'required',
                'workers.*.worker_id' => 'required',
                'workers.*.salary' => 'required',
                'services.*.id' => 'required',
            ]);
        }

        if ($contract->recordings_remaining == 0) {
            abort(406, 'There are no recordings left for this partner by the contract');
        }


        DB::beginTransaction();

        $evidention = Evidention::create([
            'event_name' => $request->event_name,
            'date' => $request->date,
            'description' => $request->description,
            //ako user ima partner_id (parnter info biro-a), ne popunjava ovo polje
            'is_commercial' => $user->partner_id !== null ? null : $request->is_commercial,
            'contract_id' => $request->contract_id,
            'city_id' => $request->city_id,
            'user_id' => $user->id,
        ]);


        //ako user nema partner_id, u pitanju je radnik info biro-a, pa novokreirana
        //evidencija ima status 4 (u izradi), a u suprotnom je u pitanju partner
        //pa evidencija dobija status 1 (narucena)
        if ($user->partner_id == null) {
            EvidentionStatus::add(4, $evidention->id, Auth::id());
        } else {
            EvidentionStatus::add(1, $evidention->id, Auth::id());
        }

        $contract = Contract::where('id', $request->contract_id)->first();
        $contract->update([
            'recordings_remaining' => $contract->recordings_remaining - 1,
        ]);

        //ako user nema partner_id, u pitanju je radnik info biro-a, pa treba dodati item-e i radnike
        if ($user->partner_id === null) {
            foreach ($request->items as $item) {
                $vehicle_id = $item['vehicle_id'];
                if ($item['item_id'] != 1 && $item['item_id'] != 2) {
                    $vehicle_id = null;
                }
                EvidentionItem::create([
                    'evidention_id' => $evidention->id,
                    'item_id' => $item['item_id'],
                    'vehicle_id' => $vehicle_id,
                    'value' => $item['value'],
                    'user_id' => Auth::id(),
                ]);
            }

            foreach ($request->services as $service) {
                EvidentionService::create([
                    'evidention_id' => $evidention->id,
                    'service_id' => $service['id'],
                    'user_id' => Auth::id(),
                ]);
            }

            foreach ($request->workers as $worker) {
                if (WorkerTypeWorker::where('worker_id', $worker['worker_id'])->where('worker_type_id', $worker['worker_type_id'])->first() != null) {
                    EvidentionWorker::create([
                        'evidention_id' => $evidention->id,
                        'worker_id' => $worker['worker_id'],
                        'worker_type_id' => $worker['worker_type_id'],
                        'salary' => $worker['salary'],
                        'user_id' => Auth::id(),
                    ]);
                }
            }
        }
        DB::commit();
        return Evidention::with('workers')->with('items')->with('services')->where('id', $evidention->id)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Evidention $evidention
     * @return \Illuminate\Http\Response
     */
    public function show(Evidention $evidention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Evidention $evidention
     * @return \Illuminate\Http\Response
     */
    public function edit(Evidention $evidention)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Evidention $evidention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evidention $evidention)
    {
        //validacija request-a za sve korisnike
        // (ovo moraju popuniti i radnici info biro-a i partneri prilikom narucivanja)
        $request->validate([
            'event_name' => 'required',
            'date' => 'required',
            'description' => 'present',
            'contract_id' => 'required',
            'city_id' => 'present',
        ]);

        $user = User::where('id', Auth::id())->first();

        Evidention::updatePermissions($evidention->id, $user->id);

        //ako korisnik nema partner_id, znaci da je u pitanju info_biro korisnik, pa je potrebno
        //odraditi validaciju i za korisnike i za item-e i za is_commercial.
        if ($user->partner_id === null) {
            $request->validate([
                'is_commercial' => 'required',
                'items.*.item_id' => 'required',
                'items.*.vehicle_id' => 'present',
                'items.*.value' => 'required',
                'workers.*.worker_type_id' => 'required',
                'workers.*.worker_id' => 'required',
                'workers.*.salary' => 'required',
                'status_id' => 'present',
            ]);
        }

        $evidentionStatus = EvidentionStatus::where('evidention_id', $evidention->id)->latest()->first();
        if ($request->status_id !== null) {
            if ($request->status_id < $evidentionStatus->status_id) {
                abort(500, "You can't switch to this status");
            } elseif ($evidentionStatus->status_id == 5) {
                abort(500, "This evidention is completed");
            } elseif ($request->status_id == $evidentionStatus->status_id) {
                abort(500, "This evidention is already in this status");
            }
        }

        DB::beginTransaction();
        $evidention->update([
            'event_name' => $request->event_name,
            'date' => $request->date,
            'description' => $request->description,
            //ako user ima partner_id (parnter info biro-a), ne popunjava ovo polje
            'is_commercial' => $user->partner_id !== null ? null : $request->is_commercial,
            'city_id' => $request->city_id,
            'contract_id' => $request->contract_id,
            'isActive' => $evidention->isActive,
            'user_id' => Auth::id(),
        ]);

        //ako user nema partner_id, u pitanju je radnik info biro-a, pa treba dodati item-e i radnike
        if ($user->partner_id === null) {
            if ($request->status_id !== null && $evidentionStatus->status_id != $request->status_id) {
                EvidentionStatus::add($request->status_id, $evidention->id, Auth::id());
            }

            $items = EvidentionItem::where('evidention_id', $evidention->id)->get();
            foreach ($items as $item) {
                $item->update([
                    'isActive' => 0,
                ]);
            }

            foreach ($request->items as $item) {
                $vehicle_id = $item['vehicle_id'];
                if ($item['item_id'] != 1 && $item['item_id'] != 2) {
                    $vehicle_id = null;
                }
                if (array_key_exists('id', $item)) {
                    EvidentionItem::where('id', $item['id'])->first()->update([
                        'item_id' => $item['item_id'],
                        'value' => $item['value'],
                        'vehicle_id' => $vehicle_id,
                        'isActive' => 1,
                        'user_id' => Auth::id(),
                    ]);
                } else {
                    EvidentionItem::create([
                        'evidention_id' => $evidention->id,
                        'item_id' => $item['item_id'],
                        'value' => $item['value'],
                        'vehicle_id' => $vehicle_id,
                        'user_id' => Auth::id(),
                    ]);
                }
            }

            $services = EvidentionService::where('evidention_id', $evidention->id)->get();
            $service_ids = [];
            foreach ($services as $service) {
                array_push($service_ids, $service->service_id);
                $service->update([
                    'isActive' => 0,
                ]);
            }

            foreach ($request->services as $service) {
                if (array_key_exists('id', $service) && in_array($service["id"], $service_ids)) {
                    EvidentionService::where('service_id', $service['id'])->where('evidention_id', $evidention->id)->first()->update([
                        'service_id' => $service['id'],
                        'isActive' => 1,
                        'user_id' => Auth::id(),
                    ]);
                } else {
                    EvidentionService::create([
                        'evidention_id' => $evidention->id,
                        'service_id' => $service['id'],
                        'user_id' => Auth::id(),
                    ]);
                }
            }


            $workers = EvidentionWorker::where('evidention_id', $evidention->id)->get();
            foreach ($workers as $worker) {
                $worker->update([
                    'isActive' => 0,
                ]);
            }

            foreach ($request->workers as $worker) {
                if (array_key_exists('id', $worker)) {
                    if (WorkerTypeWorker::where('worker_id', $worker['worker_id'])->where('worker_type_id', $worker['worker_type_id'])->first() != null) {
                        EvidentionWorker::where('id', $worker['id'])->first()->update([
                            'worker_type_id' => $worker['worker_type_id'],
                            'worker_id' => $worker['worker_type_id'],
                            'salary' => $worker['salary'],
                            'isActive' => 1,
                            'user_id' => Auth::id(),
                        ]);
                    }
                } else {
                    if (WorkerTypeWorker::where('worker_id', $worker['worker_id'])->where('worker_type_id', $worker['worker_type_id'])->first() != null) {
                        EvidentionWorker::create([
                            'evidention_id' => $evidention->id,
                            'worker_type_id' => $worker['worker_type_id'],
                            'worker_id' => $worker['worker_id'],
                            'salary' => $worker['salary'],
                            'user_id' => Auth::id(),
                        ]);
                    }
                }
            }
        }
        DB::commit();
        return Evidention::with('workers')->with('items')->with('services')->where('id', $evidention->id)->first();
    }

    public function uploadInvoice(Request $request)
    {
        $request->validate([
            "evidention_id" => "required",
            "file_name" => "required",
            "net" => "required",
            "rebate" => "required",
            "net_rebate" => "required",
            "vat" => "required",
            "gross" => "required"
        ]);

        DB::beginTransaction();

        $evidention = Evidention::where('id', $request->evidention_id)->first();
        $status = EvidentionStatus::where('evidention_id', $request->evidention_id)->get()->last();

        if ($evidention != null && $status != null && $request->file('invoice') != null) {

            //ako ne postoji folder invoices kreiraj ga
            if (!file_exists(storage_path() . '/app/invoices/')) {
                if (!mkdir(storage_path() . '/app/invoices/')) {
                    abort(422, "Cannot create invoices folder");
                }
            }

            //obrisi citav folde rkoji sadrzi fajlove faktura, da ne bi cuvali stare fakture ukoliko dodje do zamjene fajla
            if ($evidention->invoice !== null) {
                if (!File::deleteDirectory(storage_path() . '/app/invoices/' . $evidention->id)) {
                    abort(422, "Error removing old invoice");
                }
            }

            // u okviru foldera invoices kreiraj folder koji se zove kao id evidencije
            if (!file_exists(storage_path() . '/app/invoices/' . $request->evidention_id . '/')) {
                if (!mkdir(storage_path() . '/app/invoices/' . $request->evidention_id . '/')) {
                    abort(422, "Cannot create evidention folder");
                }
            }

            //smjesti u prethodno napravljeni folder fajl fakture
            if (!Storage::disk('invoices_disk')->putFileAs('/' . $request->evidention_id, $request->file('invoice'), $request->file_name)) {
                abort(422, "Error saving file");
            }

            //azuriraj polje invoice u okviru evidencije sa imenom fajla
            $evidention->update([
                'net' => $request->net,
                "rebate" => $request->rebate,
                "net_rebate" => $request->net_rebate,
                "vat" => $request->vat,
                "gross" => $request->gross,
                'invoice' => $request->file_name
            ]);

            DB::commit();

            return response("Upload successful", 200);
        }
        abort(422, "Error uploading invoice");
    }

    public function deleteInvoice(Evidention $evidention)
    {
        $evidention = Evidention::findOrFail($evidention->id);

        //obrisi citav folde rkoji sadrzi fajlove faktura, da ne bi cuvali stare fakture ukoliko dodje do zamjene fajla
        if ($evidention->invoice !== null) {
            if (!File::deleteDirectory(storage_path() . '/app/invoices/' . $evidention->id)) {
                abort(422, "Error removing invoice");
            }
        }

        $evidention->update([
            'net' => 0,
            "rebate" => 0,
            "net_rebate" => 0,
            "vat" => 0,
            "gross" => 0,
            'invoice' => null
        ]);

        $evidention->save();

        return response("Invoice delete successfully", 200);
    }

    public function getInvoice(Evidention $evidention)
    {
        return $evidention;
    }

    public function downloadInvoice(Evidention $evidention)
    {
        $invoicePath = storage_path() . '/app/invoices/' . $evidention->id . '/' . $evidention->invoice;
        return response()->file($invoicePath);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Evidention $evidention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evidention $evidention)
    {
        Evidention::updatePermissions($evidention->id, Auth::id());
        $evidention->update([
            'isActive' => !$evidention->isActive,
            'user_id' => Auth::id(),
        ]);
        return Evidention::with('workers')->with('items')->where('id', $evidention->id)->first();
    }

}

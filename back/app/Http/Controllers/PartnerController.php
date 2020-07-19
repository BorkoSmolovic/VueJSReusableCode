<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Contact;
use App\Contract;
use App\Evidention;
use App\Partner;
use App\Status;
use App\Traits\TenantTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    use TenantTrait;

    public function index()
    {
        return Partner::all();
    }

    public function getPartners()
    {
        return Partner::where('isActive', 1)->get();
    }

    public function create()
    {
        //
    }

    public function getUserInfo()
    {
        $user = User::where('id', Auth::id())->first();
        $infoBiroUser = $user->partner_id == null;
        if (!$infoBiroUser) {
            $contracts = Contract::where('partner_id', $user->partner_id)->where('isActive', 1)->orderBy('dateTo', 'ASC')->get();
            if (sizeof($contracts) == 0) {
//                abort(500, "There is no contracts for this partner");
                $response[0] = array('lastContract' => null);
                $response[1] = array('recordings_remaining' => 0);
                $results = DB::select("SELECT s.name AS status, 0 AS no FROM statuses s WHERE s.isActive = 1");
                $i = 2;
                foreach ($results as $result) {
                    $result->no = (integer)$result->no;
                    $response[$i] = $result;
                    $i++;
                }
                return $response;
            }
            $response[0] = array('lastContract' => $contracts->last()->dateTo);
            $result = Contract::selectRaw('sum(recordings_remaining) as sumRec')->where('partner_id', $user->partner_id)->where('isActive', 1)->where('dateTo', '>=', Carbon::now())->first();
            $response[1] = array('recordings_remaining' => intval($result->sumRec));
            $contracts = $contracts->pluck('id');
            $a = substr($contracts, 1, strlen($contracts) - 2);
            $results = DB::select("SELECT s.name as status,
       IFNULL((SELECT COUNT(es.status_id) AS no
        FROM evidentions e
                 LEFT JOIN evidention_statuses es on e.id = es.evidention_id AND es.status_id = (SELECT es.status_id
                                                                                                 FROM evidention_statuses es
                                                                                                 WHERE es.evidention_id = e.id
                                                                                                 ORDER BY es.created_at DESC
                                                                                                 LIMIT 1)
        WHERE e.contract_id IN (1) AND es.status_id = s.id
        GROUP BY es.status_id),0) AS no
FROM statuses s
");
        } else {
            $results = DB::select("select s.name as status, if(isnull(t.sum), 0, t.sum) as no from statuses s left join (select count(t.evidention_id) as sum, t.status_id from (select evidention_id, max(status_id) as status_id from evidention_statuses where user_id = " . Auth::id() . " or (status_id = 1 and user_id in (select id from users where not isnull(partner_id))) GROUP BY evidention_id) t GROUP by t.status_id) t on t.status_id = s.id
");
            $no = DB::select("select count(e.id) as cnt
from evidention_statuses es
         inner join evidentions e on es.evidention_id = e.id
where es.user_id = $user->id and es.status_id > 1
  and es.status_id = (select max(es1.status_id)
                      from evidention_statuses es1
                      where es1.evidention_id = es.evidention_id
                        and es1.isActive = 1)")[0];
            $partnerCnt = Partner::where('isActive', 1)->selectRaw('count(id) as cnt')->first();
            $response[0] = array("no" => (integer)$no->cnt);
            $response[1] = array("no" => (integer)$partnerCnt->cnt);
        }
        $i = 2;
        foreach ($results as $result) {
            $result->no = (integer)$result->no;
            $response[$i] = $result;
            $i++;
        }
        return $response;
    }


    public function store(Request $request)
    {
        $request->validate([
            'code' => 'present',
            'name' => 'present|max:400',
            'address' => 'required|max:100',
            'pib' => 'present|max:50',
            'pdv' => 'present|max:50',
//            'pin' => 'present',
            'partner_type_id' => 'required',
            'city_id' => 'required',
        ]);

        $partnerExists = Partner::where('pib', $request->pib)->first();
        if ($partnerExists != null) {
            if ($partnerExists->isActive) {
                abort(427, "Partner already exists");
            } else {
                abort(434, "Partner already exists but it is inactive");
            }
        }

        $partner = Partner::create([
            'code' => $request->code,
            'name' => $request->name,
//            'pin' => $request->pin,
            'address' => $request->address,
            'pib' => $request->pib,
            'pdv' => $request->pdv,
            'partner_type_id' => $request->partner_type_id,
            'city_id' => $request->city_id,
            'isActive' => 1,
            'user_id' => Auth::id(),
        ]);

        return Partner::where('id', $partner->id)->first();
    }

    public function getPartnerById($id)
    {
        return Partner::where('id', '=', $id)->get();
    }

    public function show(Partner $partner)
    {
        //
    }

    public function edit(Partner $partner)
    {
        //
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'code' => 'present',
            'name' => 'required|max:400',
            'address' => 'present|max:100',
            'pib' => 'present|max:50',
//            'pin' => 'present',
            'pdv' => 'present|max:50',
            'partner_type_id' => 'required',
            'city_id' => 'required',
        ]);

        $partnerExists = Partner::where('pib', $request->pib)->where('id', '!=', $partner->id)->first();
        if ($partnerExists != null) {
            if ($partnerExists->isActive) {
                abort(427, "Partner already exists");
            } else {
                abort(434, "Partner already exists but it is inactive");
            }
        }
        $partner->update([
            'code' => $request->code,
            'name' => $request->name,
            'address' => $request->address,
            'pib' => $request->pib,
            'pdv' => $request->pdv,
//            'pin' => $request->pin,
            'partner_type_id' => $request->partner_type_id,
            'city_id' => $request->city_id,
            'user_id' => Auth::id(),
        ]);

        return Partner::where('id', $partner->id)->first();
    }

    public function destroy(Partner $partner)
    {
        //Aktivnost partnera stavlja na 0
        $partner->update([
            'isActive' => !$partner->isActive,
            'user_id' => Auth::id(),
        ]);
        //Foreach petljom prolazi kroz svaki bankovni racun koji je od ovoga partnera
        foreach (BankAccount::where('partner_id', '=', $partner->id)->get() as $bankAccount) {
            $bankAccount->update([
                'isActive' => !$bankAccount->isActive,
                'user_id' => Auth::id(),
            ]);
        }
        //Foreach petljom prolazi kroz svaki kontakt koji je od ovoga partnera
        foreach (Contact::where('partner_id', '=', $partner->id)->get() as $contact) {
            $contact->update([
                'isActive' => !$contact->isActive,
                'user_id' => Auth::id(),
            ]);
        }
        return Partner::where('id', $partner->id)->first();
    }
}

<?php

namespace App\Http\Controllers;

use App\Evidention;
use App\User;
use App\Worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;

class ExcelController extends Controller
{


    public function store(Request $request)
    {
        $request->validate(array(
            'dateFrom' => 'required',
            'dateTo' => 'required',
            'contract' => 'present',
            'event_name' => 'present',
            'city' => 'present',
            'is_commercial' => 'present',
            'partner' => 'present',
            'user' => 'present',
            'status' => 'present',
            'isActive' => 'present',
            'sort_by' => 'present',
            'sort_order' => 'present'
        ));
//        return $request;
        $user = User::where('id', Auth::id())->first();
        $query = '';
        $evidentions = Evidention::where('isActive', 1);
        $evidentions->whereRaw('(select es1.status_id
       from evidention_statuses es1
       where es1.evidention_id = evidentions.id
         and es1.isActive = 1
       ORDER BY es1.updated_at DESC
       LIMIT 1) IN (3, 6)');

        if ($request->dateFrom != null) {
            $evidentions->whereRaw("date >= '$request->dateFrom'");
            $query .= " and e.date > '$request->dateFrom'";
        }
        if ($request->dateTo != null) {
            $evidentions->whereRaw("date <= '$request->dateTo'");
            $query .= " and e.date < '$request->dateTo'";
        }
        if ($request->contract != null) {
            $evidentions->whereRaw("contract_id like '%$request->contract%'");
            $query .= " and e.contract_id like '%$request->contract%'";
        }
        if ($request->partner != null) {
            $evidentions->whereRaw("contract_id in (select id from contracts where partner_id in (select id from partners where name like '%$request->partner%'))");
            $query .= " and contract_id in (select id from contracts where partner_id in (select id from partners where name like '%$request->partner%'))";
        }
        if ($request->user != null) {
            $evidentions->whereRaw("user_id in (select id from users where name like '%$request->user%')");
            $query .= " and e.user_id in (select id from users where username like '%$request->user%')";
        }
        if ($request->isActive != null) {
            $evidentions->where('isActive', $request->isActive);
            $query .= " and e.isActive = $request->isActive";
        }
        if ($request->event_name != null) {
            $evidentions->whereRaw("event_name like '%$request->event_name%'");
            $query .= " and e.event_name like '%$request->event_name%'";
        }
        if ($request->city != null) {
            $evidentions->whereRaw("city_id in (select id from cities where name like '%$request->city%')");
            $query .= " and e.city_id in (select id from cities where name like '%$request->city%')";
        }
        if ($request->is_commercial != null) {
            $evidentions->where('is_commercial', $request->is_commercial);
            $query .= " and e.is_commercial = '$request->is_commercial'";
        }


        $query .= ' and (select es1.status_id
       from evidention_statuses es1
       where es1.evidention_id = e.id
         and es1.isActive = 1
       ORDER BY es1.updated_at DESC
       LIMIT 1) IN (3, 6) ';
        if ($request->sort_by != null) {
            if ($request->sort_order) {
                $evidentions->orderBy($request->sort_by, 'desc');
                $query1 = " order by '$request->sort_by' desc ";
            } else {
                $evidentions->orderBy($request->sort_by, 'asc');
                $query1 = " order by '$request->sort_by' asc ";
            }
        }
        $evidentions = $evidentions->get();

//        $filter = [];
//        if($request->status != null) {
//            foreach ($evidentions as $evidention) {
//                if(stripos($evidention->status->status->name, $request->status) !== false) {
//                    array_push($filter, $evidention);
//                }
//            }
//            $evidentions = $filter;
//        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'];

//        return "SELECT t.name, MAX(t.cnt) as maxcnt, t.id, t.eid
//FROM(
//select wt.id, wt.name, COUNT(wt.id) AS cnt, evidention_id as eid
//from evidention_workers ew INNER  JOIN  worker_types wt on ew.worker_type_id = wt.id inner join evidentions e on e.id = ew.evidention_id where ew.isActive = 1 and wt.isActive = 1 and e.isActive = 1 ' . $query . '
//GROUP BY ew.worker_type_id, ew.evidention_id, wt.id, wt.name) as t
//GROUP BY t.id, t.name";

        $workerColumnNames = DB::select('SELECT t.name, MAX(t.cnt) as maxcnt, t.id, t.eid
FROM(
select wt.id, wt.name, COUNT(wt.id) AS cnt, evidention_id as eid
from evidention_workers ew INNER  JOIN  worker_types wt on ew.worker_type_id = wt.id inner join evidentions e on e.id = ew.evidention_id where ew.isActive = 1 and wt.isActive = 1 and e.isActive = 1 ' . $query . '
GROUP BY ew.worker_type_id, ew.evidention_id, wt.id, wt.name) as t
GROUP BY t.id, t.name' . $query1);


//        return 'SELECT t.name, MAX(t.cnt) as maxcnt, t.id, t.eid
//FROM(
//select wt.id, wt.name, COUNT(wt.id) AS cnt, evidention_id as eid
//from evidention_workers ew INNER  JOIN  worker_types wt on ew.worker_type_id = wt.id inner join evidentions e on e.id = ew.evidention_id where ew.isActive = 1 and wt.isActive = 1 and e.isActive = 1 ' . $query . '
//GROUP BY ew.worker_type_id, ew.evidention_id, wt.id, wt.name) as t
//GROUP BY t.id, t.name';
        $j = 5;
        foreach ($workerColumnNames as $workerColumnName) {
            for ($i = 0; $i < $workerColumnName->maxcnt; $i++) {
                $j++;
                $sheet->setCellValue($letters[$j] . '1', $workerColumnName->name . ' ' . ($i + 1));
                $sheet->getColumnDimension($letters[$j])->setWidth(40);
                $j++;
                $sheet->setCellValue($letters[$j] . '1', "Dnevnica");
                $sheet->getColumnDimension($letters[$j])->setWidth(10);
            }
        }

        $itemColumnNames = DB::select('SELECT t.name, MAX(t.cnt) as maxcnt, t.id
FROM(
      select i.id, i.name, COUNT(i.id) AS cnt, evidention_id
      from evidention_items ei INNER  JOIN  items i on ei.item_id = i.id inner join evidentions e on ei.evidention_id = e.id where ei.isActive = 1 and i.isActive = 1 and e.isActive = 1 ' . $query . '
      GROUP BY ei.item_id, ei.evidention_id, i.id, i.name) as t
GROUP BY t.id, t.name' . $query1);
        $n = 0;
        foreach ($itemColumnNames as $itemColumnName) {
            for ($i = 0; $i < $itemColumnName->maxcnt; $i++) {
                if ($itemColumnName->id == 1) {
                    $n++;
                    $j++;
                    $sheet->setCellValue($letters[$j] . '1', "Registarske oznake");
                    $sheet->getColumnDimension($letters[$j])->setWidth(20);
                }
                $j++;
                $sheet->setCellValue($letters[$j] . '1', $itemColumnName->name . ' ' . ($i + 1));
                $sheet->getColumnDimension($letters[$j])->setWidth(15);

            }
            $n += $itemColumnName->maxcnt;
        }
        $j++;
        $sheet->setCellValue($letters[$j] . 1, 'Klijent');
        $sheet->getColumnDimension($letters[$j])->setWidth(40);
        $j++;
        $sheet->setCellValue($letters[$j] . 1, 'Broj ugovora');
        $j++;
        $sheet->setCellValue($letters[$j] . 1, 'Komercijalno');
        $j++;

        /*--------------------------------------------------------------------------*/
        $sheet->setCellValue($letters[$j] . 1, 'Neto');
        $j++;
        $sheet->setCellValue($letters[$j] . 1, 'Rabat');
        $j++;
        $sheet->setCellValue($letters[$j] . 1, 'Neto iznos');
        $sheet->getColumnDimension($letters[$j])->setWidth(20);
        $j++;
        $sheet->setCellValue($letters[$j] . 1, 'PDV');
        $j++;
        $sheet->setCellValue($letters[$j] . 1, 'Bruto iznos');
        $sheet->getColumnDimension($letters[$j])->setWidth(20);
        /*--------------------------------------------------------------------------*/

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('C')->setWidth(41);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);


        $sheet->getPageMargins()->setTop(0.75);
        $sheet->getPageMargins()->setRight(0.25);
        $sheet->getPageMargins()->setLeft(0.25);
        $sheet->getPageMargins()->setBottom(0.75);


        $sheet->setCellValue('A1', 'R.Br.');
        $sheet->setCellValue('B1', 'Datum');
        $sheet->setCellValue('C1', 'Naziv dogadaja');
        $sheet->setCellValue('D1', 'Opis posla');
        $sheet->setCellValue('E1', 'Mjesto dogadaja');
        $sheet->setCellValue('F1', 'Status');
        $sheet->getStyle('A1:' . $letters[$j] . '1')->getFont()->setBold(true);

        $sheet->getStyle('A1:' . $letters[$j] . '1')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('cccccc'); // =================
        $sheet->getStyle('A1:' . $letters[$j] . '1')
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A1:' . $letters[$j] . '1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getRowDimension(1)->setRowHeight(45.25);
        $sheet->getStyle('A1:' . $letters[$j] . '1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:' . $letters[$j] . '1')->getAlignment()->setWrapText(true);

        $counter = 2;
        $rbr = 0;
        //Unos podataka
        foreach ($evidentions as $evidention) {
            $sheet->setCellValue('A' . $counter, $rbr += 1);
            $sheet->setCellValue('B' . $counter, $evidention->date);
            $sheet->setCellValue('C' . $counter, $evidention->event_name);
            $sheet->setCellValue('D' . $counter, $evidention->description);
            $sheet->setCellValue('E' . $counter, $evidention->city->name);
            $sheet->setCellValue('F' . $counter, $evidention->status->status->name);
            $k = 6;

            foreach ($workerColumnNames as $workerColumnName) {
                $a = $k;
                foreach ($evidention->workers as $worker) {
                    if ($workerColumnName->id == $worker->worker_type_id) {
                        $sheet->setCellValue($letters[$a] . $counter, $worker->fullName);
                        $a++;
                        $sheet->setCellValue($letters[$a] . $counter, $worker->salary)->getStyle($letters[$a] . $counter)->getNumberFormat()->setFormatCode('0.00');
                        $a++;
                    }
                }
                $k += $workerColumnName->maxcnt * 2;
            }
            $a = $k;
            $o = 0;
            foreach ($itemColumnNames as $itemColumnName) {
                foreach ($evidention->items as $item) {
                    if ($itemColumnName->id == $item->item_id) {
                        if ($item->item_id == 1) {
                            $sheet->setCellValue($letters[$a] . $counter, $item->vehicle->plates);
                        } elseif ($item->item_id == 2) {
                            $sheet->setCellValue($letters[$a] . $counter, "Privatno vozilo");
                        }
                        $a++;
                        $sheet->setCellValue($letters[$a] . $counter, $item->value)->getStyle($letters[$a] . $counter)->getNumberFormat()->setFormatCode('0.00');;
                        $a++;
                    }
                }
            }
            $k += $n + $o;
            $sheet->setCellValue($letters[$k] . $counter, $evidention->contract->partner->name);
            $k++;
            $sheet->setCellValue($letters[$k] . $counter, $evidention->contract->contract_name);
            $k++;
            $sheet->setCellValue($letters[$k] . $counter, $evidention->is_commercial ? 'Da' : 'Ne');
            $k++;

            /*---------------------------------------------------------------*/
            $sheet->setCellValue($letters[$k] . $counter, $evidention->net)->getStyle($letters[$k] . $counter)->getNumberFormat()->setFormatCode('0.00');
            $k++;
            $sheet->setCellValue($letters[$k] . $counter, $evidention->rebate)->getStyle($letters[$k] . $counter)->getNumberFormat()->setFormatCode('0.00');
            $k++;
            $sheet->setCellValue($letters[$k] . $counter, $evidention->net_rebate)->getStyle($letters[$k] . $counter)->getNumberFormat()->setFormatCode('0.00');
            $k++;
            $sheet->setCellValue($letters[$k] . $counter, $evidention->vat)->getStyle($letters[$k] . $counter)->getNumberFormat()->setFormatCode('0.00');
            $k++;
            $sheet->setCellValue($letters[$k] . $counter, $evidention->gross)->getStyle($letters[$k] . $counter)->getNumberFormat()->setFormatCode('0.00');
            /*--------------------------------------------------------------------------*/

            $sheet->getRowDimension($counter)->setRowHeight(-1);
            $sheet->getStyle('A' . $counter . ':' . $letters[$k] . $counter)->getAlignment()->setWrapText(true);
            $sheet->getStyle('A' . $counter . ':' . $letters[$k] . $counter)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

            if ($counter % 2 == 0) {
                $sheet->getStyle('A' . $counter . ':' . $letters[$k] . $counter)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f2f2f2'); // =================
            } else {
                $sheet->getStyle('A' . $counter . ':' . $letters[$k] . $counter)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4e4e4'); // =================
            }

            $sheet->getStyle('A' . $counter . ':' . $letters[$k] . $counter)
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
            $sheet->getStyle('A' . $counter . ':' . $letters[$k] . $counter)
                ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
            $sheet->getStyle('A' . $counter . ':' . $letters[$k] . $counter)
                ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
            $sheet->getStyle('A' . $counter)
                ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle($letters[$k] . $counter)
                ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $counter += 1;
        }

// Write an .xlsx file
        $writer = new Xlsx($spreadsheet);

//        return 'sadfsadf';
        ob_end_clean();
        $writer->save('php://output');
//        return response()->download(storage_path() . '/excel/File.xlsx', 'file.xlsx');
//
//        $fileStream = File::get(storage_path() . '/excel/File.xlsx');
//
//        File::delete(storage_path() . '/excel/File');
//
//        return $fileStream;
    }

    public function workerReport(Request $request)
    {
        $request->validate([
            'workers' => 'present',
            'worker_types' => 'present',
            'workers.*.id' => 'required',
            'worker_types.*.id' => 'required',
            'dateFrom' => 'required',
            'dateTo' => 'required',
        ]);
        $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'];

        $a = false;
        $workers = " and ew.worker_id in (0, ";
        foreach ($request->workers as $worker) {
            $workers .= $worker['id'] . ', ';
            $a = true;
        }
        $workers = substr($workers, 0, strlen($workers) - 2) . ') ';

        $workerTypes = " and ew.worker_type_id in (0, ";
        foreach ($request->worker_types as $worker_type) {
            $workerTypes .= $worker_type['id'] . ', ';
        }
        $workerTypes = substr($workerTypes, 0, strlen($workerTypes) - 2) . ') ';
//return $workerTypes;

        $query = "select concat(w.name, ' ', w.surname) as fullname,
       wt.name                        as worktype,
       ew.salary,
       e.date,
       e.event_name,
       GROUP_CONCAT(DISTINCT s.name SEPARATOR ', ')  as name,
       c2.name                        as city,
       c3.contract_name,
       p.name                         as partner_name
from evidention_workers ew
         inner join evidentions e on ew.evidention_id = e.id
         inner join evidention_statuses es on e.id = es.evidention_id
         inner join worker_types wt on ew.worker_type_id = wt.id
         inner join cities c2 on e.city_id = c2.id
         inner join contracts c3 on e.contract_id = c3.id
         inner join partners p on c3.partner_id = p.id
         inner join workers w on ew.worker_id = w.id
         inner join evidention_services es1 on e.id = es1.evidention_id
         inner join services s on es1.service_id = s.id
where es.status_id = (select max(status_id) from evidention_statuses ev1 where ev1.evidention_id = e.id)
  and es.status_id = 6
  and e.isActive = 1
  and es.isActive = 1
  and ew.isActive = 1
and e.date >= '" . $request->dateFrom . "'
and e.date <= '" . $request->dateTo . "'";

        if ($a) {
            $query .= $workers;
        }
        $a = false;
        $workerTypes = " and ew.worker_type_id in (0, ";
        foreach ($request->worker_types as $worker_type) {
            $workerTypes .= $worker_type['id'] . ', ';
            $a = true;
        }
        $workerTypes = substr($workerTypes, 0, strlen($workerTypes) - 2) . ') ';
        if ($a) {
            $query .= $workerTypes;
        }
        //order by ew.worker_id, ew.worker_type_id
        $query .= ' and wt.isActive = 1';
        $query .= " GROUP BY event_name ORDER BY fullname";
//        return $query;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getFont()->setSize(14);

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(40);

        $sheet->setCellValue('A1', 'Ime i prezime');
        $sheet->setCellValue('B1', 'Uloga');
        $sheet->setCellValue('C1', 'Dnevnica');
        $sheet->setCellValue('D1', 'Datum');
        $sheet->setCellValue('E1', 'Naziv dogadjaja');
        $sheet->setCellValue('F1', 'Usluga');
        $sheet->setCellValue('G1', 'Grad');
        $sheet->setCellValue('H1', 'Ugovor');
        $sheet->setCellValue('I1', 'Partner');

        $sheet->getRowDimension(1)->setRowHeight(40);

        $results = DB::select($query);
        $i = 2;
        foreach ($results as $result) {
            $sheet->setCellValue($letters[0] . ($i), $result->fullname);
            $sheet->setCellValue($letters[1] . ($i), $result->worktype);
            $sheet->setCellValue($letters[2] . ($i), $result->salary);
            $sheet->setCellValue($letters[3] . ($i), $result->date);
            $sheet->setCellValue($letters[4] . ($i), $result->event_name);
            $sheet->setCellValue($letters[5] . ($i), $result->name);
            $sheet->setCellValue($letters[6] . ($i), $result->city);
            $sheet->setCellValue($letters[7] . ($i), $result->contract_name);
            $sheet->setCellValue($letters[8] . ($i), $result->partner_name);

            $sheet->getRowDimension($i)->setRowHeight(20);
            $i++;
        }

        $sheet->getStyle('A2:I' . $i)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('I2:I' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2:C' . $i)->getNumberFormat()->setFormatCode('0.00');
        $sheet->getStyle('A2:I' . $i)->getFont()->setSize(12);

        //----------------------------------- Bojenje redova -------------------------------------
        $counter = 0;
        for ($k = 0; $k < $i; $k++) {
            if ($k % 2 == 0) {
                $sheet->getStyle('A' . $counter . ':I' . $counter)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f2f2f2'); // =================
            } else {
                $sheet->getStyle('A' . $counter . ':I' . $counter)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4e4e4'); // =================
            }
            $counter++;
        }
        //-----------------------------------------------------------------------------------------
        $sheet->getStyle('A1:I1')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('cccccc'); // =================


        $sheet->getStyle('A2:I' . $i)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        $sheet->getStyle('A1:I' . 1)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
//        $sheet->getStyle('A2:E' . $i)
//            ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
//        $sheet->getStyle('A2:' . $letters[5] . $i)
//            ->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE);
        $sheet->getStyle('A2:I' . $i)
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H2:I' . $i)
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        $writer->save('php://output');
    }

    public function itemsReport(Request $request)
    {
        $request->validate([
            'items' => 'present',
            'dateFrom' => 'required',
            'dateTo' => 'required',
        ]);

        // Pravljenje niza od A do Z excel
        $lettersA_Z = range('A', 'Z');

        // Pravljenje niza od AA do AZ excel
        $lettersAA_AZ = array_map(function ($letter) {
            return ('A' . $letter);
        }, $lettersA_Z);

        // Spajanje niza od A-Z i AA-AZ
        $letters = array_merge($lettersA_Z, $lettersAA_AZ);

        $hasItems = false;
        $items = " and ei.item_id in (0, ";

        if (is_array($request->cities) || is_object($request->cities)) {
            foreach ($request->items as $item) {
                $items .= $item['id'] . ', ';
                $hasItems = true;
            }
        }
        $items = substr($items, 0, strlen($items) - 2) . ') ';

        // Upit koji vraca evideciju sa troškovima
        $query = "select
                   IF(ei.vehicle_id IS NULL, i.name, CONCAT(i.name, ' ', (SELECT v.plates FROM vehicles v WHERE v.id = ei.vehicle_id))) as item_name,
                   ei.value,
                   e.date,
                   e.event_name,
                   GROUP_CONCAT(DISTINCT s.name SEPARATOR ', ')  as name,
                   c2.name as city,
                   c3.contract_name,
                   p.name  as partner_name
            from evidention_items ei
                     inner join evidentions e on ei.evidention_id = e.id
                     inner join evidention_statuses es on e.id = es.evidention_id
                     inner join cities c2 on e.city_id = c2.id
                     inner join contracts c3 on e.contract_id = c3.id
                     inner join partners p on c3.partner_id = p.id
                     INNER JOIN items i on ei.item_id = i.id
                     inner join evidention_services es1 on e.id = es1.evidention_id
                     inner join services s on es1.service_id = s.id
            where es.status_id = (select max(status_id) from evidention_statuses ev1 where ev1.evidention_id = e.id)
              and es.status_id = 6
              and e.isActive = 1
              and es.isActive = 1
              and e.date >= '" . $request->dateFrom . "'
              and e.date <= '" . $request->dateTo . "'
              AND ei.isActive = 1";

        // Ako postoje troškovi gradi se upit
        if ($hasItems) {
            $query .= $items;
        }

        $query .= " GROUP BY event_name ORDER BY item_name";

        /* --------------------------------- Pravljanje i punjenje excela ---------------------------------*/

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H1')->getFont()->setSize(12);

        // Pravljenje naslova za excel
        $ltrPos = 0;
        $headingDimensions = [25, 12, 22, 20, 45, 20, 20, 30];
        $headings = ['Trošak', 'Iznos', 'Datum', 'Naziv događaja', 'Usluga', 'Grad', 'Ugovor', 'Partner'];

        foreach ($headings as $heading) {
            $sheet->getColumnDimension($letters[$ltrPos])->setWidth($headingDimensions[$ltrPos]);
            $sheet->setCellValue($letters[$ltrPos] . '1', $heading);
            $ltrPos++;
        }
        $sheet->getRowDimension(1)->setRowHeight(40);

        // Izvlacenje podataka iz baze
        $results = DB::select($query);

        /*------------------------------------------- Punjenje excel kolona ---------------------------------------*/
        $j = 0;
        $ltrNum = 2;

        $keys = ['item_name', 'value', 'date', 'event_name', 'name', 'city', 'contract_name', 'partner_name'];

        for ($i = 0; $i < sizeof($results); $i++) {
            $tempResult = $results[$i];

            foreach ($keys as $key) {
                $sheet->setCellValue($letters[$j] . $ltrNum, $tempResult->$key);
                $j++;
            }

            $j = 0;
            $ltrNum++;
        }
        /*-----------------------------------------------------------------------------------------------------------*/

        // Stilovi kolona
        $sheet->getRowDimension($i)->setRowHeight(20);
        $sheet->getStyle('A2:H' . $ltrNum)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B2:B' . $ltrNum)->getNumberFormat()->setFormatCode('0.00');
        $sheet->getStyle('A2:H' . $ltrNum)->getFont()->setSize(12);

        // Borderi
        $sheet->getStyle('A2:H' . $ltrNum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        $sheet->getStyle('A1:H' . 1)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A2:A' . $ltrNum)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('H2:H' . $ltrNum)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //----------------------------------- Bojenje redova -------------------------------------
        $counter = 0;
        for ($k = 0; $k < $ltrNum; $k++) {
            if ($k % 2 == 0) {
                $sheet->getStyle('A' . $counter . ':H' . $counter)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f2f2f2'); // =================
            } else {
                $sheet->getStyle('A' . $counter . ':H' . $counter)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4e4e4'); // =================
            }
            $counter++;
        }
        //-----------------------------------------------------------------------------------------
        $sheet->getStyle('A1:H1')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('cccccc'); // =================


        // Kreiranje novog Xlsx objekta
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        $writer->save('php://output');
    }

    public function clientsReport(Request $request)
    {
        $request->validate([
            'client' => 'present',
            'services' => 'present',
            'country' => 'present',
            'cities' => 'present',
            'dateFrom' => 'required',
            'dateTo' => 'required',
        ]);

        // Pravljenje niza od A do Z excel
        $lettersA_Z = range('A', 'Z');

        // Pravljenje niza od AA do AZ excel
        $lettersAA_AZ = array_map(function ($letter) {
            return ('A' . $letter);
        }, $lettersA_Z);

        // Spajanje niza od A-Z i AA-AZ
        $letters = array_merge($lettersA_Z, $lettersAA_AZ);

        $hasPartner = false;
        $hasCities = false;
        $hasServices = false;

        // Gradjenje upita
        $partner = "";
        $cities = " and ci.id in (0, ";
        $services = " and s.id in (0, ";

        if (is_array($request->services) || is_object($request->services)) {

            foreach ($request->services as $service) {
                $services .= $service['id'] . ', ';
                $hasServices = true;
            }

        }
        if (is_array($request->cities) || is_object($request->cities)) {

            foreach ($request->cities as $city) {
                $cities .= $city['id'] . ', ';
                $hasCities = true;
            }

        }

        if ($request->client != null) {
            $partner = " and p.id = " . $request->client['id'];
            $hasPartner = true;
        }


        $cities = substr($cities, 0, strlen($cities) - 2) . ') ';
        $services = substr($services, 0, strlen($services) - 2) . ') ';

        // Upit koji vraca evideciju sa troškovima
        $query = "select
                       p.name  as partner_name,
                       e.net ,
                       e.rebate,
                       e.net_rebate,
                       e.vat,
                       e.gross,
                       e.date,
                       e.event_name,
                       GROUP_CONCAT(s.name SEPARATOR ', ')  as service,
                       ci.name as city,
                       co.contract_name
                from evidentions e
                         inner join evidention_statuses es2 on e.id = es2.evidention_id
                         inner join evidention_services es on e.id = es.evidention_id
                         inner join services s on es.service_id = s.id
                         inner join cities ci on e.city_id = ci.id
                         inner join contracts co on e.contract_id = co.id
                         inner join partners p on co.partner_id = p.id
                where es2.status_id = (select max(status_id) from evidention_statuses ev1 where ev1.evidention_id = e.id)
                  and e.isActive = 1
                  and es.isActive = 1
                  and e.date >= '" . $request->dateFrom . "'
                  and e.date <= '" . $request->dateTo . "'";

        // Ako postoje troškovi gradi se upit
        if ($hasPartner) {
            $query .= $partner;
        }

        if ($hasCities) {
            $query .= $cities;
        }

        if ($hasServices) {
            $query .= $services;
        }

        $query .= " GROUP BY e.id";
        /* --------------------------------- Pravljanje i punjenje excela ---------------------------------*/

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:L1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:L1')->getFont()->setSize(12);

        // Pravljenje naslova za excel
        $ltrPos = 0;
        $headingDimensions = [35, 12, 12, 12, 12, 12, 20, 25, 40, 20, 20];
        $headings = ['Partner', 'Neto', 'Rabat', 'Neto iznos', 'PDV', 'Bruto iznos', 'Datum', 'Naziv događaja', 'Usluga', 'Grad', 'Ugovor'];

        foreach ($headings as $heading) {
            $sheet->getColumnDimension($letters[$ltrPos])->setWidth($headingDimensions[$ltrPos]);
            $sheet->setCellValue($letters[$ltrPos] . '1', $heading);
            $ltrPos++;
        }
        $sheet->getRowDimension(1)->setRowHeight(40);

        // Izvlacenje podataka iz baze
        $results = DB::select($query);

        /*------------------------------------------- Punjenje excel kolona ---------------------------------------*/
        $j = 0;
        $ltrNum = 2;

        $keys = ['partner_name', 'net', 'rebate', 'net_rebate', 'vat', 'gross', 'date', 'event_name', 'service', 'city', 'contract_name'];

        for ($i = 0; $i < sizeof($results); $i++) {
            $tempResult = $results[$i];

            foreach ($keys as $key) {
                $sheet->setCellValue($letters[$j] . $ltrNum, $tempResult->$key);
                $j++;
            }

            $j = 0;
            $ltrNum++;
        }
        /*-----------------------------------------------------------------------------------------------------------*/

        // Stilovi kolona
        $sheet->getRowDimension($i)->setRowHeight(20);
        $sheet->getStyle('A2:K' . $ltrNum)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:K' . $ltrNum)->getFont()->setSize(12);

        // Borderi
        $sheet->getStyle('A2:K' . $ltrNum)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);
        $sheet->getStyle('A1:K' . 1)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A2:A' . $ltrNum)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('K2:K' . $ltrNum)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //----------------------------------- Bojenje redova -------------------------------------
        $counter = 0;
        for ($k = 0; $k < $ltrNum; $k++) {
            if ($k % 2 == 0) {
                $sheet->getStyle('A' . $counter . ':K' . $counter)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f2f2f2'); // =================
            } else {
                $sheet->getStyle('A' . $counter . ':K' . $counter)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e4e4e4'); // =================
            }
            $counter++;
        }
        //-----------------------------------------------------------------------------------------
        $sheet->getStyle('A1:K1')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('cccccc'); // =================


        // Kreiranje novog Xlsx objekta
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        $writer->save('php://output');
    }

    public function getInstruction()
    {
        return File::get(storage_path() . '/instruction/Instruction.pdf');
    }

    public function getInstructionClient()
    {
        return File::get(storage_path() . '/instruction/InstructionClient.pdf');
    }

    public function getReport()
    {
        ob_end_clean();
        return response()->download(storage_path() . '/excel/File.xlsx', 'File.xlsx');
    }
}

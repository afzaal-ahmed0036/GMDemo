<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Yajra\DataTables\DataTables;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Customer;
use App\Models\Employee;

use App\Models\Service;
use App\Models\Item;
use App\Models\SalePerson;
use App\Models\Party;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagetitle               = 'Appointments';
        if ($request->ajax()) {
            $cases = Appointment::with(['client', 'saleperson', 'services'])->select(sprintf('%s.*', (new Appointment)->table));
            $table = Datatables::of($cases);
            $table->addColumn('client_name', function ($cases) {
                return $cases->client ? $cases->client->Phone : '';
            });
            $table->addColumn('employee_name', function ($cases) {
                return $cases->saleperson ? $cases->saleperson->FullName : '';
            });

            $table->rawColumns(['active'])
                ->addColumn('status', function ($cases) {
                    $nowDate = Carbon::now();
                    $result = $nowDate->gt($cases->finish_time);
                    $html = '<div class="d-flex gap-1">';
                    //$html .= 'Now Date '.$nowDate.'<br>';
                    //$html .= 'Finish Time '.$cases->finish_time.'<br>';
                    if ($result)
                        $html .= 'Completed';
                    else
                        $html .= 'Active';
                    $html .= '  </div>';

                    return $html;
                })->addColumn('actions', function ($cases) {
                    $html = '<div class="d-flex gap-1">';
                    $html .= ' <a href="' . route('appointments.edit', $cases->id) . '" class="text-secondary" title="Edit Appointment"><i class="mdi mdi-pencil font-size-15"></i></a> ';
                    $html .= ' &nbsp <a href="#" class="text-secondary" onclick="delete_confirm2(' . $cases->id . ')" title="Remove Appointment"><i class="mdi mdi-delete font-size-15"></i></a>';
                    //$html .= ' &nbsp <a href="' . route('appointments.systemCalander', $cases->id) . '" class="text-secondary" title="View on calendar"><i class="mdi mdi-calendar font-size-15"></i></a>';
                    $html .= '  </div>';
                    return $html;
                })->rawColumns(['active', 'status', 'actions']);

            return $table->make(true);
        }
        return view('appointments.index', compact('pagetitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients     = Party::all()->pluck('Phone', 'PartyID')->prepend(trans('Please Select'), '0');

        $pagetitle   = 'Book Appointments';
        $employees   = SalePerson::all()->where('UserType', '=', 'Saleman')->pluck('FullName', 'UserID')->prepend(trans('Please Select'), '');
        $services    = Item::where('ItemType', '=', 'Goods')->get()->pluck('ItemName', 'ItemID');
        return view('appointments.create', compact('clients', 'employees', 'services'));
    }

    public function store(Request $request)
    {
        $appointment = Appointment::create($request->all());
        if (!empty($request->services)) {

            $services    = $request->services;
            foreach ($services as $service) {
                DB::table('appointment_item')->insert(['appointment_id' => $appointment->id, 'item_ItemID' => $service]);
            }
        }
        //  $appointment->services()->sync($request->input('services', []));
        return redirect()->route('appointments.create')->with('success', 'Save Successfully.');
    }


    public function edit(Appointment $appointment)
    {
        $clients     = Party::all()->pluck('Phone', 'PartyID')->prepend(trans('Please Select'), '');
        $pagetitle = 'Book Appointments';
        $employees = SalePerson::all()->where('UserType', '=', 'Saleman')->pluck('FullName', 'UserID')->prepend(trans('Please Select'), '');
        $services  = Item::where('ItemType', '=', 'Service')->get()->pluck('ItemName', 'ItemID');
        $appointment->load('client', 'saleperson', 'services');
        return view('appointments.edit', compact('clients', 'employees', 'services', 'appointment'));
    }


    public function update(Request $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        $appointment->services()->sync($request->input('services', []));
        return redirect()->back()->with('success', 'Updated Successfully.');
    }

    public function massDestroy($id)
    {
        Appointment::where('id', $id)->delete();
        return redirect()->route('appointments.index')->with('success', 'Deleted Successfully.');
    }


    public function systemCalander()
    {
        $events = [];
        $appointments = Appointment::with(['client', 'saleperson'])->get();
        $currentDate = date('Y-m-d');

        foreach ($appointments as $appointment) {

            if (!$appointment->start_time) {
                continue;
            }

            $className  = "bg-success";
            $start_time = $appointment->start_time;

            if (Carbon::parse($start_time)->format('Y-m-d') < $currentDate) {
                $className = "bg-danger";
            } elseif (Carbon::parse($start_time)->format('Y-m-d') == $currentDate) {
                $className = "bg-warning";
            } else {
                $className = "bg-success";
            }

            $events[] = [
                'title'     => $appointment->client->Phone . ' (' . $appointment->saleperson->UserName . ')',
                'start'     => $start_time,
                'url'       => route('appointments.edit', $appointment->id),
                'className' => $className
            ];
        }
        $pagetitle = 'Appointments On Full Calendar';
        return view('appointments.calendar', compact('events', 'pagetitle'));
    }
}

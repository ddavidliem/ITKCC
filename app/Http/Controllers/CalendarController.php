<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $events = [];

        $appointment = Appointment::where('status', '=', 'Approved')->get();
        foreach ($appointment as $item) {
            $events[] = [
                'title' => $item->nama,
                'start' => $item->date_time,
                // 'end' => $item->date_time,
            ];
        }
        businessHours: {
            daysofWeek:
            [1, 2, 3, 4, 5];
            startTime:
            '08::00';
            endTime:
            '16.00';
        }

        return view('admin.appointment.schedule', compact('events'));
    }
}

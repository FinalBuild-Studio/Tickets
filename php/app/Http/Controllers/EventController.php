<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::whereDate('start_at', '>', new Carbon('+1 days'))
            ->latest()
            ->paginate(12);

        return view('event.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::where('id', $id)
            ->firstOrFail();

        return view('event.show', compact('event'));
    }
}

<?php

namespace App\Mail;

use Carbon\Carbon;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Jsvrcek\ICS\Model\{Calendar, CalendarEvent};
use Jsvrcek\ICS\Model\Description\Location;
use Jsvrcek\ICS\Model\Relationship\Attendee;
use Jsvrcek\ICS\Utility\Formatter;
use Jsvrcek\ICS\{CalendarStream, CalendarExport};

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;

        $location = new Location();
        $location->setName($order->event->address.' '.$order->event->place);

        // add an Attendee
        $attendee = new Attendee(new Formatter());
        $attendee->setValue($order->email)
            ->setName($order->name);

        // setup an event
        $event = new CalendarEvent();
        $event->setStart(new Carbon($order->event->start_at))
            ->setEnd(new Carbon($order->event->end_at))
          	->setSummary($order->event->name)
          	->setUid($order->reference)
            ->addLocation($location)
            ->addAttendee($attendee);

        // setup calendar
        $calendar = new Calendar();
        $calendar->setProdId('-//CapsLock, Studio//Calendar//EN')
            ->addEvent($event);

        // setup exporter
        $calendarExport = new CalendarExport(new CalendarStream, new Formatter());
        $calendarExport->addCalendar($calendar);

        $ics = $calendarExport->getStream();

        return $this
            ->subject('[CapsLock, Studio Event] '.$order->event->name.': 訂單已成立！感謝您的參與！')
            ->view('mails.order.confirmed')
            ->attachData($ics, 'calendar.ics', ['mime' => 'calendar/event'])
            ->with(compact('order'));
    }
}

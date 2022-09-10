<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class GoogleCalendarController extends Controller
{
    public function admin() {
      return view('calendar.admin');
    }

    public function register(Request $request) {

      $event = new Event;

      $event->name = $request->name;
      $event->description = $request->description;
      $event->startDateTime = new Carbon($request->start_time);
      $event->endDateTime = new Carbon($request->end_time);

      $event->save();

      return redirect()->route('admin');
    }

    public function getTodayEvent(){

      $event = new Event;

      $start_dt = new Carbon('today');
      $end_dt = new Carbon('tomorrow');
      $events = Event::get($start_dt);
      $today_events = [];

      
      foreach($events as $event){
        if($event->startDateTime < $end_dt) {
          $today_events[] = $event;
        }
      }

      foreach($today_events as $event) {
        echo $event->name;
        echo '<br>';
        echo $event->description;
        echo '------------';
        echo '<br><br>';
      }
    }

    public function getTomorrowEvent() 
    {
      $event = new Event;

      $start_dt = new Carbon('tomorrow');
      $end_dt = new Carbon('tomorrow');
      $end_dt = $end_dt->addDay();
      $events = Event::get($start_dt);
      $tomorrow_events = [];

      foreach($events as $event){
        
        if($event->startDateTime < $end_dt) {
          $tomorrow_events[] = $event;
        }
      }

      foreach($tomorrow_events as $event) {
        echo $event->name;
        echo '<br>';
        echo $event->description;
        echo '<br>';
        echo '------------';
        echo '<br><br>';
      }
    }

    public function getSpecificEvent(Request $request) {

      $event = new Event;

      $start_dt = new Carbon($request->day);
      $end_dt = new Carbon($request->day);
      $end_dt = $end_dt->addDay();
      $events = Event::get($start_dt);
      $day_events = [];

      foreach($events as $event){
        
        if($event->startDateTime < $end_dt) {
          $day_events[] = $event;
        }
      }

      foreach($day_events as $event) {
        echo $event->name;
        echo '<br>';
        echo $event->description;
        echo '<br>';
        echo '------------';
        echo '<br><br>';
      }
    }
}
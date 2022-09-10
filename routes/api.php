<?php

use App\Http\Controllers\GoogleCalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

$httpClient = new CurlHTTPClient($_ENV['LINE_CHANNEL_ACCESS_TOKEN']);
$bot = new LINEBot($httpClient, ['channelSecret' => $_ENV['LINE_CHANNEL_SECRET']]);

Route::post('/webhook', function (Request $request) use ($bot) {
    $request->collect('events')->each(function ($event) use ($bot) {
        if ($event['message']['text'] === '今日') {

            $start_dt = new Carbon('today');
            $end_dt = new Carbon('tomorrow');
            $events = Event::get($start_dt);
            $today_events = [];
            
            foreach($events as $today_event){
                if($today_event->startDateTime < $end_dt) {
                    $today_events[] = $today_event;
                }
            }

            $result = '';

            for($i = 0; $i < count($today_events); $i++) {
                if($i == count($today_events) - 1) {
                    $result .= nl2br('タイトル : ' . $today_events[$i]->name).PHP_EOL;
                    $result .= nl2br('詳細 : ' . $today_events[$i]->description).PHP_EOL;
                    $result .= nl2br('開始時間 : ' . $today_events[$i]->startDateTime);
                } else {
                    $result .= nl2br('タイトル : ' . $today_events[$i]->name).PHP_EOL;
                    $result .= nl2br('詳細 : ' . $today_events[$i]->description).PHP_EOL;
                    $result .= nl2br('開始時間 : ' . $today_events[$i]->startDateTime).PHP_EOL.PHP_EOL;
                }  
            }
            // $result = $today_events[0]->name;
            $bot->replyText($event['replyToken'], $result);
            
        }

        if ($event['message']['text'] === '明日') {

            $start_dt = new Carbon('tomorrow');
            $end_dt = new Carbon('tomorrow');
            $end_dt = $end_dt->addDay();
            $events = Event::get($start_dt);
            $tomorrow_events = [];

            foreach($events as $tomorrow_event) {
                if($tomorrow_event->startDateTime < $end_dt) {
                    $tomorrow_events[] = $tomorrow_event;
                }
            }

            $result = '';

            for($i = 0; $i < count($tomorrow_events); $i++) {
                if($i == count($tomorrow_events) - 1) {
                    $result .= nl2br('タイトル : ' . $tomorrow_events[$i]->name).PHP_EOL;
                    $result .= nl2br('詳細 : ' . $tomorrow_events[$i]->description).PHP_EOL;
                    $result .= nl2br('開始時間 : ' . $tomorrow_events[$i]->startDateTime);
                } else {
                    $result .= nl2br('タイトル : ' . $tomorrow_events[$i]->name).PHP_EOL;
                    $result .= nl2br('詳細 : ' . $tomorrow_events[$i]->description).PHP_EOL;
                    $result .= nl2br('開始時間 : ' . $tomorrow_events[$i]->startDateTime).PHP_EOL.PHP_EOL;
                }  
            }

            $bot->replyText($event['replyToken'], $result);
        }

        if(strpos($event['message']['text'], '月') && strpos($event['message']['text'], '日')) {
            $index_month = mb_strpos($event['message']['text'], '月');
            $index_date = mb_strpos($event['message']['text'], '日');
            $month = mb_substr($event['message']['text'], 0, $index_month);
            $date = mb_substr($event['message']['text'], $index_month + 1, $index_date);
            if(strlen($month) === 1) {
                $month = '0'.$month;
            }
            if(strlen($date) === 1) {
                $date = '0'.$date;
            }
            $year = intval('2022');
            $month = intval($month);
            $date = intval($date);
            $full_date = $year . '-' . $month . '-' . $date;

            $start_dt = new Carbon($full_date);
            $end_dt = new Carbon($full_date);
            $end_dt = $end_dt->addDay();
            $events = Event::get($start_dt);
            $specific_events = [];

            foreach($events as $specific_event) {
                if($specific_event->startDateTime < $end_dt) {
                    $specific_events[] = $specific_event;
                }
            }

            $result = '';

            for($i = 0; $i < count($specific_events); $i++) {
                if($i == count($specific_events) - 1) {
                    $result .= nl2br('タイトル : ' . $specific_events[$i]->name).PHP_EOL;
                    $result .= nl2br('詳細 : ' . $specific_events[$i]->description).PHP_EOL;
                    $result .= nl2br('開始時間 : ' . $specific_events[$i]->startDateTime);
                } else {
                    $result .= nl2br('タイトル : ' . $specific_events[$i]->name).PHP_EOL;
                    $result .= nl2br('詳細 : ' . $specific_events[$i]->description).PHP_EOL;
                    $result .= nl2br('開始時間 : ' . $specific_events[$i]->startDateTime).PHP_EOL.PHP_EOL;
                }  
            }
            
            $bot->replyText($event['replyToken'], $result);
        }
        
    });
    // return 'ok!';
});

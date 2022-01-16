<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yasumi\Yasumi;
use Auth;
use DB;

use App\Models\User;
use App\Models\Shift;
use App\Models\Attendance;

class AttendancesController extends Controller
{
  public function show(User $user, Request $request){
    if(Auth::user()->role != 10 && $user->id != Auth::id()){
      abort(404);
    }
    $year = $request->year;
    $month = $request->month;
    if($year == 'NaN' || $month == 'NaN'){
      return redirect()->route('attendance.show', $user->id);
    }
    $carbon = ($year != '' &&  $month != '') ? new Carbon("{$year}-{$month}") : new Carbon();

    if(!Auth::user()->attendances()->where('date', $carbon->format('Y-m-d'))->exists()){
      return redirect("attendance/create?year={$carbon->year}&month={$carbon->month}");
    }

    $holidays = Yasumi::create('Japan', $carbon->year, 'ja_JP');
    $last_day = $carbon->copy()->lastOfMonth();
    $day = $carbon->copy()->firstOfMonth();
    $weeks = ['日', '月', '火', '水', '木', '金', '土'];
    while($day->lte($last_day)){

      $days[$day->format('j')]['week'] = $weeks[$day->format('w')];

      if($holidays->isHoliday($day) || $day->format('w') == 0){
        $days[$day->format('j')]['class'] = 'text-danger';
      }elseif($day->format('w') == 6){
        $days[$day->format('j')]['class'] = 'text-info';
      }else{
        $days[$day->format('j')]['class'] = '';
      }

      $day->addDay();
    }
    $items = ['', '稼働', '公休', '有給'];

    $attendances = $user->monthAttendances($carbon->format('Y-m'));
    $shifts = $user->activeShifts()->where('date', 'like', $carbon->format('Y-m') . '%')->get();

    return view('attendances.show', compact('user', 'carbon', 'days', 'items', 'attendances', 'shifts'));
  }

  public function create(Request $request){
    $year = $request->year;
    $month = $request->month;
    $carbon = ($year != '' &&  $month != '') ? new Carbon("{$year}-{$month}") : new Carbon();
    if(Auth::user()->attendances()->where('date', $carbon->format('Y-m-d'))->exists()){
      return redirect('attendance/' . Auth::id() . "?year={$carbon->year}&month={$carbon->month}");
    }
    $holidays = Yasumi::create('Japan', $carbon->year, 'ja_JP');

    $last_day = $carbon->copy()->lastOfMonth();
    $day = $carbon->copy()->firstOfMonth();
    $weeks = ['日', '月', '火', '水', '木', '金', '土'];
    while($day->lte($last_day)){

      $days[$day->format('j')]['week'] = $weeks[$day->format('w')];

      if($holidays->isHoliday($day) || $day->format('w') == 0){
        $days[$day->format('j')]['class'] = 'text-danger';
      }elseif($day->format('w') == 6){
        $days[$day->format('j')]['class'] = 'text-info';
      }else{
        $days[$day->format('j')]['class'] = '';
      }

      $day->addDay();
    }
    $items = ['', '稼働', '公休', '有給'];

    return view('attendances.create', compact('carbon', 'days', 'items'));
  }

  public function store(Request $request){
    DB::beginTransaction();
    try{
      $carbon = New Carbon($request->month);
      if(Auth::user()->attendances()->where('date', $carbon->format('Y-m-01'))->exists()){
        abort(404);
      }

      $day = $carbon->copy()->firstOfMonth();
      $last_day = $carbon->copy()->lastOfMonth();
      $i = 0;
      $index = 0;
      while($day->lte($last_day)){
        if($request->items[$i] == 1){

          $break_time = $request->break_times[$index];
          $start_at = $request->start_at[$index];
          $end_at = $request->end_at[$index];
          $index++;
        }else{
          $break_time = 0;
          $start_at = null;
          $end_at = null;
        }

        $attendance = Attendance::create([
          'user_id' => Auth::id(),
          'date' => $day->format('Y-m-d'),
          'break_time' => $break_time,
          'memo' => $request->memos[$index],
        ]);

        Shift::create([
          'attendance_id' => $attendance->id,
          'is_edit' => false,
          'item' => $request->items[$i],
          'start_at' => $start_at,
          'end_at' => $end_at,
          'approve' => 1
        ]);

        $day->addDay();
        $i++;
      }

      DB::commit();
      return redirect('attendance/' . Auth::id() . "?year={$carbon->year}&month={$carbon->month}");
    }catch(\Exception $e){

      DB::rollback();
      return redirect()->route('home');
    }

  }

  public function update(Request $request, Attendance $attendance){
    $attendance->fill($request->input())->save();
  }
}

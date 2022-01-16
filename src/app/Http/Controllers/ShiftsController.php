<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;

use App\Models\User;
use App\Models\Shift;

class ShiftsController extends Controller
{
  public function index(Request $request){
    $year = $request->year;
    $month = $request->month;
    if($year == 'NaN' || $month == 'NaN'){
      return redirect()->route('shift.index');
    }
    $carbon = ($year != '' && $month != '') ? new Carbon($year . '-' . $month . '-01') : new Carbon(date('Y-m-01'));

    $month = $carbon->format('Y-m');

    $pending_shifts = Shift::pendingShifts($carbon->format('Y-m'));

    return view('shifts.index', compact('month', 'pending_shifts'));
  }
  public function show(User $user, $date = ''){
    if(Auth::user()->role != 1 && $user->id != Auth::id()){
      abort(404);
    }

    $carbon = $date ? new Carbon($date) : new Carbon();
    $date = $carbon->format('Y-m-d');

    $active_shift = $user->activeShifts()->where('date', $date)->first();

    $not_active_shifts = $user->notActiveShifts()->where('date', $date)->get();

    $is_pending_shift = $user->approvePendingShifts()->where('date', $date)->exists();

    return view('shifts.show', compact('user', 'date', 'active_shift', 'not_active_shifts', 'is_pending_shift'));
  }
  public function create(Request $request){
    $carbon = new Carbon($request->date);
    $date = $carbon->format('Y-m-d');

    $active_shift = Auth::user()->activeShifts()->where('date', $date)->first();
    $is_pending_shift = Auth::user()->approvePendingShifts()->where('date', $date)->first();

    if(!$active_shift || $is_pending_shift){
      abort(404);
    }

    return view('shifts.create', compact('active_shift', 'date'));
  }
  public function store(Request $request){
    $active_shift = Auth::user()->activeShifts()->where('date', $request->date)->first();

    $data = $request->input();
    $data['is_edit'] = true;
    $data['approve'] = 0;
    $data['before_shift_id'] = $active_shift->id;
    $data['attendance_id'] = $active_shift->attendance_id;

    Shift::create($data);

    return redirect()->route('shift.show', ['user' => Auth::id(), 'date' => $request->date]);
  }
  public function edit(Shift $shift){
    if($shift->approve != 0 || $shift->attendance->user_id != Auth::id()){
      abort(404);
    }

    $date = $shift->attendance->date->format('Y-m-d');

    return view('shifts.edit', compact('date', 'shift'));
  }
  public function update(Request $request, Shift $shift){
    if($shift->approve != 0 || $shift->attendance->user_id != Auth::id()){
      abort(404);
    }

    $shift->fill($request->input())->save();

    return redirect()->route('shift.show', ['user' => Auth::id(), 'date' => $shift->attendance->date->format('Y-m-d')]);
  }
  public function destroy(Request $request, Shift $shift){
    if($shift->approve != 0 || $shift->attendance->user_id != Auth::id()){
      abort(404);
    }

    $shift->delete();

    return back();
  }
  public function shiftApprove(Request $request, Shift $shift){
    if(Auth::user()->role != 1 || $shift->attendance->user_id == Auth::id()){
      abort(404);
    }
    DB::beginTransaction();
    try{

      $approve = $request->has('ok') ? 1 : 2;
      if($approve == 1){
        $active_shift = $shift->attendance->user->activeShifts()->where('date', $request->date)->firstOrFail();
        $active_shift->fill(['approve' => 2])->save();
      }

      $shift->fill(compact('approve'))->save();

      DB::commit();
      return redirect()->route('shift.show', ['user' => $shift->attendance->user_id, 'date' => $request->date]);
    }catch(\Exception $e){

      DB::rollback();
      return redirect()->route('home');
    }
  }

  public function shiftApproveMany(Request $request){

    if(Auth::user()->role != 1){
      abort(404);
    }
    DB::beginTransaction();
    try{
      foreach($request->shift_ids as $shift_id){
        $shift = Shift::findOrFail($shift_id);
        $shift->fill(['approve' => 1])->save();
        if($shift->beforeShift){
          $shift->beforeShift->fill(['approve' => 2])->save();
        }
      }
      DB::commit();
      return back();
    }catch(\Exception $e){

      DB::rollback();
      return redirect()->route('home');
    }
  }
}

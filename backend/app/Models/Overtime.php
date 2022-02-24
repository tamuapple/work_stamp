<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Attendance;

class Overtime extends Model
{
  protected $fillable = [
    'attendance_id', 'before_overtime_id', 'is_early',
    'start_at', 'end_at', 'approve', 'memo'
  ];

  public function attendance(){
    return $this->belongsTo(Attendance::class);
  }

  public function beforeOvertime(){
    return $this->belongsTo(self::class, 'before_overtime_id');
  }

  public static function pendingEarlytimes($month){
    return self::with('attendance.user', 'attendance.activeShifts',
    'attendance.activeStartWorkStamps','attendance.activeEndWorkStamps', 'beforeOvertime')
    ->where('is_early', true)
    ->where('approve', 0)
    ->whereIn('attendance_id', function($q) use($month){
      $q->from('attendances')->select('id')->where('date', 'like', $month . '%');
    })
    ->latest('created_at')
    ->get();
  }

  public static function pendingOvertimes($month){
    return self::with('attendance.user', 'attendance.activeShifts',
    'attendance.activeStartWorkStamps','attendance.activeEndWorkStamps', 'beforeOvertime')
    ->where('is_early', false)
    ->where('approve', 0)
    ->whereIn('attendance_id', function($q) use($month){
      $q->from('attendances')->select('id')->where('date', 'like', $month . '%');
    })
    ->latest('created_at')
    ->get();
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Attendance;

class WorkStamp extends Model
{
  protected $fillable = [
    'attendance_id', 'before_work_stamp_id', 'is_edit', 'is_start',
    'stamp_at', 'exception', 'approve', 'memo'
  ];

  public function attendance(){
    return $this->belongsTo(Attendance::class);
  }
  public function beforeWorkStamp(){
    return $this->belongsTo(self::class, 'before_work_stamp_id');
  }

  public static function pendingWorkStamps($month){
    return self::with('attendance.user', 'attendance.activeShifts', 'beforeWorkStamp')
    ->where('approve', 0)
    ->whereIn('attendance_id', function($q) use($month){
      $q->from('attendances')->select('id')->where('date', 'like', $month . '%');
    })
    ->latest('created_at')
    ->get();
  }
}

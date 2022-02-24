<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Attendance;

class Shift extends Model
{
  protected $fillable = [
    'attendance_id', 'before_shift_id', 'is_edit', 'item',
    'start_at', 'end_at', 'approve', 'memo'
  ];

  public function attendance(){
    return $this->belongsTo(Attendance::class);
  }

  public function beforeShift(){
    return $this->belongsTo(self::class, 'before_shift_id');
  }

  public static function pendingShifts($month){
    return self::with('attendance.user', 'beforeShift')
    ->where('approve', 0)
    ->whereIn('attendance_id', function($q) use($month){
      $q->from('attendances')->select('id')->where('date', 'like', $month . '%');
    })
    ->latest('created_at')
    ->get();
  }
}

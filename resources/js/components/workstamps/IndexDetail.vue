<template>
  <tr>
    <td>
      <a :href="userShowLink(work_stamp.attendance.user.id)">{{ work_stamp.attendance.user.username }}</a>
    </td>
    <td>{{ day }}日</td>
    <td>{{ createdDate }}<br>{{ createdTime }}</td>
    <td>{{ isStart }}</td>
    <td>{{ beforeException }} → {{ exception }}</td>
    <td>
      {{ beforeStampAt }} → {{ stampAt }}
    </td>
    <td style="max-width: 200px">
      <div class="over-x scrollbar-none">
        {{ work_stamp.memo }}
      </div>
    </td>
    <td>
      <div class="mb-1">承認待ち</div>
      <input type="checkbox" name="work_stamp_ids[]" :value="work_stamp.id" form="form" @click="$emit('change-disabled')">
    </td>
    <td>
      <a :href="workStampShowLink(work_stamp.attendance.user_id, ymd)">詳細</a>
    </td>
  </tr>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'

export default {
  props: ['work_stamp'],
  mixins: [Data, Link],
  data(){
    return {
      'shift': this.work_stamp.attendance.active_shifts[0],
      'before_work_stamp': this.work_stamp.before_work_stamp,
      'date': new Date(this.work_stamp.attendance.date),
      'created_at': new Date(this.work_stamp.created_at),
    }
  },
  computed: {
    day(){
      return ('0' + this.date.getDate()).slice(-2)
    },
    isStart(){
      return this.work_stamp.is_start ? '出勤' : '退勤'
    },
    ymd(){
      var y = this.date.getFullYear()
      var m = ('0' + (this.date.getMonth() + 1)).slice(-2)
      var d = ('0' + this.date.getDate()).slice(-2)

      return `${y}-${m}-${d}`
    },
    createdDate(){
      var y = this.created_at.getFullYear()
      var m = ('0' + (this.created_at.getMonth() + 1)).slice(-2)
      var d = ('0' + this.created_at.getDate()).slice(-2)

      return `${y}/${m}/${d}`
    },
    createdTime(){
      var h = this.created_at.getHours()
      var i = ('0' + this.created_at.getMinutes()).slice(-2)
      var s = ('0' + this.created_at.getSeconds()).slice(-2)

      return `${h}:${i}:${s}`
    },
    exception(){
      var exception = this.work_stamp.exception
      if(exception == 0){
        return 'なし'
      }else if(exception == 1){
        if(this.work_stamp.is_start){
          return '遅刻'
        }else{
          return '早退'
        }
      }
    },
    beforeException(){
      var exception = this.before_work_stamp ? this.before_work_stamp.exception : ''
      if(!exception){
        return 'なし'
      }else if(exception == 1){
        if(this.before_work_stamp.is_start){
          return '遅刻'
        }else{
          return '早退'
        }
      }
    },
    stampAt(){
      if(this.work_stamp.exception == 0){
        if(this.work_stamp.is_start){
          return this.sliceTime(this.shift.start_at)
        }else{
          return this.sliceTime(this.shift.end_at)
        }
      }else{
        return this.sliceTime(this.work_stamp.stamp_at)
      }
    },
    beforeStampAt(){
      if(!this.before_work_stamp){
        return 'なし'
      }else{
        if(this.before_work_stamp.exception == 0){
          if(this.before_work_stamp.is_start){
            return this.sliceTime(this.shift.start_at)
          }else{
            return this.sliceTime(this.shift.end_at)
          }
        }else{
          return this.sliceTime(this.before_work_stamp.stamp_at)
        }
      }
    }
  }
}
</script>

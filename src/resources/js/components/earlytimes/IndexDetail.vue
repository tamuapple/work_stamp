<template>
  <tr>
    <td>
      <a :href="userShowLink(earlytime.attendance.user.id)">{{ earlytime.attendance.user.username }}</a>
    </td>
    <td>{{ day }}日</td>
    <td>{{ startAt }}~{{ endAt }}</td>
    <td>{{ createdDate }}<br>{{ createdTime }}</td>
    <td>{{ sliceTime(earlytime.start_at) }} ~ {{ sliceTime(earlytime.end_at) }}</td>
    <td style="max-width: 200px">
      <div class="over-x scrollbar-none">
        {{ earlytime.memo }}
      </div>
    </td>
    <td>
      <div class="mb-1">承認待ち</div>
      <input type="checkbox" name="earlytime_ids[]" :value="earlytime.id" form="form" @click="$emit('change-disabled')">
    </td>
    <td>
      <a :href="shiftShowLink(earlytime.attendance.user_id, ymd)">詳細</a>
    </td>
  </tr>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'

export default {
  props: ['earlytime'],
  mixins: [Data, Link],
  data(){
    return {
      'shift': this.earlytime.attendance.active_shifts[0],
      'start_work_stamp': this.earlytime.attendance.active_start_work_stamps[0],
      'end_work_stamp': this.earlytime.attendance.active_end_work_stamps[0],
      'date': new Date(this.earlytime.attendance.date),
      'created_at': new Date(this.earlytime.created_at),
    }
  },
  mounted(){
    console.log(this.start_work_stamp)
  },
  computed: {
    day(){
      return ('0' + this.date.getDate()).slice(-2)
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
    startAt(){
      if(this.start_work_stamp.exception == 0){
        return this.sliceTime(this.shift.start_at)
      }else{
        return `${this.sliceTime(this.start_work_stamp.stamp_at)}(遅刻)`
      }
    },
    endAt(){
      if(this.end_work_stamp.exception == 0){
        return this.sliceTime(this.shift.end_at)
      }else{
        return `${this.sliceTime(this.end_work_stamp.stamp_at)}(早退)`
      }
    }
  }
}
</script>

<template>
  <tr>
    <td>
      <a :href="userShowLink(shift.attendance.user.id)">{{ shift.attendance.user.username }}</a>
    </td>
    <td>{{ day }}日</td>
    <td>{{ createdDate }}<br>{{ createdTime }}</td>
    <td>
      {{ beforeShiftStatus }}
      <br v-if="shift.before_shift.item == 1">
      <span v-if="shift.before_shift.item == 1">
        {{ sliceTime(shift.before_shift.start_at) }}~{{ sliceTime(shift.before_shift.end_at) }}
      </span>
    </td>
    <td>
      {{ shiftStatus }}
      <br v-if="shift.item == 1">
      <span v-if="shift.item == 1">{{ sliceTime(shift.start_at) }}~{{ sliceTime(shift.end_at) }}</span>
    </td>
    <td style="max-width: 200px">
      <div class="over-x scrollbar-none">
        {{ shift.memo }}
      </div>
    </td>
    <td>
      <div class="mb-1">承認待ち</div>
      <input type="checkbox" name="shift_ids[]" :value="shift.id" form="form" @click="$emit('change-disabled')">
    </td>
    <td>
      <a :href="shiftShowLink(shift.attendance.user_id, ymd)">詳細</a>
    </td>
  </tr>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'

export default {
  props: ['shift'],
  mixins: [Data, Link],
  data(){
    return {
      'date': new Date(this.shift.attendance.date),
      'created_at': new Date(this.shift.created_at),
    }
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
    shiftStatus(){
      if(this.shift.item == 1){
        return '稼働'
      }else if(this.shift.item == 2){
        return '公休'
      }else{
        return '有給'
      }
    },
    beforeShiftStatus(){
      if(this.shift.before_shift.item == 1){
        return '稼働'
      }else if(this.shift.before_shift.item == 2){
        return '公休'
      }else{
        return '有給'
      }
    },

  }
}
</script>

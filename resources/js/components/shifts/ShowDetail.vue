<template>
  <tr>
    <td>{{ shiftItem }}</td>
    <td>
      <span v-if="shift.item == 1">{{ sliceTime(shift.start_at) }}</span>
    </td>
    <td>
      <span v-if="shift.item == 1">{{ sliceTime(shift.end_at) }}</span>
    </td>
    <td>
      <div class="mb-1">{{ isEdit }}</div>
      <div>{{ createdAt }}</div>
    </td>
    <td style="max-width: 200px">
      <div class="over-x scrollbar-none">{{ shift.memo }}</div>
    </td>
    <td :class="approveClass(shift.approve)" style="width: 100px" v-if="shift.approve == 0">
      <div v-if="user.id == authId()">
        <a :href="shiftEditLink(shift.id)" class="btn btn-sm btn-gradient-success">編集</a>
        <form :action="shiftAction(shift.id)" class="d-inline-block" method="post">
          <input type="hidden" name="_token" :value="csrfToken()">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-sm btn-gradient-danger">削除</button>
        </form>
      </div>
      <form :action="shiftApproveAction(shift.id)" method="post" v-else>
        <input type="hidden" name="_token" :value="csrfToken()">
        <input type="hidden" name="date" :value="date">
        <button type="submit" name="ok" class="btn btn-sm btn-gradient-info">承認</button>
        <button type="submit" class="btn btn-sm btn-gradient-danger">却下</button>
      </form>
    </td>
    <td :class="approveClass(shift.approve)" v-else>
      <div>{{ approve(shift.approve) }}</div>
      <form :action="shiftApproveAction(shift.id)" method="post" class="mt-1" v-if="user.id != authId()">
        <input type="hidden" name="_token" :value="csrfToken()">
        <input type="hidden" name="date" :value="date">
        <button type="submit" name="ok" class="btn btn-sm btn-gradient-info" v-if="shift.approve == 2">承認</button>
      </form>
    </td>
  </tr>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'
import ShowDetail from './ShowDetail.vue'

export default {
  props: ['user', 'date', 'shift'],
  mixins: [Data, Link],
  computed: {
    shiftItem(){
      if(this.shift.item == 1){
        return '稼働'
      }else if(this.shift.item == 2){
        return '公休'
      }else if(this.shift.item == 3){
        return '有給'
      }
    },
    isEdit(){
      if(this.shift.is_edit){
        return '修正'
      }else{
        return '申請'
      }
    },
    createdAt(){
      var D = new Date(this.shift.created_at)
      var y = D.getFullYear()
      var m = D.getMonth() + 1
      var d = D.getDate()
      var h = D.getHours()
      var i = D.getMinutes()
      var s = D.getSeconds()

      return `${y}/${m}/${d} ${h}:${i}:${s}`
    },
  }
}
</script>

<template>
  <tr class="shift-tr">
    <td>
      <span :class="colorClass">{{ day }}日({{ week }})</span>
    </td>
    <td>
      <select name="items[]" class="form-control" form="shift-form" v-model="item" @change="itemChange">
        <option v-for="(item, index) in items" :value="index">{{ item }}</option>
      </select>
    </td>
    <td>
      <input type="time" name="start_at[]" class="form-control" form="shift-form" v-model="start_at" :disabled="item != 1">
    </td>
    <td>
      <input type="time" name="end_at[]" class="form-control" form="shift-form" v-model="end_at" :disabled="item != 1">
    </td>
    <td>
      <select name="break_times[]" class="form-control" form="shift-form" v-model="break_time" :disabled="item != 1">
        <option v-for="(val, index) in break_times" :value="val">{{ index }}</option>
      </select>
    </td>
    <td>
      <span class="work-time">{{ workTime }}</span>{{ workTime ? '時間' : '' }}
    </td>
    <td>
      <input type="text" name="memos[]" class="form-control" form="shift-form">
    </td>
  </tr>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'

export default {
  props: ['day', 'colorClass', 'week', 'items', 'break_times'],
  mixins: [Data ,Link],
  data(){
    return {
      'item' : 0,
      'start_at' : null,
      'end_at' : null,
      'break_time' : ''
    }
  },
  computed: {
    workTime(){
      return this.getWorkTime(this.start_at, this.end_at, this.break_time)
    },
  },
  methods: {
    itemChange(){
      if(this.item != 1){
        this.start_at = null
        this.end_at = null
        this.break_time = ''
      }else{
        this.break_time = 0
      }
    },
  },
}
</script>

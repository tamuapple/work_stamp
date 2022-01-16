<template>
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title font-weight-bold">出勤簿</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a :href="userShowLink(authId())">ホーム</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">出勤簿</li>
        </ol>
      </nav>
    </div>
    <input type="month" name="month" form="shift-form" class="form-control mb-3 col-lg-3 col-md-6 col-12" v-model="month" @change="monthChange">
    <!-- <div class="mb-1">
      <button class="btn btn-sm btn-primary">一括申請</button>
    </div> -->
    <div class="stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">シフト</h4>
          <table class="table table-responsive-md text-center">
            <thead>
              <tr>
                <th>日</th>
                <th style="min-width: 100px">区分</th>
                <th>出勤時間</th>
                <th>退勤時間</th>
                <th style="min-width: 140px">休憩時間</th>
                <th>稼働時間</th>
                <th style="min-width: 200px">備考</th>
              </tr>
            </thead>
            <tbody>
              <CreateDetail v-for="(array, day) in days" :key="day" :colorClass="array.class" :day="day" :week="array.week" :items="items" :break_times="break_times" ></CreateDetail>
            </tbody>
          </table>
          <form action="/attendance" method="post" id="shift-form" class="row justify-content-between w-100 mx-auto px-3" ref="form">
            <div>
              <input type="hidden" name="_token" :value="csrfToken()">
            </div>
            <p class="text-danger text-center font-weight-bold" v-show="is_error">入力不備があります</p>
            <div>
              <button type="button" class="btn btn-sm btn-gradient-info btn-md" @click="check">申請</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'
import CreateDetail from './CreateDetail.vue'

export default {
  props: ['month', 'days'],
  mixins: [Data, Link],
  components: {
    CreateDetail
  },
  data(){
    return {
      'is_error': false,
      'items': { 0: '', 1: '稼働', 2: '公休', 3: '有給' },
      'break_times': {
        '0分': 0, '15分': 0.25, '30分': 0.5, '45分': 0.75,
        '1時間': 1, '1時間15分': 1.25, '1時間30分': 1.5, '1時間45分': 1.75,
        '2時間': 2, '2時間15分': 2.25, '2時間30分': 2.5,'2時間45分': 2.75
      },
    }
  },
  methods: {
    monthChange(){
      var D = this.month ? new Date(this.month) : new Date()
      var y = D.getFullYear()
      var m = D.getMonth() + 1
      window.location = `/attendance/create?year=${y}&month=${m}`
    },
    check(){
      this.is_error = false
      var elements = document.getElementsByClassName('shift-tr')
      for(let i = 0 ; i < elements.length; i++){
        if(elements[i].querySelector('[name="items[]"]').value == 0){

          this.is_error = true
          elements[i].querySelector('[name="items[]"]').classList.add('border-danger')

        }else if(elements[i].querySelector('[name="items[]"]').value == 1){

          if(elements[i].querySelector('[name="start_at[]"]').value == ''){
            this.is_error = true
            elements[i].querySelector('[name="start_at[]"]').classList.add('border-danger')
          }

          if(elements[i].querySelector('[name="end_at[]"]').value == ''){
            this.is_error = true
            elements[i].querySelector('[name="end_at[]"]').classList.add('border-danger')
          }
        }
      }

      if(this.is_error){
        return false
      }

      this.$refs.form.submit()
    }
  },
}
</script>

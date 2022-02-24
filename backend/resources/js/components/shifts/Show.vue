<template>
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title font-weight-bold">シフト詳細</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a :href="userShowLink(user.id)" v-if="user.id == authId()">ホーム</a>
            <a :href="userShowLink(user.id)" v-else>{{ user.username }}</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <a :href="attendanceShowLink(user.id)">出勤簿</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">シフト詳細</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6 col-lg-4 mb-3">
                <input type="date" class="form-control" v-model="day" @change="dateChange">
              </div>
            </div>
            <div v-if="active_shift">
              <table class="table table-bordered table-responsive-md text-center">
                <thead>
                  <tr>
                    <th>区分</th>
                    <th>出勤時間</th>
                    <th>退勤時間</th>
                    <th>申請時間</th>
                    <th style="min-width: 150px">備考</th>
                    <th>承認</th>
                  </tr>
                </thead>
                <tbody>
                  <ShowDetail :shift="active_shift" :user="user" :date="date"></ShowDetail>
                </tbody>
              </table>
              <div class="text-right mt-3" v-if="user.id == authId() && !is_pending_shift">
                <a :href="shiftCreateLink(date)" class="btn btn-sm btn-gradient-info">申請</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-if="not_active_shifts.length > 0">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered table-responsive-md text-center">
              <thead>
                <tr>
                  <th>区分</th>
                  <th>出勤時間</th>
                  <th>退勤時間</th>
                  <th>申請時間</th>
                  <th style="min-width: 150px">備考</th>
                  <th>承認</th>
                </tr>
              </thead>
              <tbody>
                <ShowDetail v-for="(shift, index) in not_active_shifts " :key="index" :date="date" :user="user" :shift="shift"></ShowDetail>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'
import ShowDetail from './ShowDetail.vue'

export default {
  props: ['user', 'date', 'active_shift', 'not_active_shifts', 'is_pending_shift'],
  mixins: [Data, Link],
  components:{
    ShowDetail
  },
  data(){
    return {
      'day': this.date,
    }
  },
  methods: {
    dateChange(){
      window.location = '/shift/' + this.user.id + '/' + this.day
    },
  },
}
</script>

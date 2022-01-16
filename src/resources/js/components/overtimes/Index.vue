<template>
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title font-weight-bold">残業申請一覧</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a :href="userShowLink(authId())">ホーム</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">残業申請一覧</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-md-6 col-lg-4 mb-3">
                <input type="month" class="form-control" v-model="month" @change="monthChange">
              </div>
            </div>
            <div v-if="pending_overtimes.length > 0">
              <table class="table table-bordered table-responsive-md text-center">
                <thead>
                  <tr>
                    <th>名前</th>
                    <th>日</th>
                    <th>出勤時間</th>
                    <th>申請時間</th>
                    <th>稼働時間</th>
                    <th style="min-width: 150px">備考</th>
                    <th>承認</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <IndexDetail v-for="(overtime, index) in pending_overtimes" :key="index" :overtime="overtime" @change-disabled="changeDisabled"></IndexDetail>
                </tbody>
              </table>
              <div class="text-right mt-3">
                <form id="form" action="/overtime/many/approve" method="post" ref="form">
                  <input type="hidden" name="_token" :value="csrfToken()">
                  <button type="button" class="btn btn-sm btn-gradient-info" :disabled="disabled" @click="submitConfirm">一括承認</button>
                </form>
              </div>
            </div>
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
import IndexDetail from './IndexDetail.vue'

export default {
  props: ['month', 'pending_overtimes'],
  mixins: [Data, Link],
  components:{
    IndexDetail
  },
  data(){
    return {
      'disabled': true,
      'total': 0
    }
  },
  methods: {
    monthChange(){
      var y = new Date(this.month).getFullYear()
      var m = new Date(this.month).getMonth() + 1
      window.location = `/overtime?year=${y}&month=${m}`
    },
    changeDisabled(){
      this.disabled = true
      document.getElementsByName('overtime_ids[]').forEach(elm => {
        if(elm.checked){
          this.total++
          this.disabled = false
        }
      })
    },
    submitConfirm(){
      if(confirm(`${this.total}件の申請を一括で承認しますか？`)){
        this.$refs.form.submit()
      }
    }
  },
}
</script>

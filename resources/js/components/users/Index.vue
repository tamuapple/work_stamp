<template>
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title font-weight-bold">ユーザー</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">ユーザー</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="mx-auto col-md-8 row justify-content-between mb-1">
        <div>合計{{ total_user_count }}人</div>
        <form ref="form">
          一般ユーザー <input type="radio" class="mr-2" name="is_admin" value="0" :checked="!is_admin" @change="changeRadio">
          管理者 <input type="radio" name="is_admin" value="1" :checked="is_admin" @change="changeRadio">
        </form>
      </div>
      <div class="col-md-8 grid-margin stretch-card mx-auto">
        <div class="card">
          <div class="card-body pt-0 over-y scrollbar-none" style="max-height: 450px">
            <table class="table text-center h-100 table-responsive-sm scrollbar-none" style="margin-top: 2.5rem">
              <thead>
                <th class="sticky-top bg-white" style="width: 50px;"></th>
                <th class="sticky-top bg-white">名前</th>
                <th class="sticky-top bg-white">メールアドレス</th>
                <th class="sticky-top bg-white">権限</th>
                <th class="sticky-top bg-white">SNS連携</th>
              </thead>
              <tbody>
                <IndexDetail v-for="(user, index) in users.data" :key="index" :user="user"></IndexDetail>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-8 row justify-content-center mx-auto">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'
import IndexDetail from './IndexDetail.vue'

export default {
  props: ['users', 'is_admin'],
  mixins: [Data, Link],
  components:{
    IndexDetail
  },
  data(){
    return {
      'admin_only': this.is_admin,
      'total_user_count': this.users.data.length
    }
  },
  methods: {
    changeRadio(){
      this.$refs.form.submit()
    }
  }
}

</script>

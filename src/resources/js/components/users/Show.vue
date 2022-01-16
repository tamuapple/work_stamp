<template>
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title font-weight-bold">{{ title }}</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page" v-if="user.id != authId()">
            <a href="/user">ユーザー</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">{{ title }}</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
          <div class="card-body">
              <h4 class="card-title">アカウント</h4>
            <table class="table table-responsive-md">
              <tbody>
                <tr><td>名前</td><td>{{ user.username }}</td></tr>
                <tr><td>メールアドレス</td><td>{{ user.email }}</td></tr>
                <tr><td>権限</td><td>{{ role(user.role) }}</td></tr>
                <tr><td>SNS連携</td><td>{{ sns(user) }}</td></tr>
              </tbody>
            </table>
            <div class="text-right">
              <a :href="userEditLink" class="btn btn-sm btn-gradient-success mr-2">編集</a>
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

export default {
  props: ['title', 'user'],
  mixins: [Data, Link],
  data(){
    return {
      'userEditLink': '/user/' + this.user.id + '/edit'
    }
  },
}
</script>

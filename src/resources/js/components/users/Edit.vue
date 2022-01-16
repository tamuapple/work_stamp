<template>
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">プロフィール編集</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <a :href="userShowLink(authId())" v-if="user.id == authId()">ホーム</a>
            <a :href="userShowLink(user.id)" v-else>{{ user.username }}</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">プロフィール編集</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">アカウント</h4>
            <slot name="update-form"></slot>
            <div class="row justify-content-between w-100 mx-auto">
              <slot name="delete-form">
                <div></div>
              </slot>
              <div>
                <a :href="userShowLink(user.id)" class="btn btn-sm btn-light mr-2">戻る</a>
                <button type="submit" class="btn btn-sm btn-gradient-info" form="form">更新</button>
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

export default {
  props: ['user'],
  mixins: [Data, Link],
}

</script>

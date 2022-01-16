<template>
  <nav class="sidebar sidebar-offcanvas" id="sidebar" v-if="auth_user.role == 1">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a :href="userShowLink(authId())" class="nav-link">
          <div class="nav-profile-image">
            <img :src="auth_user.image" :alt="auth_user.username" v-if="auth_user.image">
            <i class="icon-lg mdi mdi-account-circle" v-else></i>
            <span class="login-status online"></span>
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{ auth_user.username }}</span>
            <span class="text-secondary text-small">{{ role(auth_user.role) }}</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/home">
          <span class="menu-title">ホーム</span><i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/user">
          <span class="menu-title">ユーザー</span><i class="mdi mdi-account-multiple menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">申請一覧</span>
          <i class="menu-arrow"></i><i class="mdi mdi-crosshairs-gps menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="/shift">シフト</a></li>
            <li class="nav-item"><a class="nav-link" href="/work_stamp">打刻</a></li>
            <li class="nav-item"><a class="nav-link" href="/earlytime">早出</a></li>
            <li class="nav-item"><a class="nav-link" href="/overtime">残業</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>
  <nav class="sidebar sidebar-offcanvas" id="sidebar" v-else>
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a :href="userShowLink(authId())" class="nav-link">
          <div class="nav-profile-image">
            <img :src="auth_user.image" :alt="auth_user.username" v-if="auth_user.image">
            <i class="icon-lg mdi mdi-account-circle" v-else></i>
            <span class="login-status online"></span>
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{ auth_user.username }}</span>
            <span class="text-secondary text-small">{{ role(auth_user.role) }}</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/home">
          <span class="menu-title">ホーム</span><i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/work_stamp/stamping">
          <span class="menu-title">打刻</span><i class="mdi mdi-clock-fast menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" :href="attendanceCreateLink()">
          <span class="menu-title">出勤簿</span><i class="mdi mdi-calendar-clock menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">申請</span>
          <i class="menu-arrow"></i><i class="mdi mdi-crosshairs-gps menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" :href="shiftShowLink(authId())">シフト</a></li>
            <li class="nav-item"><a class="nav-link" :href="workStampShowLink(authId())">打刻</a></li>
            <li class="nav-item"><a class="nav-link" :href="earlyTimeShowLink(authId())">早出</a></li>
            <li class="nav-item"><a class="nav-link" :href="overTimeShowLink(authId())">残業</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </nav>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'

export default {
  props: ['auth_user'],
  mixins: [Data, Link],
}
</script>

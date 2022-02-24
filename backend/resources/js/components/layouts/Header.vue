<template>
  <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo" :href="userShowLink(auth_user.id)">
        <i class="mdi mdi-clock"></i> Work Stamp
      </a>
      <a class="navbar-brand brand-logo-mini text-center" :href="userShowLink(auth_user.id)">
        <i class="mdi mdi-clock"></i>
      </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" @click="toggleSidebar">
        <span class="mdi mdi-menu"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img" v-if="auth_user.image">
              <img :src="auth_user.image" alt="image" v-if="auth_user.image">
            </div>
            <i class="mdi mdi-account-circle text-dark" style="font-size:1.875rem" v-else></i>
            <div class="nav-profile-text">
              <p class="mb-1 text-black">{{ auth_user.username }}</p>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-dark" href="/logout">
              <i class="mdi mdi-logout mr-2 text-primary"></i> ログアウト
            </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas" @click="toggleResponsiveSidebar">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'

export default {
  props:['auth_user'],
  mixins: [Data, Link],
  methods: {
    toggleSidebar(){
      document.getElementById('body').classList.toggle('sidebar-icon-only')
    },
    toggleResponsiveSidebar(){
      document.getElementById('sidebar').classList.toggle('active')
    }
  }
}

</script>

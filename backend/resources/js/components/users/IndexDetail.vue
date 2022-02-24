<template>
  <tr>
    <td>
      <a :href="userShowLink(user.id)" class="text-dark">
        <img :src="user.image" :alt="user.username" v-if="user.image">
        <i class="icon-lg mdi mdi-account-circle" v-else></i>
      </a>
    </td>
    <td class="align-middle">{{ user.username }}</td>
    <td>{{ user.email }}</td>
    <td>{{ role(user.role) }}</td>
    <td>{{ sns(user) }}</td>
  </tr>
</template>

<script>
import Data from '../common/Data.vue'
import Link from '../common/Link.vue'

export default {
  props: ['user'],
  mixins: [Data, Link],
}
</script>

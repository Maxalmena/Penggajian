<template>
  <div class="page-section cms">
    <div class="cms-wrapper flex">
      <div class="sidebar flex-none w-40">
        <router-link
          v-for="tab in tabs"
          :key="tab.route"
          :to="{ name: tab.route }"
          class="block mb-5 font-bold link"
        >
          {{ tab.name }}
        </router-link>
        <button
          class="block mb-5 font-bold link"
          @click="logout"
        >
          Logout
        </button>
      </div>

      <div class="flex-grow py-8">
        <transition
          name="fade"
          mode="out-in"
        >
          <router-view />
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'admin',

  computed: {
    tabs () {
      return [
        {
          name: 'Banner',
          route: 'cms.banner'
        },
        {
          name: 'Kategori Game',
          route: 'cms.games.list'
        },
        {
          name: 'Member',
          route: 'cms.member.list'
        },
        {
          name: 'Biaya Admin',
          route: 'cms.admin.fee'
        },
        {
          name: 'Opsi Pembayaran',
          route: 'cms.payment.options'
        },
        {
          name: 'Transaksi Jual Beli',
          route: 'cms.admin.transaction'
        }
      ]
    }
  },

  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')
      this.$router.push({ name: 'home' })
    }
  }
}
</script>

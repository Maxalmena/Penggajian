<template>
  <nav class="navbar flex items-center justify-between flex-wrap xs:py-4 lg:py-0 lg:h-20">
    <a 
      href="/"
      class="flex items-center flex-shrink-0 text-white mr-6"
    >
      <span class="font-bold italic text-4xl text-blue-900">{{ title }}</span>
    </a>
    <div 
      v-if="!inCms"
      class="block lg:hidden"
    >
      <button
        class="flex items-center px-3 py-2 border rounded text-blue-900 border-blue-900"
        @click="hidden = !hidden"
      >
        <svg
          class="fill-current h-3 w-3"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        ><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
      </button>
    </div>
    <div 
      v-if="!inCms"
      class="w-full align-middle flex-row lg:flex lg:items-center lg:w-auto"
      :class="{ 'xs:hidden': hidden }"
    >
      <vs-input 
        v-model="search"
        color="#3f51b5"
        class="lg:mr-8 search-input lg:m-0 xs:mb-2"
        icon-after
        icon="search"
        placeholder="Cari game incaranmu!"
      />
      <div 
        v-if="!user" 
        class="xs:flex xs:justify-between lg:flex-none"
      >
        <div>
          <vs-button
            color="#3f51b5"
            type="border"
            class="px-8 py-3 mr-8 btn-login rounded"
            @click="modalActive('login')"
          >
            <span class="font-bold">Masuk</span>
          </vs-button>
        </div>
        <div>
          <vs-button
            color="#3f51b5"
            type="filled"
            class="px-8 py-3 rounded"
            @click="modalActive('regis')"
          >
            <span class="font-bold">Daftar</span>
          </vs-button>
        </div>
      </div>
      <div
        v-else
        class="xs:flex xs:justify-end lg:flex-none"
      >
        <div class="lg:mt-0 mr-8 h-6 lg:mr-12">
          <router-link
            :to="{ name: 'cart' }"
            class="px-4 py-4 leading-none relative"
          >
            <img src="../assets/icons/shopping-cart.svg">
            <span 
              v-if="cart.length > 0"
              class="badge"
            >.</span>
          </router-link>
        </div>
        <div>
          <router-link
            :to="{ name: 'me' }"
            class="px-4 py-4 leading-none lg:mt-0"
          >
            <img src="../assets/icons/user.svg">
          </router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import store from  '@/store'
import router from '@/router'
// import LocaleDropdown from './LocaleDropdown'

export default {
  // components: {
  //   LocaleDropdown
  // },
  data: () => ({
    search: '',
    hidden: true
  }),

  computed: {
    ...mapGetters({
      user: 'auth/user',
      cart: 'cart/cart'
    }),
    title () {
      return process.env.VUE_APP_TITLE
    },
    inCms () {
      return this.$route.name && this.$route.name.includes('cms.')
    }
  },

  watch: {
    search () {
      store.state.game.search = this.search
      if (router.currentRoute.name !== 'home') router.push({ name: 'home' })
    }
  },

  methods: {
    modalActive (type) {
      this.$emit('showModal', type)
    },
    toMePage () {
      router.push({ name: 'me' })
    }
  }
}
</script>

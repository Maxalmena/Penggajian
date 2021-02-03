<template>
  <div class="home-page">
    <carousel
      v-if="!search"
      class="px-4"
      :per-page="1"
      :mouse-drag="false"
      center-mode
      navigation-enabled
      :navigation-next-label="navNext"
      :navigation-prev-label="navPrev"
      pagination-active-color="#3f51b5"
      pagination-color="#fff"
      pagination-position="bottom-overlay"
    >
      <slide
        v-for="(banner, index) in banners"
        :key="index"
      >
        <img :src="banner">
      </slide>
    </carousel>
    <div class="flex w-full flex-wrap justify-center pt-4">
      <GameCard
        v-for="(game, index) in pageList"
        :key="index"
        :game="game"
      />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import GameCard from '@/components/GameCard'
import { Carousel, Slide } from 'vue-carousel'
import ChevronRight from '../assets/icons/chevron-right.svg'
import ChevronLeft from '../assets/icons/chevron-left.svg'
import store from '@/store'
import FirestoreHelper from '@/utils/FirestoreHelper'
import axios from 'axios'
import { API_URL, BANNER_IMAGE } from '@/constants/config'

export default {
  layout: 'default',

  metaInfo () {
    return { title: this.$t('home') }
  },

  components: {
    GameCard,
    Carousel,
    Slide
  },

  beforeRouteEnter (to, from, next) {
    let banners = []
    store.dispatch('game/fetchGameList')
    .then(() => axios.get(`${API_URL}/helpers?type=${BANNER_IMAGE}`))
    .then(res => {
      banners = res.data.payload.value.split(',')
      next(vm => vm.banners = banners)
    })
  },

  data () {
    return {
      banners: []
    }
  },

  computed: {
    ...mapGetters({
      authenticated: 'auth/check',
      gameList: 'game/gameList',
      search: 'game/search'
    }),
    title () {
      return process.env.VUE_APP_TITLE
    },
    navNext () {
      return `<img src="${ChevronRight}">`
    },
    navPrev () {
      return `<img src="${ChevronLeft}">`
    },
    pageList () {
      return this.gameList.filter(data => data.name.toLowerCase().includes(this.search.toLowerCase()))
    }
  }
}
</script>

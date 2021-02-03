<template>
  <div class="-ml-4 -mt-4 flex flex-wrap justify-between">
    <button
      class="add-game m-4 rounded-lg flex justify-center items-center"
      @click="toCreateGame"
    >
      <span class="link font-bold">Tambah Game Baru</span>
    </button>
    <GameCard
      v-for="(game, index) in pageList"
      :key="index"
      :game="game"
    />
  </div>
</template>

<script>
import GameCard from '@/components/GameCard'
import { mapGetters } from 'vuex'
import store from '@/store'
import router from '@/router'

export default {
  components: {
    GameCard
  },

  beforeRouteEnter (to, from, next) {
    store.dispatch('game/fetchGameList')
      .then( () => next ())
  },

  computed: {
    ...mapGetters({
       gameList: 'game/gameList'
    }),
    pageList () {
      return this.gameList
    }
  },

  methods: {
    toCreateGame () {
      router.push({ name: 'cms.games.new' })
    }
  }
}
</script>

<style>

</style>
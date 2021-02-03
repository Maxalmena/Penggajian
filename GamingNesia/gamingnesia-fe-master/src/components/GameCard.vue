<template>
  <button
    class="m-4 game-card flex-none relative overflow-hidden bg-cover rounded-lg"
    @click="toGameDetail(game.id)"
  >
    <img 
      :src="game.imageUrl"
      class="object-cover"
    >
    <div class="text-left absolute bottom-0 card-info text-white rounded-bl-lg rounded-tr-lg">
      <p>{{ game.name }}</p>
    </div>
  </button>
</template>

<script>
import router from '@/router'

export default {
  props: {
    game: {
      type: Object,
      default () {
        return {}
      }
    }
  },

  computed: {
    inCms () {
      return router.currentRoute.name.includes('cms')
    }
  },
  
  methods: {
    toGameDetail (id) {
      if (this.inCms) router.push({ name: 'cms.games.edit', params: { id: id } })
      else router.push({ name: 'games.detail', params: { id: id } })
    }
  }
}
</script>

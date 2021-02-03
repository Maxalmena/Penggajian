<template>
  <div class="games-input">
    <vs-input
      v-model="name"
      :disabled="!isCreating"
      label="Nama Game"
      color="#3f51b5"
      style="width: 22.25rem"
    />
    <vs-textarea
      v-model="desc"
      label="Deskripsi Game"
      class="mt-16"
      width="55.7rem"
      height="8rem"
    />
    <div class="flex justify-start items-center mt-8">
      <p>Cover</p>
      <UploadField
        :key="coverImg"
        class="cover-field"
        :img="coverImg"
        @imageChange="handleCoverImage"
      />
    </div>
    <div class="flex justify-start items-center mt-8">
      <p>Banner</p>
      <UploadField
        :key="bannerImg"
        class="flex-grow banner-field"
        :img="bannerImg"
        @imageChange="handleBannerImage"
      />
    </div>
    <div class="w-full text-right">
      <vs-button
        color="#3f51b5"
        type="filled"
        class="py-4 mt-12 rounded btn-submit-game"
        @click="submitGame()"
      >
        <span class="font-bold">Simpan</span>
      </vs-button>
    </div>
  </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import UploadField from '@/components/UploadField'
import FirestoreHelper from '@/utils/FirestoreHelper'
import { mapGetters } from 'vuex'

export default {
  components: {
    UploadField
  },

  data: () => ({
    name: '',
    desc: '',
    bannerImg: '',
    coverImg: '',
    newBannerImg: '',
    newCoverImg: '',
    id: ''
  }),

  beforeRouteEnter (to, from, next) {
    if (to.name.includes('edit')) {
      store.dispatch('game/fetchGame', to.params.id)
      .then(() => next(vm => vm.setGameDetail()))
    } else {
      next()
    }
  },

  computed: {
    ...mapGetters({
      game: 'game/game'
    }),
    isCreating () {
      return router.currentRoute.name.includes('new')
    }
  },

  methods: {
    handleCoverImage (img) {
      this.newCoverImg = img
    },
    handleBannerImage (img) {
      this.newBannerImg = img
    },
    setGameDetail () {
      this.name = this.game.name
      this.desc = this.game.description
      this.coverImg = this.game.imageUrl
      this.bannerImg = this.game.imageCoverUrl
      this.id = this.game.id
    },
    async submitGame () {
      if (this.newCoverImg !== '') {
        await FirestoreHelper.uploadImage({
          image: new File([this.newCoverImg], `cover-${encodeURIComponent(this.name.toLowerCase())}`),
          metadata: { contentType: this.newCoverImg.type },
          onSuccess: (res, url) => {
            this.coverImg = url
          },
          onError: (e) => console.log(e)
        })
      }

      if (this.newBannerImg !== '') {
        await FirestoreHelper.uploadImage({
          image: new File([this.newBannerImg], `banner-${encodeURIComponent(this.name.toLowerCase())}`),
          metadata: { contentType: this.newBannerImg.type },
          onSuccess: (res, url) => {
            this.imageCoverUrl = url
          },
          onError: (e) => console.log(e)
        })
      }

      const payload = {
        game: {
          name: this.name,
          description: this.desc,
          imageUrl: this.coverImg,
          imageCoverUrl: this.imageCoverUrl
        },
        id: this.id || ''
      }

      if (this.isCreating) {
        store.dispatch('game/createGame', payload)
        .then(() => router.push({ name: 'cms.games.list '}))
      }
      else {
        store.dispatch('game/updateGame', payload)
        .then(() => router.push({ name: 'cms.games.list '}))
      }
    }
  }
}
</script>

<style>

</style>
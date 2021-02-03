<template>
  <div>
    <p class="text-2xl leading-none font-bold page-title pb-8">
      Banner
    </p>
    <div
      v-for="(banner, index) in banners" 
      :key="index"
      class="flex justify-between mb-4 items-center"
    >
      {{ index + 1 }}
      <UploadField 
        :key="banner"
        :img="banner"
        class="flex-grow ml-6"
        @imageChange="handleBannerImage($event, index)"
      />
    </div>
    <vs-button
      color="#3f51b5"
      type="filled"
      class="py-4 mt-8 rounded float-right"
      style="width: 22.25rem"
      @click="saveBanner()"
    >
      <span class="font-bold">Simpan</span>
    </vs-button>
  </div>
</template>

<script>
import axios from 'axios'
import UploadField from '@/components/UploadField'
import FirestoreHelper from '@/utils/FirestoreHelper'
import { API_URL, BANNER_IMAGE } from '@/constants/config'

export default {
  middleware: 'admin',
  
  components: {
    UploadField
  },

  beforeRouteEnter (to, from, next) {
    let banners = []
    axios.get(`${API_URL}/helpers?type=${BANNER_IMAGE}`)
    .then(res => {
      banners = res.data.payload.value.split(',')
      banners.length = 5
      next(vm => vm.banners = banners)
    })
  },

  data:() => ({
    banners: []
  }),

  methods: {
    handleBannerImage (img, index) {
      this.banners[index] = img
    },
    saveBanner () {
      let index = 0
      this.banners.forEach(async img => {
        if (typeof img === 'object') {
          const writeIndex = index
            const onSuccess = (res, url) => {
            this.banners[writeIndex] = url
            axios.put(`${API_URL}/helpers?type=${BANNER_IMAGE}`, {
              value: this.banners.join()
            })
            .then(res => this.banners = res.data.payload.value.split(','))
          }
          const onError = () => {
            console.log('error')
          }
          await FirestoreHelper.uploadImage({
            image: new File([img], `banner-${new Date().valueOf()}`),
            metadata: { contentType: img.type },
            onSuccess,
            onError,
          })
        }
        index++
      })
    }
  }
}
</script>

<style>

</style>
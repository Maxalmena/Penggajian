<template>
  <div>
    <div style="height:0px;overflow:hidden">
      <input
        :id="`uploadField${uuid}`"
        type="file"
        accept="image/*"
        @change="imageUpload($event.target.files[0])"
      >
    </div>
    <div 
      v-if="!image"
      class="upload-field text-center rounded-lg flex flex-col items-center justify-center"
      @click="uploadFile"
    >
      <img 
        src="../assets/icons/camera.svg"
        class="w-8"
      >
      <span class="upload-guide text-base link">Klik di sini untuk upload gambar</span>
    </div>
    <div 
      v-else
      class="img-preview-wrapper flex justify-center"
    >
      <div
        class="img-preview"
      >
        <img
          :src="imagePreview || image"
          class="rounded-lg"
          style="height: 12.5rem; width: auto;"
          @click="uploadFile"
        >
        <img
          src="../assets/icons/button-x.svg"
          class="btn-x"
          @click="clearImage"
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    img: {
      type: String,
      default: ''
    }
  },

  data: () => ({
    image: '',
    uuid: '',
    imagePreview: ''
  }),

  watch: {
    'image': function () {
      if(typeof this.image === 'object') this.$emit('imageChange', this.image)
    }
  },

  mounted () {
    this.uuid = Math.floor((Math.random() * 1000) + 1);
    this.image = this.img
  },

  methods: {
    uploadFile () {
       document.getElementById(`uploadField${this.uuid}`).click();
    },
    imageUpload (image) {
      this.image = image
      let fileReader = new FileReader()
      fileReader.readAsDataURL(image)
      fileReader.onload = e => {
        this.imagePreview = fileReader.result
      }
    },
    clearImage () {
      this.image = ''
    }
  }
}
</script>

<style>

</style>
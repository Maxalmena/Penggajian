<template>
  <div>
    <p class="text-2xl leading-none font-bold page-title pb-8">
      Biaya Admin
    </p>
    <vs-input
      v-model="basicFee"
      type="numeric"
      label="Basic Member"
      color="#3f51b5"
      class="price-input mb-4"
      style="width: 22.25rem"
    />
    <vs-input
      v-model="vipFee"
      type="numeric"
      label="VIP Member"
      color="#3f51b5"
      class="price-input"
      style="width: 22.25rem"
    />
    <vs-button
      color="#3f51b5"
      type="filled"
      class="py-4 mt-8 rounded"
      style="width: 22.25rem"
      @click="saveAdminFee()"
    >
      <span class="font-bold">Simpan</span>
    </vs-button>
  </div>
</template>

<script>
import axios from 'axios'
import { inputPriceFormat } from '@/utils/inputPriceFormat'
import { API_URL, BASIC_ADMIN_FEE, VIP_ADMIN_FEE } from '@/constants/config'

export default {
  middleware: 'admin',

  data: () => ({
    basicFee: '',
    vipFee: ''
  }),

  watch: {
    'basicFee': function () {
      this.basicFee = inputPriceFormat(this.basicFee)
    },
    'vipFee': function () {
      this.vipFee = inputPriceFormat(this.vipFee)
    }
  },

  mounted () {
    this.setAdminFee()
  },

  methods: {
    saveAdminFee () {
      axios.put(`${API_URL}/helpers?type=${BASIC_ADMIN_FEE}`, {
        value: this.basicFee
      })
      axios.put(`${API_URL}/helpers?type=${VIP_ADMIN_FEE}`, {
        value: this.vipFee
      })
    },
    setAdminFee () {
      axios.get(`${API_URL}/helpers?type=${BASIC_ADMIN_FEE}`)
      .then(res => this.basicFee = res.data.payload.value)
      axios.get(`${API_URL}/helpers?type=${VIP_ADMIN_FEE}`)
      .then(res => this.vipFee = res.data.payload.value)
    }
  }
}
</script>

<style>

</style>
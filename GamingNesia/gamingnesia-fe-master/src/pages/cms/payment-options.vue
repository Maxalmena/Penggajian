<template>
  <div>
    <p class="text-2xl leading-none font-bold page-title pb-8">
      Opsi Pembayaran
    </p>
    <div class="flex flex-wrap justify-between w-full">
      <div style="width: 31.25rem;">
        <div 
          v-for="(option, index) in paymentOptions"
          :key="index"
          class="payment-options rounded px-4 pt-6 pb-8 mb-6"
        >
          <div class="mb-4">
            <p class="label">
              Bank / Institusi
            </p>
            <p class="text-lg">
              {{ option.name }}
            </p>
          </div>
          <div class="mb-4">
            <p class="label">
              Nomor Rekening
            </p>
            <p class="text-lg">
              {{ option.accountNumber }}
            </p>
          </div>
          <div class="mb-4">
            <p class="label">
              Atas Nama
            </p>
            <p class="text-lg">
              {{ option.accountName }}
            </p>
          </div>
          <div class="mt-2">
            <button
              class="link-alert font-bold"
              @click="removePaymentMethod(option.id)"
            >
              Hapus
            </button>
          </div>
        </div>
      </div>
      <div style="width: 21.875rem;">
        <vs-button
          color="#3f51b5"
          type="filled"
          class="w-full py-5"
          @click="addPaymentMethod()"
        >
          Tambah Opsi Pembayaran
        </vs-button>
      </div>
    </div>
    <vs-popup
      class="payment-options-modal"
      :active.sync="methodModal"
      title="Detail Opsi Pembayaran"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div class="payment-options-form">
        <vs-input
          v-model="name"
          label="Bank / Institusi"
          color="#3f51b5"
          class="mb-4"
        />
        <vs-input
          v-model="accountNumber"
          label="Nomor Rekening"
          color="#3f51b5"
          class="mb-4"
        />
        <vs-input
          v-model="accountName"
          label="Atas Nama"
          color="#3f51b5"
          class="mb-4"
        />
        <vs-button
          color="#3f51b5"
          type="filled"
          class="w-full py-5"
          @click="createPaymentMethod()"
        >
          Simpan
        </vs-button>
      </div>
    </vs-popup>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import store from '@/store'

export default {
  middleware: 'admin',

  data:() => ({
    methodModal: false,
    name: '',
    accountName: '',
    accountNumber: ''
  }),

  beforeRouteEnter (to, from, next) {
    store.dispatch('payment-options/fetchPaymentOptions')
    .then(() => next())
  },

  computed: mapGetters({
    paymentOptions: 'payment-options/paymentOptions'
  }),

  methods: {
    addPaymentMethod () {
      this.methodModal = true
    },
    removePaymentMethod (id) {
      store.dispatch('payment-options/removePaymentOptions', id)
    },
    createPaymentMethod () {
      store.dispatch('payment-options/createPaymentOptions', {
        name: this.name,
        accountName: this.accountName,
        accountNumber: this.accountNumber
      })
      .then(() => this.methodModal = false)
    }
  }
}
</script>

<style>

</style>
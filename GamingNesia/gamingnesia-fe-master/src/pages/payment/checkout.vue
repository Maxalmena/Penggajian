<template>
  <div class="checkout-wrapper">
    <p class="text-2xl pb-6 leading-none font-bold page-title">
      Pembayaran
    </p>
    <div class="checkout px-12 py-10 rounded-lg">
      <div class="checkout-total rounded-lg bg-white px-4 py-6">
        <p class="label">
          Total Pembayaran
        </p>
        <p class="nominal font-bold text-2xl">
          {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(transactionDetail.nettPrice) }}
        </p>
        <p class="guide mt-2">
          Pastikan transfer sesuai dengan nominal yang tertera!
        </p>
      </div>
      <div class="method rounded-lg bg-white px-4 py-6 mt-6">
        <p class="label text-xl font-semibold">
          Pilih Metode Pembayaran
        </p>
        <div class="option">
          <vs-radio
            v-for="(option, index) in paymentOptions"
            :key="index"
            v-model="paymentMethod"
            vs-name="method"
            color="#3f51b5"
            :vs-value="option.id"
            class="mt-6"
          >
            <p class="font-bold">
              Transfer ke {{ option.name }}
            </p>
            <p>Nomor rekening {{ option.accountNumber }}</p>
            <p>Atas nama {{ option.accountName }}</p>
          </vs-radio>
        </div>
      </div>
      <vs-button
        :disabled="!paymentMethod"
        color="#3f51b5"
        type="filled"
        class="w-full py-5 mt-6 rounded"
        @click="uploadModal=true"
      >
        <span class="font-bold">UPLOAD BUKTI PEMBAYARAN</span>
      </vs-button>
    </div>

    <vs-popup 
      class="upload-modal"
      :active.sync="uploadModal"
      title="Upload Bukti Pembayaran"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div v-if="!submit">
        <UploadField 
          class="my-10"
          @imageChange="handleImageChange"
        />
        <div class="btn-upload">
          <vs-button
            ref="loadableButton"
            :disabled="!proofImg"
            color="#3f51b5"
            type="filled"
            class="w-full py-5 vs-con-loading__container rounded"
            @click="submitProof"
          >
            <span class="font-bold">UPLOAD BUKTI PEMBAYARAN</span>
          </vs-button>
        </div>
      </div>
      <div 
        v-else
        class="post-upload flex flex-col items-center justify-center"
      >
        <img 
          src="../../assets/icons/success.svg"
          width="100px"
          class="mb-1"
        >
        <p class="mb-4 mt-8 text-black text-base text-xl">
          Upload berhasil!
        </p>
        <p class="text-base">
          Selanjutnya, kamu bisa cek status transaksi di halaman profil.
        </p>
      </div>
    </vs-popup>
  </div>
</template>

<script>
import UploadField from '@/components/UploadField'
import FirestoreHelper from '@/utils/FirestoreHelper'
import router from '@/router'
import axios from 'axios'
import store from '@/store'
import { mapGetters } from 'vuex'

export default {
  components: {
    UploadField
  },

  data: () => ({
    paymentMethod: '',
    uploadModal: false,
    submit: '',
    proofImg: ''
  }),

  computed: {
    ...mapGetters({
      transactionDetail: 'checkout/transactionDetail',
      user: 'auth/user',
      paymentOptions: 'payment-options/paymentOptions'
    })
  },

  watch: {
    'uploadModal': function() {
      if (this.submit && !this.uploadModal) router.push({ name: 'home' })
    }
  },

  mounted () {
    if (!this.transactionDetail) router.push({ name: 'cart' })
  },

  methods: {
    handleImageChange (image) {
      this.proofImg = image
    },
    async submitProof () {
       this.$vs.loading({
        background: '#3f51b5',
        color: '#fff',
        container: this.$refs.loadableButton.$el,
        scale: 0.45
      })

      this.checkout()
    },
    async checkout () {
      const localCart = localStorage.getItem('cart')
      const parsedCart = JSON.parse(localCart)
      const cartDataToSend = parsedCart.reduce((prev, currVal) => {
        return [
          ...prev,
          {
            'productId': currVal.id,
            'quantity': currVal.unit,
            'remarks': currVal.remarks ? currVal.remarks : ''
          }
        ]
      }, [])

      let proofImg = ''
      const onSuccess = (res, url) => {
        proofImg = url

        const buyerId = this.$store.getters['auth/user'].id
        const dataToSend = {
          products: cartDataToSend,
          paymentConfirmationImg: proofImg,
          paymentMethod: this.paymentMethod,
          uniqueCode: this.transactionDetail.uniqueCode,
          adminFee: this.transactionDetail.adminFee,
          totalPrice: this.transactionDetail.nettPrice,
          buyerId,
        }
        
        store.dispatch('checkout/createTransaction', dataToSend).then(() => {
          localStorage.removeItem('cart')
          store.state.cart.cart = []
          this.$vs.loading.close(this.$refs.loadableButton.$el)
          this.submit = 'success'
        })
      }

      const onError = () => {
        this.$vs.loading.close(this.$refs.loadableButton.$el)
        this.submit = 'error'
      }

      await FirestoreHelper.uploadImage({
        image: new File([this.proofImg], `proof-${encodeURIComponent(this.user.fullName)}-${new Date().valueOf()}`),
        metadata: { contentType: this.proofImg.type },
        onSuccess,
        onError,
      })
    },
  },
}
</script>

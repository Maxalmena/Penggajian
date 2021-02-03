<template>
  <div class="history-wrapper transaction-wrapper">
    <div class="history px-12 pt-8 pb-5">
      <div class="transaction-wrapper-status">
        <div class="status-left">
          <p 
            v-if="buyerStatus"
            class="link-alt font-bold mb-6"
          >
            {{ buyerStatus }}
          </p>
          <p 
            v-if="sellerStatus"
            class="link-alt font-bold mb-6"
          >
            {{ sellerStatus }}
          </p>
        </div>
        <div class="status-right">
          <p>{{ transactionDate }}</p>
          <p class="product-price">
            {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(isSeller ? grossPrice - discountPrice: transactionValue) }}
          </p>
        </div>
      </div>
      <div class="history-scroll">
        <TransactionCard 
          v-for="(product, index) in transactions.transactionDetails"
          :key="index"
          :product="product"
        />
      </div>

      <div
        v-if="waitingForBuyerConfirmation"
        class="actions"
      >
        <!-- <vs-button
          class="btn-buy mx-4 flex-none rounded"
          color="#3f51b5"
          type="border"
        >
          <span class="font-bold">Komplain</span>
        </vs-button> -->
        <vs-button
          ref="loadableButton"

          color="#3f51b5"
          type="filled"
          class="btn-buy flex-none rounded"
          @click="productAccepted"
        >
          <span class="font-bold">Sudah terima</span>
        </vs-button>
      </div>
      <div
        v-else-if="isBuyer"
        class="actions"
      >
        <!-- <vs-button
          class="btn-buy mx-4 flex-none rounded"
          color="#3f51b5"
          type="border"
        >
          <span class="font-bold">Komplain</span>
        </vs-button> -->
      </div>
      <div
        v-if="isAdmin"
        class="actions"
      >
        <vs-button
          class="btn-buy mx-4 flex-none rounded"
          color="success"
          type="border"
          @click="openProof()"
        >
          <span class="font-bold">Lihat Bukti</span>
        </vs-button>
        <vs-button
          class="btn-buy mx-4 flex-none rounded"
          color="danger"
          type="border"
          @click="declinePayment()"
        >
          <span class="font-bold">Tolak Transaksi</span>
        </vs-button>
        <vs-button
          class="btn-buy mx-4 flex-none rounded"
          color="#3f51b5"
          type="border"
          @click="confirmPayment()"
        >
          <span class="font-bold">Sudah Bayar</span>
        </vs-button>
      </div>
    </div>
    
    <vs-popup 
      class="upload-modal"
      :active.sync="isTransactionAccepted"
      title="Penerimaan Pesanan"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div 
        class="post-upload flex flex-col items-center justify-center"
      >
        <img 
          v-if="error === ''"
          src="../../assets/icons/success.svg"
          width="100px"
          class="mb-1"
        >

        <p 
          v-if="error !== ''"
          class="mb-4 mt-8 text-black text-base text-xl"
        >
          {{ error }}
        </p>
        <p
          v-else
          class="mb-4 mt-8 text-black text-base text-xl"
        >
          Berhasil menerima pesanan
        </p>
      </div>
    </vs-popup>

    <vs-popup 
      class="upload-modal"
      :active.sync="isTransactionDeclined"
      title="Penerimaan Pesanan"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div 
        class="post-upload flex flex-col items-center justify-center"
      >
        <img
          v-if="error === ''"
          src="../../assets/icons/success.svg"
          width="100px"
          class="mb-1"
        >
        <p 
          v-if="error !== ''"
          class="mb-4 mt-8 text-black text-base text-xl"
        >
          {{ error }}
        </p>
        <p
          v-else
          class="mb-4 mt-8 text-black text-base text-xl"
        >
          Berhasil menolak pesanan
        </p>
      </div>
    </vs-popup>

    <vs-popup 
      class="upload-modal"
      :active.sync="isTransactionPaymentAccepted"
      title="Penerimaan Pesanan"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div 
        class="post-upload flex flex-col items-center justify-center"
      >
        <img 
          v-if="error === ''"
          src="../../assets/icons/success.svg"
          width="100px"
          class="mb-1"
        >
        <p 
          v-if="error !== ''"
          class="mb-4 mt-8 text-black text-base text-xl"
        >
          {{ error }}
        </p>
        <p
          v-else
          class="mb-4 mt-8 text-black text-base text-xl"
        >
          Berhasil menerima pesanan
        </p>
      </div>
    </vs-popup>
  </div>
</template>

<script>
import store from  '@/store'
import router from '@/router'
import TransactionCard from '@/components/TransactionCard'
import {
  WAITING_FOR_ADMIN_CONFIRMATION,
  WAITING_FOR_BUYER_CONFIRMATION,
  COMPLETED,
  FAILED,
} from '@/constants/transactionConstants'

export default {
  components: {
    TransactionCard,
  },
  props: {
    transactions: {
      type: Object,
      default () {
        return {}
      }
    },
    historyType: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      WAITING_FOR_ADMIN_CONFIRMATION,
      WAITING_FOR_BUYER_CONFIRMATION,
      COMPLETED,
      FAILED,
      isTransactionAccepted: false,
      isTransactionDeclined: false,
      isTransactionPaymentAccepted: false,
      error: ''
    }
  },
  computed: {
    buyerStatus () {
      if (this.historyType === 'buyer') {
        const { status } = this.transactions
        
        if (
          status === WAITING_FOR_ADMIN_CONFIRMATION
          || status === WAITING_FOR_BUYER_CONFIRMATION
        ) {
          return 'Transaksi Berlangsung'
        }

        if (status === COMPLETED) {
          return 'Transaksi Berhasil!'
        }

        if (status === FAILED) {
          return 'Transaksi Gagal!'
        }
      }

      return ''
    },
    sellerStatus () {
      if (this.historyType !== 'buyer') {
        const { status } = this.transactions
        
        if (status === WAITING_FOR_ADMIN_CONFIRMATION) {
          return 'Menunggu Konfirmasi Pembayaran dari Penjual oleh Admin'
        }

        if (status === WAITING_FOR_BUYER_CONFIRMATION) {
          return 'Menunggu Konfirmasi Pembeli'
        }

        if (status === COMPLETED) {
          return 'Transaksi Berhasil!'
        }

        if (status === FAILED) {
          return 'Transaksi Gagal!'
        }
      }

      return ''
    },
    isBuyer () {
      return this.historyType === 'buyer'
    },
    isSeller () {
      return this.historyType !== 'buyer'
    },
    isAdmin () {
      return router.currentRoute.name.includes('cms')
    },
    waitingForBuyerConfirmation () {
      return this.isBuyer && (
        this.transactions.status === WAITING_FOR_BUYER_CONFIRMATION
      )
    },
    transactionDate () {
      const options = { year: 'numeric', month: 'long', day: 'numeric' }
      const date = new Date(this.transactions.date)
      return date.toLocaleDateString("en-US", options)
    },
    grossPrice () {
      return this.transactions.transactionDetails.reduce ((prev, curr, idx) => {
        return prev + (curr.product.sellingPrice * curr.quantity)
      }, 0)
    },
    discountPrice () {
      return this.transactions.transactionDetails.reduce ((prev, curr, idx) => {
        return prev += (curr.product.promo.status ? !curr.product.promo.unit ? 
                parseInt(curr.product.promo.value) : 
                parseInt(curr.product.sellingPrice) * parseInt(curr.product.promo.value) / 100 
                : 0) * curr.quantity
      }, 0)
    },
    transactionValue () {
      return this.transactions.totalPrice
    }
  },
  methods: {
    async productAccepted () {
      this.error = ''
      const { id } = this.transactions
      const success = await store.dispatch(
        'transaction/updateTransactionStatus', 
        { id, status: COMPLETED }
      )
      
      if (!success) {
        this.error = 'Terjadi kesalahan, coba lagi!'
      }

      this.isTransactionAccepted = true
    },
    async confirmPayment () {
      this.error = ''
      const { id } = this.transactions
      const success = await store.dispatch(
        'transaction/updateTransactionStatus', 
        { id, status: WAITING_FOR_BUYER_CONFIRMATION }
      )

      if (!success) {
        this.error = 'Terjadi kesalahan, coba lagi!'
      }

      this.isTransactionPaymentAccepted = true
    },
    async declinePayment () {
      this.error = ''
      const { id } = this.transactions
      const success = await store.dispatch(
        'transaction/updateTransactionStatus', 
        { id, status: FAILED }
      )

      if (!success) {
        this.error = 'Terjadi kesalahan, coba lagi!'
      }

      this.isTransactionDeclined = true
    },
    openProof () {
      window.open(this.transactions.payment.paymentConfirmationImg, '_blank')
    }
  },
}
</script>

<style>

</style>
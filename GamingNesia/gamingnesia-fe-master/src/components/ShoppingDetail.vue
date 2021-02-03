<template>
  <div class="shopping-detail rounded-lg py-6 px-4">
    <p class="shopping-detail-label font-xl font-bold">
      Total Belanja
    </p>
    <div class="flex mt-4">
      <div class="shopping-detail-label w-1/2">
        <p class="mb-2">
          Harga
        </p>
        <p 
          v-if="discountPrice"
          class="mb-2"
        >
          Diskon
        </p>
        <p
          v-if="cart.length > 0"
          class="mb-2"
        >
          Biaya Admin
        </p>
        <p 
          v-if="cart.length > 0"
          class="mb-2"
        >
          Kode Unik
        </p>
        <p 
          v-if="cart.length > 0"
          class="flavor-text text-xs"
        >
          untuk mempermudah verifikasi pembayaran 
        </p>
      </div>
      <div class="w-1/2">
        <p class="product-price mb-2">
          {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(grossPrice) }}
        </p>
        <p 
          v-if="discountPrice"
          class="product-price promo-value mb-2 font-bold"
        >
          {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(discountPrice) }}
        </p>
        <p 
          v-if="cart.length > 0"
          class="product-price mb-2"
        >
          {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(adminFee) }}
        </p>
        <p 
          v-if="cart.length > 0"
          class="product-price mb-2"
        >
          {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(uniqueCode) }}
        </p>
      </div>
    </div>
    <div 
      v-if="cart.length > 0"
      class="flex pt-6 mb-4"
    >
      <div class="w-1/2">
        <p class="shopping-detail-label">
          Total Bayar
        </p>
      </div>
      <div class="w-1/2 font-bold">
        <p class="nominal">
          {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(nettPrice) }}
        </p>
      </div>
    </div>
    <vs-button 
      v-if="inCart"
      :disabled="cart.length < 1"
      color="#3f51b5"
      type="filled"
      class="w-full py-5 rounded"
      @click="toCheckoutPage"
    >
      <span class="font-bold uppercase">Lanjut ke pembayaran</span>
    </vs-button>
  </div>
</template>

<script>
import router from '@/router'
import store from '@/store'
import { mapGetters } from 'vuex'
import { API_URL } from '@/constants/config'
import axios from 'axios'

export default {
  props: {
    inCart: {
      type: Boolean,
      default: false
    },
  },

  data: () => ({
    adminFee: 0
  }),
  
  computed: {
    ...mapGetters({
      user: 'auth/user',
      cart: 'cart/cart'
    }),
    grossPrice () {
      return this.cart.reduce ((prev, curr, idx) => {
        const sellingPriceInt = parseInt(curr.sellingPrice)
        return prev + (sellingPriceInt * curr.unit)
      }, 0)
    },
    discountPrice () {
      return this.cart.reduce ((prev, product, idx) => {
        return prev += product.promo.status ? !product.promo.unit ? 
                parseInt(product.promo.values) : 
                parseInt(product.sellingPrice) * parseInt(product.promo.values) / 100 
                : 0
      }, 0)
    },
    uniqueCode () {
      return Math.floor((Math.random() * 100) + 1)
    },
    nettPrice () {
      return this.grossPrice - this.discountPrice + this.uniqueCode + this.adminFee
    },
  },

  mounted () {
    if (this.user.membership) axios.get(`${API_URL}/helpers?type=VIP_ADMIN_FEE`)
    .then(res => this.adminFee = parseInt(res.data.payload.value))
    else axios.get(`${API_URL}/helpers?type=BASIC_ADMIN_FEE`)
    .then(res => this.adminFee = parseInt(res.data.payload.value))
  },

  methods: {
    toCheckoutPage() {
      store.state.checkout.transactionDetail = {
        grossPrice: this.grossPrice,
        adminFee: this.adminFee,
        uniqueCode: this.uniqueCode,
        nettPrice: this.nettPrice
      }
      router.push({ name: 'checkout' })
    }
  }
}
</script>

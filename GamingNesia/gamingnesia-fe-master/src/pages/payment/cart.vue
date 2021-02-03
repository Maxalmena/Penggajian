<template>
  <div
    :key="fuck"
    class="cart-item"
  >
    <p class="text-2xl pb-2 leading-none font-bold page-title">
      Keranjang Belanja
    </p>
    <div
      v-if="!cartItems"
      class="mt-4 text-center py-20 rounded-lg"
      style="box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.16); background-color: #f5f6ff;"
    >
      <p class="text-lg mb-8">
        Ups, keranjang belanjamu masih kosong nih
      </p>
      <vs-button
        color="#3f51b5"
        type="filled"
        class="py-5 rounded"
        style="width: 21.875rem"
        @click="toHome()"
      >
        BELANJA SEKARANG
      </vs-button>
    </div>
    <ProductCard 
      v-for="(product, index) in cartItems"
      :key="index"
      :product="product"
      @refreshCart="refreshCart"
    />
  </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { mapGetters } from 'vuex'
import ProductCard from '@/components/ProductCard'

export default {
   components: {
    ProductCard
  },

  middleware: 'auth',

  data: () => ({
    fuck: 0,
    items: [],
    cartItems: JSON.parse(localStorage.getItem('cart')),
  }),

  computed: {
    ...mapGetters ({
      productList: 'product/productList',
    }),
    // cartItems () {
    //   const localCart = localStorage.getItem('cart')
    //   return JSON.parse(localCart)
    // },
    pageList () {
      return this.productList
    }
  },

  methods: {
    toHome () {
      router.push({ name: 'home' })
    },
    refreshCart () {
      this.cartItems = store.state.cart.cart
      this.fuck ++
    }
  }
}
</script>

<style>

</style>
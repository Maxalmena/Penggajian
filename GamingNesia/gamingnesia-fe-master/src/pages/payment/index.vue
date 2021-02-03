<template>
  <div class="page-section pt-8 flex justify-between">
    <Cart v-if="inCart" />
    <Checkout v-else />
    <keep-alive>
      <ShoppingDetail :in-cart="inCart" />
    </keep-alive>
  </div>
</template>

<script>
import axios from 'axios'
import store from '@/store'
import Cart from './cart'
import Checkout from './checkout'
import ShoppingDetail from '@/components/ShoppingDetail'
import { API_URL } from '@/constants/config'

export default {
  components: {
    Cart,
    Checkout,
    ShoppingDetail
  },

  data: () => ({
    action: ''
  }),

  beforeRouteEnter (to, from, next) {
    const cartProducts = []
    store.getters['cart/cart'].forEach(item => {
      axios.get(`${API_URL}/products/${item.id}`)
      .then(res => cartProducts.push(res.data.payload))
    })
    store.dispatch('payment-options/fetchPaymentOptions')
    store.dispatch('cart/setCartProduct', cartProducts)
    next(vm => vm.action = to.name)
  },

  computed: {
    inCart () {
      return this.action === 'cart'
    }
  }
}
</script>

<style>

</style>
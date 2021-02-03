<template>
  <div
    class="product-card rounded-lg my-3 overflow-hidden w-full"
  >
    <div
      class="flex items-center"
    >
      <img 
        :src="product.product.imageUrl"
      >
      <div class="product-card-text ml-8 flex-grow text-left text-lg transaction-card">
        <div>
          <p class="product-name">
            {{ product.product.name }}
          </p>
          <div class="flex items-center">
            <span class="product-price pr-4">
              {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(!product.product.promo.status ? product.product.sellingPrice : afterPromoPrice) }}
            </span>
            <div
              v-if="product.product.promo.status"
              class="pr-4"
            >
              <span 
                class="product-price pre-disc line-through"
              >
                {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(product.product.sellingPrice) }}
              </span>
            </div>
            <svg
              v-if="product.product.promo.status"
              width="37px"
              height="24px"
              viewBox="0 0 37 24"
              version="1.1"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
            >
              <g
                stroke-width="1"
                fill="none"
                fill-rule="evenodd"
              >
                <g>
                  <path
                    d="M186,4 L186,20 C186,22.209139 184.209139,24 182,24 L13,24 L13,24 L13,0 L182,0 C184.209139,-4.05812251e-16 186,1.790861 186,4 Z"
                    fill="#FF5F1D"
                  />
                  <path
                    d="M37,3.99996022 L37,20.0000398 C37,22.2091568 35.2064501,24 32.9939941,24 L8.95795903,24 C6.74550309,24 4.95195318,22.2091568 4.95195318,20.0000398 L4.95195318,8.47234376 C4.95195318,5.73150702 3.40110215,3.22589742 0.945947327,2.00009945 L0.522979273,1.78892199 C0.0558095384,1.55567571 -0.133537111,0.98844789 0.100061695,0.521983182 C0.260266539,0.202076128 0.587735506,0 0.945947327,0 L32.9939941,0 C35.2064501,0 37,1.79084319 37,3.99996022 Z"
                    fill="#FF5F1D"
                  />
                </g>
              </g>
            </svg>
            <span 
              v-if="product.product.promo.status"
              class="promo-flair text-white text-xl truncate ..."
            >
              {{ promoText }}
            </span>
          </div>
        </div>
        <div 
          class="transaction-card-right"
        >
          <p class="product-name">
            {{ product.quantity }} item
          </p>
        </div>
      </div>
    </div>
    <div v-if="product.remarks">
      User ID : {{ product.remarks }}
    </div>
  </div>
</template>

<script>
import router from '@/router'
import { mapGetters } from 'vuex'
import store from '@/store'
import numeral from 'numeral'

export default {
  props: {
    product: {
      type: Object,
      default () {
        return {
          unit: 1
        }
      }
    }
  },

  data () {
    let datas = {
      extraField: '',
      currentProduct: { ...this.product } 
    }

    return datas
  },

  computed: {
    ...mapGetters({
      auth: 'auth/user',
      cart: 'cart/cart'
    }),
    inMe () {
      return router.currentRoute.name === 'me'
    },
    inCatalog () {
      return router.currentRoute.name === 'products.catalog'
    },
    promoText () {
      return this.product.product.promo && !this.product.product.promo.unit ? 'Potongan ' + numeral(this.product.product.promo.value).format('0a') : 'Diskon ' + parseInt(this.product.product.promo.value) +' %'
    },
    afterPromoPrice () {
      return this.product.product.sellingPrice - (!this.product.product.promo.unit ?  parseInt(this.product.product.promo.value) : Math.floor(parseInt(this.product.product.sellingPrice) * parseInt(this.product.product.promo.value) / 100))
    },
    unit () {
      return this.product.unit
    },
  },

  methods: {
    toEditPage (id) {
      console.log('edit product ' + id)
    },
    removeProduct (id) {
      console.log('remove product ' + id)
    },
    incrementProductUnit () {
      this.currentProduct.unit = this.currentProduct.unit + 1

      store.dispatch('cart/updateCartItem', this.currentProduct)
    },
    decrementProductUnit () {
      this.currentProduct.unit = this.currentProduct.unit - 1

      store.dispatch('cart/updateCartItem', this.currentProduct)
    }
  },
}
</script>

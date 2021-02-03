<template>
  <div
    class="product-card rounded-lg my-3 overflow-hidden w-full"
    :class="{ 'my-4': inCart }"
  >
    <div class="flex items-center">
      <img 
        :class="{ 'rounded-lg': inCart }"
        :src="product.imageUrl"
      >
      <div class="product-card-text ml-8 flex-grow text-left text-lg">
        <p class="product-name">
          {{ product.name }}
        </p>
        <div class="flex items-center">
          <span class="product-price pr-4">
            {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(!product.promo.status ? product.sellingPrice : afterPromoPrice) }}
          </span>
          <div
            v-if="product.promo.status"
            class="pr-4"
          >
            <span 
              class="product-price pre-disc line-through"
            >
              {{ new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(product.sellingPrice) }}
            </span>
          </div>
          <svg
            v-if="!inMe && product.promo.status"
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
            v-if="!inMe && product.promo.status"
            class="promo-flair text-white text-xl truncate ..."
          >
            {{ promoText }}
          </span>
        </div>
      </div>
      <vs-button
        v-if="!inCart && !inMe && !inCatalog"
        color="#3f51b5"
        type="filled"
        class="btn-buy mx-4 flex-none rounded"
        @click="buyProduct(product)"
      >
        <span class="font-bold">BELI</span>
      </vs-button>
      <div 
        v-if="inMe"
        style="padding-right: .875rem;"
      >
        1 item
      </div>
      <button
        v-if="inCatalog"
        class="font-bold link p-0 h-auto"
        @click="toEditPage(product.id)"
      >
        <span class="font-bold">Ubah Detail</span>
      </button>
      <button
        v-if="inCatalog"
        class="font-bold link-alert pl-12 pr-2 p-0 h-auto"
        @click="removeProduct(product.id)"
      >
        <span class="font-bold">Hapus</span>
      </button>
    </div>
    <div 
      v-if="inCart"
      class="cart-fillable flex"
    >
      <vs-input
        v-model="remarks"
        type="name"
        label="User ID"
        color="#3f51b5"
        class="extra-field mr-8"
      />
      <button 
        @click="decrementProductUnit(currentProduct.id)"
      >
        <img src="../assets/icons/minus-circle.svg">
      </button>
      <vs-input
        v-model="currentProduct.unit"
        disabled
        type="name"
        label="Qty"
        color="#2196f3"
        class="qty mx-1"
      />
      <button @click="incrementProductUnit()">
        <img src="../assets/icons/plus-circle.svg">
      </button>
    </div>
  </div>
</template>

<script>
import router from '@/router'
import { mapGetters, mapState } from 'vuex'
import store from '@/store'

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
      remarks: '',
      currentProduct: { ...this.product } 
    }

    return datas
  },

  computed: {
    ...mapState({
      cart: state => state.cart.cart
    }),
    ...mapGetters({
      auth: 'auth/user',
    }),
    inCart () {
      return router.currentRoute.name === 'cart'
    },
    inMe () {
      return router.currentRoute.name === 'me'
    },
    inCatalog () {
      return router.currentRoute.name === 'products.catalog'
    },
    promoText () {
      return !this.product.promo.unit ? 'Potongan ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumSignificantDigits: 21 }).format(parseInt(this.product.promo.values)) : 'Diskon ' + parseInt(this.product.promo.values) +' %'
    },
    afterPromoPrice () {
      return this.product.sellingPrice - (!this.product.promo.unit ?  parseInt(this.product.promo.values) : Math.floor(parseInt(this.product.sellingPrice) * parseInt(this.product.promo.values) / 100))
    },
    unit () {
      return this.product.unit
    }
  },

  watch: {
    'remarks': function () {
      this.currentProduct.remarks = this.remarks
      store.dispatch('cart/updateCartItem', this.currentProduct)
    }
  },

  methods: {
    buyProduct (selectedProduct) {
      if (!this.auth) {
        this.$vs.notify({
          title: this.$i18n.t('error_alert_title'),
          text: 'Harap melakukan login terlebih dahulu untuk dapat membeli item.',
          color: 'danger'
        })

        return
      }
      
      this.$vs.notify({
        title: this.$i18n.t('add_cart_success'),
        text: 'Berhasil menambahkan ke keranjang',
        color: 'green'
      })

      selectedProduct.unit = 1
      store.dispatch('cart/addCartItem', selectedProduct)
    },
    toEditPage (id) {
      this.$emit('editProduct', id)
    },
    removeProduct (id) {
      this.$emit('removeProduct', id)
    },
    incrementProductUnit () {
      this.currentProduct.unit = this.currentProduct.unit + 1

      store.dispatch('cart/updateCartItem', this.currentProduct)
    },
    decrementProductUnit (id) {
      if ((this.currentProduct.unit - 1) === 0) {
        store.dispatch('cart/removeCartItem', id).then (res => {
          this.$emit('refreshCart')
        })
      } else {
        this.currentProduct.unit = this.currentProduct.unit - 1
        store.dispatch('cart/updateCartItem', this.currentProduct)
      }
    }
  }
}
</script>

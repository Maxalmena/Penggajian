<template>
  <div class="page-section pt-8">
    <div class="catalog-header flex items-center justify-between">
      <div class="catalog-header--left">
        <button
          class="font-bold link p-0 h-0"
          @click="toMePage"
        >
          &lt; kembali ke Profil
        </button>
        <p class="text-2xl pt-5 leading-none font-bold page-title">
          Katalog Barang Dijual
        </p>
      </div>
      <div class="catalog-header--right">
        <vs-button
          color="#3f51b5"
          type="filled"
          class="w-full py-4 px-12 rounded"
          @click="createProduct"
        >
          <span class="font-bold">Tambah Item</span>
        </vs-button>
      </div>
    </div>
    <div class="catalog-content">
      <ProductCard 
        v-for="(product, index) in pageList"
        :key="index"
        :product="product"
        @editProduct="handleEditProduct"
        @removeProduct="handleRemoveProduct"
      />
    </div>
    <vs-popup
      class="product-modal"
      :active.sync="productModal"
      title="Detail Item"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div class="product-form">
        <div class="w-6/12">
          <UploadField
            :key="productImg"
            :img="productImg"
            @imageChange="handleImageChange"
          />
          <span class="text-xs upload-guide">Gambar disarankan memiliki ukuran 1620 x 1550px atau dengan rasio yang sama </span>
        </div>
        <div class="w-full">
          <div class="w-full flex justify-between pt-6">
            <vs-input
              v-model="name"
              label="Nama Item"
              color="#3f51b5"
              class="w-full"
              style="width: 22.25rem"
            />
            <vs-select
              v-model="selectedCategory"
              label="Kategori Game"
              color="primary"
              class="w-full ml-8"
              style="width: 22.25rem"
            >
              <vs-select-item
                v-for="(game, index) in gameList"
                :key="index"
                :value="index"
                :text="game.name"
              />
            </vs-select>
          </div>
          <div class="w-6/12 pt-6">
            <vs-input
              v-model="price"
              type="numeric"
              label="Harga"
              color="#3f51b5"
              class="price-input"
              style="width: 22.25rem"
            />
          </div>
          <div class="w-full pt-6 flex">
            <vs-select
              v-model="selectedPromo"
              label="Jenis Promo"
              color="primary"
              style="width: 22.25rem"
            >
              <vs-select-item
                v-for="(type, index) in promoType"
                :key="index"
                :value="index"
                :text="type.text"
                @click="setPromoType(index)"
              />
            </vs-select>
            <vs-input
              v-if="selectedPromo !== 0"
              v-model="promo"
              label="Promo"
              color="#3f51b5"
              class="ml-8"
              :class="{ 'percent-input': selectedPromo === 2, 'price-input': selectedPromo === 1}"
              style="width: 22.25rem"
            />
          </div>
          <div class="flex justify-end">
            <vs-button
              color="#3f51b5"
              type="filled"
              class="py-4 mt-8 rounded"
              style="width: 22.25rem"
              @click="submitProduct()"
            >
              <span class="font-bold">Simpan</span>
            </vs-button>
          </div>
        </div>
      </div>
    </vs-popup>
  </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { mapGetters } from 'vuex'
import ProductCard from '@/components/ProductCard'
import UploadField from '@/components/UploadField'
import FirestoreHelper from '@/utils/FirestoreHelper'
import { inputPriceFormat } from '@/utils/inputPriceFormat'

export default {
  components: {
    ProductCard,
    UploadField
  },

  middleware: 'auth',

  data: () => ({
    productModal: false,
    id: '',
    productImg: '',
    newProductImg: '',
    name: '',
    price: '',
    promo: '',
    promoType: [
      {
        value: '',
        text: 'Tidak'
      },
      {
        value: 'NOMINAL',
        text: 'Potongan Harga (Rp)'
      },
      {
        value: 'DISCOUNT',
        text: 'Diskon (%)'
      }
    ],
    selectedPromo: 0,
    selectedCategory: 0,
    isEditing: false
  }),

  beforeRouteEnter (to, from, next) {
    store.dispatch('game/fetchGameList')
    .then(() => store.dispatch('product/fetchProductListBySeller', store.getters['auth/user'].id))
    .then(() => next())
  },

  computed: {
    ...mapGetters ({
      productList: 'product/productList',
      product: 'product/product',
      gameList: 'game/gameList',
      user: 'auth/user'
    }),
    pageList () {
      return this.productList
    }
  },

  watch: {
    'price': function () {
      this.price = inputPriceFormat(this.price)
    },
    'promo': function () {
      const promo = this.selectedPromo === 2 && this.promo > 100 ? '100' : this.promo
      this.promo = inputPriceFormat(promo)
    }
  },

  methods: {
    toMePage () {
      router.push({ name: 'me' })
    },
    createProduct () {
      this.productImg = ''
      this.name = ''
      this.selectedCategory = 0
      this.price = ''
      this.selectedPromo = 0
      this.promo = ''
      this.isEditing = false
      this.productModal = true,
      this.id = ''
    },
    handleImageChange (image) {
      this.newProductImg = image
    },
    setPromoType (type) {
      this.promoType = type
    },
    handleEditProduct (id) {
      store.dispatch('product/fetchProduct', id)
      .then(() => {
        this.productImg = this.product.imageUrl
        this.name = this.product.name
        this.selectedCategory = this.gameList.findIndex(game => game.id.includes(this.product.categoryId))
        this.price = this.product.sellingPrice
        this.selectedPromo = this.product.promo.status ? (this.product.promo.unit ? 2 : 1) : 0
        this.promo = this.product.promo.values
        this.isEditing = true
        this.productModal = true
        this.id = this.product.id
      })
    },
    handleRemoveProduct (id) {
      store.dispatch('product/removeProduct', id)
      .then(() => store.dispatch('product/fetchProductListBySeller', store.getters['auth/user'].id))
    },
    async submitProduct() {
      if (this.newProductImg) {
        await FirestoreHelper.uploadImage({
          image: new File([this.newProductImg], `cover-${encodeURIComponent(this.name.toLowerCase())}`),
          metadata: { contentType: this.newProductImg.type },
          onSuccess: (res, url) => {
            this.productImg = url
          },
          onError: (e) => console.log(e)
        })
      } 

      const payload = {
        id: this.id,
        name: this.name,
        imageUrl: this.productImg,
        categoryId: this.gameList[this.selectedCategory].id,
        sellingPrice: parseInt(this.price.toString().replace(/\./g, '')),
        promo: {
          values: parseInt(this.promo.toString().replace(/\./g, '')) || 0,
          unit: this.selectedPromo > 0 ? this.selectedPromo - 1 : 0,
          status: !!this.selectedPromo
        },
        sellerId: this.user.id
      }

      if (this.isEditing) {
      store.dispatch('product/updateProduct', payload)
      .then(() => store.dispatch('product/fetchProductListBySeller', store.getters['auth/user'].id))
      .then(() => this.productModal = false)
      }
      else store.dispatch('product/createProduct', payload)
      .then(() => store.dispatch('product/fetchProductListBySeller', store.getters['auth/user'].id))
      .then(() => this.productModal = false)
    }
  }
}
</script>

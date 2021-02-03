<template>
  <div class="game-detail">
    <img 
      class="hero"
      :src="game.imageCoverUrl"
    >
    
    <div class="game-info relative">
      <img
        class="game-img rounded-lg absolute"
        :src="game.imageUrl"
      >
      <div class="game-text pt-2">
        <h4 class="game-name font-bold text-xl">
          {{ game.name }}
        </h4>
        <p class="flavor-text">
          {{ game.description }}
        </p>
      </div>
    </div>

    <div class="game-product">
      <div class="product-list-header">
        <vs-input 
          v-model="search"
          type="search"
          color="#3f51b5"
          class="lg:mr-8 search-input lg:m-0 xs:mb-2"
          icon-after
          icon="search"
          :placeholder="`Cari item di ${game.name}`"
        />
      </div>
      <div class="product-list mt-4">
        <ProductCard 
          v-for="(product, index) in pageList"
          :key="index"
          :product="product"
        />
      </div>
    </div>
  </div>
</template>

<script>
import store from '@/store'
import { mapGetters } from 'vuex'
import ProductCard from '@/components/ProductCard'

export default {
  components: {
    ProductCard
  },

  beforeRouteEnter (to, from, next) {
    store.dispatch('game/fetchGame', to.params.id)
    .then(() => store.dispatch('product/fetchProductListByCategory',to.params.id))
    .then(() => next())
  },

  data: () => ({
    search: ''
  }),

  computed: {
    ...mapGetters ({
      game: 'game/game',
      productList: 'product/productList'
    }),
    pageList () {
      return this.productList.filter(data => data.name.toLowerCase().includes(this.search.toLowerCase()))
    }
  }
}
</script>

<template>
  <div>{{ product }}</div>
</template>

<script>
import store from '@/store'
import { mapGetters } from 'vuex'
export default {
  beforeRouteEnter (to, from, next) {
    store.dispatch('product/fetchProduct', to.params.id)
      .then( () => next())
  },

  computed: {
    ...mapGetters ({
      product: 'product/product'
    }),
  }
}
</script>

<style>

</style>
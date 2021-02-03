<template>
  <div>
    <p class="text-2xl leading-none font-bold page-title pb-8">
      Transaksi Jual Beli
    </p>
    <Transaction
      v-for="(tx, index) in txList"
      :key="index"
      :transactions="tx"
    />
  </div>
</template>

<script>
import store from '@/store'
import { mapState } from 'vuex'
import Transaction from '@/components/transaction/Transaction'

export default {
  middleware: 'admin',
  
  components: {
    Transaction
  },

  beforeRouteEnter (to, from, next) {
    store.dispatch('transaction/fetchTransactionList')
    .then(() => next())
  },

  computed: {
    ...mapState({
      transactionList: state => state.transaction.transactionList
    }),
    txList () {
      const txList = this.transactionList
      return txList.sort((a, b) => new Date(b.date) - new Date(a.date))
    }
  }
}
</script>

<style>

</style>
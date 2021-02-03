import axios from "axios"
import { API_URL } from "@/constants/config"
import {
  FETCH_SELLER_TRANSACTION_LIST,
  FETCH_BUYER_TRANSACTION_LIST,
  UPDATE_TRANSACTION_STATUS,
  FETCH_TRANSACTION_LIST
} from "../mutation-types"

export const state = {
  sellerTransactionList: [],
  buyerTransactionList: [],
  transactionList: []
}

export const getters = {
  product: state => state.product
}

export const mutations = {
  [FETCH_SELLER_TRANSACTION_LIST](state, transactionList) {
    state.sellerTransactionList = transactionList
	},
	[FETCH_BUYER_TRANSACTION_LIST](state, transactionList) {
    state.buyerTransactionList = transactionList
  },
  [FETCH_TRANSACTION_LIST] (state, transactionList) {
    state.transactionList = transactionList
  },
  [UPDATE_TRANSACTION_STATUS](state, { transactionId, status }) {
    state.sellerTransactionList = [
      ...state.sellerTransactionList.filter (item => {
        if (item.id == transactionId) {
          item.status = status
          return item
        }

        return item
      })
    ]

    state.buyerTransactionList = [
      ...state.buyerTransactionList.filter (item => {
        if (item.id == transactionId) {
          item.status = status
          return item
        }

        return item
      })
    ]

    state.transactionList = [
      ...state.transactionList.filter(item => {
        if (item.id == transactionId) {
          item.status = status
          return item
        }

        return item
      })
    ]
  }
}

export const actions = {
  async fetchSellerTransactionList({ commit }, id) {
    try {
      const { data } = await axios.get(`${API_URL}/transactions?sellerId=${id}`)

      if (data.status !== "success") return

			commit(FETCH_SELLER_TRANSACTION_LIST, data.payload)
			
			return data.payload
    } catch (e) {
			console.log(e)
			
			return e
    }
  },

  async fetchBuyerTransactionList({ commit }, id) {
    try {
      const { data } = await axios.get(`${API_URL}/transactions?buyerId=${id}`)

      if (data.status !== "success") return

      commit(FETCH_BUYER_TRANSACTION_LIST, data.payload)
    } catch (e) {
      console.log(e)
    }
  },

  async fetchTransactionList ({ commit }, id) {
    try {
      const { data } = await axios.get(`${API_URL}/transactions`)

      if (data.status !== "success") return

      commit(FETCH_TRANSACTION_LIST, data.payload)
    } catch (e) {
      console.log(e)
    }
  },

  async updateTransactionStatus({ commit }, { id, status }) {
    try {
      const { data } = await axios.patch(
        `${API_URL}/transactions/${id}/status`,
        { status }
      )

      if (!data.status) return false

      commit(UPDATE_TRANSACTION_STATUS, {
        transactionId: data.payload.id,
        status: data.payload.status
      })
      return true
    } catch (e) {
      console.log(e)

      return false
    }
  },

  async checkout ({ _ }, dataToSend) {
    try {
      const { data } = await axios.post(
        `${API_URL}/transactions`,
        dataToSend
      )

      if (data.statusCode !== 201) return

      return true
    } catch (e) {
      console.log(e)

      return false
    }
  }
}

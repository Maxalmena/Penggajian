import axios from 'axios'
import { API_URL } from '@/constants/config'
import {
  FETCH_PAYMENT_OPTIONS
} from '../mutation-types'

export const state = {
  paymentOptions: null
}

export const getters = {
  paymentOptions: state => state.paymentOptions
}

export const mutations = {
  [FETCH_PAYMENT_OPTIONS] (state, { paymentOptions }) {
    state.paymentOptions = paymentOptions
  }
}

export const actions = {
  async createPaymentOptions ({ dispatch }, payload) {
    try {
      await axios.post(`${API_URL}/paymentMethods`, payload)
      .then(() => dispatch('fetchPaymentOptions'))
    } catch (e) {
      console.log(e)
    }
  },

  async fetchPaymentOptions ({ commit }) {
    try {
      const { data } = await axios.get(`${API_URL}/paymentMethods`)

      data.status === 'success' && commit(FETCH_PAYMENT_OPTIONS, { paymentOptions: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async removePaymentOptions ({ dispatch }, id) {
    try {
      await axios.delete(`${API_URL}/paymentMethods/${id}`)
      .then(() => dispatch('fetchPaymentOptions'))
    } catch (e) {
      console.log(e)
    }
  }
}

import axios from 'axios'
import { API_URL } from '@/constants/config'

export const state = {
  transactionDetail: null
}

export const getters = {
  transactionDetail: state => state.transactionDetail
}

export const actions = {
  async createTransaction ({ }, payload) {
    try {
      await axios.post(`${API_URL}/transactions`, payload)
    } catch (e) {
      console.log(e)
    }
  }
}
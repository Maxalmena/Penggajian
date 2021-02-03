import axios from 'axios'
import { API_URL } from '@/constants/config'
import {
  FETCH_PRODUCT,
  FETCH_PRODUCT_LIST
} from '../mutation-types'

export const state = {
  product: null,
  productList: null
}

export const getters = {
  product: state => state.product,
  productList: state => state.productList
}

export const mutations = {
  [FETCH_PRODUCT] (state, { product }) {
    state.product = product
  },
  [FETCH_PRODUCT_LIST] (state, { productList }) {
    state.productList = productList
  }
}

export const actions = {
  async createProduct ({ }, payload) {
    try {
      await axios.post(`${API_URL}/products`, payload)
    } catch (e) {
      console.log(e)
    }
  },

  async updateProduct ({ }, payload) {
    try {
      await axios.put(`${API_URL}/products/${payload.id}`, payload)
    } catch (e) {
      console.log(e)
    }
  },

  async fetchProduct ({ commit }, id) {
    try {
      const { data } = await axios.get(`${API_URL}/products/${id}`)

      data.status === 'success' && commit(FETCH_PRODUCT, { product: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async fetchProductListByCategory ({ commit }, id) {
    try {
      const { data } = await axios.get(`${API_URL}/products?categoryId=${id}`)

      data.status === 'success' && commit(FETCH_PRODUCT_LIST, { productList: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async fetchProductListBySeller ({ commit }, id) {
    try {
      const { data } = await axios.get(`${API_URL}/products?sellerId=${id}`)

      data.status === 'success' && commit(FETCH_PRODUCT_LIST, { productList: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async removeProduct ({ }, id) {
    try {
      await axios.delete(`${API_URL}/products/${id}`)
    } catch (e) {
      console.log(e)
    }
  }
}

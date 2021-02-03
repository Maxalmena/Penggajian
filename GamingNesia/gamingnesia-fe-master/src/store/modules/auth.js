import axios from 'axios'
import Cookies from 'js-cookie'
import { API_URL } from '@/constants/config'
import {
  LOGOUT,
  SAVE_TOKEN,
  FETCH_USER_SUCCESS,
  FETCH_USER_FAILURE,
  UPDATE_USER
} from '../mutation-types'

// state
export const state = {
  user: null,
  token: Cookies.get('token')
}

// getters
export const getters = {
  user: state => state.user,
  token: state => state.token,
  check: state => state.user !== null
}

// mutations
export const mutations = {
  [SAVE_TOKEN] (state, token) {
    state.token = token
    Cookies.set('token', token, 365)
  },

  [FETCH_USER_SUCCESS] (state, { user }) {
    state.user = user
  },

  [FETCH_USER_FAILURE] (state) {
    state.token = null
    Cookies.remove('token')
  },

  [LOGOUT] (state) {
    state.user = null
    state.token = null

    Cookies.remove('token')
  },

  [UPDATE_USER] (state, { user }) {
    state.user = user
  }
}

// actions
export const actions = {
  saveToken ({ commit }, payload) {
    commit(SAVE_TOKEN, payload)
  },

  async fetchUser ({ commit }) {
    try {
      const { data } = await axios.get(`${API_URL}/me`, 'oshit')
      
      commit(FETCH_USER_SUCCESS, { user: data.payload })
    } catch (e) {
      commit(FETCH_USER_FAILURE)
    }
  },

  async updateUser ({ commit }, payload) {
    try {
      const { data } = await axios.patch(`${API_URL}/users`, payload)
      
      if (data.status === 'success') commit(UPDATE_USER, data.payload)
    } catch (e) { }
  },

  async logout ({ commit }) {
    try {
      await axios.post(`${API_URL}/logout`)
    } catch (e) { }

    commit(LOGOUT)
  },

  async fetchOauthUrl (ctx, { provider }) {
    const { data } = await axios.post(`/api/oauth/${provider}`)

    return data.url
  },

  async login ({ commit, dispatch }, payload) {
    const { data } = await axios.post(`${API_URL}/login`, payload)
    if (data.status === 'success') {
      commit(SAVE_TOKEN, data.payload.authToken)
      dispatch('fetchUser')
    }
    return data.status === 'success'
  },

  async register ({ commit, dispatch }, payload) {
    const { data } = await axios.post(`${API_URL}/users`, payload)

    if (data.status === 'success') {
      commit(SAVE_TOKEN, data.payload.authToken)
      dispatch('fetchUser')

      return true
    }
    
    return false
  }
}

import axios from 'axios'
import { API_URL } from '@/constants/config'
import {
  FETCH_GAME,
  FETCH_GAME_LIST
} from '../mutation-types'

export const state = {
  game: null,
  gameList: null,
  search: ''
}

export const getters = {
  game: state => state.game,
  gameList: state => state.gameList,
  search: state => state.search
}

export const mutations = {
  [FETCH_GAME] (state, { game }) {
    state.game = game
  },
  [FETCH_GAME_LIST] (state, { gameList }) {
    state.gameList = gameList
  }
}

export const actions = {
  async createGame ({ }, payload) {
    try {
      await axios.post(`${API_URL}/categories`, payload.game)
    } catch (e) {
      console.log(e)
    }
  },

  async updateGame ({ }, payload) {
    try {
      await axios.put(`${API_URL}/categories/${payload.id}`, payload.game)
    } catch (e) {
      console.log(e)
    }
  },

  async fetchGame ({ commit }, id) {
    try {
      const { data } = await axios.get(`${API_URL}/categories/${id}`)

      data.status === 'success' && commit(FETCH_GAME, { game: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async fetchGameList ({ commit }) {
    try {
      const { data } = await axios.get(`${API_URL}/categories`)

      data.status === 'success' && commit(FETCH_GAME_LIST, { gameList: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async removeGame ({ }, id) {
    try {
      await axios.delete(`${API_URL}/categories/${id}`)
    } catch (e) {
      console.log(e)
    }
  }
}

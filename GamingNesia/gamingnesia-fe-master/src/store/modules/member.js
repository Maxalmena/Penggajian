import axios from 'axios'
import { API_URL } from '@/constants/config'
import {
  FETCH_MEMBER_LIST,
  FETCH_MEMBER
} from '../mutation-types'

export const state = {
  member: null,
  memberList: null
}

export const getters = {
  member: state => state.member,
  memberList: state => state.memberList
}

export const mutations = {
  [FETCH_MEMBER] (state, { member }) {
    state.member = member
  },
  [FETCH_MEMBER_LIST] (state, { memberList }) {
    state.memberList = memberList
  }
}

export const actions = {
  async updateMember ({ }, payload) {
    try {
      const id = payload.id
      delete payload.id
      const { data } = await axios.put(`${API_URL}/users/${id}`, payload)

      commit(FETCH_MEMBER, { member: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async updatePassword ({ }, payload) {
    try {
      const { data } = await axios.put(`${API_URL}/users/${payload.id}/changePassword`, payload)

      commit(FETCH_MEMBER, { member: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async fetchMember ({ commit }, id) {
    try {
      const { data } = await axios.get(`${API_URL}/users/${id}`)
      
      commit(FETCH_MEMBER, { member: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async fetchMemberList ({ commit }) {
    try {
      const { data } = await axios.get(`${API_URL}/users`)

      data.status === 'success' && commit(FETCH_MEMBER_LIST, { memberList: data.payload })
    } catch (e) {
      console.log(e)
    }
  },

  async removeMember ({ }, id) {
    try {
      await axios.delete(`${API_URL}/users/${id}`)
    } catch (e) {
      console.log(e)
    }
  }
}

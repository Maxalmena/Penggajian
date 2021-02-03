<template>
  <div>
    <vs-input 
      v-model="search"
      color="#3f51b5"
      class="search-input"
      icon-after
      icon="search"
      placeholder="Cari member"
    />
    <div class="flex flex-wrap justify-between">
      <div
        v-for="(member, index) in members"
        :key="index"
        class="mt-6 member-card p-4 rounded-lg"
      >
        <p class="text-xl pb-2">
          {{ member.fullName }}
        </p>
        <p class="text-xl pb-2">
          {{ member.email }}
        </p>
        <p class="text-xl pb-2">
          {{ member.phoneNumber }}
        </p>
        <div class="mt-2">
          <button
            class="mr-8 font-bold link"
            @click="editMember(member.id)"
          >
            Ubah Data Member
          </button>
          <button
            class="ml-1 font-bold link-alert"
            @click="deleteMember(member.id)"
          >
            Hapus Member
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import router from '@/router'
import store from '@/store'
import { mapGetters } from 'vuex'

export default {
  data: () => ({
    search: ''
  }),

  beforeRouteEnter (to, from, next) {
    store.dispatch('member/fetchMemberList')
    .then(() => next())
  },

  computed: {
    ...mapGetters({
      memberList: 'member/memberList'
    }),
    members () {
      return this.memberList.filter(data => data.fullName.toLowerCase().includes(this.search) || data.fullname.toLowerCase().includes(this.search))
    }
  },

  methods: {
    editMember (id) {
      router.push({ name: 'cms.member.edit', params: { id: encodeURIComponent(id) } })
    },
    deleteMember (id) {
      store.dispatch('member/removeMember', id)
    }
  }
}
</script>

<style>

</style>
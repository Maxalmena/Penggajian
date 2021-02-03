<template>
  <div class="member-input">
    <vs-input
      v-model="name"
      label="Nama"
      color="#3f51b5"
      style="width: 22.25rem"
      class="mb-4"
    />
    <vs-input
      v-model="email"
      label="Email"
      color="#3f51b5"
      style="width: 22.25rem"
      class="mb-4"
    />
    <vs-select
      v-model="selectedStatus"
      label="Status Member"
      color="primary"
      style="width: 22.25rem"
      class="mb-4"
    >
      <vs-select-item
        v-for="(type, index) in status"
        :key="index"
        :value="index"
        :text="type"
      />
    </vs-select>
    <vs-input
      v-model="password"
      type="password"
      label="Ubah Password"
      color="#3f51b5"
      style="width: 22.25rem"
      class="mb-4"
    />
    <vs-button
      color="#3f51b5"
      type="filled"
      class="py-4 mt-4 rounded block"
      style="width: 22.25rem"
      @click="updateMember()"
    >
      <span class="font-bold">Simpan</span>
    </vs-button>
    <vs-button
      color="#3f51b5"
      type="border"
      class="py-4 mt-4 rounded block"
      style="width: 22.25rem"
      @click="toMemberListPage"
    >
      <span class="font-bold">Batal, kembali ke page Member</span>
    </vs-button>
  </div>
</template>

<script>
import router from '@/router'
import store from '@/store'
import { mapGetters } from 'vuex'

export default {
  data: () => ({
    name: '',
    email: '',
    selectedStatus: '',
    password: '',
    status: [
      'Reguler',
      'VIP'
    ]
  }),

  beforeRouteEnter (to, from, next) {
    store.dispatch('member/fetchMember', decodeURIComponent(to.params.id))
    .then(() => next(vm => vm.setMemberDetail()))
  },

  computed: {
    ...mapGetters({
      member: 'member/member'
    })
  },

  methods: {
    setMemberDetail () {
      this.id = this.member.id || ''
      this.name = this.member.fullName || ''
      this.email = this.member.email || ''
      this.selectedStatus = this.member.membership || 0
    },
    toMemberListPage () {
      router.push({ name: 'cms.member.list' })
    },
    updateMember () {
      const payload = {
        id: this.id,
        fullName: this.name,
        email: this.email,
        password: this.password || '',
        profilePic: this.member.profilePic || 0,
        address: this.member.address,
        phoneNumber: this.member.phoneNumber,
        membership: this.selectedStatus
      }
      store.dispatch('member/updateMember', payload)
      .then(() => router.push({ name: 'cms.member.list'}))
    }
  }
}
</script>

<style>

</style>
<template>
  <div>
    <p class="text-2xl leading-none font-bold page-title pb-8">
      {{ inMemberList ? 'Member' : 'Ubah Data Member' }}
    </p>
    <div>
      <transition
        name="fade"
        mode="out-in"
      >
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
import router from '@/router'

export default {
  middleware: 'admin',
  
  computed: {
    inMemberList () {
      return router.currentRoute === 'cms.member.list'
    }
  }
}
</script>

<style>

</style>
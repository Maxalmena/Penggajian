<template>
  <div>
    <p class="text-2xl leading-none font-bold page-title pb-8">
      Kategori Game
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

export default {
  middleware: 'admin'
}
</script>

<style>

</style>
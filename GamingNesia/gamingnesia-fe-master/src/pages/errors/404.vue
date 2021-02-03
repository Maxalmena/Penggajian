<template>
  <div class="text-center mt-40">
    <div class="flex justify-center items-center mb-10">
      <img 
        src="../../assets/icons/alert-triangle.svg"
        width="70px"
      >
      <h1 class="text-3xl ml-4 rounded">
        Halaman Tidak Ditemukan
      </h1>
    </div>

    <vs-button 
      color="#3f51b5" 
      type="filled"
      :to="{ name: 'home' }"
    >
      Halaman Utama
    </vs-button>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

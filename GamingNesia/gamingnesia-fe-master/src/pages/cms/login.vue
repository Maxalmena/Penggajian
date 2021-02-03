<template>
  <div class="login-box-wrapper w-full flex flex-col items-center justify-center">
    <div class="login-box">
      <p class="w-full font-bold text-xl">
        Masuk sebagai Admin
      </p>
      <vs-input
        v-model="loginForm.email"
        label="Email"
        color="#3f51b5"
        class="my-5 w-full"
      />
      <vs-input
        v-model="loginForm.password"
        type="password"
        label="Password"
        color="#3f51b5"
        class="my-5 w-full"
      />
      <vs-button
        color="#3f51b5"
        type="filled"
        class="w-full py-4 rounded"
        @click="login"
      >
        <span class="font-bold">Masuk</span>
      </vs-button>
    </div>
  </div>
</template>

<script>
import router from '@/router'
import store from '@/store'
import { required, email, password } from '@/utils/validation'

export default {
  middleware: 'guest',
  
  data:() => ({
    loginForm: {
      email: '',
      password: ''
    },
    error: {
      email: '',
      password: ''
    }
  }),

  watch: {
    loginForm: {
      handler () {
        this.clearError()
      },
      deep: true
    }
  },

  methods: {
    login () {
      let noError = true
      Object.keys(this.loginForm).forEach(key => {
        if (!required(this.loginForm[key])) {
          this.error[key] = `${key} tidak boleh kosong.`
          noError = false
        } else if (key === 'email' && !email(this.loginForm[key])) {
          this.error[key] = `format ${key} tidak valid.`
          noError = false
        } else this.error[key] = ''
      })
      if (!noError) return
      store.dispatch('auth/login', {
        email: this.loginForm.email,
        password: this.loginForm.password
      }).then(res => {
        if (res) router.push({ name: 'cms.banner' })
        else {
          this.error.email = ' '
          this.error.password = 'Email atau password yang Anda masukkan salah.'
        }
      })
    },
    clearError () {
      Object.keys(this.error).forEach(key => {
        if (this.error[key].length > 0)this.error[key] = ''
      })
    }
  }
}
</script>

<style>

</style>
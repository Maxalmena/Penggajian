<template>
  <div class="main-layout">
    <navbar 
      :key="authenticated"
      @showModal="showAuthModal"
    />
    <div 
      class="w-full" 
      style="margin-top: 5rem;"
    >
      <child />
    </div>
    <vs-popup
      class="auth-modal"
      :active.sync="authModal"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div class="auth-modal--body">
        <div class="auth-modal--title w-full flex justify-between items-center">
          <span class="text-2xl font-bold">{{ authType === 'login' ? 'Masuk' : 'Daftar' }}</span>
          <a
            href="#"
            class="text-base font-bold text-blue-900"
            @click="authType === 'login' ? authType = 'regis' : authType = 'login'"
          >
            {{ authType === 'login' ? 'Daftar' : 'Masuk' }}
          </a>
        </div>
        <!-- Login Form -->
        <div
          v-if="authType === 'login'"
          class="auth-modal--form mt-12"
        >
          <vs-input
            v-model="loginForm.email"
            label="Email"
            color="#3f51b5"
            class="mb-8"
            :danger="error.email.length > 0"
            :danger-text="error.email"
          />
          <vs-input
            v-model="loginForm.password"
            type="password"
            label="Password"
            color="#3f51b5"
            class="mb-4"
            :danger="error.password.length > 0"
            :danger-text="error.password"
          />
          <!-- <div
            class="w-full flex flex-row-reverse mb-4"
          >
            <a 
              href="#"
              class="font-bold text-blue-900"
              @click="forget"
            >
              Lupa password?
            </a>
          </div> -->
          <vs-button
            class="mt-5 auth-btn rounded"
            color="#3f51b5"
            type="filled"
            @click="login"
          >
            <span class="font-bold">Masuk</span>
          </vs-button>
        </div>
        <!-- Register Form -->
        <div
          v-else
          class="auth-modal--form mt-12"
        >
          <vs-input
            v-model="regisForm.name"
            label="Nama"
            color="#3f51b5"
            class="mb-8"
            :danger="error.name.length > 0"
            :danger-text="error.name"
          />
          <vs-input
            v-model="regisForm.email"
            label="Email"
            color="#3f51b5"
            class="mb-8"
            :danger="error.email.length > 0"
            :danger-text="error.email"
          />
          <vs-input
            v-model="regisForm.password"
            type="password"
            label="Password"
            color="#3f51b5"
            class="mb-8"
            :danger="error.password.length > 0"
            :danger-text="error.password"
          />
          <vs-input
            v-model="regisForm.repeat_password"
            type="password"
            label="Ulangi Password"
            color="#3f51b5"
            class="mb-4"
            :danger="error.repeat_password.length > 0"
            :danger-text="error.repeat_password"
          />
          <vs-button
            class="mt-5 auth-btn rounded"
            color="#3f51b5"
            type="filled"
            @click="register"
          >
            <span class="font-bold">Daftar</span>
          </vs-button>
        </div>
      </div>
    </vs-popup>
  </div>
</template>

<script>
import Navbar from '@/components/Navbar'
import { required, email, password } from '@/utils/validation'
import store from '@/store'
import { mapGetters } from 'vuex'

export default {
  name: 'MainLayout',

  components: {
    Navbar
  },

  data: () => ({
    authModal: false,
    authType: '',
    loginForm: {
      email: '',
      password: ''
    },
    regisForm: {
      name: '',
      email: '',
      password: '',
      repeat_password: ''
    },
    error: {
      name: '',
      email: '',
      password: '',
      repeat_password: ''
    },
  }),

  computed: {
    ...mapGetters ({
      auth: 'auth/check'
    }),
    authenticated () {
      return this.auth
    }
  },

  watch: {
    loginForm: {
      handler () {
        this.clearError()
      },
      deep: true
    },
    regisForm: {
      handler () {
        this.clearError()
      },
      deep: true
    },
    'authModal': function () {
      this.clearError()
    },
    'authType': function () {
      this.clearError()
    }
  },

  mounted () {
    if (localStorage.getItem('cart')) {
      try {
        store.dispatch('cart/fetchCart', JSON.parse(localStorage.getItem('cart')))
      } catch (e) {
        localStorage.removeItem('cart')
      }
    }
  },

  methods: {
    showAuthModal (type) {
      this.authType = type
      this.authModal = true
    },
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
      else {
        store.dispatch('auth/login', {
          email: this.loginForm.email,
          password: this.loginForm.password
        }).then(res => {
          if (res) this.authModal = false
          else {
            this.error.email = ' '
            this.error.password = 'Email atau password yang Anda masukkan salah.'
          }
        })
      }
    },
    register () {
      let noError = true
      Object.keys(this.regisForm).forEach(key => {
        if (!required(this.regisForm[key])) {
          this.error[key] = `${key} tidak boleh kosong.`.replace('_', ' ')
          noError = false
        } else if (key === 'email' && !email(this.regisForm[key])) {
          this.error[key] = `format ${key} tidak valid.`
          noError = false
        } else this.error[key] = ''
      })
      if (!password(this.regisForm.password)) {
        this.error.password = 'Password harus di antara 6 - 20 karakter, mengandung 1 karakter angka, 1 huruf kapital, dan 1 huruf kecil'
        noError = false
      } else if (this.regisForm.password !== this.regisForm.repeat_password) {
        this.error.repeat_password = 'Konfirmasi password tidak cocok dengan password semula.'
        noError = false
      }
      if (!noError) return
      else {
        store.dispatch('auth/register', {
          fullname: this.regisForm.name,
          email: this.regisForm.email,
          password: this.regisForm.password
        }).then(res => {
          if (res) this.authModal = false
          else this.error.email = 'Email telah terdaftar.'
        })
      }
    },
    clearError () {
      Object.keys(this.error).forEach(key => {
        if (this.error[key].length > 0)this.error[key] = ''
      })
    }
  }
}
</script>

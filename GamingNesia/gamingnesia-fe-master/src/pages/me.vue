<template>
  <div class="page-section pt-8">
    <div class="history-wrapper flex justify-between">
      <p class="text-2xl pb-6 leading-none font-bold page-title">
        Transaksi {{ historyType === 'buyer' ? 'Pembelian' : 'Penjualan' }}
      </p>
      <button
        class="font-bold link p-0 h-0"
        @click="changeHistoryType"
      >
        Buka Sebagai {{ historyType === 'buyer' ? 'Penjual' : 'Pembeli' }} >
      </button>
    </div>
    <div class="me-wrapper flex justify-between">
      <div 
        v-if="historyType !== 'buyer'"
        class="history-wrapper"
      >
        <Transaction
          v-for="(tx, index) in sellerTransactionList"
          :key="index"
          :transactions="tx"
          :history-type="historyType"
        />
      </div>
      <div 
        v-else
        class="history-wrapper"
      >
        <Transaction
          v-for="(tx, index) in buyerTransactionList"
          :key="index"
          :transactions="tx"
          :history-type="historyType"
        />
      </div>
      <div class="me">
        <div class="profile-info px-4 py-6">
          <p class="mb-4 text-xl text-black">
            Profil Kamu
          </p>
          <p class="mb-1">
            {{ me.fullname }}
          </p>
          <p>
            {{ me.email }}
          </p>
          <button
            class="block"
            @click="editProfile"
          >
            <p class="link font-bold mt-6">
              Ubah Data Diri
            </p>
          </button>
          <button
            class="block"
            @click="changePassword"
          >
            <p class="link font-bold mt-1">
              Ganti Password
            </p>
          </button>
          <button
            class="block"
            @click="logout"
          >
            <p class="font-bold link-alt mt-1">
              Logout
            </p>
          </button>
        </div>
        <vs-button
          v-if="historyType === 'seller'"
          color="#3f51b5"
          type="filled"
          class="w-full py-4 mt-8 rounded"
          @click="toCatalogPage"
        >
          <span class="font-bold">Lihat Barang Dijual</span>
        </vs-button>
        <vs-button
          color="#3f51b5"
          type="border"
          class="w-full py-4 mt-8 rounded"
          @click="helpModal = true"
        >
          <span class="font-bold">Bantuan</span>
        </vs-button>
      </div>
    </div>
    <vs-popup
      class="profile-modal"
      :active.sync="helpModal"
      title="Bantuan"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div style="padding: 1.75rem 1.875rem 3rem;">
        <button
          class="flex content-center mb-4"
          style="height: 2.75rem;"
          @click="toLine()"
        >
          <font-awesome-icon 
            :icon="['fab', 'line']" 
            :style="{ color: '#3f51b5' }"
            size="3x"
          />
          <div class="text-lg ml-2">
            <span 
              class="inline-block align-middle"
              style="line-height: 2.75rem;"
            >
              @590cepnb
            </span>
          </div>
        </button>
        <button
          class="flex content-center mb-4"
          style="height: 2.75rem;"
          @click="toWhatsApp()"
        >
          <font-awesome-icon 
            :icon="['fab', 'whatsapp']"
            :style="{ color: '#3f51b5' }"
            size="3x"
          />
          <div class="text-lg ml-2">
            <span 
              class="inline-block align-middle"
              style="line-height: 2.75rem;"
            >
              +62 812-9163-3225
            </span>
          </div>
        </button>
        Jam Layanan: 09.00 WIB - 20.00 WIB
      </div>
    </vs-popup>
    <vs-popup
      class="profile-modal"
      :active.sync="profileModal"
      title="Ubah Data Diri"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div class="profile-form">
        <vs-input
          v-model="profileForm.name"
          label="Nama"
          color="#3f51b5"
          class="mb-8"
          :danger="error.name.length > 0"
          :danger-text="error.name"
        />
        <vs-input
          v-model="profileForm.email"
          label="Email"
          color="#3f51b5"
          class="mb-8"
          :danger="error.email.length > 0"
          :danger-text="error.email"
        />
        <vs-input
          v-model="profileForm.phoneNumber"
          type="number"
          label="No Telefon"
          color="#3f51b5"
          class="mb-8"
          :danger="error.phoneNumber.length > 0"
          :danger-text="error.phoneNumber"
        />
        <vs-button
          class="mt-4 rounded w-full py-5"
          color="#3f51b5"
          type="filled"
          @click="submitProfile"
        >
          <span class="font-bold">Simpan</span>
        </vs-button>
      </div>
    </vs-popup>
    <vs-popup
      class="profile-modal"
      :active.sync="cPassModal"
      title="Ganti Password"
      background-color-popup="rgb(255,255,255)"
      button-close-hidden
    >
      <div class="profile-form">
        <vs-input
          v-model="cPassForm.pass"
          type="password"
          label="Password Sekarang"
          color="#3f51b5"
          class="mb-8"
          :danger="error.pass.length > 0"
          :danger-text="error.pass"
        />
        <vs-input
          v-model="cPassForm.newPass"
          type="password"
          label="Password Baru"
          color="#3f51b5"
          class="mb-8"
          :danger="error.newPass.length > 0"
          :danger-text="error.newPass"
        />
        <vs-input
          v-model="cPassForm.cNewPass"
          type="password"
          label="Ulangi Password Baru"
          color="#3f51b5"
          class="mb-8"
          :danger="error.cNewPass.length > 0"
          :danger-text="error.cNewPass"
        />
        <vs-button
          class="mt-4 rounded w-full py-5"
          color="#3f51b5"
          type="filled"
          @click="submitPassword"
        >
          <span class="font-bold">Simpan</span>
        </vs-button>
      </div>
    </vs-popup>
  </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { required, email, password } from '@/utils/validation'
import { mapGetters, mapState } from 'vuex'
import Transaction from '@/components/transaction/Transaction'

export default {
  components: {
    Transaction
  },

  middleware: 'auth',

  data () {
    const user = this.$store.getters['auth/user']

    return {
      historyType: 'buyer',
      profileModal: false,
      cPassModal: false,
      profileForm: {
        id: user.id || '',
        name: user.fullName || '',
        email: user.email || '',
        phoneNumber: user.phoneNumber || ''
      },
      cPassForm: {
        id: user.id || '',
        pass: '',
        newPass: '',
        cNewPass: ''
      },
      error: {
        name: '',
        email: '',
        phoneNumber: '',
        pass: '',
        newPass: '',
        cNewPass: ''
      },
      me: user,
      helpModal: false
    }
  },

  beforeRouteEnter (to, from, next) {
    const id = store.getters['auth/user'].id
    store.dispatch('transaction/fetchBuyerTransactionList', id)
    .then(() => store.dispatch('transaction/fetchSellerTransactionList', id))
    .then(() => next())
  },

  computed: {
    ...mapState({
      sellerTransactionList: state => state.transaction.sellerTransactionList,
      buyerTransactionList: state => state.transaction.buyerTransactionList,
    }),
    ...mapGetters ({
      productList: 'product/productList',
    }),
    pageList () {
      return this.productList
    },
    sellerTxList () {
      const txList = this.sellerTransactionList
      return txList.sort((a, b) => new Date(b.date) - new Date(a.date))
    },
    buyerTxList () {
      const txList = this.buyerTransactionList
      return txList.sort((a, b) => new Date(b.date) - new Date(a.date))
    }
  },

  watch: {
    profileForm: {
      handler () {
        this.clearError()
      },
      deep: true
    },
    cPassForm: {
      handler () {
        this.clearError()
      },
      deep: true
    },
    'profileModal': function () {
      this.clearError()
    },
    'cPassModal': function () {
      this.clearError()
    },
  },

  methods: {
    changeHistoryType () {
      if(this.historyType === 'buyer') this.historyType = 'seller'
      else this.historyType = 'buyer'
    },
    toCatalogPage () {
      router.push({ name: 'products.catalog' })
    },
    editProfile () {
      this.profileModal = true
    },
    changePassword () {
      this.cPassModal = true
    },
    submitProfile () {
      let noError = true
      Object.keys(this.profileForm).forEach(key => {
        if (!required(this.profileForm[key])) {
          this.error[key] = `${key} tidak boleh kosong.`.replace('_', ' ')
          noError = false
        } else if (key === 'email' && !email(this.profileForm[key])) {
          this.error[key] = `format ${key} tidak valid.`
          noError = false
        } else this.error[key] = ''
      })
      if (!noError) return
      store.dispatch('member/updateMember', {
        id: this.profileForm.id,
        fullName: this.profileForm.name,
        email: this.profileForm.email,
        phoneNumber: this.profileForm.phoneNumber,
        address: this.$store.getters['auth/user'].address,
        membership: this.$store.getters['auth/user'].membership,
        profilePic: this.$store.getters['auth/user'].profilePic
      })
    },
    submitPassword () {
      let noError = true
      Object.keys(this.cPassForm).forEach(key => {
        if (!required(this.cPassForm[key])) {
          this.error[key] = `${key} tidak boleh kosong.`.replace('_', ' ')
          noError = false
        } else this.error[key] = ''
      })
      if (!noError) return
      store.dispatch('member/updatePassword', {
        id: this.cPassForm.id,
        oldPassword: this.cPassForm.pass,
        newPassword: this.cPassForm.newPass
      })
      .then(() => this.cPassModal = false)
    },
    async logout () {
      await this.$store.dispatch('auth/logout')
      this.$router.push({ name: 'home' })
    },
    clearError () {
      Object.keys(this.error).forEach(key => {
        if (this.error[key].length > 0)this.error[key] = ''
      })
    },

    toLine () {
      window.open('https://line.me/R/ti/p/%40590cepnb', '_blank')
    },
    toWhatsApp () {
      window.open('https://wa.me/6281291633225', '_blank')
    }
  }
}
</script>

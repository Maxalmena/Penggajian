import store from '@/store'

export default (to, from, next) => {
  if (!store.getters['auth/user'].email.includes('admin@gamingnesia.com')) {
    next({ name: 'home' })
  } else {
    next()
  }
}

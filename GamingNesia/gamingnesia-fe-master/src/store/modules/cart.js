import {
  FETCH_CART,
  ADD_CART_ITEM,
  SET_CART_PRODUCTS,
  UPDATE_CART_PRODUCT,
  REMOVE_CART_ITEM,
} from '../mutation-types'

export const state = {
  cart: [],
  cartProducts: []
}

export const getters = {
  cart: state => state.cart,
  cartProducts: state => state.cartProducts
}

export const mutations = {
  [FETCH_CART] (state, { cart }) {
    state.cart = cart
  },
  [ADD_CART_ITEM] (state, newItem) {
    const isItemExists = state.cart.find(item => item.id === newItem.id)

    if (isItemExists === undefined) {
      const newCart = [
        ...state.cart,
        newItem,
      ]

      localStorage.setItem('cart', JSON.stringify(newCart))
      state.cart = newCart

      return
    }

    const newCart = [
      ...state.cart.filter(item => {
        if (item.id === isItemExists.id) {
          item.unit += 1
          return item
        }

        return item
      })
    ]

    localStorage.setItem('cart', JSON.stringify(newCart))
    state.cart = newCart
  },
  [SET_CART_PRODUCTS] (state, products) {
    state.cartProducts = products
  },
  [UPDATE_CART_PRODUCT] (state, product) {
    const cartToUpdate = state.cart.find(item => item.id === product.id)

    if (cartToUpdate === undefined) {
      return
    }

    cartToUpdate.remarks = product.remarks
    cartToUpdate.unit = product.unit
    const newCart = [
      ...state.cart.map(item => {
        if (item.id === product.id) {
          return cartToUpdate
        }

        return item
      }),
    ]

    localStorage.setItem('cart', JSON.stringify(newCart))
    state.cart = newCart
  },
  [REMOVE_CART_ITEM] (state, id) {
    return new Promise((resolve, _) => {
      const remainingCartItem = [
        ...state.cart.filter(item => {
          return item.id !== id
        })
      ]
      const remainingCartItemJSON = JSON.stringify(remainingCartItem)
      localStorage.setItem('cart',remainingCartItemJSON)
      state.cart = remainingCartItem

      resolve(JSON.parse(remainingCartItemJSON))
    })
  }
}

export const actions = {
  fetchCart ({ commit }, payload) {
    commit(FETCH_CART, { cart: payload })
  },
  addCartItem ({ commit }, id) {
    commit(ADD_CART_ITEM, id)
  },
  setCartProduct ({ commit }, payload) {
    commit(SET_CART_PRODUCTS, payload)
  },
  updateCartItem ({ commit }, newProduct) {
    commit(UPDATE_CART_PRODUCT, newProduct)
  },
  removeCartItem ({ commit }, id) {
    commit(REMOVE_CART_ITEM, id)
  },
}

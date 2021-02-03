function page (path) {
  return () => import(/* webpackChunkName: '' */ `@/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'home', component: page('home.vue') },

  { path: '/cms',
    component: page('cms/index.vue'),
    children: [
      { path: '', redirect: { name: 'cms.banner' } },
      { path: 'banner', name: 'cms.banner', component: page('cms/banner.vue') },
      {
        path: 'games',
        component: page('cms/games.vue'),
        children: [
          { path: '', redirect: { name: 'cms.games.list'} },
          { path: 'list', name: 'cms.games.list', component: page('games/games-list.vue') },
          { path: 'new', name: 'cms.games.new', component: page('games/games-input.vue') },
          { path: ':id/edit', name: 'cms.games.edit', component: page('games/games-input.vue') }
        ]
      },
      {
        path: 'member',
        component: page('cms/member.vue'),
        children: [
          { path: '', redirect: { name: 'cms.member.list' } },
          { path: 'list', name: 'cms.member.list', component: page('member/member-list.vue') },
          { path: ':id/edit', name: 'cms.member.edit', component: page('member/member-input.vue') }
        ]
      },
      { path: 'admin-fee', name: 'cms.admin.fee', component: page('cms/admin-fee.vue') },
      { path: 'transactions', name: 'cms.admin.transaction', component: page('cms/transaction.vue') },
      { path: 'payment-options', name: 'cms.payment.options', component: page('cms/payment-options.vue') }
    ]
  },
  
  { path: '/cart', name: 'cart', component: page('payment/index.vue') },
  { path: '/checkout', name: 'checkout', component: page('payment/index.vue') },
  { path: '/products/:id', name: 'products.detail', component: page('products/products-detail.vue') },
  { path: '/games/:id', name: 'games.detail', component: page('games/games-detail.vue') },
  { path: '/me', name: 'me', component: page('me.vue') },
  { path: '/catalog', name: 'products.catalog', component: page('products/products-catalog.vue') },

  { path: '/cms/login', name:'cms.login', component: page('cms/login.vue') },
  { path: '*', component: page('errors/404.vue') }
]

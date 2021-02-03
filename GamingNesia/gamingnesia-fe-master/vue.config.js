module.exports = {
  devServer: {
    https: true,
    proxy: {
      '^/api': {
        target: process.env.VUE_APP_API_URL,
        ws: true,
        changeOrigin: true,
      },
    },
  },
  css: {
    loaderOptions: {
      sass: {
        prependData: '@import \'~@/sass/app.scss\';',
      },
    },
  },
}

module.exports = {
  extends: [
    'plugin:vue/recommended',
  ],
  parserOptions: {
    parser: 'babel-eslint',
    sourceType: 'module',
    allowImportExportEverywhere: true,
    ecmaVersion: 7,
    ecmaFeatures: {
      jsx: true,
      modules: true,
    },
  },
}

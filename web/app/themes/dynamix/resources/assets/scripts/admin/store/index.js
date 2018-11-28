// import Vue from 'vue'
// import Vuex from 'vuex'

// Vue.use(Vuex)

// export const store = new Vuex.Store({
//   state: {
//     count: 0,
//   },
//   mutations: {
//     increment: state => state.count++,
//     decrement: state => state.count--,
//   },
// })

import Vue from 'vue'
import Vuex from 'vuex'
import medias from './modules/medias'
// import createLogger from '../../../src/plugins/logger'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export const store = new Vuex.Store({
  state: {
    count: 0,
  },
  mutations: {
    increment: state => state.count++,
    decrement: state => state.count--,
  },
  modules: {
    medias,
  },
  strict: debug,
  // plugins: debug ? [createLogger()] : []
})

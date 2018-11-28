import Vue from 'vue'
import Router from 'vue-router'
import Index from '../vue/components/index.vue'
import Medias from '../vue/components/medias.vue'
import Section from '../vue/components/section.vue'
import Slider from '../vue/components/slider.vue'
import Condidat from '../vue/components/candidat.vue'
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index,
    },
    {
      path: '/medias',
      name: 'medias',
      component: Medias,
    },
    {
      path: '/section',
      name: 'section',
      component: Section,
    },
    {
      path: '/slider',
      name: 'slider',
      component: Slider,
    },
    {
      path: '/condidate',
      name: 'condidate',
      component: Condidat,
    },
  ],
})
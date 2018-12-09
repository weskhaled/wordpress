import Vue from 'vue';
import Swiper from 'swiper';
import { swapper } from '../lib/swiperwrapper';
import Card from '../vue/card.vue';
import VueImageCompare from 'vue-image-compare';
Vue.use(VueImageCompare);
export default {
  init() {
    // JavaScript to be fired on the home page
    swapper(
      {
        container: '#home-slider',
        full_screen: false,
        awesome_nav: true,
        parallax: true,
        autoplay: 30,
        swiper: {
          //swiper original params
          mousewheelControl: false,
        },
      }
    );

    // new Vue({
    // })
    new Vue({
      el: '#app-imgbeforeandafter',      
      components: {
        Card,
      },
      data() {
        return {
          before: '//localhost:3000/app/uploads/2018/09/home_beauty2_highlight1-1024x652.jpg',
          after: '//localhost:3000/app/uploads/2018/09/home_beauty2_highlight1-1024x652.jpg',
        }
      },
      created: function () {
        console.log('this is a vue js home page');
      },
    });

    new Swiper('#quote-clients', {
      speed: 400,
      spaceBetween: 0,
      grabCursor: true,
      autoplay: {
        delay: 50000,
      },
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        type: 'bullets',
      },
    });
    new Swiper('#partners-slider', {
      speed: 400,
      slidesPerView: 'auto',
      spaceBetween: 30,
      grabCursor: true,
      freeMode: true,
      loop: true,
      // scrollbar: {
      //   el: '.swiper-scrollbar',
      //   draggable: true,
      // },
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};

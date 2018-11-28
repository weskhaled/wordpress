import axios from 'axios';
export default class CondidatServices {

    sendRequest() {
      // Use vue-resource or any other http library to send your request
    }
    getall(){
        return axios.get(wpApiSettings.root+'wp/v2/slider',{},{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
    }
  }
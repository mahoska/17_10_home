import Vue from 'vue'
import Router from 'vue-router'
import General from '@/components/General'
import GeneralAdmin from '@/components/GeneralAdmin'


Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'General',
      component: General
    },
    {
      path: '/admin',
      name: 'GeneralAdmin',
      component: GeneralAdmin
    }
  ]
})

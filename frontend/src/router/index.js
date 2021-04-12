import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.MIX_DASHBOARD_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: () => import('@/views/Dashboard.vue'),
      meta: {
        pageTitle: 'Dashboard',
        breadcrumb: [
          {
            text: 'Dashboard',
            active: true,
          },
        ],
      },
    },
    {
      path: '/second-page/:id',
      name: 'second-page',
      component: () => import('@/views/SecondPage.vue'),
      meta: {
        pageTitle: 'Second Page',
        breadcrumb: [
          {
            text: 'Second Page',
            active: true,
          },
        ],
      },
    },
    {
      path: '/third-page',
      name: 'third-page',
      component: () => import('@/views/ThirdPage.vue'),
      meta: {
        pageTitle: 'Third Page',
        breadcrumb: [
          {
            text: 'Third Page',
            active: true,
          },
        ],
      },
    },
    {
      path: '/users',
      name: 'users-table',
      component: () => import('@/views/user/UserTable.vue'),
      meta: {
        pageTitle: 'Users Table',
        breadcrumb: [
          {
            text: 'Table',
          },
          {
            text: 'Users Table',
            active: true,
          },
        ],
      },
    },
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '*',
      redirect: 'error-404',
    },
  ],
})

export default router

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [
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
      action: 'read',
      subject: 'Auth',
    },
  },
  {
    path: '/buildings',
    name: 'buildings-table',
    component: () => import('@/views/building/BuildingTable.vue'),
    meta: {
      pageTitle: 'Buildings Table',
      breadcrumb: [
        {
          text: 'Table',
        },
        {
          text: 'Buildings Table',
          active: true,
        },
      ],
      action: "manage",
      subject: "all"
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
];

if (localStorage.getItem('userRole') === 'ADMIN') {
  routes.push({
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
  });
}

const router = new VueRouter({
  mode: 'history',
  base: null,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: routes,
})

export default router

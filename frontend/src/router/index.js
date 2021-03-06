import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [
  {
    path: '/',
    name: 'dashboard',
    component: () => import('@/views/dashboard/Dashboard.vue'),
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
    path: '/buildings',
    name: 'buildings-table',
    component: () => import('@/views/building/BuildingTable.vue'),
    meta: {
      pageTitle: 'Buildings Table',
      breadcrumb: [
        {
          text: 'Buildings Table',
          active: true,
        },
      ],
    },
  },
  {
    path: '/floors',
    name: 'floors-table',
    component: () => import('@/views/floor/FloorTable.vue'),
    meta: {
      pageTitle: 'Floors Table',
      breadcrumb: [
        {
          text: 'Floors Table',
          active: true,
        },
      ],
    },
  },
  {
    path: '/rooms',
    name: 'rooms-table',
    component: () => import('@/views/room/RoomTable.vue'),
    meta: {
      pageTitle: 'Rooms Table',
      breadcrumb: [
        {
          text: 'Rooms Table',
          active: true,
        },
      ],
    },
  },
  {
    path: '/appliances',
    name: 'appliances-table',
    component: () => import('@/views/appliance/ApplianceTable.vue'),
    meta: {
      pageTitle: 'Appliances Table',
      breadcrumb: [
        {
          text: 'Appliances Table',
          active: true,
        },
      ],
    },
  },
  {
    path: '/appliances/:id',
    name: 'appliance-view',
    component: () => import('@/views/appliance/ViewAppliance.vue'),
    meta: {
      pageTitle: 'View Appliance',
      breadcrumb: [
        {
          text: 'Appliances Table',
          to: '/appliances',
        },
        {
          text: 'View',
          active: true,
        },
      ],
      navActiveLink: 'appliances-table',
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

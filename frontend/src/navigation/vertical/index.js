export default [
  {
    title: 'Dashboard',
    route: 'dashboard',
    icon: 'BarChart2Icon',
  },
  {
    title: 'Space Management',
    icon: 'HomeIcon',
    children: [
      {
        title: 'Buildings',
        route: 'buildings',
      },
      {
        title: 'Floors',
        route: 'floors',
      },
      {
        title: 'Rooms',
        route: 'rooms',
      },
    ],
  },
  {
    title: 'Appliances',
    route: 'appliances',
    icon: 'BatteryChargingIcon',
  },
  {
    title: 'Users',
    route: 'users-table',
    icon: 'UsersIcon',
  },
]

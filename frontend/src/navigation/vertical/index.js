let navigation = [
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
        route: 'buildings-table',
      },
      {
        title: 'Floors',
        route: 'floors-table',
      },
      {
        title: 'Rooms',
        route: 'rooms-table',
      },
    ],
  },
  {
    title: 'Appliances',
    route: 'appliances',
    icon: 'BatteryChargingIcon',
  },
];

if (localStorage.getItem('userRole') === 'ADMIN') {
  navigation.push({
    title: 'Users',
    route: 'users-table',
    icon: 'UsersIcon',
  });
}

export default navigation;

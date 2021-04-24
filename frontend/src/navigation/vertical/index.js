let navigation = [
  {
    title: 'Dashboard',
    route: 'dashboard',
    icon: 'BarChart2Icon',
  },
  {
    header: 'Tables',
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
    route: 'appliances-table',
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

// navigation.push({
//     header: 'Settings',
//   },
//   {
//     title: 'Configuration',
//     route: 'settings',
//     icon: 'SettingsIcon',
//   });

export default navigation;

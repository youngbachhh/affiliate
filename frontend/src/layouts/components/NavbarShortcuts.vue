<script setup lang="ts">
const shortcuts = [
  // {
  //   icon: 'ri-calendar-line',
  //   title: 'Calendar',
  //   subtitle: 'Appointments',
  //   to: { name: 'apps-calendar' },
  // },
  {
    icon: "ri-file-list-3-line",
    title: "Hóa Đơn",
    subtitle: "Quản lý tài khoản",
    to: { name: "apps-invoice-list" },
  },
  {
    icon: "ri-user-line",
    title: "Người Dùng",
    subtitle: "Quản lý người dùng",
    to: { name: "apps-user-list" },
  },
  {
    icon: "ri-computer-line",
    title: "Quản Lý Vai Trò",
    subtitle: "Phân quyền",
    to: { name: "apps-roles" },
  },
  {
    icon: "ri-pie-chart-2-line",
    title: "Phân Tích",
    subtitle: "Phân tích dữ liệu",
    to: { name: "dashboards-analytics" },
  },
  {
    icon: "ri-settings-4-line",
    title: "Cài Đặt",
    subtitle: "Cài đặt tài khoản",
    to: { name: "pages-account-settings-tab", params: { tab: "account" } },
  },
];
</script>

<template>
  <Shortcuts :shortcuts="shortcuts" />
</template>

<script setup lang="ts">
import RoleCards from "@/views/apps/roles/RoleCards.vue";
import UserList from "@/views/apps/roles/UserList.vue";
</script>

<template>
  <VRow>
    <VCol cols="12">
      <h5 class="text-h5 mb-1">Danh sách vai trò</h5>
      <p class="text-body-1 mb-0">
        Vai trò giúp bạn quản lý quyền hạn của người dùng trong hệ thống.
      </p>
    </VCol>

    <!-- 👉 Roles Cards -->
    <VCol cols="12">
      <RoleCards />
    </VCol>

    <VCol cols="12">
      <h5 class="text-h5 mt-6">Tất cả người dùng và vai trò của họ</h5>
      <!-- <p class="text-body-1 mb-6">
        Find all of your company's administrator accounts and their associate
        roles.
      </p> -->

      <!-- 👉 User List  -->
      <UserList />
    </VCol>
  </VRow>
</template>

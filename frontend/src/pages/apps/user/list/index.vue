<script setup lang="ts">
import AddNewUserDrawer from "@/views/apps/user/list/AddNewUserDrawer.vue";
import type { UserProperties } from "@db/apps/users/types";

// 👉 Store
const searchQuery = ref("");
const selectedRole = ref();
const selectedPlan = ref();
const selectedStatus = ref();

// Các tuỳ chọn bảng dữ liệu
const itemsPerPage = ref(10);
const page = ref(1);
const sortBy = ref();
const orderBy = ref();

// Cập nhật các tuỳ chọn bảng dữ liệu
const updateOptions = (options: any) => {
  page.value = options.page;
  sortBy.value = options.sortBy[0]?.key;
  orderBy.value = options.sortBy[0]?.order;
};

// Tiêu đề
const headers = [
  { title: "Người dùng", key: "user" },
  { title: "Email", key: "email" },
  { title: "Vai trò", key: "role" },
  { title: "Trạng thái", key: "status" },
  { title: "Hành động", key: "actions", sortable: false },
];

// 👉 Lấy danh sách người dùng
const { data: usersData, execute: fetchUsers } = await useApi<any>(
  createUrl("/apps/users", {
    query: {
      q: searchQuery,
      status: selectedStatus,
      plan: selectedPlan,
      role: selectedRole,
      itemsPerPage,
      page,
      sortBy,
      orderBy,
    },
  })
);

const users = computed((): UserProperties[] => usersData.value.users);
const totalUsers = computed(() => usersData.value.totalUsers);

// 👉 Bộ lọc tìm kiếm
const roles = [
  { title: "Quản trị viên", value: "admin" },
  { title: "Tác giả", value: "author" },
  { title: "Biên tập viên", value: "editor" },
  { title: "Người duy trì", value: "maintainer" },
  { title: "Người đăng ký", value: "subscriber" },
];

const plans = [
  { title: "Cơ bản", value: "basic" },
  { title: "Công ty", value: "company" },
  { title: "Doanh nghiệp", value: "enterprise" },
  { title: "Nhóm", value: "team" },
];

const status = [
  { title: "Chờ xử lý", value: "pending" },
  { title: "Hoạt động", value: "active" },
  { title: "Không hoạt động", value: "inactive" },
];

const resolveUserRoleVariant = (role: string) => {
  const roleLowerCase = role.toLowerCase();

  if (roleLowerCase === "subscriber")
    return { color: "success", icon: "ri-user-line" };
  if (roleLowerCase === "author")
    return { color: "error", icon: "ri-computer-line" };
  if (roleLowerCase === "maintainer")
    return { color: "info", icon: "ri-pie-chart-line" };
  if (roleLowerCase === "editor")
    return { color: "warning", icon: "ri-edit-box-line" };
  if (roleLowerCase === "admin")
    return { color: "primary", icon: "ri-vip-crown-line" };

  return { color: "success", icon: "ri-user-line" };
};

const resolveUserStatusVariant = (stat: string) => {
  const statLowerCase = stat.toLowerCase();
  if (statLowerCase === "pending") return "warning";
  if (statLowerCase === "active") return "success";
  if (statLowerCase === "inactive") return "secondary";

  return "primary";
};

const isAddNewUserDrawerVisible = ref(false);

// 👉 Thêm người dùng mới
const addNewUser = async (userData: UserProperties) => {
  // userListStore.addUser(userData)
  await $api("/apps/users", {
    method: "POST",
    body: userData,
  });

  // Lấy lại danh sách người dùng
  fetchUsers();
};

// 👉 Xoá người dùng
const deleteUser = async (id: number) => {
  await $api(`/apps/users/${id}`, {
    method: "DELETE",
  });

  // Lấy lại danh sách người dùng
  // TODO: Làm điều này không đồng bộ
  fetchUsers();
};

const widgetData = ref([
  {
    title: "Phiên",
    value: "21,459",
    change: 29,
    desc: "Tổng người dùng",
    icon: "ri-group-line",
    iconColor: "primary",
  },
  {
    title: "Trả phí",
    value: "4,567",
    change: 18,
    desc: "Phân tích tuần trước",
    icon: "ri-user-add-line",
    iconColor: "error",
  },
  {
    title: "Đang hoạt động",
    value: "19,860",
    change: -14,
    desc: "Phân tích tuần trước",
    icon: "ri-user-follow-line",
    iconColor: "success",
  },
  {
    title: "Chờ xử lý",
    value: "237",
    change: 42,
    desc: "Phân tích tuần trước",
    icon: "ri-user-search-line",
    iconColor: "warning",
  },
]);
</script>

<template>
  <section>
    <!-- 👉 Tiện ích -->
    <div class="d-flex mb-6">
      <VRow>
        <template v-for="(data, id) in widgetData" :key="id">
          <VCol cols="12" md="3" sm="6">
            <VCard>
              <VCardText>
                <div class="d-flex justify-space-between">
                  <div class="d-flex flex-column gap-y-1">
                    <span class="text-base text-high-emphasis">{{
                      data.title
                    }}</span>
                    <h4 class="text-h4 d-flex align-center gap-2">
                      {{ data.value }}
                      <span
                        class="text-base font-weight-regular"
                        :class="data.change > 0 ? 'text-success' : 'text-error'"
                        >({{ prefixWithPlus(data.change) }}%)</span
                      >
                    </h4>

                    <p class="text-sm mb-0">
                      {{ data.desc }}
                    </p>
                  </div>
                  <VAvatar
                    :color="data.iconColor"
                    variant="tonal"
                    rounded
                    size="42"
                  >
                    <VIcon :icon="data.icon" size="26" />
                  </VAvatar>
                </div>
              </VCardText>
            </VCard>
          </VCol>
        </template>
      </VRow>
    </div>

    <VCard title="Bộ lọc" class="mb-6">
      <VCardText>
        <VRow>
          <!-- 👉 Chọn Vai trò -->
          <VCol cols="12" sm="4">
            <VSelect
              v-model="selectedRole"
              label="Chọn Vai trò"
              placeholder="Chọn Vai trò"
              :items="roles"
              clearable
              clear-icon="ri-close-line"
            />
          </VCol>
          <!-- 👉 Chọn Gói dịch vụ -->
          <VCol cols="12" sm="4">
            <VSelect
              v-model="selectedPlan"
              label="Chọn Gói dịch vụ"
              placeholder="Chọn Gói dịch vụ"
              :items="plans"
              clearable
              clear-icon="ri-close-line"
            />
          </VCol>
          <!-- 👉 Chọn Trạng thái -->
          <VCol cols="12" sm="4">
            <VSelect
              v-model="selectedStatus"
              label="Chọn Trạng thái"
              placeholder="Chọn Trạng thái"
              :items="status"
              clearable
              clear-icon="ri-close-line"
            />
          </VCol>
        </VRow>
      </VCardText>

      <VDivider />

      <VCardText class="d-flex flex-wrap gap-4">
        <!-- 👉 Nút xuất dữ liệu -->
        <VBtn
          variant="outlined"
          color="secondary"
          prepend-icon="ri-upload-2-line"
        >
          Xuất file
        </VBtn>
        <VSpacer />
        <div class="app-user-search-filter d-flex align-center">
          <!-- 👉 Tìm kiếm  -->
          <VTextField
            v-model="searchQuery"
            placeholder="Tìm kiếm"
            density="compact"
            class="me-4"
          />
          <!-- 👉 Nút thêm người dùng -->
          <VBtn @click="isAddNewUserDrawerVisible = true"> Thêm mới </VBtn>
        </div>
      </VCardText>

      <!-- SECTION bảng dữ liệu -->
      <VDataTableServer
        v-model:items-per-page="itemsPerPage"
        v-model:page="page"
        :items="users"
        item-value="id"
        :items-length="totalUsers"
        :headers="headers"
        show-select
        class="text-no-wrap rounded-0"
        @update:options="updateOptions"
      >
        <!-- Người dùng -->
        <template #item.user="{ item }">
          <div class="d-flex align-center">
            <VAvatar
              size="34"
              :variant="!item.avatar ? 'tonal' : undefined"
              :color="
                !item.avatar
                  ? resolveUserRoleVariant(item.role).color
                  : undefined
              "
              class="me-3"
            >
              <VImg v-if="item.avatar" :src="item.avatar" />
              <span v-else>{{ avatarText(item.fullName) }}</span>
            </VAvatar>

            <div class="d-flex flex-column">
              <RouterLink
                :to="{ name: 'apps-user-view-id', params: { id: item.id } }"
                class="text-h6 font-weight-medium user-list-name"
              >
                {{ item.fullName }}
              </RouterLink>

              <span class="text-sm text-medium-emphasis"
                >@{{ item.username }}</span
              >
            </div>
          </div>
        </template>
        <!-- Vai trò -->
        <template #item.role="{ item }">
          <div class="d-flex gap-4">
            <VIcon
              :icon="resolveUserRoleVariant(item.role).icon"
              :color="resolveUserRoleVariant(item.role).color"
            />
            <span class="text-capitalize text-high-emphasis">{{
              item.role
            }}</span>
          </div>
        </template>
        <!-- Gói dịch vụ -->
        <template #item.plan="{ item }">
          <span class="text-capitalize text-high-emphasis">{{
            item.currentPlan
          }}</span>
        </template>
        <!-- Trạng thái -->
        <template #item.status="{ item }">
          <VChip
            :color="resolveUserStatusVariant(item.status)"
            size="small"
            class="text-capitalize"
          >
            {{ item.status }}
          </VChip>
        </template>

        <!-- Hành động -->
        <template #item.actions="{ item }">
          <IconBtn size="small" @click="deleteUser(item.id)">
            <VIcon icon="ri-delete-bin-7-line" />
          </IconBtn>

          <IconBtn
            size="small"
            :to="{ name: 'apps-user-view-id', params: { id: item.id } }"
          >
            <VIcon icon="ri-eye-line" />
          </IconBtn>

          <IconBtn size="small" color="medium-emphasis">
            <VIcon size="24" icon="ri-more-2-line" />

            <VMenu activator="parent">
              <VList>
                <VListItem link>
                  <template #prepend>
                    <VIcon icon="ri-download-line" />
                  </template>
                  <VListItemTitle>Tải xuống</VListItemTitle>
                </VListItem>
                <VListItem link>
                  <template #prepend>
                    <VIcon icon="ri-edit-box-line" />
                  </template>
                  <VListItemTitle>Chỉnh sửa</VListItemTitle>
                </VListItem>
              </VList>
            </VMenu>
          </IconBtn>
        </template>

        <!-- Phân trang -->
        <template #bottom>
          <VDivider />

          <div class="d-flex justify-end flex-wrap gap-x-6 px-2 py-1">
            <div
              class="d-flex align-center gap-x-2 text-medium-emphasis text-base"
            >
              Số hàng mỗi trang:
              <VSelect
                v-model="itemsPerPage"
                class="per-page-select"
                variant="plain"
                :items="[10, 20, 25, 50, 100]"
              />
            </div>

            <p
              class="d-flex align-center text-base text-high-emphasis me-2 mb-0"
            >
              {{ paginationMeta({ page, itemsPerPage }, totalUsers) }}
            </p>

            <div class="d-flex gap-x-2 align-center me-2">
              <VBtn
                class="flip-in-rtl"
                icon="ri-arrow-left-s-line"
                variant="text"
                density="comfortable"
                color="high-emphasis"
                :disabled="page <= 1"
                @click="page <= 1 ? (page = 1) : page--"
              />

              <VBtn
                class="flip-in-rtl"
                icon="ri-arrow-right-s-line"
                density="comfortable"
                variant="text"
                color="high-emphasis"
                :disabled="page >= Math.ceil(totalUsers / itemsPerPage)"
                @click="
                  page >= Math.ceil(totalUsers / itemsPerPage)
                    ? (page = Math.ceil(totalUsers / itemsPerPage))
                    : page++
                "
              />
            </div>
          </div>
        </template>
      </VDataTableServer>
      <!-- SECTION -->
    </VCard>
    <!-- 👉 Thêm Người dùng mới -->
    <AddNewUserDrawer
      v-model:isDrawerOpen="isAddNewUserDrawerVisible"
      @user-data="addNewUser"
    />
  </section>
</template>

<style lang="scss">
.app-user-search-filter {
  inline-size: 24.0625rem;
}

.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>

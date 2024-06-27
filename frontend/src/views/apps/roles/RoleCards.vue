<script setup lang="ts">
import avatar1 from "@images/avatars/avatar-1.png";
import avatar10 from "@images/avatars/avatar-10.png";
import avatar2 from "@images/avatars/avatar-2.png";
import avatar3 from "@images/avatars/avatar-3.png";
import avatar4 from "@images/avatars/avatar-4.png";
import avatar5 from "@images/avatars/avatar-5.png";
import avatar6 from "@images/avatars/avatar-6.png";
import avatar7 from "@images/avatars/avatar-7.png";
import avatar8 from "@images/avatars/avatar-8.png";
import avatar9 from "@images/avatars/avatar-9.png";
import poseM from "@images/pages/pose_m1.png";

interface Permission {
  name: string;
  read: boolean;
  write: boolean;
  create: boolean;
}

interface RoleDetails {
  name: string;
  permissions: Permission[];
}

interface Roles {
  role: string;
  users: string[];
  details: RoleDetails;
}

// 👉 Danh sách Vai trò
const roles = ref<Roles[]>([
  {
    role: "Quản trị viên",
    users: [avatar1, avatar2, avatar3, avatar4],
    details: {
      name: "Quản trị viên",
      permissions: [
        {
          name: "Quản lý người dùng",
          read: true,
          write: true,
          create: true,
        },
        {
          name: "Quản lý tranh chấp",
          read: true,
          write: true,
          create: true,
        },
        {
          name: "Quản lý API",
          read: true,
          write: true,
          create: true,
        },
      ],
    },
  },
  {
    role: "Quản lý",
    users: [avatar1, avatar2, avatar3, avatar4, avatar5, avatar6, avatar7],
    details: {
      name: "Quản lý",
      permissions: [
        {
          name: "Báo cáo",
          read: true,
          write: true,
          create: false,
        },
        {
          name: "Bảng lương",
          read: true,
          write: true,
          create: true,
        },
        {
          name: "Quản lý người dùng",
          read: true,
          write: true,
          create: true,
        },
      ],
    },
  },
  {
    role: "Người dùng",
    users: [avatar1, avatar2, avatar3, avatar4, avatar5],
    details: {
      name: "Người dùng",
      permissions: [
        {
          name: "Quản lý người dùng",
          read: true,
          write: false,
          create: false,
        },
        {
          name: "Quản lý nội dung",
          read: true,
          write: false,
          create: false,
        },
        {
          name: "Quản lý tranh chấp",
          read: true,
          write: false,
          create: false,
        },
        {
          name: "Quản lý cơ sở dữ liệu",
          read: true,
          write: false,
          create: false,
        },
      ],
    },
  },
  {
    role: "Hỗ trợ",
    users: [avatar1, avatar2, avatar3, avatar4, avatar5, avatar6],
    details: {
      name: "Hỗ trợ",
      permissions: [
        {
          name: "Quản lý kho lưu trữ",
          read: true,
          write: true,
          create: false,
        },
        {
          name: "Quản lý nội dung",
          read: true,
          write: true,
          create: false,
        },
        {
          name: "Quản lý cơ sở dữ liệu",
          read: true,
          write: true,
          create: false,
        },
      ],
    },
  },
  {
    role: "Người dùng bị hạn chế",
    users: [
      avatar1,
      avatar2,
      avatar3,
      avatar4,
      avatar5,
      avatar6,
      avatar7,
      avatar8,
      avatar9,
      avatar10,
    ],
    details: {
      name: "Người dùng bị hạn chế",
      permissions: [
        {
          name: "Quản lý người dùng",
          read: true,
          write: false,
          create: false,
        },
        {
          name: "Quản lý nội dung",
          read: true,
          write: false,
          create: false,
        },
        {
          name: "Quản lý tranh chấp",
          read: true,
          write: false,
          create: false,
        },
        {
          name: "Quản lý cơ sở dữ liệu",
          read: true,
          write: false,
          create: false,
        },
      ],
    },
  },
]);

const isRoleDialogVisible = ref(false);

const roleDetail = ref<RoleDetails>();

const isAddRoleDialogVisible = ref(false);

const editPermission = (value: RoleDetails) => {
  isRoleDialogVisible.value = true;
  roleDetail.value = value;
};
</script>

<template>
  <VRow>
    <!-- 👉 Vai trò -->
    <VCol v-for="item in roles" :key="item.role" cols="12" sm="6" lg="4">
      <VCard>
        <VCardText class="d-flex align-center">
          <span>Tổng cộng {{ item.users.length }} người dùng</span>

          <VSpacer />

          <div class="v-avatar-group">
            <template v-for="(user, index) in item.users" :key="user">
              <VAvatar
                v-if="
                  item.users.length > 4 && item.users.length !== 4 && index < 3
                "
                size="40"
                :image="user"
              />

              <VAvatar v-if="item.users.length === 4" size="40" :image="user" />
            </template>
            <VAvatar
              v-if="item.users.length > 4"
              :color="$vuetify.theme.name === 'dark' ? '#3F3B59' : '#F0EFF0'"
            >
              <span class="text-high-emphasis">
                +{{ item.users.length - 3 }}
              </span>
            </VAvatar>
          </div>
        </VCardText>

        <VCardText>
          <h5 class="text-h5 mb-1">
            {{ item.role }}
          </h5>
          <div class="d-flex align-center">
            <a href="javascript:void(0)" @click="editPermission(item.details)">
              Chỉnh sửa vai trò
            </a>

            <VSpacer />

            <IconBtn color="secondary" class="mt-n2">
              <VIcon icon="ri-file-copy-line" />
            </IconBtn>
          </div>
        </VCardText>
      </VCard>
    </VCol>

    <!-- 👉 Thêm Vai trò mới -->
    <VCol cols="12" sm="6" lg="4">
      <VCard class="h-100" :ripple="false">
        <VRow no-gutters class="h-100">
          <VCol
            cols="5"
            class="d-flex flex-column justify-end align-center mt-5"
          >
            <img width="65" :src="poseM" />
          </VCol>

          <VCol cols="7">
            <VCardText class="d-flex flex-column align-end justify-end gap-4">
              <VBtn size="small" @click="isAddRoleDialogVisible = true">
                Thêm Vai trò
              </VBtn>
              <span class="text-end">Thêm vai trò nếu chưa tồn tại.</span>
            </VCardText>
          </VCol>
        </VRow>
      </VCard>
      <AddEditRoleDialog v-model:is-dialog-visible="isAddRoleDialogVisible" />
    </VCol>
  </VRow>

  <AddEditRoleDialog
    v-model:is-dialog-visible="isRoleDialogVisible"
    v-model:role-permissions="roleDetail"
  />
</template>

<script setup lang="ts">
interface Props {
  userData: {
    id: number;
    fullName: string;
    company: string;
    role: string;
    username: string;
    country: string;
    contact: string;
    email: string;
    currentPlan: string;
    status: string;
    avatar: string;
    taskDone: number;
    projectDone: number;
    taxId: string;
    language: string[];
  };
}

const props = defineProps<Props>();

const standardPlan = {
  plan: "Standard",
  price: 99,
  benefits: ["10 Users", "Up to 10GB storage", "Basic Support"],
};

const isUserInfoEditDialogVisible = ref(false);
const isUpgradePlanDialogVisible = ref(false);

// 👉 Status variant resolver
const resolveUserStatusVariant = (stat: string) => {
  if (stat === "pending") return "warning";
  if (stat === "active") return "success";
  if (stat === "inactive") return "secondary";

  return "primary";
};

// 👉 Role variant resolver
const resolveUserRoleVariant = (role: string) => {
  if (role === "subscriber") return { color: "primary", icon: "ri-user-line" };
  if (role === "author")
    return { color: "warning", icon: "ri-settings-2-line" };
  if (role === "maintainer")
    return { color: "success", icon: "ri-database-2-line" };
  if (role === "editor") return { color: "info", icon: "ri-pencil-line" };
  if (role === "admin") return { color: "error", icon: "ri-server-line" };

  return { color: "primary", icon: "ri-user-line" };
};
</script>

<template>
  <VRow>
    <!-- SECTION User Details -->
    <VCol cols="12">
      <VCard v-if="props.userData">
        <VCardText class="text-center pt-12 pb-6">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded
            :size="120"
            :color="!props.userData.avatar ? 'primary' : undefined"
            :variant="!props.userData.avatar ? 'tonal' : undefined"
          >
            <VImg v-if="props.userData.avatar" :src="props.userData.avatar" />
            <span v-else class="text-5xl font-weight-medium">
              {{ avatarText(props.userData.fullName) }}
            </span>
          </VAvatar>

          <!-- 👉 User fullName -->
          <h5 class="text-h5 mt-4">
            {{ props.userData.fullName }}
          </h5>

          <!-- 👉 Role chip -->
          <VChip
            :color="resolveUserRoleVariant(props.userData.role).color"
            size="small"
            class="text-capitalize mt-4"
          >
            {{ props.userData.role }}
          </VChip>
        </VCardText>

        <VCardText class="d-flex justify-center flex-wrap gap-6 pb-6">
          <!-- 👉 Done task -->
          <div class="d-flex align-center me-8">
            <VAvatar
              :size="40"
              rounded
              color="primary"
              variant="tonal"
              class="me-4"
            >
              <VIcon size="24" icon="ri-check-line" />
            </VAvatar>

            <div>
              <h6 class="text-h5">
                {{ kFormatter(props.userData.taskDone) }}
              </h6>
              <span>Đơn hàng </span>
            </div>
          </div>

          <!-- 👉 Done Project -->
          <div class="d-flex align-center me-4">
            <VAvatar
              :size="44"
              rounded
              color="primary"
              variant="tonal"
              class="me-3"
            >
              <VIcon size="24" icon="ri-briefcase-4-line" />
            </VAvatar>

            <div>
              <h6 class="text-h6">
                {{ kFormatter(props.userData.projectDone) }}
              </h6>
              <span>Giới thiệu</span>
            </div>
          </div>
        </VCardText>

        <!-- 👉 Details -->
        <VCardText class="pb-6">
          <h5 class="text-h5">Chi tiết</h5>

          <VDivider class="my-4" />

          <!-- 👉 User Details list -->
          <VList class="card-list">
            <VListItem>
              <VListItemTitle class="text-sm">
                <span class="font-weight-medium">Tên:</span>
                <span class="text-body-1">
                  @{{ props.userData.username }}
                </span>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle class="text-sm">
                <span class="font-weight-medium"> Email: </span>
                <span class="text-body-1">{{ props.userData.email }}</span>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle class="text-sm">
                <span class="font-weight-medium"> Trạng thái: </span>
                <VChip
                  size="small"
                  :color="resolveUserStatusVariant(props.userData.status)"
                  class="text-capitalize"
                >
                  {{ props.userData.status }}
                </VChip>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle class="text-sm">
                <span class="font-weight-medium">Vai trò: </span>
                <span class="text-capitalize text-body-1">{{
                  props.userData.role
                }}</span>
              </VListItemTitle>
            </VListItem>
            <!--
            <VListItem>
              <VListItemTitle class="text-sm">
                <span class="font-weight-medium"> Tax ID: </span>
                <span class="text-body-1">
                  {{ props.userData.taxId }}
                </span>
              </VListItemTitle>
            </VListItem>
            -->

            <VListItem>
              <VListItemTitle class="text-sm">
                <span class="font-weight-medium"> Liên hệ: </span>
                <span class="text-body-1">{{ props.userData.contact }}</span>
              </VListItemTitle>
            </VListItem>

            <!--
            <VListItem>
              <VListItemTitle class="text-sm">
                <span class="font-weight-medium"> Language: </span>
                <span class="text-body-1">{{ props.userData.language }}</span>
              </VListItemTitle>
            </VListItem>
            -->

            <!--
            <VListItem>
              <VListItemTitle class="text-sm">
                <span class="font-weight-medium"> Country: </span>
                <span class="text-body-1">{{ props.userData.country }}</span>
              </VListItemTitle>
            </VListItem>
            -->
          </VList>
        </VCardText>

        <!-- 👉 Edit and Suspend button -->
        <VCardText class="d-flex justify-center">
          <VBtn
            variant="elevated"
            class="me-4"
            @click="isUserInfoEditDialogVisible = true"
          >
            Sửa
          </VBtn>
          <VBtn variant="outlined" color="error"> Tạm ngưng </VBtn>
        </VCardText>
      </VCard>
    </VCol>
    <!-- !SECTION -->

    <!-- SECTION Current Plan -->

    <!-- !SECTION -->
  </VRow>

  <!-- 👉 Edit user info dialog -->
  <UserInfoEditDialog
    v-model:isDialogVisible="isUserInfoEditDialogVisible"
    :user-data="props.userData"
  />

  <!-- 👉 Upgrade plan dialog -->
  <UserUpgradePlanDialog v-model:isDialogVisible="isUpgradePlanDialogVisible" />
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 0.5rem;
}

.current-plan {
  border: 2px solid rgb(var(--v-theme-primary));
}

.text-capitalize {
  text-transform: capitalize !important;
}
</style>

<script setup lang="ts">
import type { Customer } from "@db/apps/ecommerce/types";

const props = defineProps<Props>();
const isUserInfoEditDialogVisible = ref(false);
const isUpgradePlanDialogVisible = ref(false);
interface Props {
  customerData: Customer;
}
</script>

<template>
  <VRow>
    <!-- SECTION Customer Details -->
    <VCol cols="12">
      <VCard v-if="props.customerData">
        <VCardText class="text-center pt-15">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded
            :size="120"
            :color="!props.customerData.customer ? 'primary' : undefined"
            :variant="!props.customerData.avatar ? 'tonal' : undefined"
          >
            <VImg
              v-if="props.customerData.avatar"
              :src="props.customerData.avatar"
            />
            <span v-else class="text-5xl font-weight-medium">
              Người dùng không có ảnh
            </span>
          </VAvatar>

          <!-- 👉 Customer fullName -->
          <h6 class="text-h5 mt-4">
            {{ props.customerData.customer }}
          </h6>
          <p class="text-body-1 mb-0">
            Mã khách hàngs #{{ props.customerData.customerId }}
          </p>

          <div class="d-flex justify-space-evenly gap-x-12 mt-6">
            <div class="d-flex align-center">
              <VAvatar variant="tonal" color="primary" rounded class="me-4">
                <VIcon icon="ri-shopping-cart-line" />
              </VAvatar>
              <div class="d-flex flex-column align-start">
                <h5 class="text-h5">
                  {{ props.customerData.order }}
                </h5>
                <span class="text-body-1">Đơn hàng</span>
              </div>
            </div>
            <div class="d-flex align-center">
              <VAvatar variant="tonal" color="primary" rounded class="me-4">
                <VIcon icon="ri-money-dollar-circle-line" />
              </VAvatar>
              <div class="d-flex flex-column align-start">
                <h5 class="text-h5">
                  {{ Math.round(props.customerData.totalSpent) }}
                </h5>
                <span class="text-body-1">Đã tiêu</span>
              </div>
            </div>
          </div>
        </VCardText>

        <!-- 👉 Customer Details -->
        <VCardText>
          <h5 class="text-h5">Details</h5>
          <VDivider class="my-4" />

          <VList class="card-list mt-2">
            <VListItem>
              <VListItemTitle>
                <span class="font-weight-medium me-2">Tên:</span>
                <span class="text-body-1">
                  {{ props.customerData.customer }}
                </span>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <span class="font-weight-medium me-2">Email:</span>
                <span class="text-body-1">
                  {{ props.customerData.email }}
                </span>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <span class="font-weight-medium me-2">Trạng thái:</span>
                <span class="text-body-1">
                  {{ props.customerData.status }}
                </span>
              </VListItemTitle>
            </VListItem>

            <VListItem>
              <VListItemTitle>
                <span class="font-weight-medium me-2">Contact:</span>
                <span class="text-body-1">
                  {{ props.customerData.contact }}
                </span>
              </VListItemTitle>
            </VListItem>
            <!-- 
            <VListItem>
              <VListItemTitle>
                <span class="font-weight-medium me-2">Country:</span>
                <span class="text-body-1">
                  {{ props.customerData.country }}
                </span>
              </VListItemTitle>
            </VListItem> -->
          </VList>

          <div class="mt-6 text-center">
            <VBtn
              block
              @click="
                isUserInfoEditDialogVisible = !isUserInfoEditDialogVisible
              "
            >
              Sửa thông tin
            </VBtn>
          </div>
        </VCardText>
      </VCard>
    </VCol>
    <!-- !SECTION -->

    <!-- SECTION  Upgrade to Premium -->
    <!-- <VCol cols="12">
      <VCard
        flat
        class="current-plan"
        color="primary"
      >
        <VCardText>
          <div class="d-flex align-center">
            <div>
              <h5 class="text-h5 text-white mb-4">
                Upgrade to premium
              </h5>
              <p class="mb-6 text-wrap">
                Upgrade customer to premium membership to access pro features.
              </p>
            </div>
            <div>
              <VImg
                :src="rocketImg"
                height="108"
                width="108"
              />
            </div>
          </div>
          <VBtn
            color="#fff"
            class="text-primary"
            block
            @click="isUpgradePlanDialogVisible = !isUpgradePlanDialogVisible"
          >
            Upgrade to Premium
          </VBtn>
        </VCardText>
      </VCard>
    </VCol> -->
    <!-- !SECTION -->
  </VRow>
  <UserInfoEditDialog v-model:isDialogVisible="isUserInfoEditDialogVisible" />
  <UserUpgradePlanDialog v-model:isDialogVisible="isUpgradePlanDialogVisible" />
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 0.5rem;
}
</style>

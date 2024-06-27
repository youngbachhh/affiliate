<script setup lang="ts">
import type { CheckoutData } from "./types";

interface Props {
  currentStep?: number;
  checkoutData: CheckoutData;
}
interface Emit {
  (e: "update:currentStep", value: number): void;
  (e: "update:checkout-data", value: CheckoutData): void;
}
const props = defineProps<Props>();

const emit = defineEmits<Emit>();

const checkoutAddressDataLocal = ref(props.checkoutData);
const isEditAddressDialogVisible = ref(false);

const deliveryOptions = [
  {
    icon: "ri-user-line",
    title: "Giao hàng tiêu chuẩn",
    desc: "Sản phẩm sẽ được giao trong vòng 1 tuần.",
    value: "free",
  },
  {
    icon: "ri-star-smile-line",
    title: "Giao hàng nhanh",
    desc: "Sản phẩm sẽ được giao trong 3-4 ngày.",
    value: "express",
  },
  // {
  //   icon: 'ri-vip-crown-line',
  //   title: 'Overnight',
  //   desc: 'Get your product in 1 day.',
  //   value: 'overnight',
  // },
];

const resolveAddressBadgeColor: any = {
  home: "primary",
  office: "success",
};

const resolveDeliveryBadgeData: any = {
  free: { color: "success", price: "Free" },
  express: { color: "secondary", price: 10 },
  overnight: { color: "secondary", price: 15 },
};

const totalPriceWithDeliveryCharges = computed(() => {
  checkoutAddressDataLocal.value.deliveryCharges = 0;
  if (checkoutAddressDataLocal.value.deliverySpeed !== "free")
    checkoutAddressDataLocal.value.deliveryCharges =
      resolveDeliveryBadgeData[
        checkoutAddressDataLocal.value.deliverySpeed
      ].price;

  return (
    checkoutAddressDataLocal.value.orderAmount +
    checkoutAddressDataLocal.value.deliveryCharges
  );
});

const updateAddressData = () => {
  emit("update:checkout-data", checkoutAddressDataLocal.value);
};

const nextStep = () => {
  updateAddressData();
  emit("update:currentStep", props.currentStep ? props.currentStep + 1 : 1);
};

watch(() => props.currentStep, updateAddressData);
</script>

<template>
  <VRow>
    <VCol cols="12" md="8">
      <!-- 👉 Address options -->
      <div class="text-body-1 text-high-emphasis font-weight-medium mb-4">
        Chọn địa chỉ nhận hàng
      </div>

      <!-- 👉 Address custom input -->
      <CustomRadios
        v-model:selected-radio="checkoutAddressDataLocal.deliveryAddress"
        :radio-content="checkoutAddressDataLocal.addresses"
        :grid-column="{ cols: '12', sm: '6' }"
      >
        <template #default="{ item }">
          <div class="w-100">
            <div class="d-flex justify-space-between mb-4">
              <div class="text-body-1 text-high-emphasis">
                {{ item.title }}
              </div>

              <VChip
                :color="resolveAddressBadgeColor[item.value]"
                size="small"
                class="text-capitalize"
              >
                {{ item.value }}
              </VChip>
            </div>

            <p class="text-body-2 mb-0">
              {{ item.desc }}
            </p>
            <p class="text-body-2 mb-0">Số điện thoại: {{ item.subtitle }}</p>
            <p class="text-body-2 mb-3">Cash/Card on delivery available</p>

            <VDivider class="pb-2" />

            <div class="d-flex gap-x-4 py-2">
              <a href="javascript:void(0)" class="text-base">Sửa</a>
              <a href="javascript:void(0)" class="text-base">Xóa</a>
            </div>
          </div>
        </template>
      </CustomRadios>

      <!-- 👉 Add New Address -->
      <VBtn
        variant="outlined"
        class="mt-4 mb-6"
        size="small"
        @click="isEditAddressDialogVisible = !isEditAddressDialogVisible"
      >
        Thêm địa chỉ mới
      </VBtn>

      <!-- 👉 Delivery options -->
      <div class="text-body-1 text-high-emphasis font-weight-medium mb-4">
        Chọn phương thức giao hàng
      </div>

      <!-- 👉 Delivery options custom input -->
      <CustomRadiosWithIcon
        v-model:selected-radio="checkoutAddressDataLocal.deliverySpeed"
        :radio-content="deliveryOptions"
        :grid-column="{ cols: '12', sm: '4' }"
      >
        <template #default="{ item }">
          <div class="d-flex flex-column align-center gap-2 w-100">
            <div class="d-flex justify-end w-100 mb-n3">
              <VChip
                :color="resolveDeliveryBadgeData[item.value].color"
                size="small"
              >
                {{
                  resolveDeliveryBadgeData[item.value].price === "Free"
                    ? resolveDeliveryBadgeData[item.value].price
                    : `$${resolveDeliveryBadgeData[item.value].price}`
                }}
              </VChip>
            </div>

            <VIcon size="28" :icon="item.icon" class="text-high-emphasis" />

            <h6 class="text-h6">
              {{ item.title }}
            </h6>
            <p class="text-body-2 mb-0">
              {{ item.desc }}
            </p>
          </div>
        </template>
      </CustomRadiosWithIcon>
    </VCol>

    <VCol cols="12" md="4">
      <VCard flat variant="outlined">
        <!-- 👉 Delivery estimate date -->
        <VCardText>
          <h6 class="text-h6 mb-4">Dự kiến ​​giao hàng</h6>

          <VList class="card-list">
            <VListItem
              v-for="product in checkoutAddressDataLocal.cartItems"
              :key="product.name"
            >
              <template #prepend>
                <VImg
                  width="54"
                  height="70"
                  :src="product.image"
                  class="me-2"
                />
              </template>

              <div class="text-body-1">
                {{ product.name }}
              </div>
              <div class="text-body-1 font-weight-medium">
                {{ product.estimatedDelivery }}
              </div>
            </VListItem>
          </VList>
        </VCardText>

        <VDivider />

        <!-- 👉 Price details -->
        <VCardText>
          <h6 class="text-h6 mb-4">Chi tiết giá</h6>

          <div class="d-flex align-center justify-space-between text-sm mb-2">
            <div class="text-high-emphasis text-body-1">Tổng đơn hàng</div>
            <div class="text-body-1">
              ${{ checkoutAddressDataLocal.orderAmount }}
            </div>
          </div>

          <div class="d-flex justify-space-between">
            <div class="text-body-1 text-high-emphasis">Phí giao hàng</div>

            <div class="d-flex gap-x-2">
              <div class="text-body-1 text-disabled">$5.00</div>
              <VChip size="small" color="success"> Free </VChip>
            </div>
          </div>
        </VCardText>

        <VDivider />

        <VCardText
          class="d-flex align-center justify-space-between text-high-emphasis"
        >
          <span class="text-base font-weight-medium">Tổng tiền</span>
          <span class="text-base font-weight-medium">
            ${{ totalPriceWithDeliveryCharges }}
          </span>
        </VCardText>
      </VCard>

      <VBtn block class="mt-4" @click="nextStep"> Đặt hàng </VBtn>
    </VCol>
  </VRow>
  <AddEditAddressDialog v-model:isDialogVisible="isEditAddressDialogVisible" />
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 16px;
}
</style>

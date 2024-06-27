<script setup lang="ts">
import type { CheckoutData } from "./types";

const props = defineProps<{
  currentStep?: number;
  checkoutData: CheckoutData;
}>();

defineEmits<{
  (e: "update:currentStep", value: number): void;
  (e: "update:checkout-data", value: CheckoutData): void;
}>();

const selectedDeliveryAddress = computed(() => {
  return props.checkoutData.addresses.filter((address) => {
    return address.value === props.checkoutData.deliveryAddress;
  });
});

const resolveDeliveryMethod = computed(() => {
  if (props.checkoutData.deliverySpeed === "overnight")
    return { method: "Giao hàng qua đêm", desc: "Trong vòng 1 ngày làm việc." };
  else if (props.checkoutData.deliverySpeed === "express")
    return {
      method: "Giao hàng nhanh",
      desc: "Thông thường trong 3-4 ngày làm việc",
    };
  else
    return {
      method: "Giao hàng tiêu chuẩn",
      desc: "Thông thường trong 1 tuần",
    };
});
</script>

<template>
  <section class="text-base">
    <div class="text-center">
      <h4 class="text-h4 mb-3">Cảm ơn bạn! 😇</h4>
      <p class="text-body-1">
        Đơn hàng của bạn
        <span class="text-high-emphasis font-weight-medium">#1536548131</span>
        đã được đặt!
      </p>
      <p class="mb-0">
        Chúng tôi đã gửi một email tới
        <span class="text-high-emphasis font-weight-medium"
          >john.doe@example.com</span
        >
        với xác nhận đơn hàng và biên lai của bạn.
      </p>
      <p>
        Nếu email không đến trong vòng hai phút, vui lòng kiểm tra thư mục spam
        để xem email có bị chuyển vào đó không.
      </p>
      <div class="d-flex align-center gap-2 justify-center">
        <VIcon size="20" icon="ri-time-line" />
        <span>Thời gian đặt: 25/05/2020 13:35</span>
      </div>
    </div>

    <VRow class="border rounded ma-0 mt-5">
      <VCol
        cols="12"
        md="4"
        class="pa-5"
        :class="$vuetify.display.mdAndUp ? 'border-e' : 'border-b'"
      >
        <div class="d-flex align-center gap-2 text-high-emphasis mb-4">
          <VIcon icon="ri-map-pin-line" size="20" />
          <div class="text-h6">Vận chuyển</div>
        </div>

        <template v-for="item in selectedDeliveryAddress" :key="item.value">
          <p class="mb-0">
            {{ item.title }}
          </p>
          <p>
            {{ item.desc }}
          </p>

          <h6 class="text-h6 text-medium-emphasis">+{{ item.subtitle }}</h6>
        </template>
      </VCol>

      <VCol
        cols="12"
        md="4"
        class="pa-5"
        :class="$vuetify.display.mdAndUp ? 'border-e' : 'border-b'"
      >
        <div class="d-flex align-center gap-2 text-high-emphasis mb-4">
          <VIcon icon="ri-bank-card-line" size="20" />
          <span class="text-base font-weight-medium"> Địa chỉ thanh toán </span>
        </div>

        <template v-for="item in selectedDeliveryAddress" :key="item.value">
          <p class="mb-0">
            {{ item.title }}
          </p>
          <p>
            {{ item.desc }}
          </p>

          <h6 class="text-h6 text-medium-emphasis">+{{ item.subtitle }}</h6>
        </template>
      </VCol>

      <VCol cols="12" md="4" class="pa-5">
        <div class="d-flex align-center gap-2 text-high-emphasis mb-4">
          <VIcon icon="ri-ship-2-line" size="20" />
          <span class="text-base font-weight-medium">
            Phương thức vận chuyển
          </span>
        </div>

        <p class="font-weight-medium">Phương thức ưa thích:</p>
        <p class="mb-0">
          {{ resolveDeliveryMethod.method }}
        </p>
        <p class="mb-0">( {{ resolveDeliveryMethod.desc }} )</p>
      </VCol>
    </VRow>

    <VRow>
      <VCol cols="12" md="9">
        <!-- 👉 các mục trong giỏ hàng -->
        <div class="border rounded">
          <template
            v-for="(item, index) in props.checkoutData.cartItems"
            :key="item.name"
          >
            <div
              class="d-flex align-start gap-3 pa-5 position-relative flex-column flex-sm-row align-center"
              :class="index ? 'border-t' : ''"
            >
              <div>
                <VImg width="80" :src="item.image" />
              </div>

              <div
                class="d-flex w-100"
                :class="
                  $vuetify.display.width <= 700 ? 'flex-column' : 'flex-row'
                "
              >
                <div>
                  <h6 class="text-h6 mb-2">
                    {{ item.name }}
                  </h6>
                  <div
                    class="d-flex flex-column align-start text-no-wrap gap-2 text-base"
                  >
                    <div>
                      <span class="text-body-1 d-inline-block">Bán bởi:</span>
                      <span class="text-primary text-body-1 d-inline-block">{{
                        item.seller
                      }}</span>
                    </div>
                    <VChip
                      v-if="index !== props.checkoutData.cartItems.length - 1"
                      :color="item.inStock ? 'success' : 'error'"
                      size="small"
                    >
                      {{ item.inStock ? "Còn hàng" : "Hết hàng" }}
                    </VChip>
                  </div>
                </div>

                <VSpacer />

                <div
                  class="d-flex flex-column justify-center"
                  :class="
                    $vuetify.display.width <= 700 ? 'text-start' : 'text-end'
                  "
                >
                  <p class="text-base mb-0">
                    <span class="text-primary">${{ item.price }}</span>
                    <span>/</span>
                    <span class="text-disabled text-decoration-line-through"
                      >${{ item.discountPrice }}</span
                    >
                  </p>
                </div>
              </div>
            </div>
          </template>
        </div>
      </VCol>

      <VCol cols="12" md="3">
        <div class="border rounded">
          <div class="border-b pa-5">
            <h6 class="text-h6 mb-4">Chi tiết giá</h6>

            <div class="d-flex align-center justify-space-between text-sm mb-4">
              <div class="text-body-1 text-high-emphasis">Tổng đơn hàng</div>
              <div class="text-body-1">
                ${{ props.checkoutData.orderAmount }}.00
              </div>
            </div>

            <div class="d-flex align-center justify-space-between text-sm">
              <div class="text-body-1 text-high-emphasis">Phí giao hàng</div>
              <div
                v-if="props.checkoutData.deliverySpeed === 'free'"
                class="d-flex align-center"
              >
                <div class="me-2 text-body-1 text-disabled">$5.00</div>
                <VChip color="success" size="small"> Free </VChip>
              </div>
              <div v-else>
                <span>${{ props.checkoutData.deliveryCharges }}</span>
              </div>
            </div>
          </div>
          <div class="d-flex align-center justify-space-between text-h6 pa-5">
            <span>Tổng cộng</span>
            <span
              >${{
                props.checkoutData.orderAmount +
                props.checkoutData.deliveryCharges
              }}.00</span
            >
          </div>
        </div>
      </VCol>
    </VRow>
  </section>
</template>

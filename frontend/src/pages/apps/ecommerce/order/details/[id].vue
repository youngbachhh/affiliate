<script setup lang="ts">
import avatar1 from "@images/avatars/avatar-1.png";
import product21 from "@images/ecommerce-images/product-21.png";
import product22 from "@images/ecommerce-images/product-22.png";
import product23 from "@images/ecommerce-images/product-23.png";
import product24 from "@images/ecommerce-images/product-24.png";

const route = useRoute("apps-ecommerce-order-details-id");
const isConfirmDialogVisible = ref(false);
const isUserInfoEditDialogVisible = ref(false);
const isEditAddressDialogVisible = ref(false);

const headers = [
  { title: "Sản phẩm", key: "productName" },
  { title: "Giá", key: "price" },
  { title: "Số lượng", key: "quantity" },
  { title: "Tổng tiền", key: "total", sortable: false },
];

const orderData = [
  {
    productName: "OnePlus 7 Pro",
    productImage: product21,
    brand: "OnePlus",
    price: 799,
    quantity: 1,
  },
  {
    productName: "Magic Mouse",
    productImage: product22,
    brand: "Apple",
    price: 89,
    quantity: 1,
  },
  {
    productName: "Wooden Chair",
    productImage: product23,
    brand: "insofer",
    price: 289,
    quantity: 2,
  },
  {
    productName: "Air Jorden",
    productImage: product24,
    brand: "Nike",
    price: 299,
    quantity: 2,
  },
];
</script>

<template>
  <div>
    <div
      class="d-flex justify-space-between align-center flex-wrap gap-y-4 mb-6"
    >
      <div>
        <div class="d-flex gap-2 align-center mb-2 flex-wrap">
          <h5 class="text-h5">Đơn hàng #{{ route.params.id }}</h5>
          <div class="d-flex gap-x-2">
            <VChip variant="tonal" color="success" size="small">
              Đã thanh toán
            </VChip>
            <VChip variant="tonal" color="info" size="small">
              Sẵn Sàng Để Lấy
            </VChip>
          </div>
        </div>
        <div>
          <span class="text-body-1"> Aug 17, 2024, 5:48 (ET) </span>
        </div>
      </div>

      <VBtn
        variant="outlined"
        color="error"
        @click="isConfirmDialogVisible = !isConfirmDialogVisible"
      >
        Xóa đơn hàng
      </VBtn>
    </div>

    <VRow>
      <VCol cols="12" md="8">
        <!-- 👉 Order Details -->
        <VCard class="mb-6">
          <VCardItem>
            <template #title>
              <h5 class="text-h5">Chi tiết đơn hàng</h5>
            </template>
            <template #append>
              <span class="text-primary cursor-pointer">Sửa</span>
            </template>
          </VCardItem>

          <VDataTable
            :headers="headers"
            :items="orderData"
            item-value="productName"
            show-select
            class="text-no-wrap"
          >
            <template #item.productName="{ item }">
              <div class="d-flex gap-x-3">
                <VAvatar
                  size="34"
                  variant="tonal"
                  :image="item.productImage"
                  rounded
                />

                <div class="d-flex flex-column align-center">
                  <h6 class="text-h6">
                    {{ item.productName }}
                  </h6>

                  <span class="text-sm text-start align-self-start">
                    {{ item.brand }}
                  </span>
                </div>
              </div>
            </template>

            <template #item.price="{ item }">
              <span>${{ item.price }}</span>
            </template>

            <template #item.total="{ item }">
              <span> ${{ item.price * item.quantity }} </span>
            </template>

            <template #bottom />
          </VDataTable>
          <VDivider />

          <VCardText>
            <div class="d-flex align-end flex-column">
              <table class="text-high-emphasis">
                <tbody>
                  <tr>
                    <td width="200px">Tổng sản phẩm:</td>
                    <td class="font-weight-medium">$2,093</td>
                  </tr>
                  <!-- <tr>
                    <td>Shipping fee: </td>
                    <td class="font-weight-medium">
                      $2
                    </td>
                  </tr> -->
                  <!-- <tr>
                    <td>Tax: </td>
                    <td class="font-weight-medium">
                      $28
                    </td>
                  </tr> -->
                  <tr>
                    <td class="font-weight-medium">Tổng tiền:</td>
                    <td class="font-weight-medium">$2,113</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </VCardText>
        </VCard>

        <!-- 👉 Shipping Activity -->
        <VCard title="Hoạt động giao hàng">
          <VCardText>
            <VTimeline
              truncate-line="both"
              align="start"
              side="end"
              line-inset="10"
              line-color="primary"
              density="compact"
              class="v-timeline-density-compact"
            >
              <VTimelineItem dot-color="primary" size="x-small">
                <div class="d-flex justify-space-between align-center mb-3">
                  <span class="app-timeline-title"
                    >Đơn hàng đã được đặt (Mã đơn hàng: #32543)</span
                  >
                  <span class="app-timeline-meta">Thứ Ba 11:29 AM</span>
                </div>
                <p class="app-timeline-text mb-0">
                  Đơn hàng của bạn đã được đặt thành công
                </p>
              </VTimelineItem>

              <VTimelineItem dot-color="primary" size="x-small">
                <div class="d-flex justify-space-between align-center mb-3">
                  <span class="app-timeline-title">Nhận hàng</span>
                  <span class="app-timeline-meta">Thứ Tư 11:29 AM</span>
                </div>
                <p class="app-timeline-text mb-0">
                  Lịch trình nhận hàng đã được đặt với đơn vị vận chuyển
                </p>
              </VTimelineItem>

              <VTimelineItem dot-color="primary" size="x-small">
                <div class="d-flex justify-space-between align-center mb-3">
                  <span class="app-timeline-title">Đã gửi hàng</span>
                  <span class="app-timeline-meta">Thứ Năm 8:15 AM</span>
                </div>
                <p class="app-timeline-text mb-0">
                  Mặt hàng đã được đơn vị vận chuyển nhận.
                </p>
              </VTimelineItem>

              <VTimelineItem dot-color="primary" size="x-small">
                <div class="d-flex justify-space-between align-center mb-3">
                  <span class="app-timeline-title">Gói hàng đã đến</span>
                  <span class="app-timeline-meta">Thứ Bảy 15:20 AM</span>
                </div>
                <p class="app-timeline-text mb-0">
                  Gói hàng đã đến cơ sở của Amazon, NY
                </p>
              </VTimelineItem>

              <VTimelineItem dot-color="primary" size="x-small">
                <div class="d-flex justify-space-between align-center mb-3">
                  <span class="app-timeline-title">Đã gửi đi để giao hàng</span>
                  <span class="app-timeline-meta">Hôm nay 14:12 PM</span>
                </div>
                <p class="app-timeline-text mb-0">
                  Gói hàng đã rời khỏi cơ sở của Amazon, NY
                </p>
              </VTimelineItem>

              <VTimelineItem dot-color="primary" size="x-small">
                <div class="d-flex justify-space-between align-center mb-3">
                  <span class="app-timeline-title">Giao hàng</span>
                </div>
                <p class="app-timeline-text mb-0">
                  Gói hàng sẽ được giao vào ngày mai
                </p>
              </VTimelineItem>
            </VTimeline>
          </VCardText>
        </VCard>
      </VCol>

      <VCol cols="12" md="4">
        <!-- 👉 Customer Details  -->
        <VCard class="mb-6">
          <VCardText class="d-flex flex-column gap-y-6">
            <h5 class="text-h5">Chi tiết khách hàng</h5>

            <div class="d-flex align-center">
              <VAvatar :image="avatar1" class="me-3" />
              <div>
                <div class="text-body-1 text-high-emphasis font-weight-medium">
                  Shamus Tuttle
                </div>
                <span>Mã khách hàng: #47389</span>
              </div>
            </div>

            <div class="d-flex align-center">
              <VAvatar variant="tonal" color="success" class="me-3">
                <VIcon icon="ri-shopping-cart-line" />
              </VAvatar>

              <h6 class="text-h6">12 Đơn hàng</h6>
            </div>

            <div class="d-flex flex-column gap-y-1">
              <div class="d-flex justify-space-between gap-1 text-body-2">
                <h6 class="text-h6">Thông tin liên hệ</h6>
                <span
                  class="text-base text-primary font-weight-medium cursor-pointer"
                  @click="
                    isUserInfoEditDialogVisible = !isUserInfoEditDialogVisible
                  "
                >
                  Chỉnh sửa
                </span>
              </div>
              <span>Email: Sheldon88@yahoo.com</span>
              <span>Di động: 0123124424</span>
            </div>
          </VCardText>
        </VCard>

        <!-- 👉 Shipping Address -->
        <VCard class="mb-6">
          <VCardText>
            <div class="d-flex align-center justify-space-between gap-1 mb-6">
              <div class="text-body-1 text-high-emphasis font-weight-medium">
                Địa chỉ giao hàng
              </div>
              <span
                class="text-base text-primary font-weight-medium cursor-pointer"
                @click="
                  isEditAddressDialogVisible = !isEditAddressDialogVisible
                "
                >Chỉnh sửa</span
              >
            </div>
            <div>
              222 Nguyễn Văn Lộc <br />
              Mộ Lao <br />
              Hà Đông <br />
              Hà Nội
            </div>
          </VCardText>
        </VCard>

        <!-- 👉 Billing Address -->
        <VCard>
          <VCardText>
            <div class="d-flex align-center justify-space-between gap-1 mb-3">
              <div class="text-body-1 text-high-emphasis font-weight-medium">
                Địa chỉ thanh toán
              </div>
              <span
                class="text-base text-primary font-weight-medium cursor-pointer"
                @click="
                  isEditAddressDialogVisible = !isEditAddressDialogVisible
                "
                >Chỉnh sửa</span
              >
            </div>
            <div>
              222 Nguyễn Văn Lộc <br />
              Mộ Lao <br />
              Hà Đông <br />
              Hà Nội
            </div>

            <div class="mt-6">
              <h6 class="text-h6 mb-1">Mastercard</h6>
              <div class="text-base">Số thẻ: ******4291</div>
            </div>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>

    <ConfirmDialog
      v-model:isDialogVisible="isConfirmDialogVisible"
      confirmation-question="Are you sure to cancel your Order?"
      cancel-msg="Order cancelled!!"
      cancel-title="Cancelled"
      confirm-msg="Your order cancelled successfully."
      confirm-title="Cancelled!"
    />

    <UserInfoEditDialog v-model:isDialogVisible="isUserInfoEditDialogVisible" />

    <AddEditAddressDialog
      v-model:isDialogVisible="isEditAddressDialogVisible"
    />
  </div>
</template>

<script setup lang="ts">
import type { Order } from "@db/apps/ecommerce/types";
import mastercard from "@images/logos/mastercard.png";
import paypal from "@images/logos/paypal.png";

const widgetData = ref([
  { title: "Chờ Thanh Toán", value: 56, icon: "ri-calendar-2-line" },
  { title: "Hoàn Thành", value: 12689, icon: "ri-check-double-line" },
  { title: "Đã Hoàn Tiền", value: 124, icon: "ri-wallet-3-line" },
  { title: "Thất Bại", value: 32, icon: "ri-error-warning-line" },
]);

const searchQuery = ref("");

// Data table options
const itemsPerPage = ref(10);
const page = ref(1);
const sortBy = ref();
const orderBy = ref();

// Data table Headers
const headers = [
  { title: "Đơn hàng", key: "order" },
  { title: "Ngày", key: "date" },
  { title: "Khách hàng", key: "customers" },
  { title: "Thanh toán", key: "payment", sortable: false },
  { title: "Trạng thái", key: "status" },
  { title: "Phương thức", key: "method", sortable: false },
  { title: "Hành động", key: "actions", sortable: false },
];

// Update data table options
const updateOptions = (options: any) => {
  page.value = options.page;
  sortBy.value = options.sortBy[0]?.key;
  orderBy.value = options.sortBy[0]?.order;
};

const resolvePaymentStatus = (status: number) => {
  if (status === 1) return { text: "Đã Thanh Toán", color: "success" };
  if (status === 2) return { text: "Đang Chờ", color: "warning" };
  if (status === 3) return { text: "Đã Hủy", color: "secondary" };
  if (status === 4) return { text: "Thất Bại", color: "error" };
};

const resolveStatus = (status: string) => {
  if (status === "Delivered") return { text: "Đã giao hàng", color: "success" };
  if (status === "Out for Delivery")
    return { text: "Đang giao hàng", color: "primary" };
  if (status === "Ready to Pickup")
    return { text: "Sẵn sàng để lấy", color: "info" };
  if (status === "Dispatched") return { text: "Đã xuất kho", color: "warning" };
};

// Fetch Orders
const { data: ordersData, execute: fetchOrders } = await useApi<any>(
  createUrl("/apps/ecommerce/orders", {
    query: {
      q: searchQuery,
      page,
      itemsPerPage,
      sortBy,
      orderBy,
    },
  })
);

const orders = computed((): Order[] => ordersData.value.orders);
const totalOrder = computed(() => ordersData.value.total);

// Delete Orders
const deleteOrder = async (id: number) => {
  await $api(`/apps/ecommerce/orders/${id}`, {
    method: "DELETE",
  });
  fetchOrders();
};
</script>

<template>
  <div>
    <VCard class="mb-6">
      <VCardText class="px-2">
        <VRow>
          <template v-for="(data, index) in widgetData" :key="index">
            <VCol cols="12" sm="6" md="3" class="px-6">
              <div
                class="d-flex justify-space-between"
                :class="
                  $vuetify.display.xs
                    ? 'product-widget'
                    : $vuetify.display.sm
                    ? index < 2
                      ? 'product-widget'
                      : ''
                    : ''
                "
              >
                <div class="d-flex flex-column gap-y-1">
                  <h4 class="text-h4">
                    {{ data.value }}
                  </h4>
                  <span class="text-base text-capitalize">
                    {{ data.title }}
                  </span>
                </div>

                <VAvatar variant="tonal" rounded size="42">
                  <VIcon :icon="data.icon" size="26" />
                </VAvatar>
              </div>
            </VCol>
            <VDivider
              v-if="
                $vuetify.display.mdAndUp
                  ? index !== widgetData.length - 1
                  : $vuetify.display.smAndUp
                  ? index % 2 === 0
                  : false
              "
              vertical
              inset
              length="100"
            />
          </template>
        </VRow>
      </VCardText>
    </VCard>

    <VCard>
      <VCardText>
        <div
          class="d-flex justify-sm-space-between align-center justify-start flex-wrap gap-4"
        >
          <VTextField
            v-model="searchQuery"
            placeholder="Tìm đơn hàng"
            density="compact"
            style="max-inline-size: 200px; min-inline-size: 200px"
          />

          <VBtn
            prepend-icon="ri-upload-2-line"
            variant="outlined"
            color="secondary"
          >
            Xuất file
          </VBtn>
        </div>
      </VCardText>

      <VDataTableServer
        v-model:items-per-page="itemsPerPage"
        v-model:page="page"
        :headers="headers"
        :items="orders"
        item-value="order"
        :items-length="totalOrder"
        show-select
        class="text-no-wrap"
        @update:options="updateOptions"
      >
        <!-- Order ID -->
        <template #item.order="{ item }">
          <RouterLink
            :to="{
              name: 'apps-ecommerce-order-details-id',
              params: { id: item.order },
            }"
          >
            #{{ item.order }}
          </RouterLink>
        </template>

        <!-- Date -->
        <template #item.date="{ item }">
          {{ new Date(item.date).toDateString() }}
        </template>

        <!-- Customers  -->
        <template #item.customers="{ item }">
          <div class="d-flex align-center">
            <VAvatar
              size="34"
              :variant="!item.avatar.length ? 'tonal' : undefined"
              :rounded="1"
              class="me-4"
            >
              <VImg v-if="item.avatar" :src="item.avatar" />

              <span v-else class="font-weight-medium">{{
                avatarText(item.customer)
              }}</span>
            </VAvatar>

            <div class="d-flex flex-column">
              <RouterLink
                :to="{
                  name: 'pages-user-profile-tab',
                  params: { tab: 'profile' },
                }"
              >
                <div class="text-high-emphasis font-weight-medium">
                  {{ item.customer }}
                </div>
              </RouterLink>
              <span class="text-sm">{{ item.email }}</span>
            </div>
          </div>
        </template>

        <!-- Payments -->
        <template #item.payment="{ item }">
          <div
            :class="`text-${resolvePaymentStatus(item.payment)?.color}`"
            class="d-flex align-center font-weight-medium"
          >
            <VIcon size="10" icon="ri-circle-fill" class="me-2" />
            <span>{{ resolvePaymentStatus(item.payment)?.text }}</span>
          </div>
        </template>

        <!-- Status -->
        <template #item.status="{ item }">
          <VChip v-bind="resolveStatus(item.status)" size="small" />
        </template>

        <!-- Method -->
        <template #item.method="{ item }">
          <div class="d-flex align-start gap-x-2">
            <img :src="item.method === 'mastercard' ? mastercard : paypal" />
            <div>
              <VIcon icon="ri-more-line" class="me-2" />
              <span v-if="item.method === 'mastercard'">
                {{ item.methodNumber }}
              </span>
              <span v-else> @gmail.com </span>
            </div>
          </div>
        </template>

        <!-- Actions -->
        <template #item.actions="{ item }">
          <IconBtn size="small">
            <VIcon icon="ri-more-2-line" />
            <VMenu activator="parent">
              <VList>
                <VListItem value="view">
                  <RouterLink
                    :to="{
                      name: 'apps-ecommerce-order-details-id',
                      params: { id: item.order },
                    }"
                    class="text-high-emphasis"
                  >
                    Xem
                  </RouterLink>
                </VListItem>
                <VListItem value="delete" @click="deleteOrder(item.id)">
                  Xóa
                </VListItem>
              </VList>
            </VMenu>
          </IconBtn>
        </template>

        <!-- Pagination -->
        <template #bottom>
          <VDivider />

          <div class="d-flex justify-end flex-wrap gap-x-6 px-2 py-1">
            <div
              class="d-flex align-center gap-x-2 text-medium-emphasis text-base"
            >
              Số lượng mỗi trang:
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
              {{ paginationMeta({ page, itemsPerPage }, totalOrder) }}
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
                :disabled="page >= Math.ceil(totalOrder / itemsPerPage)"
                @click="
                  page >= Math.ceil(totalOrder / itemsPerPage)
                    ? (page = Math.ceil(totalOrder / itemsPerPage))
                    : page++
                "
              />
            </div>
          </div>
        </template>
      </VDataTableServer>
    </VCard>
  </div>
</template>

<style lang="scss" scoped>
#customer-link {
  &:hover {
    color: "#000" !important;
  }
}

.product-widget {
  border-block-end: 1px solid
    rgba(var(--v-theme-on-surface), var(--v-border-opacity));
  padding-block-end: 1rem;
}
</style>

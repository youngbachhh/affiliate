<script setup lang="ts">
import type { Invoice } from "@db/apps/invoice/types";

type invoiceStatus =
  | "Downloaded"
  | "Draft"
  | "Paid"
  | "Sent"
  | "Partial Payment"
  | "Past Due"
  | null;

const searchQuery = ref("");
const selectedStatus = ref<invoiceStatus>(null);
const selectedRows = ref<string[]>([]);

// Tùy chọn bảng dữ liệu
const itemsPerPage = ref(10);
const page = ref(1);
const sortBy = ref();
const orderBy = ref();

// Cập nhật tùy chọn bảng dữ liệu
const updateOptions = (options: any) => {
  page.value = options.page;
  sortBy.value = options.sortBy[0]?.key;
  orderBy.value = options.sortBy[0]?.order;
};

const widgetData = ref([
  { title: "Khách hàng", value: 24, icon: "ri-user-line" },
  { title: "Hóa đơn", value: 165, icon: "ri-pages-line" },
  { title: "Đã thanh toán", value: "$2.46k", icon: "ri-wallet-line" },
  {
    title: "Chưa thanh toán",
    value: "$876",
    icon: "ri-money-dollar-circle-line",
  },
]);

// 👉 tiêu đề
const headers = [
  { title: "Mã hóa đơn", key: "id" },
  { title: "Trạng thái", key: "trending", sortable: false },
  { title: "Khách hàng", key: "client" },
  { title: "Tổng cộng", key: "total" },
  { title: "Ngày phát hành", key: "date" },
  { title: "Số dư", key: "balance" },
  { title: "Hành động", key: "actions", sortable: false },
];

// 👉 Lấy hóa đơn
const { data: invoiceData, execute: fetchInvoices } = await useApi<any>(
  createUrl("/apps/invoice", {
    query: {
      q: searchQuery,
      status: selectedStatus,
      itemsPerPage,
      page,
      sortBy,
      orderBy,
    },
  })
);

const invoices = computed((): Invoice[] => invoiceData.value.invoices);
const totalInvoices = computed(() => invoiceData.value.totalInvoices);

// 👉 Trình phân giải biến thể số dư hóa đơn
const resolveInvoiceBalanceVariant = (
  balance: string | number,
  total: number
) => {
  if (balance === total)
    return { status: "Chưa thanh toán", chip: { color: "error" } };

  if (balance === 0)
    return { status: "Đã thanh toán", chip: { color: "success" } };

  return { status: balance, chip: { variant: "text" } };
};

// 👉 Trình phân giải biến thể trạng thái hóa đơn
const resolveInvoiceStatusVariantAndIcon = (status: string) => {
  if (status === "Partial Payment")
    return { variant: "warning", icon: "ri-line-chart-line" };
  if (status === "Paid") return { variant: "success", icon: "ri-check-line" };
  if (status === "Downloaded")
    return { variant: "info", icon: "ri-arrow-down-line" };
  if (status === "Draft") return { variant: "secondary", icon: "ri-save-line" };
  if (status === "Sent") return { variant: "primary", icon: "ri-mail-line" };
  if (status === "Past Due")
    return { variant: "error", icon: "ri-error-warning-line" };

  return { variant: "secondary", icon: "ri-close-line" };
};

const computedMoreList = computed(() => {
  return (paramId: number) => [
    { title: "Tải xuống", value: "download", prependIcon: "ri-download-line" },
    {
      title: "Sửa",
      value: "edit",
      prependIcon: "ri-pencil-line",
      to: { name: "apps-invoice-edit-id", params: { id: paramId } },
    },
    { title: "Nhân bản", value: "duplicate", prependIcon: "ri-stack-line" },
  ];
});

// 👉 Xóa hóa đơn
const deleteInvoice = async (id: number) => {
  await $api(`/apps/invoice/${id}`, { method: "DELETE" });

  fetchInvoices();
};
</script>

<template>
  <section v-if="invoices">
    <!-- 👉 Tiện ích hóa đơn -->
    <VCard class="mb-6">
      <VCardText class="px-2">
        <VRow>
          <template v-for="(data, id) in widgetData" :key="id">
            <VCol
              cols="12"
              sm="6"
              md="3"
              class="px-6"
              :class="
                id !== widgetData.length - 1 && $vuetify.display.width <= 600
                  ? 'border-b'
                  : ''
              "
            >
              <div class="d-flex justify-space-between">
                <div class="d-flex flex-column">
                  <h4 class="text-h4">
                    {{ data.value }}
                  </h4>
                  <span class="text-body-1 text-capitalize">{{
                    data.title
                  }}</span>
                </div>

                <VAvatar variant="tonal" rounded size="42">
                  <VIcon :icon="data.icon" size="26" color="high-emphasis" />
                </VAvatar>
              </div>
            </VCol>
            <VDivider
              v-if="
                $vuetify.display.mdAndUp
                  ? id !== widgetData.length - 1
                  : $vuetify.display.smAndUp
                  ? id % 2 === 0
                  : false
              "
              vertical
              inset
            />
          </template>
        </VRow>
      </VCardText>
    </VCard>

    <VCard id="invoice-list">
      <VCardText class="d-flex align-center flex-wrap gap-4">
        <!-- 👉 Tạo hóa đơn -->
        <VBtn prepend-icon="ri-add-line" :to="{ name: 'apps-invoice-add' }">
          Tạo hóa đơn
        </VBtn>

        <VSpacer />

        <div class="d-flex align-center flex-wrap gap-4">
          <!-- 👉 Tìm kiếm  -->
          <div class="invoice-list-search">
            <VTextField
              v-model="searchQuery"
              density="compact"
              placeholder="Tìm kiếm hóa đơn"
            />
          </div>

          <div class="invoice-list-search">
            <VSelect
              v-model="selectedStatus"
              placeholder="Trạng thái hóa đơn"
              clearable
              density="compact"
              clear-icon="ri-close-line"
              :items="[
                'Downloaded',
                'Draft',
                'Sent',
                'Paid',
                'Partial Payment',
                'Past Due',
              ]"
            />
          </div>
        </div>
      </VCardText>

      <!-- SECTION Bảng dữ liệu -->
      <VDataTableServer
        v-model="selectedRows"
        v-model:items-per-page="itemsPerPage"
        v-model:page="page"
        show-select
        :items-length="totalInvoices"
        :headers="headers"
        :items="invoices"
        item-value="id"
        class="text-no-wrap rounded-0"
        @update:options="updateOptions"
      >
        <!-- id -->
        <template #item.id="{ item }">
          <RouterLink
            :to="{ name: 'apps-invoice-preview-id', params: { id: item.id } }"
          >
            #{{ item.id }}
          </RouterLink>
        </template>

        <!-- trending -->
        <template #item.trending="{ item }">
          <VTooltip>
            <template #activator="{ props }">
              <VAvatar
                :size="28"
                v-bind="props"
                :color="
                  resolveInvoiceStatusVariantAndIcon(item.invoiceStatus).variant
                "
                variant="tonal"
              >
                <VIcon
                  :size="16"
                  :icon="
                    resolveInvoiceStatusVariantAndIcon(item.invoiceStatus).icon
                  "
                />
              </VAvatar>
            </template>
            <p class="mb-0">
              {{ item.invoiceStatus }}
            </p>
            <p class="mb-0">Số dư: {{ item.balance }}</p>
            <p class="mb-0">Ngày đến hạn: {{ item.dueDate }}</p>
          </VTooltip>
        </template>

        <!-- client -->
        <template #item.client="{ item }">
          <div class="d-flex align-center">
            <VAvatar
              size="34"
              :color="
                !item.avatar.length
                  ? resolveInvoiceStatusVariantAndIcon(item.invoiceStatus)
                      .variant
                  : undefined
              "
              :variant="!item.avatar.length ? 'tonal' : undefined"
              class="me-3"
            >
              <VImg v-if="item.avatar.length" :src="item.avatar" />
              <span v-else>{{ avatarText(item.client.name) }}</span>
            </VAvatar>
            <div class="d-flex flex-column">
              <RouterLink
                :to="{
                  name: 'pages-user-profile-tab',
                  params: { tab: 'profile' },
                }"
                class="text-h6 font-weight-medium mb-0"
              >
                {{ item.client.name }}
              </RouterLink>
              <span class="text-body-2">{{ item.client.companyEmail }}</span>
            </div>
          </div>
        </template>

        <!-- Tổng cộng -->
        <template #item.total="{ item }"> ${{ item.total }} </template>

        <!-- Ngày phát hành -->
        <template #item.date="{ item }">
          {{ item.issuedDate }}
        </template>

        <!-- Số dư -->
        <template #item.balance="{ item }">
          <VChip
            v-if="
              typeof resolveInvoiceBalanceVariant(item.balance, item.total)
                .status === 'string'
            "
            :color="
              resolveInvoiceBalanceVariant(item.balance, item.total).chip.color
            "
            size="small"
          >
            {{ resolveInvoiceBalanceVariant(item.balance, item.total).status }}
          </VChip>
          <h6 v-else class="text-h6 font-weight-regular">
            {{
              Number(
                resolveInvoiceBalanceVariant(item.balance, item.total).status
              ) > 0
                ? `$${
                    resolveInvoiceBalanceVariant(item.balance, item.total)
                      .status
                  }`
                : `-$${Math.abs(
                    Number(
                      resolveInvoiceBalanceVariant(item.balance, item.total)
                        .status
                    )
                  )}`
            }}
          </h6>
        </template>

        <!-- Hành động -->
        <template #item.actions="{ item }">
          <div class="text-no-wrap">
            <IconBtn size="small" @click="deleteInvoice(item.id)">
              <VIcon icon="ri-delete-bin-7-line" />
            </IconBtn>

            <IconBtn
              size="small"
              :to="{ name: 'apps-invoice-preview-id', params: { id: item.id } }"
            >
              <VIcon icon="ri-eye-line" />
            </IconBtn>

            <MoreBtn
              size="small"
              :menu-list="computedMoreList(item.id)"
              item-props
            />
          </div>
        </template>

        <!-- Phân trang -->
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
              {{ paginationMeta({ page, itemsPerPage }, totalInvoices) }}
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
                :disabled="page >= Math.ceil(totalInvoices / itemsPerPage)"
                @click="
                  page >= Math.ceil(totalInvoices / itemsPerPage)
                    ? (page = Math.ceil(totalInvoices / itemsPerPage))
                    : page++
                "
              />
            </div>
          </div>
        </template>
      </VDataTableServer>
      <!-- !SECTION -->
    </VCard>
  </section>
  <section v-else>
    <VCard>
      <VCardTitle>Không tìm thấy hóa đơn</VCardTitle>
    </VCard>
  </section>
</template>

<style lang="scss">
#invoice-list {
  .invoice-list-actions {
    inline-size: 8rem;
  }

  .invoice-list-search {
    inline-size: 12rem;
  }
}
</style>

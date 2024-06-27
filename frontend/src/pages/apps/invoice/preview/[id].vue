<script setup lang="ts">
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";
import { themeConfig } from "@themeConfig";

// Components
import InvoiceAddPaymentDrawer from "@/views/apps/invoice/InvoiceAddPaymentDrawer.vue";
import InvoiceSendInvoiceDrawer from "@/views/apps/invoice/InvoiceSendInvoiceDrawer.vue";

const route = useRoute("apps-invoice-preview-id");

const isAddPaymentSidebarVisible = ref(false);
const isSendPaymentSidebarVisible = ref(false);

const { data: invoiceData } = await useApi<any>(
  `/apps/invoice/${Number(route.params.id)}`
);

const invoice = invoiceData.value.invoice;
const paymentDetails = invoiceData.value.paymentDetails;

// 👉 Invoice Description
// ℹ️ Your real data will contain this information
const purchasedProducts = [
  {
    name: "Premium Branding Package",
    description: "Branding & Promotion",
    qty: 1,
    hours: 15,
    price: 32,
  },
  {
    name: "SMM",
    description: "Social media templates",
    qty: 1,
    hours: 14,
    price: 28,
  },
  {
    name: "Web Design",
    description: "Web designing package",
    qty: 1,
    hours: 12,
    price: 24,
  },
  {
    name: "SEO",
    description: "Search engine optimization",
    qty: 1,
    hours: 5,
    price: 22,
  },
];

// 👉 Print Invoice
const printInvoice = () => {
  window.print();
};
</script>

<template>
  <section v-if="invoiceData">
    <VRow>
      <VCol cols="12" md="9">
        <VCard class="invoice-preview-wrapper pa-12">
          <!-- SECTION Header -->
          <div
            class="invoice-header-preview d-flex flex-wrap justify-space-between flex-column flex-sm-row print-row bg-var-theme-background gap-6 rounded pa-6 mb-6"
          >
            <!-- 👉 Left Content -->
            <div>
              <div class="d-flex align-center mb-6">
                <!-- 👉 Logo -->
                <VNodeRenderer :nodes="themeConfig.app.logo" class="me-3" />

                <!-- 👉 Title -->
                <h6 class="text-xl leading-normal text-uppercase">
                  {{ themeConfig.app.title }}
                </h6>
              </div>

              <!-- 👉 Address -->
              <h6 class="text-h6 font-weight-regular">
                Office 149, 450 South Brand Brooklyn
              </h6>
              <h6 class="text-h6 font-weight-regular">
                San Diego County, CA 91905, USA
              </h6>
              <h6 class="text-h6 font-weight-regular">
                +1 (123) 456 7891, +44 (876) 543 2198
              </h6>
            </div>

            <!-- 👉 Right Content -->
            <div>
              <!-- 👉 Invoice ID -->
              <h6 class="font-weight-medium text-lg mb-6">
                Hóa đơn #{{ invoice.id }}
              </h6>

              <!-- 👉 Issue Date -->
              <h6 class="text-h6 font-weight-regular">
                <span>Ngày phát hành: </span>
                <span>{{
                  new Date(invoice.issuedDate).toLocaleDateString("en-GB")
                }}</span>
              </h6>

              <!-- 👉 Due Date -->
              <h6 class="text-h6 font-weight-regular">
                <span>Ngày hết hạn: </span>
                <span>{{
                  new Date(invoice.dueDate).toLocaleDateString("en-GB")
                }}</span>
              </h6>
            </div>
          </div>
          <!-- !SECTION -->

          <!-- 👉 Payment Details -->
          <VRow class="print-row mb-6">
            <VCol class="text-no-wrap">
              <h6 class="text-h6 mb-4">Hóa đơn tới:</h6>

              <p class="mb-0">
                {{ invoice.client.name }}
              </p>
              <p class="mb-0">
                {{ invoice.client.company }}
              </p>
              <p class="mb-0">
                {{ invoice.client.address }}, {{ invoice.client.country }}
              </p>
              <p class="mb-0">
                {{ invoice.client.contact }}
              </p>
              <p class="mb-0">
                {{ invoice.client.companyEmail }}
              </p>
            </VCol>

            <VCol class="text-no-wrap">
              <h6 class="text-h6 mb-4">Hóa đơn tới:</h6>
              <table>
                <tbody>
                  <tr>
                    <td class="pe-6">Tổng tiền đến hạn:</td>
                    <td>
                      {{ paymentDetails.totalDue }}
                    </td>
                  </tr>
                  <tr>
                    <td class="pe-6">Bank Name:</td>
                    <td>
                      {{ paymentDetails.bankName }}
                    </td>
                  </tr>
                  <tr>
                    <td class="pe-6">Country:</td>
                    <td>
                      {{ paymentDetails.country }}
                    </td>
                  </tr>
                  <tr>
                    <td class="pe-6">IBAN:</td>
                    <td>
                      {{ paymentDetails.iban }}
                    </td>
                  </tr>
                  <tr>
                    <td class="pe-6">SWIFT Code:</td>
                    <td>
                      {{ paymentDetails.swiftCode }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </VCol>
          </VRow>

          <!-- 👉 invoice Table -->
          <VTable
            class="invoice-preview-table border text-high-emphasis overflow-hidden mb-6"
          >
            <thead>
              <tr>
                <th scope="col">SẢN PHẨM</th>
                <th scope="col">MÔ TẢ</th>
                <th scope="col" class="text-center">HOURS</th>
                <th scope="col" class="text-center">SỐ LƯỢNG</th>
                <th scope="col" class="text-center">TỔNG TIỀN</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="item in purchasedProducts" :key="item.name">
                <td class="text-no-wrap">
                  {{ item.name }}
                </td>
                <td class="text-no-wrap">
                  {{ item.description }}
                </td>
                <td class="text-center">
                  {{ item.hours }}
                </td>
                <td class="text-center">
                  {{ item.qty }}
                </td>
                <td class="text-center">${{ item.price }}</td>
              </tr>
            </tbody>
          </VTable>

          <!-- 👉 Total -->
          <div
            class="d-flex justify-space-between flex-column flex-sm-row print-row"
          >
            <div class="mb-2">
              <div class="d-flex align-center mb-1">
                <h6 class="text-h6 me-2">Người bán:</h6>
                <span>Jenny Parker</span>
              </div>
              <p>Cảm ơn!</p>
            </div>

            <div>
              <table class="w-100">
                <tbody>
                  <tr>
                    <td class="pe-16">Tổng sản phẩm:</td>
                    <td
                      :class="$vuetify.locale.isRtl ? 'text-start' : 'text-end'"
                    >
                      <h6 class="text-sm">$1800</h6>
                    </td>
                  </tr>
                  <tr>
                    <td class="pe-16">Giảm giá:</td>
                    <td
                      :class="$vuetify.locale.isRtl ? 'text-start' : 'text-end'"
                    >
                      <h6 class="text-sm">$28</h6>
                    </td>
                  </tr>
                  <tr>
                    <td class="pe-16">Thuế:</td>
                    <td
                      :class="$vuetify.locale.isRtl ? 'text-start' : 'text-end'"
                    >
                      <h6 class="text-sm">21%</h6>
                    </td>
                  </tr>
                </tbody>
              </table>

              <VDivider class="mt-4 mb-3" />

              <table class="w-100">
                <tbody>
                  <tr>
                    <td class="pe-16">Tổng tiền:</td>
                    <td
                      :class="$vuetify.locale.isRtl ? 'text-start' : 'text-end'"
                    >
                      <h6 class="text-sm">$1690</h6>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <VDivider class="my-6 border-dashed" />

          <p class="mb-0">
            <span class="text-high-emphasis font-weight-medium me-1">
              Ghi chú:
            </span>
            <span
              >Thật vui khi được làm việc với bạn và nhóm của bạn. Chúng tôi kì
              vọng vào bạn sẽ ghi nhớ chúng tôi cho các dự án tự do trong tương
              lai. Cám ơn Bạn!</span
            >
          </p>
        </VCard>
      </VCol>

      <VCol cols="12" md="3" class="d-print-none">
        <VCard>
          <VCardText>
            <!-- 👉 Send Invoice Trigger button -->
            <VBtn
              block
              prepend-icon="ri-send-plane-line"
              class="mb-4"
              @click="isSendPaymentSidebarVisible = true"
            >
              Gửi hóa đơn
            </VBtn>

            <VBtn block color="secondary" variant="outlined" class="mb-4">
              Tải xuống
            </VBtn>

            <div class="d-flex flex-wrap gap-4">
              <VBtn
                variant="outlined"
                color="secondary"
                class="flex-grow-1"
                @click="printInvoice"
              >
                In
              </VBtn>

              <VBtn
                color="secondary"
                variant="outlined"
                class="mb-4 flex-grow-1"
                :to="{
                  name: 'apps-invoice-edit-id',
                  params: { id: route.params.id },
                }"
              >
                Chỉnh sửa
              </VBtn>
            </div>

            <!-- 👉  Add Payment trigger button  -->
            <VBtn
              block
              prepend-icon="ri-money-dollar-circle-line"
              color="success"
              @click="isAddPaymentSidebarVisible = true"
            >
              Thêm phương thức thanh toán
            </VBtn>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>

    <!-- 👉 Add Payment Sidebar -->
    <InvoiceAddPaymentDrawer
      v-model:isDrawerOpen="isAddPaymentSidebarVisible"
    />

    <!-- 👉 Send Invoice Sidebar -->
    <InvoiceSendInvoiceDrawer
      v-model:isDrawerOpen="isSendPaymentSidebarVisible"
    />
  </section>
</template>

<style lang="scss">
.invoice-preview-table {
  --v-table-header-color: var(--v-theme-surface);

  &.v-table .v-table__wrapper table thead tr th {
    border-block-end: 1px solid
      rgba(var(--v-border-color), var(--v-border-opacity)) !important;
  }
}

@media print {
  .v-theme--dark {
    --v-theme-surface: 255, 255, 255;
    --v-theme-on-surface: 94, 86, 105;
  }

  body {
    background: none !important;
  }

  .invoice-header-preview,
  .invoice-preview-wrapper {
    padding: 0 !important;
  }

  .product-buy-now {
    display: none;
  }

  .v-navigation-drawer,
  .layout-vertical-nav,
  .app-customizer-toggler,
  .layout-footer,
  .layout-navbar,
  .layout-navbar-and-nav-container {
    display: none;
  }

  .v-card {
    box-shadow: none !important;

    .print-row {
      flex-direction: row !important;
    }
  }

  .layout-content-wrapper {
    padding-inline-start: 0 !important;
  }

  .v-table__wrapper {
    overflow: hidden !important;
  }
}
</style>

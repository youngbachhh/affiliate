<script lang="ts" setup>
import InvoiceEditable from "@/views/apps/invoice/InvoiceEditable.vue";
import InvoiceSendInvoiceDrawer from "@/views/apps/invoice/InvoiceSendInvoiceDrawer.vue";

// Type: Invoice data
import type { InvoiceData, PurchasedProduct } from "@/views/apps/invoice/types";

// 👉 Dữ liệu mặc định
const invoiceData = ref<InvoiceData>({
  invoice: {
    id: 5037,
    issuedDate: "",
    service: "",
    total: 0,
    avatar: "",
    invoiceStatus: "",
    dueDate: "",
    balance: 0,
    client: {
      address: "112, Lorem Ipsum, Florida",
      company: "Greeva Inc",
      companyEmail: "johndoe@greeva.com",
      contact: "+1 123 3452 12",
      country: "USA",
      name: "John Doe",
    },
  },
  paymentDetails: {
    totalDue: "$12,110.55",
    bankName: "American Bank",
    country: "United States",
    iban: "ETD95476213",
    swiftCode: "BR91905",
  },
  purchasedProducts: [
    {
      title: "",
      cost: 0,
      hours: 0,
      description: "",
    },
  ],
  note: "",
  paymentMethod: "",
  salesperson: "",
  thanksNote: "",
});

const paymentTerms = ref(true);
const clientNotes = ref(false);
const paymentStub = ref(false);
const selectedPaymentMethod = ref("Tài khoản ngân hàng");
const paymentMethods = ["Tài khoản ngân hàng", "PayPal", "Chuyển khoản UPI"];
const isSendPaymentSidebarVisible = ref(false);

const addProduct = (value: PurchasedProduct) => {
  invoiceData.value?.purchasedProducts.push(value);
};

const removeProduct = (id: number) => {
  invoiceData.value?.purchasedProducts.splice(id, 1);
};
</script>

<template>
  <VRow>
    <!-- 👉 Hoá đơn có thể chỉnh sửa -->
    <VCol cols="12" md="9">
      <InvoiceEditable
        :data="invoiceData"
        @push="addProduct"
        @remove="removeProduct"
      />
    </VCol>

    <!-- 👉 Cột bên phải: Hành động hoá đơn -->
    <VCol cols="12" md="3">
      <VCard class="mb-8">
        <VCardText>
          <!-- 👉 Gửi hoá đơn -->
          <VBtn
            block
            prepend-icon="ri-send-plane-line"
            class="mb-3"
            @click="isSendPaymentSidebarVisible = true"
          >
            Gửi hoá đơn
          </VBtn>

          <!-- 👉 Xem trước -->
          <VBtn
            block
            color="secondary"
            variant="outlined"
            class="mb-3"
            :to="{ name: 'apps-invoice-preview-id', params: { id: '5036' } }"
          >
            Xem trước
          </VBtn>

          <!-- 👉 Lưu -->
          <VBtn block color="secondary" variant="outlined"> Lưu </VBtn>
        </VCardText>
      </VCard>

      <!-- 👉 Chọn phương thức thanh toán -->
      <VSelect
        v-model="selectedPaymentMethod"
        :items="paymentMethods"
        label="Chấp nhận thanh toán qua"
        class="mb-6"
      />

      <!-- 👉 Điều khoản thanh toán -->
      <div class="d-flex align-center justify-space-between mb-2">
        <VLabel for="payment-terms"> Điều khoản thanh toán </VLabel>
        <div>
          <VSwitch id="payment-terms" v-model="paymentTerms" />
        </div>
      </div>

      <!-- 👉 Ghi chú khách hàng -->
      <div class="d-flex align-center justify-space-between mb-2">
        <VLabel for="client-notes"> Ghi chú khách hàng </VLabel>
        <div>
          <VSwitch id="client-notes" v-model="clientNotes" />
        </div>
      </div>

      <!-- 👉 Phiếu thanh toán -->
      <div class="d-flex align-center justify-space-between">
        <VLabel for="payment-stub"> Phiếu thanh toán </VLabel>
        <div>
          <VSwitch id="payment-stub" v-model="paymentStub" />
        </div>
      </div>
    </VCol>
  </VRow>

  <!-- 👉 Thanh bên gửi hoá đơn -->
  <InvoiceSendInvoiceDrawer
    v-model:isDrawerOpen="isSendPaymentSidebarVisible"
  />
</template>

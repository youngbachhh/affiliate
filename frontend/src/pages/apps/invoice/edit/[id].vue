<script lang="ts" setup>
import InvoiceAddPaymentDrawer from "@/views/apps/invoice/InvoiceAddPaymentDrawer.vue";
import InvoiceEditable from "@/views/apps/invoice/InvoiceEditable.vue";
import InvoiceSendInvoiceDrawer from "@/views/apps/invoice/InvoiceSendInvoiceDrawer.vue";

// Type: Dữ liệu hóa đơn
import type { InvoiceData, PurchasedProduct } from "@/views/apps/invoice/types";

const invoiceData = ref<InvoiceData>();
const route = useRoute("apps-invoice-edit-id");

// 👉 fetchInvoice

const { data: invoiceDetails } = await useApi<any>(
  `/apps/invoice/${route.params.id}`
);

invoiceData.value = {
  invoice: invoiceDetails.value.invoice,
  paymentDetails: invoiceDetails.value.paymentDetails,

  /*
      Chúng tôi đang thêm một số dữ liệu bổ sung trong phản hồi cho mục đích dữ liệu
      Phản hồi của bạn sẽ chứa dữ liệu bổ sung này
      Mục đích là làm cho API thân thiện hơn và ít tĩnh nhất có thể
    */

  purchasedProducts: [
    {
      title: "Thiết kế ứng dụng",
      cost: 24,
      hours: 2,
      description: "Thiết kế bộ giao diện người dùng & các trang ứng dụng.",
    },
  ],
  note: "Rất hân hạnh được làm việc với bạn và đội ngũ của bạn. Chúng tôi hy vọng bạn sẽ ghi nhớ chúng tôi cho các dự án freelance trong tương lai. Cảm ơn bạn!",
  paymentMethod: "Tài khoản ngân hàng",
  salesperson: "Tom Cook",
  thanksNote: "Cảm ơn bạn đã kinh doanh với chúng tôi",
};

const addProduct = (value: PurchasedProduct) => {
  invoiceData.value?.purchasedProducts.push(value);
};

const removeProduct = (id: number) => {
  invoiceData.value?.purchasedProducts.splice(id, 1);
};

const isSendSidebarActive = ref(false);
const isAddPaymentSidebarActive = ref(false);
const paymentTerms = ref(true);
const clientNotes = ref(false);
const paymentStub = ref(false);
const selectedPaymentMethod = ref("Tài khoản ngân hàng");
const paymentMethods = ["Tài khoản ngân hàng", "PayPal", "Chuyển khoản UPI"];
</script>

<template>
  <VRow>
    <!-- 👉 InvoiceEditable -->
    <VCol cols="12" md="9">
      <InvoiceEditable
        v-if="invoiceData?.invoice"
        :data="invoiceData"
        @push="addProduct"
        @remove="removeProduct"
      />
    </VCol>

    <!-- 👉 Cột bên phải: Hành động hóa đơn -->
    <VCol cols="12" md="3">
      <VCard class="mb-8">
        <VCardText>
          <!-- 👉 Nút kích hoạt Gửi hóa đơn -->
          <VBtn
            block
            prepend-icon="ri-send-plane-line"
            class="mb-4"
            @click="isSendSidebarActive = true"
          >
            Gửi hóa đơn
          </VBtn>

          <div class="d-flex flex-wrap gap-4">
            <!-- 👉 Nút Xem trước -->
            <VBtn
              color="secondary"
              variant="outlined"
              class="flex-grow-1"
              :to="{
                name: 'apps-invoice-preview-id',
                params: { id: route.params.id },
              }"
            >
              Xem trước
            </VBtn>

            <!-- 👉 Nút Lưu -->
            <VBtn color="secondary" variant="outlined" class="mb-4 flex-grow-1">
              Lưu
            </VBtn>
          </div>

          <!-- 👉 Nút kích hoạt Thêm thanh toán -->
          <VBtn
            block
            color="success"
            prepend-icon="ri-money-dollar-circle-line"
            @click="isAddPaymentSidebarActive = true"
          >
            Thêm thanh toán
          </VBtn>
        </VCardText>
      </VCard>

      <!-- 👉 Chấp nhận thanh toán qua -->
      <VSelect
        v-model="selectedPaymentMethod"
        :items="paymentMethods"
        label="Chấp nhận thanh toán qua"
        class="mb-6"
      />

      <!-- 👉 Điều khoản thanh toán -->
      <!-- <div class="d-flex align-center justify-space-between mb-2">
        <VLabel for="payment-terms"> Điều khoản thanh toán </VLabel>
        <div>
          <VSwitch id="payment-terms" v-model="paymentTerms" />
        </div>
      </div> -->

      <!-- 👉 Ghi chú của khách hàng -->
      <div class="d-flex align-center justify-space-between mb-2">
        <VLabel for="client-notes"> Ghi chú của khách hàng </VLabel>
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

    <!-- 👉 Ngăn kéo gửi hóa đơn -->
    <InvoiceSendInvoiceDrawer v-model:isDrawerOpen="isSendSidebarActive" />

    <!-- 👉 Ngăn kéo thêm thanh toán -->
    <InvoiceAddPaymentDrawer v-model:isDrawerOpen="isAddPaymentSidebarActive" />
  </VRow>
</template>

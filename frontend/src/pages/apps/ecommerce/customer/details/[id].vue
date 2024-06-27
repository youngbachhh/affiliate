<script setup lang="ts">
import CustomerBioPanel from "@/views/apps/ecommerce/customer/view/CustomerBioPanel.vue";
import CustomerTabAddressAndBilling from "@/views/apps/ecommerce/customer/view/CustomerTabAddressAndBilling.vue";
import CustomerTabNotification from "@/views/apps/ecommerce/customer/view/CustomerTabNotification.vue";
import CustomerTabOverview from "@/views/apps/ecommerce/customer/view/CustomerTabOverview.vue";
import CustomerTabSecurity from "@/views/apps/ecommerce/customer/view/CustomerTabSecurity.vue";
import type { Customer } from "@db/apps/ecommerce/types";

const route = useRoute("apps-ecommerce-customer-details-id");
const customerData = ref<Customer>();
const userTab = ref(null);

const tabs = [
  { icon: "ri-group-line", title: "Tổng quát" },
  { icon: "ri-lock-line", title: "Bảo mật" },
  { icon: "ri-map-pin-line", title: "Địa chỉ & Cài đặt" },
  // { icon: "ri-notification-3-line", title: "Thông báo" },
];

const { data, error } = await useApi<Customer>(
  `/apps/ecommerce/customers/${route.params.id}`
);

if (error.value) console.log(error.value);
else if (data.value) customerData.value = data.value;
</script>

<template>
  <div>
    <!-- 👉 Header  -->
    <div
      class="d-flex justify-space-between align-center flex-wrap gap-y-4 mb-6"
    >
      <div>
        <h4 class="text-h4">Mã khách hàng #{{ route.params.id }}</h4>
        <p class="text-body-1 mb-0">Thứ Bảy 15:20 AM</p>
      </div>
      <VBtn variant="outlined" color="error"> Xóa khách hàng </VBtn>
    </div>
    <!-- 👉 Customer Profile  -->
    <VRow v-if="customerData">
      <VCol cols="12" md="5" lg="4">
        <CustomerBioPanel :customer-data="customerData" />
      </VCol>
      <VCol cols="12" md="7" lg="8">
        <VTabs
          v-model="userTab"
          class="v-tabs-pill mb-6 6 disable-tab-transition"
        >
          <VTab v-for="tab in tabs" :key="tab.icon">
            <VIcon start :icon="tab.icon" />
            <span>{{ tab.title }}</span>
          </VTab>
        </VTabs>
        <VWindow
          v-model="userTab"
          class="mb-6 disable-tab-transition"
          :touch="false"
        >
          <VWindowItem>
            <CustomerTabOverview />
          </VWindowItem>
          <VWindowItem>
            <CustomerTabSecurity />
          </VWindowItem>
          <VWindowItem>
            <CustomerTabAddressAndBilling />
          </VWindowItem>
          <VWindowItem>
            <CustomerTabNotification />
          </VWindowItem>
        </VWindow>
      </VCol>
    </VRow>
  </div>
</template>

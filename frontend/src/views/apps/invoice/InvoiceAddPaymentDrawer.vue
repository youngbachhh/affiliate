<script setup lang="ts">
import { PerfectScrollbar } from "vue3-perfect-scrollbar";

interface SubmitData {
  invoiceBalance: string;
  paymentAmount: string;
  paymentDate: string;
  paymentMethod: string;
  paymentNote: string;
}
interface Emit {
  (e: "update:isDrawerOpen", value: boolean): void;
  (e: "submit", value: SubmitData): void;
}

interface Props {
  isDrawerOpen: boolean;
}
const props = defineProps<Props>();
const emit = defineEmits<Emit>();

const invoiceBalance = ref();
const paymentAmount = ref();
const paymentDate = ref("");
const paymentMethod = ref();
const paymentNote = ref("");

const onSubmit = () => {
  emit("update:isDrawerOpen", false);
  emit("submit", {
    invoiceBalance: invoiceBalance.value,
    paymentAmount: paymentAmount.value,
    paymentDate: paymentDate.value,
    paymentMethod: paymentMethod.value,
    paymentNote: paymentNote.value,
  });
};

const handleDrawerModelValueUpdate = (val: boolean) => {
  emit("update:isDrawerOpen", val);
};
</script>

<template>
  <VNavigationDrawer
    temporary
    location="end"
    :width="400"
    :model-value="props.isDrawerOpen"
    class="scrollable-content"
    @update:model-value="handleDrawerModelValueUpdate"
  >
    <!-- 👉 Header -->
    <AppDrawerHeaderSection
      title="Thêm phương thức thanh toán"
      @cancel="$emit('update:isDrawerOpen', false)"
    />

    <VDivider />

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <VForm @submit.prevent="onSubmit">
            <VRow>
              <VCol cols="12">
                <VTextField
                  v-model="invoiceBalance"
                  label="Số dư hóa đơn"
                  type="number"
                  placeholder="$99"
                />
              </VCol>

              <VCol cols="12">
                <VTextField
                  v-model="paymentAmount"
                  label="Số tiền thanh toán"
                  type="number"
                  placeholder="$99"
                />
              </VCol>

              <VCol cols="12">
                <AppDateTimePicker
                  v-model="paymentDate"
                  label="Ngày thanh toán"
                  placeholder="Chọn ngày"
                />
              </VCol>

              <VCol cols="12">
                <VSelect
                  v-model="paymentMethod"
                  label="Chọn phương thức thanh toán"
                  placeholder="Chọn phương thức thanh toán"
                  :items="[
                    'Cash',
                    'Bank Transfer',
                    'Debit',
                    'Credit',
                    'PayPal',
                  ]"
                />
              </VCol>

              <VCol cols="12">
                <VTextarea
                  v-model="paymentNote"
                  label="Phiếu thanh toán nội bộ"
                  placeholder="Phiếu thanh toán nội bộ"
                />
              </VCol>

              <VCol cols="12">
                <VBtn type="submit" class="me-3"> Gửi </VBtn>

                <VBtn
                  type="reset"
                  color="secondary"
                  variant="outlined"
                  @click="$emit('update:isDrawerOpen', false)"
                >
                  Hủy
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>

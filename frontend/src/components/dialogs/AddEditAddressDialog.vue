<script setup lang="ts">
interface BillingAddress {
  firstName: string;
  lastName: string;
  selectedCountry: string | null;
  addressLine1: string;
  addressLine2: string;
  landmark: string;
  contact: string;
  country: string | null;
  state: string;
  zipCode: number | null;
}
interface Props {
  billingAddress?: BillingAddress;
  isDialogVisible: boolean;
}
interface Emit {
  (e: "update:isDialogVisible", value: boolean): void;
  (e: "submit", value: BillingAddress): void;
}

const props = withDefaults(defineProps<Props>(), {
  billingAddress: () => ({
    firstName: "",
    lastName: "",
    selectedCountry: null,
    addressLine1: "",
    addressLine2: "",
    landmark: "",
    contact: "",
    country: null,
    state: "",
    zipCode: null,
  }),
});

const emit = defineEmits<Emit>();

const billingAddress = ref<BillingAddress>(
  structuredClone(toRaw(props.billingAddress))
);

const resetForm = () => {
  emit("update:isDialogVisible", false);
  billingAddress.value = structuredClone(toRaw(props.billingAddress));
};

const onFormSubmit = () => {
  emit("update:isDialogVisible", false);
  emit("submit", billingAddress.value);
};

const selectedAddress = ref("Home");

const addressTypes = [
  {
    title: "Home",
    desc: "Delivery Time (7am - 9pm)",
    value: "Home",
    icon: "ri-home-smile-2-line",
  },
  {
    title: "Office",
    desc: "Delivery Time (10am - 6pm)",
    value: "Office",
    icon: "ri-building-line",
  },
];
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 900"
    :model-value="props.isDialogVisible"
    @update:model-value="(val) => $emit('update:isDialogVisible', val)"
  >
    <VCard v-if="props.billingAddress" class="pa-sm-11 pa-3">
      <VCardText class="pt-5">
        <!-- 👉 dialog close btn -->
        <DialogCloseBtn variant="text" size="default" @click="resetForm" />

        <!-- 👉 Title -->
        <div class="text-center mb-6">
          <h4 class="text-h4 mb-2">
            {{ props.billingAddress.firstName ? "Sửa" : "Thêm" }} Địa chỉ
          </h4>

          <p class="text-body-1">Thêm địa chỉ</p>
        </div>

        <CustomRadios
          v-model:selected-radio="selectedAddress"
          :radio-content="addressTypes"
          :grid-column="{ sm: '6', cols: '12' }"
          class="mb-5"
        >
          <template #default="items">
            <div class="d-flex flex-column">
              <div class="d-flex mb-2 align-center gap-x-1">
                <VIcon :icon="items.item.icon" size="20" />
                <div class="text-body-1 font-weight-medium text-high-emphasis">
                  {{ items.item.title }}
                </div>
              </div>
              <p class="text-body-2 mb-0">
                {{ items.item.desc }}
              </p>
            </div>
          </template>
        </CustomRadios>
        <!-- 👉 Form -->
        <VForm @submit.prevent="onFormSubmit">
          <VRow>
            <!-- 👉 First Name -->
            <VCol cols="12" md="6">
              <VTextField
                v-model="billingAddress.firstName"
                label="First Name"
                placeholder="John"
              />
            </VCol>

            <!-- 👉 Last Name -->
            <VCol cols="12" md="6">
              <VTextField
                v-model="billingAddress.lastName"
                label="Last Name"
                placeholder="Doe"
              />
            </VCol>

            <!-- 👉 Select country -->

            <!-- <VCol cols="12">
              <VSelect
                v-model="billingAddress.selectedCountry"
                label="Select Country"
                placeholder="Select Country"
                :items="['USA', 'Canada', 'NZ', 'Aus']"
              />
            </VCol> -->

            <!-- 👉 Address Line 1 -->

            <!-- <VCol cols="12">
              <VTextField
                v-model="billingAddress.addressLine1"
                label="Address Line 1"
                placeholder="1, New Street"
              />
            </VCol> -->

            <!-- 👉 Address Line 2 -->

            <!-- <VCol cols="12">
              <VTextField
                v-model="billingAddress.addressLine2"
                label="Address Line 2"
                placeholder="Near hospital"
              />
            </VCol> -->

            <!-- 👉 Landmark -->

            <VCol cols="12">
              <VTextField
                v-model="billingAddress.landmark"
                label="Địa chỉ cụ thể"
                placeholder="222 Nguyễn Văn Lộc, Mộ La, Hà Đông, Hà Nội"
              />
            </VCol>

            <!-- 👉 State -->
            <!-- <VCol cols="12" md="6">
              <VTextField
                v-model="billingAddress.state"
                label="State/Province"
                placeholder="New York"
              />
            </VCol> -->

            <!-- 👉 Zip Code -->
            <!-- <VCol cols="12" md="6">
              <VTextField
                v-model="billingAddress.zipCode"
                label="Zip Code"
                placeholder="123123"
                type="number"
              />
            </VCol> -->

            <VCol cols="12">
              <VSwitch label="Đặt làm địa chỉ nhận hàng mặc định" />
            </VCol>

            <!-- 👉 Submit and Cancel button -->
            <VCol cols="12" class="text-center">
              <VBtn type="submit" class="me-3"> Xác nhận </VBtn>

              <VBtn variant="outlined" color="secondary" @click="resetForm">
                Hủy
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>

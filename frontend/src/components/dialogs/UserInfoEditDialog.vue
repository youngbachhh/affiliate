<script setup lang="ts">
interface UserData {
  id: number;
  fullName: string;
  company: string;
  role: string;
  username: string;
  country: string | null;
  contact: string;
  email: string;
  currentPlan: string;
  status: string | null;
  avatar?: string;
  taskDone?: number;
  projectDone?: number;
  taxId: string;
  language: string[];
}

interface Props {
  userData?: UserData;
  isDialogVisible: boolean;
}

interface Emit {
  (e: "submit", value: UserData): void;
  (e: "update:isDialogVisible", val: boolean): void;
}

const props = withDefaults(defineProps<Props>(), {
  userData: () => ({
    avatar: "",
    company: "",
    contact: "",
    country: null,
    currentPlan: "",
    email: "",
    fullName: "",
    id: 0,
    role: "",
    status: null,
    username: "",
    language: [],
    projectDone: 0,
    taskDone: 0,
    taxId: "",
  }),
});

const emit = defineEmits<Emit>();

const userData = ref<UserData>(structuredClone(toRaw(props.userData)));

watch(props, () => {
  userData.value = structuredClone(toRaw(props.userData));
});

const onFormSubmit = () => {
  emit("update:isDialogVisible", false);
  emit("submit", userData.value);
};

const onFormReset = () => {
  userData.value = structuredClone(toRaw(props.userData));

  emit("update:isDialogVisible", false);
};

const dialogVisibleUpdate = (val: boolean) => {
  emit("update:isDialogVisible", val);
};
</script>

<template>
  <VDialog
    :width="$vuetify.display.smAndDown ? 'auto' : 900"
    :model-value="props.isDialogVisible"
    @update:model-value="dialogVisibleUpdate"
  >
    <VCard class="pa-sm-11 pa-3">
      <!-- 👉 nút đóng dialog -->
      <DialogCloseBtn variant="text" size="default" @click="onFormReset" />

      <VCardText class="pt-5">
        <div class="text-center pb-6">
          <h4 class="text-h4 mb-2">Chỉnh sửa thông tin người dùng</h4>
          <div class="text-body-1">
            Cập nhật thông tin người dùng sẽ nhận được kiểm tra quyền riêng tư.
          </div>
        </div>

        <!-- 👉 Biểu mẫu -->
        <VForm class="mt-4" @submit.prevent="onFormSubmit">
          <VRow>
            <!-- 👉 Tên -->
            <VCol cols="12" md="6">
              <VTextField
                v-model="userData.fullName.split(' ')[0]"
                label="Tên"
                placeholder="John"
              />
            </VCol>

            <!-- 👉 Họ -->
            <VCol cols="12" md="6">
              <VTextField
                v-model="userData.fullName.split(' ')[1]"
                label="Họ"
                placeholder="Doe"
              />
            </VCol>

            <!-- 👉 Tên người dùng  -->

            <VCol cols="12">
              <VTextField
                v-model="userData.username"
                label="Tên người dùng"
                placeholder="John Doe"
              />
            </VCol>

            <!-- 👉 Email thanh toán -->
            <VCol cols="12" md="6">
              <VTextField
                v-model="userData.email"
                label="Email thanh toán"
                placeholder="johndoe@email.com"
              />
            </VCol>

            <!-- 👉 Trạng thái -->
            <VCol cols="12" md="6">
              <VSelect
                v-model="userData.status"
                :items="['Active', 'Inactive', 'Pending']"
                label="Trạng thái"
                placeholder="Trạng thái"
              />
            </VCol>

            <!-- 👉 Mã số thuế -->
            <!-- <VCol cols="12" md="6">
              <VTextField
                v-model="userData.taxId"
                label="Mã số thuế"
                placeholder="Tax-3456789"
              />
            </VCol> -->

            <!-- 👉 Liên hệ -->
            <VCol cols="12" md="6">
              <VTextField
                v-model="userData.contact"
                label="Liên hệ"
                placeholder="+1 9876543210"
              />
            </VCol>

            <!-- 👉 Ngôn ngữ -->
            <!-- <VCol cols="12" md="6">
              <VSelect
                v-model="userData.language"
                :items="['English', 'Spanish', 'French']"
                label="Ngôn ngữ"
                placeholder="English"
                chips
                closable-chips
                multiple
              />
            </VCol> -->

            <!-- 👉 Quốc gia -->
            <!-- <VCol cols="12" md="6">
              <VSelect
                v-model="userData.country"
                :items="['United States', 'United Kingdom', 'France']"
                label="Quốc gia"
                placeholder="United States"
              />
            </VCol> -->

            <!-- 👉 Công tắc -->
            <VCol cols="12">
              <VSwitch density="compact" label="Sử dụng địa chỉ thanh toán?" />
            </VCol>

            <!-- 👉 Lưu và Huỷ -->
            <VCol cols="12" class="d-flex flex-wrap justify-center gap-4">
              <VBtn type="submit"> Lưu </VBtn>

              <VBtn color="secondary" variant="outlined" @click="onFormReset">
                Huỷ
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>
</template>

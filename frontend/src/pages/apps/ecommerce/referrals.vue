<script setup lang="ts">
import type { Referrals } from "@db/apps/ecommerce/types";
import paperImg from "@images/svg/paper.svg?raw";
import rocketImg from "@images/svg/rocket.svg?raw";
import userInfoImg from "@images/svg/user-info.svg?raw";
import { VNodeRenderer } from "@layouts/components/VNodeRenderer";

const rocketIcon = h("div", {
  innerHTML: rocketImg,
  style: "font-size: 2.625rem; color: rgb(var(--v-theme-primary))",
});
const userInfoIcon = h("div", {
  innerHTML: paperImg,
  style: "font-size: 2.625rem; color: rgb(var(--v-theme-primary))",
});
const paperIcon = h("div", {
  innerHTML: userInfoImg,
  style: "font-size: 2.625rem; color: rgb(var(--v-theme-primary))",
});

const widgetData = [
  {
    title: "Tổng Thu Nhập",
    value: "$24,983",
    icon: "ri-money-dollar-circle-line",
    color: "primary",
  },
  {
    title: "Thu Nhập Chưa Thanh Toán",
    value: "$8,647",
    icon: "ri-gift-line",
    color: "success",
  },
  {
    title: "Người Đăng Ký",
    value: "2,367",
    icon: "ri-group-line",
    color: "error",
  },
  {
    title: "Tỷ Lệ Chuyển Đổi",
    value: "4.5%",
    icon: "ri-refresh-line",
    color: "info",
  },
];

const stepsData = [
  {
    icon: rocketIcon,
    desc: "Tạo & xác nhận liên kết giới thiệu của bạn và nhận",
    value: "$50",
  },
  {
    icon: paperIcon,
    desc: "Đối với mỗi người đăng ký mới bạn nhận được",
    value: "10%",
  },
  {
    icon: userInfoIcon,
    desc: "Làm cho bạn bè khác tạo liên kết và nhận",
    value: "$100",
  },
];

// Các tùy chọn cho bảng dữ liệu
const itemsPerPage = ref(10);
const page = ref(1);
const sortBy = ref();
const orderBy = ref();

// Tiêu đề của bảng dữ liệu
const headers = [
  { title: "Người Dùng", key: "users" },
  { title: "Mã người giới thiệu", key: "referred-id" },
  { title: "Trạng Thái", key: "status" },
  { title: "Giá Trị", key: "value" },
  { title: "Thu Nhập", key: "earning" },
];

// Cập nhật các tùy chọn của bảng dữ liệu
const updateOptions = (options: any) => {
  page.value = options.page;
  sortBy.value = options.sortBy[0]?.key;
  orderBy.value = options.sortBy[0]?.order;
};

// Lấy dữ liệu giới thiệu từ API
const { data: referralData } = await useApi<any>(
  createUrl("/apps/ecommerce/referrals", {
    query: {
      page,
      itemsPerPage,
      sortBy,
      orderBy,
    },
  })
);

const referrals = computed((): Referrals[] => referralData.value.referrals);
const totalReferrals = computed(() => referralData.value.total);

// Hàm xử lý trạng thái
const resolveStatus = (status: string) => {
  if (status === "Rejected") return { text: "Từ chối", color: "error" };
  if (status === "Unpaid") return { text: "Chưa thanh toán", color: "warning" };
  if (status === "Paid") return { text: "Đã thanh toán", color: "success" };
};
</script>

<template>
  <div>
    <!-- 👉 Header -->
    <VRow class="match-height">
      <!-- 👉 Widgets -->
      <VCol
        v-for="(data, index) in widgetData"
        :key="index"
        cols="12"
        md="3"
        sm="6"
      >
        <VCard>
          <VCardText>
            <div class="d-flex align-center justify-space-between">
              <div class="d-flex flex-column">
                <span class="text-h5 mb-1">{{ data.value }}</span>
                <span class="text-sm">{{ data.title }}</span>
              </div>
              <VAvatar :icon="data.icon" variant="tonal" :color="data.color" />
            </div>
          </VCardText>
        </VCard>
      </VCol>

      <!-- 👉 Icon Steps -->
      <VCol cols="12" md="8">
        <VCard>
          <VCardItem>
            <VCardTitle> Cách Sử Dụng</VCardTitle>
            <VCardSubtitle>
              Tích hợp mã giới thiệu của bạn trong 3 bước dễ dàng.
            </VCardSubtitle>
          </VCardItem>

          <VCardText>
            <div
              class="d-flex gap-6 justify-space-between align-center flex-sm-row flex-column"
            >
              <div
                v-for="(step, index) in stepsData"
                :key="index"
                class="d-flex flex-column align-center gap-y-2"
                style="max-inline-size: 185px"
              >
                <div class="icon-container">
                  <VNodeRenderer :nodes="step.icon" />
                </div>
                <span class="text-body-1 text-wrap text-center">
                  {{ step.desc }}
                </span>
                <span class="text-primary text-h6">{{ step.value }}</span>
              </div>
            </div>
          </VCardText>
        </VCard>
      </VCol>

      <!-- 👉 Invite -->
      <VCol cols="12" md="4">
        <VCard>
          <VCardText>
            <div class="mb-11">
              <h5 class="text-h5 mb-5">Mời bạn bè của bạn</h5>
              <div class="d-flex align-center flex-wrap gap-4">
                <VTextField placeholder="Địa chỉ Email" density="compact" />
                <VBtn>
                  <VIcon start icon="ri-check-line" />
                  Gửi
                </VBtn>
              </div>
            </div>

            <div>
              <h5 class="text-h5 mb-5">Chia sẻ liên kết giới thiệu</h5>
              <div class="d-flex align-center flex-wrap gap-4">
                <VTextField
                  placeholder="web89.com/?ref=6478"
                  density="compact"
                />
                <!-- <div class="d-flex gap-x-2">
                  <VBtn icon class="rounded" color="#3B5998">
                    <VIcon color="white" icon="ri-facebook-circle-line" />
                  </VBtn>

                  <VBtn icon class="rounded" color="#55ACEE">
                    <VIcon color="white" icon="ri-twitter-line" />
                  </VBtn>
                </div> -->
              </div>
            </div>
          </VCardText>
        </VCard>
      </VCol>

      <!-- 👉 Referral Table -->

      <VCol cols="12">
        <VCard>
          <VCardText>
            <div
              class="d-flex justify-space-between align-center flex-wrap gap-4"
            >
              <h5 class="text-h5">Người dùng đã giới thiệu</h5>
              <VBtn prepend-icon="ri-upload-2-line"> Xuất file </VBtn>
            </div>
          </VCardText>

          <VDataTableServer
            v-model:items-per-page="itemsPerPage"
            v-model:page="page"
            :items="referrals"
            :headers="headers"
            :items-length="totalReferrals"
            show-select
            class="text-high-emphasis"
            @update:options="updateOptions"
          >
            <template #item.users="{ item }">
              <div class="d-flex align-center gap-x-4">
                <VAvatar :image="item.avatar" :size="34" />
                <div>
                  <h6 class="text-h6">
                    <RouterLink
                      class="text-high-emphasis"
                      :to="{
                        name: 'apps-ecommerce-customer-details-id',
                        params: { id: 478426 },
                      }"
                    >
                      {{ item.user }}
                    </RouterLink>
                  </h6>

                  <div class="text-sm text-medium-emphasis">
                    {{ item.email }}
                  </div>
                </div>
              </div>
            </template>

            <template #item.referred-id="{ item }">
              {{ item.referredId }}
            </template>

            <template #item.status="{ item }">
              <VChip v-bind="resolveStatus(item.status)" size="small" />
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
                  {{ paginationMeta({ page, itemsPerPage }, totalReferrals) }}
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
                    :disabled="page >= Math.ceil(totalReferrals / itemsPerPage)"
                    @click="
                      page >= Math.ceil(totalReferrals / itemsPerPage)
                        ? (page = Math.ceil(totalReferrals / itemsPerPage))
                        : page++
                    "
                  />
                </div>
              </div>
            </template>
          </VDataTableServer>
        </VCard>
      </VCol>
    </VRow>
  </div>
</template>

<style lang="scss" scoped>
.icon-container {
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px dashed rgb(var(--v-theme-primary));
  border-radius: 50%;
  block-size: 70px;
  inline-size: 70px;
}

.icon {
  color: #000;
  font-size: 42px;
}
</style>

<script setup lang="ts">
const statistics = [
  {
    title: "Sales",
    stats: "245k",
    icon: "ri-pie-chart-2-line",
    color: "primary",
  },
  {
    title: "Khách hàng",
    stats: "12.5k",
    icon: "ri-group-line",
    color: "success",
  },
  {
    title: "Sản phẩm",
    stats: "1.54k",
    icon: "ri-macbook-line",
    color: "warning",
  },
  {
    title: "Doanh thu",
    stats: "$88k",
    icon: "ri-money-dollar-circle-line",
    color: "info",
  },
];
</script>

<template>
  <VCard title="Giao dịch">
    <template #subtitle>
      <p class="text-body-1 mb-0">
        <span class="d-inline-block font-weight-medium text-high-emphasis"
          >Toàn bộ 48.5% tăng trưởng</span
        >
        <span class="text-high-emphasis">😎</span> tháng này
      </p>
    </template>

    <template #append>
      <IconBtn class="mt-n5">
        <VIcon color="high-emphasis" icon="ri-more-2-line" />
      </IconBtn>
    </template>

    <VCardText class="pt-10">
      <VRow>
        <VCol
          v-for="item in statistics"
          :key="item.title"
          cols="12"
          sm="6"
          md="3"
        >
          <div class="d-flex align-center gap-x-3">
            <VAvatar :color="item.color" rounded size="40" class="elevation-2">
              <VIcon size="24" :icon="item.icon" />
            </VAvatar>

            <div class="d-flex flex-column">
              <div class="text-body-1">
                {{ item.title }}
              </div>
              <h5 class="text-h5">
                {{ item.stats }}
              </h5>
            </div>
          </div>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>

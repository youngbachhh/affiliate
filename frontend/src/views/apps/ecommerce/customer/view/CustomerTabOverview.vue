<script setup lang="ts">
import CustomerOrderTable from "./CustomerOrderTable.vue";
</script>

<template>
  <VRow class="match-height">
    <VCol cols="12" md="6">
      <VCard>
        <VCardText class="d-flex gap-y-2 flex-column">
          <VAvatar
            variant="tonal"
            color="primary"
            icon="ri-money-dollar-circle-line"
            rounded
          />
          <h6 class="text-lg font-weight-medium">Số dư Tài khoản</h6>
          <div class="text-base">
            <p class="mb-0">
              <span class="text-primary font-weight-medium text-lg me-1"
                >$7480</span
              >
              Dư nợ
            </p>
            <p class="mb-0 text-base">
              Số dư tài khoản cho giao dịch tiếp theo
            </p>
          </div>
        </VCardText>
      </VCard>
    </VCol>

    <VCol cols="12" md="6">
      <VCard>
        <VCardText class="d-flex gap-y-2 flex-column">
          <VAvatar
            variant="tonal"
            color="success"
            icon="ri-gift-line"
            rounded
          />
          <h6 class="text-lg font-weight-medium">
            Chương trình Khách hàng thân thiết
          </h6>
          <div>
            <VChip color="success" size="small" class="mb-2">
              Thành viên Bạch kim
            </VChip>

            <p class="mb-0 text-base">3000 điểm để lên hạng tiếp theo</p>
          </div>
        </VCardText>
      </VCard>
    </VCol>
    <!-- 
    <VCol cols="12" md="6">
      <VCard>
        <VCardText class="d-flex gap-y-2 flex-column">
          <VAvatar
            variant="tonal"
            color="warning"
            icon="ri-star-smile-line"
            rounded
          />
          <h6 class="text-lg font-weight-medium">Danh sách mong muốn</h6>
          <div>
            <p class="mb-0">
              <span class="text-warning font-weight-medium text-lg me-1"
                >15</span
              >
              mục trong danh sách mong muốn
            </p>
            <p class="mb-0 text-base">
              Nhận thông báo khi các mục được giảm giá
            </p>
          </div>
        </VCardText>
      </VCard>
    </VCol> -->

    <!-- <VCol cols="12" md="6">
      <VCard>
        <VCardText class="d-flex gap-y-2 flex-column">
          <VAvatar
            variant="tonal"
            color="info"
            icon="ri-vip-crown-line"
            rounded
          />
          <h6 class="text-lg font-weight-medium">Phiếu giảm giá</h6>
          <div>
            <p class="mb-0">
              <span class="text-info text-lg me-2">21</span>
              Phiếu giảm giá bạn đã nhận được
            </p>
            <p class="mb-0 text-base">
              Sử dụng phiếu giảm giá cho giao dịch tiếp theo
            </p>
          </div>
        </VCardText>
      </VCard>
    </VCol> -->

    <VCol>
      <CustomerOrderTable />
    </VCol>
  </VRow>
</template>

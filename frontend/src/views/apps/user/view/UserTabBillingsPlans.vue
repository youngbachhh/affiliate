<script setup lang="ts">
import americanExpress from "@images/icons/payments/american-express.png";
import mastercard from "@images/icons/payments/mastercard.png";
import visa from "@images/icons/payments/visa.png";

interface CardDetail {
  name: string;
  number: string;
  expiry: string;
  isPrimary: boolean;
  type: string;
  cvv: string;
  image: string;
}

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

const isUpgradePlanDialogVisible = ref(false);

const currentCardDetails = ref();
const isCardEditDialogVisible = ref(false);
const isCardAddDialogVisible = ref(false);
const isEditAddressDialogVisible = ref(false);

const openEditCardDialog = (cardDetails: CardDetail) => {
  currentCardDetails.value = cardDetails;

  isCardEditDialogVisible.value = true;
};

const creditCards: CardDetail[] = [
  {
    name: "Tom McBride",
    number: "4851234567899865",
    expiry: "12/24",
    isPrimary: true,
    type: "mastercard",
    cvv: "123",
    image: mastercard,
  },
  {
    name: "Mildred Wagner",
    number: "5531234567895678",
    expiry: "02/24",
    isPrimary: false,
    type: "visa",
    cvv: "456",
    image: visa,
  },
  {
    name: "Lester Jennings",
    number: "5531234567890002",
    expiry: "08/20",
    isPrimary: false,
    type: "visa",
    cvv: "456",
    image: americanExpress,
  },
];

const currentBillingAddress = {
  companyName: "Web89",
  billingEmail: "gertrude@gmail.com",
  taxID: "TAX-875623",
  vatNumber: "SDF754K77",
  address: "100 Water Plant Avenue, Building 1303 Wake Island",
  contact: "+1(609) 933-44-22",
  country: "USA",
  state: "Queensland",
  zipCode: 403114,
};

const editBillingData: BillingAddress = {
  firstName: "Gertrude",
  lastName: "Jennings",
  selectedCountry: "USA",
  addressLine1: "100 Water Plant Avenue",
  addressLine2: "Building 1303 Wake Island",
  landmark: "Near Wake Island",
  contact: "+1(609) 933-44-22",
  country: "USA",
  state: "Queensland",
  zipCode: 403114,
};
</script>

<template>
  <VRow>
    <!-- 👉 Gói hiện tại -->
    <!-- <VCol cols="12">
      <VCard title="Gói hiện tại">
        <VCardText>
          <VRow>
            <VCol cols="12" md="6">
              <h6 class="text-h6 mb-1">Gói hiện tại của bạn là Basic</h6>
              <p>Khởi đầu đơn giản cho mọi người</p>

              <h6 class="text-h6 mb-1">Kích hoạt đến ngày 09 tháng 12, 2021</h6>
              <p>Chúng tôi sẽ gửi thông báo khi gói đăng ký của bạn hết hạn</p>

              <h6 class="text-h6 mb-1">
                <span class="me-3">$199 Mỗi tháng</span>
                <VChip color="primary" size="small"> Phổ biến </VChip>
              </h6>
              <p class="mb-0">Gói tiêu chuẩn cho các doanh nghiệp vừa và nhỏ</p>
            </VCol>

            <VCol cols="12" md="6">
              <VAlert
                color="warning"
                variant="tonal"
                icon="ri-alert-line"
                closable
              >
                <VAlertTitle>Chúng tôi cần sự chú ý của bạn!</VAlertTitle>
                <span>Gói của bạn cần được cập nhật</span>
              </VAlert>

              <div
                class="d-flex justify-space-between font-weight-bold mt-4 mb-1"
              >
                <h6 class="text-h6">Ngày</h6>
                <h6 class="text-h6">26 trên 30 ngày</h6>
              </div>

              <VProgressLinear
                rounded
                color="primary"
                :height="10"
                :model-value="75"
              />
              <p class="text-sm mt-1">Gói của bạn cần được cập nhật</p>
            </VCol>

            <VCol cols="12">
              <div class="d-flex flex-wrap gap-4">
                <VBtn @click="isUpgradePlanDialogVisible = true">
                  nâng cấp gói
                </VBtn>

                <VBtn color="error" variant="outlined"> Hủy đăng ký </VBtn>
              </div>
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol> -->

    <!-- 👉 Phương thức thanh toán -->
    <VCol cols="12">
      <VCard title="Phương thức thanh toán">
        <template #append>
          <VBtn
            size="small"
            prepend-icon="ri-add-line"
            @click="isCardAddDialogVisible = !isCardAddDialogVisible"
          >
            Thêm thẻ
          </VBtn>
        </template>

        <VCardText class="d-flex flex-column gap-y-4">
          <VCard v-for="card in creditCards" :key="card.name" border flat>
            <VCardText class="d-flex flex-sm-row flex-column">
              <div class="text-no-wrap">
                <VImg
                  :src="card.image"
                  max-width="90"
                  width="auto"
                  :height="25"
                />
                <h6 class="text-h6 my-2">
                  {{ card.name }}
                  <VChip v-if="card.isPrimary" color="primary" size="small">
                    Chính
                  </VChip>
                </h6>
                <span class="text-body-1"
                  >**** **** ****
                  {{ card.number.substring(card.number.length - 4) }}</span
                >
              </div>

              <VSpacer />

              <div class="d-flex flex-column text-sm-end">
                <div class="order-sm-0 order-1">
                  <VBtn
                    variant="outlined"
                    class="me-4"
                    size="small"
                    @click="openEditCardDialog(card)"
                  >
                    Chỉnh sửa
                  </VBtn>
                  <VBtn color="error" size="small" variant="outlined">
                    Xóa
                  </VBtn>
                </div>
                <span class="text-body-2 my-4 order-sm-1 order-0"
                  >Thẻ hết hạn vào {{ card.expiry }}</span
                >
              </div>
            </VCardText>
          </VCard>
        </VCardText>
      </VCard>
    </VCol>

    <VCol cols="12">
      <!-- 👉 Địa chỉ thanh toán -->
      <VCard title="Địa chỉ thanh toán">
        <template #append>
          <VBtn
            size="small"
            prepend-icon="ri-add-line"
            @click="isEditAddressDialogVisible = !isEditAddressDialogVisible"
          >
            Chỉnh sửa địa chỉ
          </VBtn>
        </template>

        <VCardText>
          <VRow>
            <VCol cols="12" lg="6">
              <VTable class="billing-address-table">
                <tr>
                  <td>
                    <h6 class="text-h6 text-no-wrap mb-2">Tên công ty:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-2">
                      {{ currentBillingAddress.companyName }}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h6 class="text-h6 text-no-wrap mb-2">Email thanh toán:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-2">
                      {{ currentBillingAddress.billingEmail }}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h6 class="text-h6 text-no-wrap mb-2">Mã số thuế:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-2">
                      {{ currentBillingAddress.taxID }}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h6 class="text-h6 text-no-wrap mb-2">Mã số VAT:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-2">
                      {{ currentBillingAddress.vatNumber }}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td class="d-flex align-baseline">
                    <h6 class="text-h6 text-no-wrap">Địa chỉ thanh toán:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-0">
                      {{ currentBillingAddress.address }}
                    </p>
                  </td>
                </tr>
              </VTable>
            </VCol>

            <VCol cols="12" lg="6">
              <VTable class="billing-address-table">
                <tr>
                  <td>
                    <h6 class="text-h6 text-no-wrap mb-2">Liên hệ:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-2">
                      {{ currentBillingAddress.contact }}
                    </p>
                  </td>
                </tr>
                <!-- <tr>
                  <td>
                    <h6 class="text-h6 text-no-wrap mb-2">Quốc gia:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-2">
                      {{ currentBillingAddress.country }}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h6 class="text-h6 text-no-wrap mb-2">Bang:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-2">
                      {{ currentBillingAddress.state }}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h6 class="text-h6 text-no-wrap">Mã bưu điện:</h6>
                  </td>
                  <td>
                    <p class="text-body-1 mb-0">
                      {{ currentBillingAddress.zipCode }}
                    </p>
                  </td>
                </tr> -->
              </VTable>
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>

  <!-- 👉 Chỉnh sửa thẻ Dialog -->
  <CardAddEditDialog
    v-model:isDialogVisible="isCardEditDialogVisible"
    :card-details="currentCardDetails"
  />

  <!-- 👉 Thêm thẻ Dialog -->
  <CardAddEditDialog v-model:isDialogVisible="isCardAddDialogVisible" />

  <!-- 👉 Chỉnh sửa địa chỉ Dialog -->
  <AddEditAddressDialog
    v-model:isDialogVisible="isEditAddressDialogVisible"
    :billing-address="editBillingData"
  />

  <!-- 👉 Nâng cấp gói Dialog -->
  <UserUpgradePlanDialog v-model:isDialogVisible="isUpgradePlanDialogVisible" />
</template>

<style lang="scss">
.billing-address-table {
  tr {
    td:first-child {
      inline-size: 148px;
    }
  }
}
</style>

<script setup lang="ts">
import { deleteCategory } from "@/api/categories";
import { useCategories } from "@/composables/useCategories";
import { useFormatCurrency } from "@/composables/useFormatting";
import { Category } from "@/types/category";
import ECommerceAddCategoryDrawer from "@/views/apps/ecommerce/EcommerceAddCategoryDrawer.vue";

const { categoryData, fetchCategories } = useCategories();

const headers = [
  { title: "Danh mục", key: "name" },
  { title: "Tất cả sản phẩm", key: "products_count", align: "end" },
  { title: "Tổng thu nhập", key: "revenue", align: "end" },
  { title: "Hành động", key: "actions", sortable: false },
];

const itemsPerPage = ref(10);
const searchQuery = ref("");
const isAddCategoryDrawerOpen = ref(false);
const isEditCategoryDialogOpen = ref(false);
const isConfirmDialogVisible = ref(false);
const page = ref(1);

const snackBar = ref({
  text: "",
  color: "",
  timeout: 0,
  isSnackbarTopVisible: false,
});

const updateSnackBar = (snackBarData: any) => {
  snackBar.value = snackBarData;
};

// Update data table options
const updateOptions = (options: any) => {
  page.value = options.page;
};

const handleCategoryAdded = () => {
  fetchCategories();
};

const handleDialogVisible = (isVisible: boolean) => {
  isEditCategoryDialogOpen.value = isVisible;
};

const selectedCategory = ref<Category>();

const setSelectCategory = (category: Category) => {
  selectedCategory.value = category;
};

const editItem = (item: Category) => {
  setSelectCategory(item);
  isEditCategoryDialogOpen.value = !isEditCategoryDialogOpen.value;
};

const deleteItem = async (item: Category) => {
  try {
    await deleteCategory(item.id);
  } catch (error) {
    console.error("Failed to delete category:", error);
  } finally {
    fetchCategories();
  }
};
</script>

<template>
  <div>
    <VCard>
      <VCardText>
        <div
          class="d-flex justify-md-space-between flex-wrap gap-4 justify-center"
        >
          <VTextField
            v-model="searchQuery"
            placeholder="Tìm kiếm"
            density="compact"
            style="max-inline-size: 280px; min-inline-size: 200px"
          />

          <div class="d-flex align-center flex-wrap gap-4">
            <VBtn
              prepend-icon="ri-upload-2-line"
              color="secondary"
              variant="outlined"
            >
              Xuất file
            </VBtn>
            <VBtn
              prepend-icon="ri-add-line"
              @click="isAddCategoryDrawerOpen = !isAddCategoryDrawerOpen"
            >
              Thêm danh mục
            </VBtn>
          </div>
        </div>
      </VCardText>

      <VDataTable
        v-model:items-per-page="itemsPerPage"
        :headers="headers as any"
        :page="page"
        :items="categoryData"
        item-value="name"
        :search="searchQuery"
        show-select
        class="text-no-wrap category-table"
        @update:options="updateOptions"
      >
        <template v-slot:item.actions="{ item }">
          <IconBtn size="small">
            <VIcon icon="ri-edit-box-line" @click="editItem(item)" />
          </IconBtn>
          <IconBtn size="small">
            <VIcon
              icon="ri-delete-bin-2-line"
              @click="
                () => {
                  setSelectCategory(item);
                  isConfirmDialogVisible = !isConfirmDialogVisible;
                }
              "
            />
          </IconBtn>

          <!-- <MoreBtn
            size="small"
            :menu-list="[
              {
                title: 'Tải xuống',
                value: 'download',
                prependIcon: 'ri-download-line',
              },
              {
                title: 'Sửa',
                value: 'edit',
                prependIcon: 'ri-pencil-line',
              },
              {
                title: 'Nhân bản',
                value: 'duplicate',
                prependIcon: 'ri-stack-line',
              },
            ]"
            item-props
          /> -->
        </template>

        <template #item.name="{ item }">
          <div class="d-flex gap-x-3">
            <!-- <VAvatar variant="tonal" rounded size="38">
              <img
                :src="item.image"
                :alt="item.name"
                width="38"
                height="38"
              />
            </VAvatar> -->
            <div class="py-2">
              <p class="text-high-emphasis font-weight-medium">
                {{ item.name }}
              </p>
              <div class="text-body-2" v-html="item.description"></div>
            </div>
          </div>
        </template>

        <template #item.revenue="{ item }">
          <div class="text-end pe-4">
            {{ useFormatCurrency(item.revenue ?? 0) }}
          </div>
        </template>

        <template #item.products_count="{ item }">
          <div class="text-end pe-4">
            {{ (item.products_count ?? 0).toLocaleString() }}
          </div>
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
              {{
                paginationMeta(
                  { page, itemsPerPage },
                  categoryData?.length ?? 0
                )
              }}
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
                :disabled="
                  page >= Math.ceil((categoryData?.length ?? 0) / itemsPerPage)
                "
                @click="
                  page >= Math.ceil(categoryData?.length ?? 0 / itemsPerPage)
                    ? (page = Math.ceil(
                        categoryData?.length ?? 0 / itemsPerPage
                      ))
                    : page++
                "
              />
            </div>
          </div>
        </template>
      </VDataTable>
    </VCard>

    <ECommerceAddCategoryDrawer
      v-model:isDrawerOpen="isAddCategoryDrawerOpen"
      @categoryAdded="handleCategoryAdded"
      :snackBar="snackBar"
      @update:snackBar="updateSnackBar"
    />

    <EditCategoryDialog
      @update:isDialogVisible="handleDialogVisible"
      v-model:isDialogVisible="isEditCategoryDialogOpen"
      :category="selectedCategory"
      :snackBar="snackBar"
      @update:snackBar="updateSnackBar"
    />

    <ConfirmDialog
      v-model:isDialogVisible="isConfirmDialogVisible"
      confirmation-question="Bạn chắc chắn muốn xóa Danh mục này?"
      cancel-msg="Hủy xóa Danh mục!!"
      cancel-title="Đã hủy"
      confirm-msg="Đã xóa thành công Danh mục"
      confirm-title="Đã xóa!"
      @confirm="selectedCategory && deleteItem(selectedCategory)"
    />

    <VSnackbar
      v-model="snackBar.isSnackbarTopVisible"
      location="top"
      :color="snackBar.color"
      :timeout="snackBar.timeout"
    >
      {{ snackBar.text }}
    </VSnackbar>
  </div>
</template>

<style lang="scss">
.ProseMirror-focused {
  border: none;
}

.category-table.v-table.v-data-table {
  .v-table__wrapper {
    table {
      thead {
        tr {
          th.v-data-table-column--align-end {
            .v-data-table-header__content {
              flex-direction: row;
              justify-content: end;
            }
          }
        }
      }
    }
  }
}
</style>

<script lang="ts" setup>
import { updateCategory } from "@/api/categories";
import { Category } from "@/types/category";

interface Props {
  isDialogVisible: boolean;
  category?: Category;
  snackBar?: SnackBar;
}

interface Emit {
  (e: "update:isDialogVisible", value: boolean): void;
  (e: "update:snackBar", value: SnackBar): void;
}

interface SnackBar {
  text: string;
  color: string;
  timeout: number;
  isSnackbarTopVisible: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  category: () => ({
    id: 0,
    name: "",
    description: "",
  }),
});

const emit = defineEmits<Emit>();

const onSubmit = async () => {
  try {
    await updateCategory(props.category.id, props.category);
    emit("update:snackBar", {
      text: "Cập nhật danh mục thành công",
      color: "success",
      timeout: 3000,
      isSnackbarTopVisible: true,
    });
    handleDialogVisible(false);
  } catch (error) {
    emit("update:snackBar", {
      text: "Cập nhật danh mục thất bại",
      color: "error",
      timeout: 3000,
      isSnackbarTopVisible: true,
    });
    return;
  }
};

const handleDialogVisible = (isVisible: boolean) => {
  emit("update:isDialogVisible", isVisible);
};
</script>

<template>
  <VDialog :model-value="props.isDialogVisible" max-width="600" persistent>
    <!-- Dialog Content -->
    <VCard title="Cập nhật Danh mục">
      <VCardText>
        <VRow>
          <VCol cols="12">
            <VTextField
              v-model="props.category.name"
              label="Tiêu đề"
              placeholder="Nước hoa"
            />
          </VCol>
          <VCol cols="12">
            <v-textarea
              label="Mô tả"
              v-model="props.category.description"
              variant="outlined"
            ></v-textarea>
          </VCol>
        </VRow>
      </VCardText>

      <VCardActions>
        <VSpacer />
        <VBtn color="error" @click="handleDialogVisible(false)"> Hủy </VBtn>
        <VBtn color="success" @click="onSubmit"> Lưu </VBtn>
      </VCardActions>
    </VCard>
  </VDialog>
</template>

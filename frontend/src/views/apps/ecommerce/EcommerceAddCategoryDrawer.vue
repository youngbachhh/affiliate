<script setup lang="ts">
import { createCategory } from "@/api/categories";
// import { Image } from "@tiptap/extension-image";
// import { Placeholder } from "@tiptap/extension-placeholder";
// import { Underline } from "@tiptap/extension-underline";
// import { StarterKit } from "@tiptap/starter-kit";
// import { useEditor } from "@tiptap/vue-3";
import { CategoryCreateDTO } from "@/types/category";
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import { VForm } from "vuetify/components/VForm";

interface Props {
  isDrawerOpen: boolean;
  snackBar?: SnackBar;
}

interface Emit {
  (e: "update:isDrawerOpen", value: boolean): void;
  (e: "categoryAdded"): void;
  (e: "update:snackBar", value: SnackBar): void;
}

interface SnackBar {
  text: string;
  color: string;
  timeout: number;
  isSnackbarTopVisible: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits<Emit>();

const handleDrawerModelValueUpdate = (val: boolean) => {
  emit("update:isDrawerOpen", val);
};

// const editor = useEditor({
//   content: "",
//   extensions: [
//     StarterKit,
//     Image,
//     Placeholder.configure({
//       placeholder: "Mô tả",
//     }),
//     Underline,
//   ],
// });

// const addImage = () => {
//   const url = window.prompt("URL");

//   if (url) editor.value?.chain().focus().setImage({ src: url }).run();
// };

const refVForm = ref<VForm>();
const categoryTitle = ref();
const categoryDescription = ref();
const categorySlug = ref();
const categoryImg = ref();
const parentCategory = ref();
const parentStatus = ref();

const resetForm = () => {
  emit("update:isDrawerOpen", false);
  refVForm.value?.reset();
  // editor.value?.commands.clearContent();
};

const addCategory = async () => {
  try {
    const category: CategoryCreateDTO = {
      name: categoryTitle.value,
      description: categoryDescription.value,
    };
    await createCategory(category);
    emit("update:snackBar", {
      text: "Danh mục đã được thêm!",
      color: "success",
      timeout: 3000,
      isSnackbarTopVisible: true,
    });

    resetForm();
    emit("categoryAdded");
  } catch (error) {
    emit("update:snackBar", {
      text: "Danh mục dã tồn tại!",
      color: "error",
      timeout: 3000,
      isSnackbarTopVisible: true,
    });

    return;
  }
};
</script>

<template>
  <VNavigationDrawer
    :model-value="props.isDrawerOpen"
    temporary
    location="end"
    width="370"
    class="category-navigation-drawer scrollable-content"
    @update:model-value="handleDrawerModelValueUpdate"
  >
    <!-- 👉 Header -->
    <AppDrawerHeaderSection
      title="Thêm danh mục"
      @cancel="$emit('update:isDrawerOpen', false)"
    />
    <VDivider />

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <VForm ref="refVForm" @submit.prevent="">
            <VRow>
              <VCol cols="12">
                <VTextField
                  v-model="categoryTitle"
                  label="Tiêu đề"
                  :rules="[requiredValidator]"
                  placeholder="Nước hoa"
                />
              </VCol>

              <!-- <VCol cols="12">
                <VTextField
                  v-model="categorySlug"
                  label="Slug"
                  :rules="[requiredValidator]"
                  placeholder="Trends fashion"
                />
              </VCol> -->

              <!-- <VCol cols="12">
                <VFileInput
                  v-model="categoryImg"
                  prepend-icon=""
                  :rules="[requiredValidator]"
                  density="compact"
                  label="No file chosen"
                  clearable
                >
                  <template #append>
                    <VBtn variant="outlined"> Choose </VBtn>
                  </template>
                </VFileInput>
              </VCol> -->

              <!-- <VCol cols="12">
                <VSelect
                  v-model="parentCategory"
                  :rules="[requiredValidator]"
                  label="Parent Category"
                  placeholder="Select Parent Category"
                  :items="[
                    'HouseHold',
                    'Management',
                    'Electronics',
                    'Office',
                    'Accessories',
                  ]"
                />
              </VCol> -->

              <VCol cols="12">
                <VTextarea
                  label="Mô tả"
                  v-model="categoryDescription"
                  variant="outlined"
                ></VTextarea>
              </VCol>

              <!-- <VCol cols="12">
                <VSelect
                  v-model="parentStatus"
                  :rules="[requiredValidator]"
                  placeholder="Select Category Status"
                  label="Parent Status"
                  :items="['Published', 'Inactive', 'Scheduled']"
                />
              </VCol> -->

              <VCol cols="12">
                <div class="d-flex justify-start">
                  <VBtn
                    type="submit"
                    color="primary"
                    class="me-4"
                    @click="addCategory"
                  >
                    Thêm
                  </VBtn>
                  <VBtn color="error" variant="outlined" @click="resetForm">
                    Hủy
                  </VBtn>
                </div>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>

<style lang="scss">
.category-navigation-drawer {
  .ProseMirror {
    padding: 0.5rem;
    block-size: auto;
    min-block-size: 6.25rem;

    p {
      margin-block-end: 0;
    }

    p.is-editor-empty:first-child::before {
      block-size: 0;
      color: #adb5bd;
      content: attr(data-placeholder);
      float: inline-start;
      pointer-events: none;
    }
  }

  .is-active {
    border-color: rgba(
      var(--v-theme-primary),
      var(--v-border-opacity)
    ) !important;
    background-color: rgba(var(--v-theme-primary), var(--v-activated-opacity));
    color: rgb(var(--v-theme-primary));
  }

  .ProseMirror-focused {
    outline: none !important;
  }

  .tiptap-editor-wrapper {
    border: 1px solid rgba(var(--v-border-color), 0.22);

    &:hover {
      border-color: rgba(var(--v-border-color), 0.6);
    }
  }
}
</style>

<script lang="ts" setup>
interface Props {
  menuList?: unknown[];
  itemProps?: boolean;
}

interface Emit {
  (e: "update:isDialogVisible", value: boolean): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emit>();

const handleSelected = (item: unknown) => {
  switch ((item as any).id) {
    case "edit":
      console.log(item);
      emit("update:isDialogVisible", true);
      break;
    case "delete":
      console.log("Delete");
      break;
    default:
      break;
  }
};
</script>

<template>
  <IconBtn>
    <VIcon icon="ri-more-2-line" />

    <VMenu v-if="props.menuList" activator="parent">
      <VList
        :items="props.menuList"
        :item-props="props.itemProps"
        @click:select="handleSelected"
      />
    </VMenu>
  </IconBtn>
</template>

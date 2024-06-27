import { getCategories } from "@/api/categories";
import { Category } from "@/types/category";
import { onMounted, ref } from "vue";

export function useCategories() {
  const categoryData = ref<Category[]>();
  const categorySelect = ref<
    {
      title: string;
      value: number;
    }[]
  >();

  const fetchCategories = async () => {
    try {
      const fetchedCategories = await getCategories();
      categoryData.value = fetchedCategories.map((category) => ({
        ...category,
        products_count: category.products_count ?? 0,
        revenue: category.revenue ?? 0,
      }));

      categorySelect.value = fetchedCategories.map((category) => ({
        title: category.name,
        value: category.id,
      }));
    } catch (error) {
      console.error("Failed to fetch categories:", error);
    }
  };

  onMounted(fetchCategories);

  return {
    categoryData,
    categorySelect,
    fetchCategories,
  };
}

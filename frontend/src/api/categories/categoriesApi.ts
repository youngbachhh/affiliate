import { Category, CategoryCreateDTO } from "../../types/category";
import { handleApiError } from "../../utils/errorHandler";
import axiosClient from "../axiosClient";

export const getCategories = async (): Promise<Category[]> => {
  try {
    return await axiosClient.get("/categories");
  } catch (error) {
    handleApiError(error as Error);
    return [];
  }
};

export const getCategoryById = async (id: number): Promise<Category> => {
  try {
    return await axiosClient.get(`/categories/${id}`);
  } catch (error) {
    handleApiError(error as Error);
    return {} as Category;
  }
};

export const createCategory = async (
  categoryData: CategoryCreateDTO
): Promise<Category> => {
  try {
    return await axiosClient.post("/categories", categoryData);
  } catch (error) {
    handleApiError(error as Error);
    return {} as Category;
  }
};

export const updateCategory = async (
  id: number,
  categoryData: Category
): Promise<Category> => {
  try {
    return await axiosClient.put(`/categories/${id}`, categoryData);
  } catch (error) {
    handleApiError(error as Error);
    return {} as Category;
  }
};

export const deleteCategory = async (id: number): Promise<void> => {
  try {
    await axiosClient.delete(`/categories/${id}`);
  } catch (error) {
    handleApiError(error as Error);
  }
};

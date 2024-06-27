import { Product, ProductCreateDTO } from "../../types/product";
import { handleApiError } from "../../utils/errorHandler";
import axiosClient from "../axiosClient";

export const getProducts = async (): Promise<Product[]> => {
  try {
    return await axiosClient.get("/products");
  } catch (error) {
    handleApiError(error as Error);
    return [];
  }
};

export const getProductById = async (id: number): Promise<Product> => {
  try {
    return await axiosClient.get(`/products/${id}`);
  } catch (error) {
    handleApiError(error as Error);
    return {} as Product;
  }
};

export const createProduct = async (
  productData: ProductCreateDTO
): Promise<Product> => {
  try {
    return await axiosClient.post("/products", productData);
  } catch (error) {
    handleApiError(error as Error);
    return {} as Product;
  }
};

export const updateProduct = async (
  id: number,
  productData: Product
): Promise<Product> => {
  try {
    return await axiosClient.put(`/products/${id}`, productData);
  } catch (error) {
    handleApiError(error as Error);
    return {} as Product;
  }
};

export const deleteProduct = async (id: number): Promise<void> => {
  try {
    await axiosClient.delete(`/products/${id}`);
  } catch (error) {
    handleApiError(error as Error);
  }
};

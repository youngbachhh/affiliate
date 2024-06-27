export interface Category {
  id: number;
  name: string;
  description?: string;
  products_count?: number;
  revenue?: number;
}

export interface CategoryCreateDTO {
  name: string;
  description?: string;
}

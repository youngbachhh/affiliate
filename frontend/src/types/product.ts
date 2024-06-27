export interface Product {
  id: number;
  name: string;
  price: number;
  quantity: number;
  status: string;
  description: string;
  in_stock: boolean;
  category_id: number;
  discount_id?: number;
  is_featured?: boolean;
  is_new_arrival?: boolean;
  commission_rate?: number;
}

export interface ProductCreateDTO {
  name: string;
  price: number;
  quantity: number;
  status: string;
  description: string;
  in_stock: boolean;
  category_id: number;
  discount_id?: number;
  is_featured?: boolean;
  is_new_arrival?: boolean;
  commission_rate?: number;
}

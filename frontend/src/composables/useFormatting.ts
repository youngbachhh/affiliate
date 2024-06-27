export const useFormatCurrency = (value: number) => {
  return Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(value);
};

export const formatCurrency = (value: number) => {
  return value.toLocaleString("vi-VN");
};

export const formatPercentage = (value: number) => {
  return `${value}%`;
};

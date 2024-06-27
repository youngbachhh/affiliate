export const parseCurrency = (value: string) => {
  return parseFloat(value.replace(/\./g, "").replace(",", "."));
};

export const parsePercentage = (value: string) => {
  const cleanedValue = value.replace("%", "").replace(",", ".");
  return parseFloat(cleanedValue);
};

export const handleApiError = (error: Error): void => {
  console.error("API call failed:", error.message);
  throw error;
};

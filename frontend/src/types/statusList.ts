interface Select {
  value: string;
  title: string;
}

export const productStatusList: Select[] = [
  { value: "inactive", title: "Không hoạt động" },
  { value: "published", title: "Đã xuất bản" },
  { value: "scheduled", title: "Đã lên lịch" },
];

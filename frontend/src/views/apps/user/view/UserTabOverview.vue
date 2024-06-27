<script lang="ts" setup>
import pdf from "@images/icons/project-icons/pdf.png";
import { useTheme } from "vuetify";
import UserInvoiceTable from "./UserInvoiceTable.vue";

// Images
import avatar2 from "@images/avatars/avatar-2.png";
import avatar3 from "@images/avatars/avatar-3.png";
import avatar4 from "@images/avatars/avatar-4.png";
import avatar5 from "@images/avatars/avatar-5.png";
import figma from "@images/icons/project-icons/figma.png";
import html5 from "@images/icons/project-icons/html5.png";
import python from "@images/icons/project-icons/python.png";
import react from "@images/icons/project-icons/react.png";
import sketch from "@images/icons/project-icons/sketch.png";
import vue from "@images/icons/project-icons/vue.png";
import xamarin from "@images/icons/project-icons/xamarin.png";

// Project Table Header
const projectTableHeaders = [
  { title: "DỰ ÁN", key: "name" },
  { title: "TỔNG SỐ TASK", key: "totalTask" },
  { title: "TIẾN ĐỘ", key: "progress" },
  { title: "GIỜ LÀM VIỆC", key: "hours" },
];

const { name } = useTheme();

const projects = [
  {
    logo: react,
    name: "Ứng dụng eCommerce BGC",
    project: "Dự án React",
    totalTask: "122/240",
    progress: 78,
    hours: "18:42",
  },
  {
    logo: figma,
    name: "Thiết kế Logo Falcon",
    project: "Dự án Figma",
    totalTask: "09/56",
    progress: 18,
    hours: "20:42",
  },
  {
    logo: vue,
    name: "Thiết kế Bảng điều khiển",
    project: "Dự án Vuejs",
    totalTask: "290/320",
    progress: 62,
    hours: "120:87",
  },
  {
    logo: xamarin,
    name: "Ứng dụng di động Foodista",
    project: "Dự án Xamarin",
    totalTask: "290/320",
    progress: 8,
    hours: "120:87",
  },
  {
    logo: python,
    name: "Ứng dụng Email Dojo",
    project: "Dự án Python",
    totalTask: "120/186",
    progress: 49,
    hours: "230:10",
  },
  {
    logo: sketch,
    name: "Website Blockchain",
    project: "Dự án Sketch",
    totalTask: "99/109",
    progress: 92,
    hours: "342:41",
  },
  {
    logo: html5,
    name: "Website Hoffman",
    project: "Dự án HTML",
    totalTask: "98/110",
    progress: 88,
    hours: "12:45",
  },
];

const resolveUserProgressVariant = (progress: number) => {
  if (progress <= 25) return "error";
  if (progress > 25 && progress <= 50) return "warning";
  if (progress > 50 && progress <= 75) return "primary";
  if (progress > 75 && progress <= 100) return "success";

  return "secondary";
};

const search = ref("");
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Danh sách Dự án">
        <template #append>
          <VTextField
            v-model="search"
            placeholder="Tìm kiếm Dự án"
            density="compact"
            style="inline-size: 10rem"
          />
        </template>
        <!-- 👉 Bảng Danh sách Dự án của Người dùng -->

        <!-- SECTION Bảng dữ liệu -->
        <VDataTable
          :search="search"
          :headers="projectTableHeaders"
          :items="projects"
          item-value="name"
          class="text-no-wrap rounded-0"
        >
          <!-- projects -->
          <template #item.name="{ item }">
            <div class="d-flex align-center">
              <VAvatar :size="34" class="me-3" :image="item.logo" />
              <div>
                <h6 class="text-h6 mb-0">
                  {{ item.name }}
                </h6>
                <p class="text-sm text-medium-emphasis mb-0">
                  {{ item.project }}
                </p>
              </div>
            </div>
          </template>

          <!-- total task -->
          <template #item.totalTask="{ item }">
            <div class="text-high-emphasis">
              {{ item.totalTask }}
            </div>
          </template>

          <!-- Tiến độ -->
          <template #item.progress="{ item }">
            <div class="text-high-emphasis">{{ item.progress }}%</div>
            <VProgressLinear
              :height="6"
              :model-value="item.progress"
              rounded
              :color="resolveUserProgressVariant(item.progress)"
            />
          </template>

          <!-- remove footer -->
          <!-- TODO refactor this after vuetify community gives answer -->
          <template #bottom />
        </VDataTable>
        <!-- !SECTION -->
      </VCard>
    </VCol>

    <VCol cols="12">
      <!-- 👉 Dòng thời gian Hoạt động của Người dùng -->
      <VCard title="Dòng thời gian Hoạt động của Người dùng">
        <VCardText>
          <VTimeline
            density="compact"
            align="start"
            truncate-line="both"
            :line-inset="8"
            class="v-timeline-density-compact"
          >
            <VTimelineItem dot-color="error" size="x-small">
              <div
                class="d-flex justify-space-between align-center flex-wrap gap-2 mb-3"
              >
                <span class="app-timeline-title">
                  Đã thanh toán 12 Hóa đơn
                </span>
                <span class="app-timeline-meta">12 phút trước</span>
              </div>

              <p class="app-timeline-text mb-2">
                Đã thanh toán các Hóa đơn cho công ty
              </p>
              <div class="d-inline-flex align-center timeline-chip">
                <img :src="pdf" height="20" class="me-2" alt="img" />

                <span class="app-timeline-text font-weight-medium">
                  invoice.pdf
                </span>
              </div>
            </VTimelineItem>

            <VTimelineItem dot-color="primary" size="x-small">
              <div
                class="d-flex justify-space-between align-center flex-wrap gap-2 mb-3"
              >
                <span class="app-timeline-title">
                  Cuộc họp với Khách hàng
                </span>
                <span class="app-timeline-meta">45 phút trước</span>
              </div>

              <p class="app-timeline-text mb-2">
                Cuộc họp với dự án React cùng John @10:15 sáng
              </p>

              <div class="d-flex align-center mt-3">
                <VAvatar size="32" class="me-2" :image="avatar2" />
                <div>
                  <p class="text-sm font-weight-medium mb-0">
                    Lester McCarthy (Khách hàng)
                  </p>
                  <span class="text-sm">CEO của Tập đoàn Kelly</span>
                </div>
              </div>
            </VTimelineItem>

            <VTimelineItem dot-color="info" size="x-small">
              <div
                class="d-flex justify-space-between align-center flex-wrap gap-2 mb-3"
              >
                <span class="app-timeline-title">
                  Tạo một dự án mới cho khách hàng
                </span>
                <span class="app-timeline-meta">2 ngày trước</span>
              </div>

              <p class="app-timeline-text mb-2">6 thành viên trong một dự án</p>

              <div class="v-avatar-group">
                <VAvatar
                  v-for="avatar in [avatar2, avatar3, avatar4, avatar5]"
                  :key="avatar"
                  :image="avatar"
                />
                <VAvatar :color="name === 'light' ? '#F0EFF0' : '#3F3B59'">
                  <span class="text-high-emphasis">+3</span>
                </VAvatar>
              </div>
            </VTimelineItem>
          </VTimeline>
        </VCardText>
      </VCard>
    </VCol>

    <VCol cols="12">
      <UserInvoiceTable />
    </VCol>
  </VRow>
</template>

<template>
  <v-container>
    <v-row class="text-center">
      <v-col cols="12">
        <v-data-table
          v-model="selectedParent"
          :headers="headersParent"
          :items="parentTasks"
          :expanded.sync="expanded"
          show-select
          item-key="category"
          class="elevation-1"
          hide-default-header
          hide-default-footer
          @click:row="(item, slot) => slot.expand(!slot.isExpanded)"
        >
          <template #item.data-table-select="{ isSelected, select }">
            <v-simple-checkbox
              color="primary"
              :value="isSelected"
              @input="select($event)"
            ></v-simple-checkbox>
          </template>

          <template #item.category="{ item }">
            <span class="text-subtitle-2 blue--text text--darken-3">{{
              item.category
            }}</span>
          </template>

          <template #expanded-item="{ headers, item }">
            <td class="px-0 py-2" :colspan="headers.length">
              <v-data-table
                v-model="selectedChild"
                :headers="headersChild"
                :items="item.food"
                item-key="name"
                elevation="0"
                show-select
                hide-default-footer
              >
                <template #item.data-table-select="{ isSelected, select }">
                  <v-simple-checkbox
                    color="purple"
                    :value="isSelected"
                    @input="select($event)"
                  ></v-simple-checkbox>
                </template>

                <template #item.name="{ item }">
                  <span class="text-subtitle-2 purple--text text--darken-3">{{
                    item.name
                  }}</span>
                </template>
              </v-data-table>
            </td>
          </template>
        </v-data-table>

        <v-card color="grey lighten-3" class="mt-6">
          <v-card-title>Parent selection</v-card-title>
          <v-card-text class="text--primary">{{ selectedParent }}</v-card-text>
        </v-card>

        <v-card color="grey lighten-3" class="mt-6">
          <v-card-title>Child selection</v-card-title>
          <v-card-text class="text--primary">{{ selectedChild }}</v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  name: "HelloWorld",
  data: () => ({
    selectedParent: [],
    selectedChild: [],
    expanded: [],
    headersParent: [
      {
        text: "Select",
        align: "left",
        value: "data-table-select",
        class: "checkbox",
        cellClass: "checkbox",
      },
      {
        text: "Category",
        align: "left",
        value: "category",
      },
    ],
    headersChild: [
      {
        text: "Select",
        align: "left",
        value: "data-table-select",
        class: "checkbox",
        cellClass: "checkbox",
      },
      {
        text: "Name",
        align: "left",
        value: "name",
      },
      { text: "Calories", value: "calories" },
      { text: "Fat (g)", value: "fat" },
      { text: "Carbs (g)", value: "carbs" },
      { text: "Protein (g)", value: "protein" },
      { text: "Iron (%)", value: "iron" },
    ],
    parentTasks: [], // To store the fetched data for parent selection
  }),
  computed: {
    allChildSelected() {
      // Check if all child items are selected for each parent
      return this.parentTasks.every((parent) =>
        parent.food.every((child) =>
          this.selectedChild.some((selectedChildItem) =>
            this.isSameFoodItem(selectedChildItem, child)
          )
        )
      );
    },
  },
  watch: {
    selectedParent(val) {
      // When a parent gets selected, select all its children
      // Unless some child items are already selected
      this.selectedChild = [];
      if (val.length > 0) {
        val.forEach((category) => {
          category.food.forEach((foodItem) => {
            this.selectedChild.push(foodItem);
          });
        });
      }
    },
  },
  methods: {
    isSameFoodItem(item1, item2) {
      // Helper method to compare two food items by their properties
      return (
        item1.name === item2.name &&
        item1.calories === item2.calories &&
        item1.fat === item2.fat &&
        item1.carbs === item2.carbs &&
        item1.protein === item2.protein &&
        item1.iron === item2.iron
      );
    },
  },
  mounted() {
    // Fetch data from the backend API for parent selection
    axios
      .get("/tasks/task_list")
      .then((response) => {
        // Map the fetched data to the structure used in the component
        this.parentTasks = response.data.map((task) => ({
          category: task.Title, // Assuming Title corresponds to the category in treats
          food: [
            {
              name: task.Description,
              calories: task.Calories,
              fat: task.Fat,
              carbs: task.Carbs,
              protein: task.Protein,
              iron: task.Iron,
            },
          ],
        }));
      })
      .catch((error) => {
        console.error("Error fetching tasks:", error);
      });

    // Fetch data from the backend API for child selection
    axios
      .get("/tasks/subtask_list")
      .then((response) => {
        // Map the fetched data to the structure used in the component
        const childTasks = response.data.map((subtask) => ({
          name: subtask.Name,
          calories: subtask.Calories,
          fat: subtask.Fat,
          carbs: subtask.Carbs,
          protein: subtask.Protein,
          iron: subtask.Iron,
        }));
        this.selectedChild = childTasks; // Pre-select all child items initially
      })
      .catch((error) => {
        console.error("Error fetching subtasks:", error);
      });
  },
};
</script>

<style>
.checkbox {
  width: 25px;
}
</style>

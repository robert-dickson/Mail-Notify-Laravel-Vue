<!-- Home.vue -->

<template>
  <div>
    <h1>Task List</h1>
    <DataTable />
  </div>
</template>

<script>
import DataTable from "../components/tasktable.vue";

export default {
  components: {
    DataTable,
  },
};
</script>

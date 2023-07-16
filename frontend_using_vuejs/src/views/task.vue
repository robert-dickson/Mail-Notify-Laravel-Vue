<template>
  <div class="container" style="max-width: 800px">
    <!-- Heading -->
    <h2 class="text-center mt-5">My Vue Todo App</h2>

    <!-- Input -->
    <div class="d-flex mt-5">
      <input
        type="text"
        v-model="task.title"
        placeholder="Enter task title"
        class="w-100 form-control"
      />
      <input
        type="text"
        v-model="task.description"
        placeholder="Enter task description"
        class="w-100 form-control"
      />
      <button class="btn btn-warning rounded-0" @click="submitTask">
        SUBMIT
      </button>
    </div>

    <!-- Task table -->
    <table class="table table-bordered mt-5">
      <thead>
        <tr>
          <th scope="col" style="width: 100px">Title</th>
          <th scope="col" style="width: 180px">Description</th>
          <th scope="col" style="width: 120px">Status</th>
          <th scope="col" class="text-center" style="width: 100px">Delete</th>
          <th scope="col" class="text-center" style="width: 100px">Edit</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(task, index) in tasks" :key="index">
          <td>
            <span :class="{ 'line-through': task.status === 'done' }">
              {{ task.title }}
            </span>
          </td>
          <td>{{ task.description }}</td>
          <td>
            <span
              class="pointer noselect"
              @click="changeStatus(index)"
              :class="{
                'text-danger': task.status === 'todo',
                'text-success': task.status === 'done',
                'text-warning': task.status === 'in progress',
              }"
            >
              {{ capitalizeFirstChar(task.status) }}
            </span>
          </td>
          <td class="text-center">
            <div @click="deleteTask(task.id)">
              <span class="fa fa-trash pointer"></span>
            </div>
          </td>
          <td class="text-center">
            <div @click="editTask(index)">
              <p class="fa fa-pen pointer"></p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref } from "vue";
import { useTasks } from "@/assets/js/task"; // Import the useTasks function from your tasks.js file

export default {
  name: "Task",
  setup() {
    // Use the useTasks function to fetch, add, update, and delete tasks
    const { tasks, addTask, updateTask, deleteTaskFromServer } = useTasks();

    const task = ref({
      title: "",
      description: "",
      status: "todo",
    });

    const editedTask = ref(null);
    const statuses = ["todo", "in progress", "done"];

    // Capitalize the first character of a string
    const capitalizeFirstChar = (str) => {
      if (!str || str.length === 0) {
        return "";
      }
      return str.charAt(0).toUpperCase() + str.slice(1);
    };

    // Change the status of a task (todo, in progress, done)
    const changeStatus = (index) => {
      let newIndex = statuses.indexOf(tasks.value[index].status);
      if (++newIndex > 2) newIndex = 0;
      tasks.value[index].status = statuses[newIndex];
      updateTask(tasks.value[index].id, { status: tasks.value[index].status });
    };

    // Delete a task
    const deleteTask = (taskId) => {
      deleteTaskFromServer(taskId).then(() => {
        tasks.value = tasks.value.filter((task) => task.id !== taskId);
      });
    };

    // Edit a task
    const editTask = (index) => {
      task.value.title = tasks.value[index].title;
      task.value.description = tasks.value[index].description;
      task.value.status = tasks.value[index].status;
      editedTask.value = index;
    };

    // Submit a task
    const submitTask = () => {
      if (!task.value.title) return;

      if (editedTask.value !== null) {
        updateTask(tasks.value[editedTask.value].id, task.value).then((res) => {
          tasks.value[editedTask.value].title = res.data.title;
          tasks.value[editedTask.value].description = res.data.description;
          tasks.value[editedTask.value].status = res.data.status;
          editedTask.value = null;
        });
      } else {
        addTask(task.value).then((res) => {
          tasks.value.push(res.data);
        });
      }

      task.value.title = "";
      task.value.description = "";
      task.value.status = "todo";
    };

    return {
      tasks, // Expose tasks to the template
      task,
      editedTask,
      statuses,
      capitalizeFirstChar,
      changeStatus,
      deleteTask,
      editTask,
      submitTask,
    };
  },
};
</script>

<style scoped>
.pointer {
  cursor: pointer;
}

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently supported by Chrome, Edge, Opera, and Firefox */
}

.line-through {
  text-decoration: line-through;
}
</style>

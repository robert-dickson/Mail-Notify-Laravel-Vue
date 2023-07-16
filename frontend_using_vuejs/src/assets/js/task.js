import { ref } from "vue";
import axios from "axios";

const apiUrl = "http://localhost:8000/api/tasks"; // API endpoint for tasks

export function useTasks() {
  const tasks = ref([]);
  const error = ref(null);

  // Fetch tasks from the backend
  const fetchTasks = async () => {
    error.value = null;
    try {
      const res = await axios.get(`${apiUrl}/task_list`);
      tasks.value = res.data.data; // Assuming your backend returns an array of tasks under 'data' key
    } catch (err) {
      error.value = err;
    }
  };

  // Add a new task
  const addTask = async (taskData) => {
    error.value = null;
    try {
      const res = await axios.post(`${apiUrl}`, taskData);
      tasks.value.push(res.data.data); // Add the newly created task to the tasks array
    } catch (err) {
      error.value = err;
    }
  };

  // Update an existing task
  const updateTask = async (taskId, taskData) => {
    error.value = null;
    try {
      const res = await axios.put(`${apiUrl}/${taskId}`, taskData);
      const index = tasks.value.findIndex((task) => task.id === taskId);
      if (index !== -1) {
        tasks.value[index] = res.data.data; // Update the task in the tasks array
      }
    } catch (err) {
      error.value = err;
    }
  };

  // Delete a task
  const deleteTask = async (taskId) => {
    error.value = null;
    try {
      await axios.delete(`${apiUrl}/${taskId}`);
      tasks.value = tasks.value.filter((task) => task.id !== taskId); // Remove the task from the tasks array
    } catch (err) {
      error.value = err;
    }
  };

  // Call this function to fetch tasks when needed (e.g., when the component is mounted)
  fetchTasks();

  return {
    tasks,
    error,
    addTask,
    updateTask,
    deleteTask,
  };
}

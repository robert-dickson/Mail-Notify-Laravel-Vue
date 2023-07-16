import { ref } from "vue";
import axios from "axios";

export function useRegister() {
  const registerUrl = "http://localhost:8000/api/register";
  const loginUrl = "http://localhost:8000/api/login";
  const error = ref(null);

  // Register a new user
  const registerUser = async (userData) => {
    error.value = null;
    try {
      const res = await axios.post(registerUrl, userData);
      // Handle the response as needed
      console.log(res.data);
    } catch (err) {
      error.value = err;
    }
  };

  // Login as a user
  const loginUser = async (userData) => {
    error.value = null;
    try {
      const res = await axios.post(loginUrl, userData);
      // Handle the response as needed
      console.log(res.data);
    } catch (err) {
      error.value = err;
    }
  };

  return {
    error,
    registerUser,
    loginUser,
  };
}

<template>
  <div class="auth-container">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <Input id="email" placeholder="Email" v-model="form.email" type="email" required />
      <Input
        id="password"
        placeholder="Password"
        v-model="form.password"
        type="password"
        required
      />
      <button type="submit">Login</button>
      <p>
        Don't have an account?
        <router-link to="/register">Register</router-link>
      </p>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import apiClient from "@/assets/js/config/axiosConfig";
import Input from "@/assets/js/components/input.vue";

const form = ref({
  email:"",
  password: "",
});

const login = async () => {
  const {email, password} = form.value;
  try {
    const res = await apiClient.post('user/login', {
      email: email,
      password: password,
    });
    console.log(res.data);
    
  } catch (error) {
    console.log(err);
    
  }
};
</script>

<style scoped>
.auth-container {
  max-width: 400px;
  margin: 50px auto;
  text-align: center;
}

input {
  display: block;
  width: 100%;
  padding: 10px;
  margin: 10px 0;
}

button {
  width: 40%;
  height: 40px;
  border-radius: 20px;
  margin: 12px auto;
  border-color: #999;
}
</style>

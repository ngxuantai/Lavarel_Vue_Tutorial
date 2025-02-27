<template>
  <div class="auth-container">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div class="row-wrapper">
        <Input v-model="form.firstName" type="text" placeholder="First Name" required />
        <Input v-model="form.lastName" type="text" placeholder="Last Name" required />
      </div>
      <Input v-model="form.email" type="email" placeholder="Email" required />
      <Input
        v-model="form.password"
        type="password"
        placeholder="Password"
        required
      />
      <button type="submit">Register</button>
      <p>
        Already have an account? <router-link to="/login">Login</router-link>
      </p>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Input from "@/assets/js/components/input.vue";

const form = ref({
  firstName: "",
  lastName: "",
  email: "",
  password: "",
});

const register = () => {
  const { name, email, password } = form.value;
  console.log("Register clicked:", name, email, password);
};
</script>

<style scoped>
.auth-container {
  max-width: 400px;
  margin: 50px auto;
  text-align: center;
}

.row-wrapper {
  display: flex;
  gap: 12px;
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

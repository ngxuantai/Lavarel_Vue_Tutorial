<template>
  <form @submit.prevent="handleSubmit">
    <Input
      id="name"
      label="Project name"
      type="text"
      placeholder="Project name"
      v-model="form.name"
    />

    <div class="group">
      <label for="description">Description</label>
      <textarea type="text" id="description" v-model="form.description"></textarea>
    </div>

    <Input
      id="startDate"
      label="Start date"
      type="date"
      v-model="form.startDate"
    />

    <Select
      id="status"
      label="Status"
      :options="optionStatus"
      v-model="form.status">
    </Select>

    <button type="submit">Submit</button>
  </form>
</template>

<script setup>
import { ref } from "vue";
import apiClient from "@/assets/js/config/axiosConfig";
import Input from "@/assets/js/components/input.vue";
import Select from "@/assets/js/components/select.vue";

const form = ref({
  name: "",
  description: "",
  startDate: "",
  status: 1,
});

const optionStatus = [
  { text: "Planning", value: 1 },
  { text: "In progress", value: 2 },
  { text: "Completed", value: 3 },
  { text: "On hold", value: 4 },
];

const handleSubmit = async () => {
  const {name, description, startDate, status} = form.value;
  try {
    await apiClient.post('project/create', {
      name: name,
      description: description,
      start_date: startDate,
      status: status
    });
  } catch (error) {
    console.log(err);
  }
};
</script>

<style lang="css" scoped>
form{
  max-width: 40%;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.group {
  display: flex;
  flex-direction: column;
  margin-bottom: 10px;
}

textarea, input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}

button {
  width: 40%;
  height: 40px;
  border-radius: 20px;
  margin: 0 auto;
}
</style>

<template>
  <div class="input-group">
    <label v-if="label" :for="id">{{ label }}</label>
    <div class="input-wrapper">
      <input
        :id="id"
        :type="showPassword ? 'text' : type"
        :placeholder="placeholder"
        :value="modelValue"
        @input="updateValue"
      />
      <span v-if="type === 'password'" class="icon" @click="togglePassword">
        <i :class="showPassword ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
      </span>
    </div>
    <!-- <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p> -->
  </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
  id: String,
  label: String,
  type: { type: String, default: "text" },
  placeholder: String,
  modelValue: String,
  // errorMessage: String,
});

const emit = defineEmits(["update:modelValue"]);

const showPassword = ref(false);

const updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};

const togglePassword = () => {
  showPassword.value = !showPassword.value;
}
</script>

<style scoped>
.input-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 10px;
  text-align: left;
}

.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

input {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}

.icon {
  position: absolute;
  right: 10px;
  cursor: pointer;
  font-size: 18px;
  color: #777;
}

.icon:hover {
  color: #333;
}

.error-message {
  color: red;
  font-size: 14px;
  margin-top: 4px;
}
</style>

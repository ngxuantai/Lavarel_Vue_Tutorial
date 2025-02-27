<template>
  <div class="select-group">
    <label v-if="label" :for="id">{{ label }}</label>
    <select :id="id" :value="modelValue" @change="updateValue">
      <option v-for="(option, index) in options" :key="index" :value="option.value">
        {{ option.text }}
      </option>
    </select>
  </div>
</template>

<script setup>
defineProps({
  id: String,
  label: String,
  options: Array,
  modelValue: [String, Number],
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};
</script>

<style scoped>
.select-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 10px;
}

select {
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}
</style>

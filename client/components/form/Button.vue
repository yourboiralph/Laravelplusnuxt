<template>
    <button
      type="button"
      class="flex items-center justify-center gap-x-2 outline-none px-7 py-3 rounded-md"
      :class="{
        'transition-colors duration-200 bg-blue-400 text-black font-semibold text-sm hover:bg-teal-200': props.buttonStyle === 'primary',
        'bg-green-700 text-black font-extrabold hover:bg-green-600': props.buttonStyle === 'success',
        'bg-orange-600 text-white hover:bg-orange-500': props.buttonStyle === 'warning',
        'bg-red-700 text-white hover:bg-red-600': props.buttonStyle === 'danger',
      }"
      :disabled="props.disabled"
    >
      <slot name="icon-left" />
      <slot />
      <slot name="icon-right" />
    </button>
  </template>
  
  <script setup lang="ts">
  import { defineProps } from "vue";
  
  const props = defineProps({
    buttonStyle: {
      type: String,
      required: false,
    },
    disabled: {
      type: Boolean,
      required: false,
      default: false,
    },
    text: {
      type: String,
      required: false,
    },
  });
  </script>
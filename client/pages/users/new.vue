<template>
    <div class="mx-auto max-w-5xl py-10">
      <h3 class="text-2xl">Edit User</h3>
      <div class="py-3">
        <button @click="back()" class="border px-4 py-1 hover:bg-gray-50">Back</button>
      </div>
      <div v-if="pending">
        Loading...
      </div>
      <div v-else>
        <form class="space-y-3" @submit.prevent="saveUser()">
          <div>
            <FormLabel label="Name" />
            <FormTextField name="name" placeholder="Name" v-model="state.user.name" />
            <div class="error-message">
              {{ state.errors && state.errors.data && state.errors.data.errors && state.errors.data.errors.name && state.errors.data.errors.name[0]}}
            </div>
          </div>
          <div>
            <FormLabel label="Course" />
            <FormTextField name="course" placeholder="Course" v-model="state.user.course" />
            <div class="error-message">
              {{ state.errors && state.errors.data && state.errors.data.errors && state.errors.data.errors.course && state.errors.data.errors.course[0] }}
            </div>
          </div>
          <div>
            <FormLabel label="Email" />
            <FormTextField type="email" name="email" placeholder="Email" v-model="state.user.email" required />
            <div class="error-message">
              {{ state.errors && state.errors.data && state.errors.data.errors && state.errors.data.errors.email && state.errors.data.errors.email[0] }}
            </div>
          </div>
          <div>
            <FormLabel label="Password" />
            <FormTextField name="password" type="password" placeholder="Password" v-model="state.user.password" />
            <div class="error-message">
              {{ state.errors && state.errors.data && state.errors.data.errors && state.errors.data.errors.password && state.errors.data.errors.password[0] }}
            </div>
          </div>
          <div>
            <FormLabel label="Status" />
            <br />
            <FormCheckbox :value="state.user.is_active ? true : false"
                          @click="state.user.is_active = !state.user.is_active" />
            <div class="error-message">
              {{ state.errors && state.errors.data && state.errors.data.errors && state.errors.data.errors.status && state.errors.data.errors.status[0] }}
            </div>
          </div>
          <div>
            <FormButton type="submit" buttonStyle="primary" class="w-full">Update</FormButton>
          </div>
        </form>
      </div>
    </div>
  </template>
  
<style>
    .error-message {
        color: red;
    }
</style>

  
<script setup>
import { ref } from 'vue';

const state = reactive({
  user: {
    name: null,
    course: null,
    password: null,
    email: null,
    is_active: false,
  },
  errors: null,
});

function back() {
  navigateTo('/');
}

async function saveUser() {
  const payload = {
    name: state.user.name,
    email: state.user.email,
    password: state.user.password,
    course: state.user.course,
    is_active: state.user.is_active,
  };

  // Email validation
  if (state.user.email && !validateEmail(state.user.email)) {
    state.errors = {
      data: {
        errors: {
          email: ['Invalid email format.'],
        },
      },
    };
    return;
  }

  await $fetch(`http://127.0.0.1:8000/api/users`, {
    method: 'POST',
    body: payload,
  })
    .then((result) => {
      if (result) {
        alert('Successfully saved.');
      }
    })
    .catch((errors) => {
      state.errors = errors;
    });
}

function validateEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}
</script>

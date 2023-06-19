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
        <form class="space-y-3" @submit.prevent="updateUser()">
          <div>
            <FormLabel label="Name" />
            <FormTextField name="name" placeholder="Name" v-model="state.user.name" @input="clearError('name')" />
            <div class="text-red-800">
              {{ state.errors && state.errors.name && state.errors.name[0] }}
            </div>
          </div>
          <div>
            <FormLabel label="Course" />
            <FormTextField name="course" placeholder="Course" v-model="state.user.course" @input="clearError('course')" />
            <div class="text-red-800">
              {{ state.errors && state.errors.course && state.errors.course[0] }}
            </div>
          </div>
          <div>
            <FormLabel label="Email" />
            <FormTextField type="email" name="email" placeholder="Email" v-model="state.user.email" required @input="clearError('email')" />
            <div class="text-red-800">
              {{ state.errors && state.errors.email && state.errors.email[0] }}
            </div>
          </div>
          <div>
            <FormLabel label="Password" />
            <FormTextField name="password" type="password" placeholder="Password" v-model="state.user.password" @input="clearError('password')" />
            <div class="text-red-800">
              {{ state.errors && state.errors.password && state.errors.password[0] }}
            </div>
          </div>
          <div>
            <FormLabel label="Status" />
            <br />
            <FormCheckbox :value="state.user.is_active ? true : false" @click="state.user.is_active = !state.user.is_active" @input="clearError('status')" />
            <div class="text-red-800">
              {{ state.errors && state.errors.status && state.errors.status[0] }}
            </div>
          </div>
          <div>
            <FormButton type="submit" buttonStyle="primary" class="w-full">Update</FormButton>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  const route = useRoute();
  const userId = route.query.user_id;
  
  const { pending, data: user } = await useLazyAsyncData('user', () => $fetch(`http://127.0.0.1:8000/api/users/${userId}`));
  
  const state = reactive({
    user: {
      name: user && user.value && user.value.name,
      course: user && user.value && user.value.course,
      is_active: user && user.value && user.value.is_active,
      email: user && user.value && user.value.email,
      password: user && user.value && user.value.password,
    },
    errors: {},
  });
  
  watch(user, (newData) => {
    state.user = {
      name: newData && newData.name,
      course: newData && newData.course,
      is_active: newData && newData.is_active,
      email: newData && newData.email,
      password: newData && newData.password,
    };
  });
  
  const fieldLabels = {
    name: 'Name',
    course: 'Course',
    email: 'Email',
    password: 'Password',
    status: 'Status',
  };
  
  function back() {
    navigateTo('/');
  }
  
  function clearError(field) {
    if (state.errors && state.errors[field]) {
      state.errors[field] = [];
    }
  }
  
  async function updateUser() {
    const payload = {
      name: state.user.name,
      course: state.user.course,
      is_active: state.user.is_active,
      email: state.user.email,
      password: state.user.password,
    };
  
    const emptyFields = Object.entries(payload).filter(([key, value]) => !value);
    if (emptyFields.length > 0) {
      emptyFields.forEach(([key]) => {
        state.errors = {
          ...state.errors,
          [key]: [`${fieldLabels[key]} is required.`],
        };
      });
      return;
    }
  
    if (state.user.email && !validateEmail(state.user.email)) {
      state.errors = {
        ...state.errors,
        email: ['Invalid email format.'],
      };
      return;
    }
  
    await $fetch(`http://127.0.0.1:8000/api/users/${userId}`, {
      method: 'PUT',
      body: payload,
    })
      .then((result) => {
        if (result) {
          alert('Successfully updated.');
        }
      });
  }
  
  function validateEmail(email) {
    //pov biot si baja
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  </script>
  
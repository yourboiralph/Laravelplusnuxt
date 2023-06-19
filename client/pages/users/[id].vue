<template>
    <div class="mx-auto max-w-5xl py-10">
        <h3 class="text-2xl">User</h3>
        <div class="py-3">
            <button @click="back()" class="border px-4 py-1 hover:bg-gray-50">Back</button>
        </div>
        <div v-if="user">
            <p>Name: {{ user.name }}</p>
            <p>Course: {{ user.course }}</p>
            <p>
                Is Active:
                <span v-if="user.is_active" class="text-green-700">✓</span>
                <span v-else class="text-red-700">X</span>
            </p>
        </div>
    </div>
</template>
  
<script setup>
const route = useRoute();
const userId = route.params.id
console.log(userId)
const { pending, data: user } = useFetch(`http://127.0.0.1:8000/api/users/${userId}`, {
    lazy: true
})

function back() {
    navigateTo('/')
}
</script>
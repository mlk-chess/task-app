<template>
    <div class="badge badge-accent">
        {{ selectedMembers.length }} membres sélectionnés
    </div>

    <div class="relative text-gray-600">
        <input v-model="query" @input="search"
            class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="text"
            placeholder="Recherche..." />
    </div>

    <ul v-if="query" class="w-48 text-sm font-medium border rounded-lg">
        <li v-for="contributor in  filteredContributors " :key="contributor.id" class="w-full border-b  rounded-t-lg">
            <div class="flex items-center pl-3">
                <input v-model="selectedMembers" type="checkbox" :id="contributor.username"
                    :value="'/api/users/' + contributor.id"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                <label :for="contributor.username" class="w-full py-3 ml-2 text-sm font-medium">
                    {{ contributor.username }}
                </label>
            </div>
        </li>
    </ul>
</template>

<script setup>
import { onMounted, ref, watch, computed, defineProps, defineEmits } from 'vue';
import jsCookie from 'js-cookie'

const props = defineProps({
    members: {
        required: true
    },
})


const contributors = ref([]);
const isSearching = ref(false);
const selectedMembers = ref([]);
const membersUsername = ref([]);

const emit = defineEmits();

onMounted(async () => {
    await fetchUsers();
})

const fetchUsers = async () => {
    const token = jsCookie.get('jwt')
    const requestToken = new Request(
        "https://kaitokid.fr/api/get-contributors",
        {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token
            }
        });

    fetch(requestToken)
        .then(response => response.status === 200 && response.json())
        .then(data => {
            contributors.value = data["hydra:member"]
        })
}

const query = ref('');

const search = () => {
    isSearching.value = true;
};

watch(query, () => {
    search();
});

const filteredContributors = computed(() => {
    if (isSearching.value || query.value === '') {
        return contributors.value.filter(contributor => {
            return contributor.username.toLowerCase().startsWith(query.value.toLowerCase());
        });
    } else {
        return [];
    }
});

watch(selectedMembers, () => {
    emit('update:selectedMembers', selectedMembers.value);
});

</script>

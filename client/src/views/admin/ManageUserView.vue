<template>
    <NavBar />

    <section class="m-10">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <label>
                                #id
                            </label>
                        </th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <th>
                            <label>
                                {{ user["@id"].split("/")[3] }}
                            </label>
                        </th>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">{{ user.username }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ user.email }}</td>

                        <td>
                            <span class="badge badge-outline badge-primary" v-if="user.status === 1">Actif</span>
                            <span class="badge badge-outline badge-secondary" v-else-if="user.status === 2">Admin</span>
                            <span class="badge badge-outline" v-else-if="user.status === 0">En attente</span>
                            <span class="badge badge-outline badge-accent" v-else>Désactivé</span>
                        </td>

                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <Footer />
</template>

<script setup>
import NavBar from "../../components/NavBar.vue";
import Footer from "../../components/Footer.vue";
import { onMounted, ref } from "vue";
import jsCookie from 'js-cookie'

const users = ref([]);

onMounted(() => {
    const token = jsCookie.get('jwt');
    if (token === undefined) {
        router.push({ name: 'login' })
    } else {
        fetch(`https://localhost/api/users`, {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        })
            .then(response => response.json())
            .then((data) => {
                users.value = data["hydra:member"]
            })
    }
})

</script>
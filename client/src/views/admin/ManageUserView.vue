<template>
    <NavBar />

    <section class="m-10">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox" />
                            </label>
                        </th>
                        <th>Name</th>
                        <th>Job</th>
                        <th>Favorite Color</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>
                            <label>
                                <input type="checkbox" class="checkbox" />
                            </label>
                        </th>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">Hart Hagerty</div>
                                    <div class="text-sm opacity-50">United States</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            Zemlak, Daniel and Leannon
                            <br />
                            <span class="badge badge-ghost badge-sm">Desktop Support Technician</span>
                        </td>
                        <td>Purple</td>
                        <th>
                            <button class="btn btn-ghost btn-xs">details</button>
                        </th>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Job</th>
                        <th>Favorite Color</th>
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
import { onMounted, ref, watch } from "vue";
import jsCookie from 'js-cookie'


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
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
            })
    }
})

</script>
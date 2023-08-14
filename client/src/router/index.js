import { createRouter, createWebHistory } from "vue-router";
import jsCookie from 'js-cookie'
import LoginView from '../views/LoginView.vue'
import PageNotFound from "@/views/PageNotFound.vue";


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/login",
      name: "login",
      component: LoginView,
      meta: {
        requiresLogin: true
      }
    },
    {
      path: "/:pathMatch(.*)*",
      component: PageNotFound
    }
  ]
})


router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = jsCookie.get('jwt')

    const requestToken = new Request(
        "https://localhost/api/auth",
        {
          method: "POST",
          headers: {
            "Authorization": "Bearer " + token
          }
        });

    fetch(requestToken)
        .then((response) => {
          if (response.status === 200) {
            return response.json()
          } else {
            next('/login')
            throw new Error('Token request failed')
          }
        })
        .then((data) => {
          next()
        })
  }else if (to.meta.requiresAuthAdmin) {
    const token = jsCookie.get('jwt')

    const requestToken = new Request(
        "https://localhost/api/auth",
        {
          method: "POST",
          headers: {
            "Authorization": "Bearer " + token
          }
        });

    fetch(requestToken)
        .then((response) => {
          if (response.status === 200) {
            return response.json()
          } else {
            next('/login')
            throw new Error('Token request failed')
          }
        })
        .then((data) => {

            if (data.data.roles.includes('ROLE_ADMIN')) {
              next()
            } else {
              next('/login')
            }
        })
  }else if (to.meta.requiresLogin) {
    const token = jsCookie.get('jwt')

    const requestToken = new Request(
        "https://localhost/api/auth",
        {
          method: "POST",
          headers: {
            "Authorization": "Bearer " + token
          }
        });

    fetch(requestToken)
        .then((response) => {
          if (response.status === 200) {
            return response.json()
          } else {
            next()
          }
        })
        .then((data) => {
          next('/')
        })
  }else {
    next()
  }
})
export default router;

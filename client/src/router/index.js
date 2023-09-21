import { createRouter, createWebHistory } from "vue-router";
import jsCookie from 'js-cookie';
import LoginView from '@/views/LoginView.vue';
import RegisterView from '@/views/RegisterView.vue';
import PageNotFound from "@/views/PageNotFound.vue";
import HomeView from "@/views/HomeView.vue";
import DashboardView from "@/views/DashboardView.vue";
import ConfirmAccountView from "@/views/ConfirmAccountView.vue";
import ResetPasswordView from "@/views/ResetPasswordView.vue";
import PasswordForgottenView from "@/views/PasswordForgottenView.vue"
import ListsTasksView from "@/views/ListsTasksView.vue";
import TasksView from "@/views/TasksView.vue";
import DashboardAdminView from "@/views/admin/DashboardAdminView.vue";
import ManageUserView from "@/views/admin/ManageUserView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
      meta: {
        requiresLogin: true
      }
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView,
      meta: {
        requiresLogin: true
      }
    },
    {
      path: "/confirm-account",
      name: "confirm-account",
      component: ConfirmAccountView,
    },
    {
      path: "/reset-password",
      name: "reset-password",
      component: ResetPasswordView,
    },
    {
      path: "/password-forgotten",
      name: "password-forgotten",
      component: PasswordForgottenView,
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: DashboardView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: "/lists",
      name: "lists",
      component: ListsTasksView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: "/list/:id",
      name: "tasks",
      component: TasksView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: "/admin/dashboard",
      name: "dashboard-admin",
      component: DashboardAdminView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: "/admin/users",
      name: "manage-user",
      component: ManageUserView,
      meta: {
        requiresAuth: true
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
      "https://kaitokid.fr/api/auth",
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
  } else if (to.meta.requiresAuthAdmin) {
    const token = jsCookie.get('jwt')

    const requestToken = new Request(
      "https://kaitokid.fr/api/auth",
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
  } else if (to.meta.requiresLogin) {
    const token = jsCookie.get('jwt')

    if (token) {
      const requestToken = new Request(
        "https://kaitokid.fr/api/auth",
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
    } else {
      next()
    }
  } else {
    next()
  }
})
export default router;

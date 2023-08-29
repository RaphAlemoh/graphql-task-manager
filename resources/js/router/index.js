import { createWebHistory, createRouter } from 'vue-router'

/* Guest Component */
const Login = () => import('@/components/Login.vue')
const Register = () => import('@/components/Register.vue')
const Welcome = () => import('@/components/Welcome.vue')
/* Guest Component */

/* Authenticated Component */
const Dashboard = () => import('@/components/Dashboard.vue')
const Task = () => import('@/components/Task/Index.vue')
const CreateTask = () => import('@/components/Task/Create.vue')
const EditTask = () => import('@/components/Task/Edit.vue')
const ViewTask = () => import('@/components/Task/View.vue')

const routes = [
    {
        name: "home",
        path: "/",
        component: Welcome,
        meta: {
            title: `ApTiw Task Manager`,
            middleware: "guest"
        }
    },
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {

        path: "/",
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "dashboard",
                path: '/dashboard',
                component: Dashboard,
                meta: {
                    title: `User Dashboard`
                }
            },
            {
                name: "tasks",
                path: '/tasks',
                component: Task,
                meta: {
                    title: `Task`
                }
            },
            {
                name: "create_task",
                path: 'create/task',
                component: CreateTask,
                meta: {
                    title: `Create Task`
                }
            },
            {
                name: "edit_task",
                path: 'edit/task:id',
                component: EditTask,
                meta: {
                    title: `Edit Task`
                }
            },
            {
                name: "view_task",
                path: 'view/task:id',
                component: ViewTask,
                meta: {
                    title: `View Task`
                }
            },
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.name == "login" || to.meta.name == "register" && localStorage.getItem("token")) {
        next({ name: "dashboard" })
    } else {
        next()
    }
})

export default router

import Vue from 'vue'
import VueRouter from 'vue-router'
import TodoIndex from './pages/index.vue'
import TodoAdd from './pages/add.vue'
import TodoDetail from './pages/detail.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [{
            path: '/',
            name: 'todo.index',
            component: TodoIndex
        },
        {
            path: '/tambah',
            name: 'todo.add',
            component: TodoAdd
        },
        {
            path: '/detail/:id',
            name: 'todo.detail',
            component: TodoDetail
        }
    ]
})

export default router

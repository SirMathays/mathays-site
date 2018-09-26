import Dashboard from './pages/Dashboard.vue'

import Error404 from '../error/404.vue'

const routes = [
    {
        path: '/login',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/404',
        name: 'not-found',
        component: Error404,
        props: { message: 'page not found' }
    },
    {
        path: '*',
        name: '404',
        redirect: {
            name: 'not-found'
        }
    },
]

export default {
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'exact-active',
    routes, // short for `routes: routes`
}
import Home from './pages/Home'

import Error404 from '../error/404'

var prefix = '/personal'

const routes = [
    {
        path: prefix + '/:slug?',
        name: 'home',
        component: Home,
    },
    {
        path: prefix + '/404',
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
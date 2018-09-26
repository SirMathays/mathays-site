import Dashboard from './pages/Dashboard.vue'
import BlogIndex from './pages/BlogIndex.vue'
import PostEdit from './pages/PostEdit.vue'
import VideoIndex from './pages/VideoIndex.vue'
import VideoEdit from './pages/VideoEdit.vue'

import Error404 from '../error/404.vue'

var prefix = '/admin'

const routes = [
    {
        path: prefix + '/',
        redirect: {
            name: 'dashboard'
        },
    },
    {
        path: prefix + '/dashboard',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: prefix + '/blog',
        name: 'blog',
        component: BlogIndex
    },
    {
        path: prefix + '/blog/edit/:id?',
        name: 'post-edit',
        component: PostEdit
    },
    {
        path: prefix + '/videos',
        name: 'videos',
        component: VideoIndex
    },
    {
        path: prefix + '/videos/edit/:id?',
        name: 'video-edit',
        component: VideoEdit
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
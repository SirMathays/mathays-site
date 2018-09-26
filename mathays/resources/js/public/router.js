import Home from './pages/Home.vue'
import Blog from './pages/Blog.vue'
import Videos from './pages/Videos.vue'
import Video from './pages/subpages/Video.vue'
import Post from './pages/subpages/Post.vue'

import Error404 from '../error/404.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/blog',
        name: 'blog',
        component: Blog,
    },
    {
        path: '/blog/:year/:month/:slug',
        name: 'post',
        component: Post,
    },
    {
        path: '/videos',
        name: 'videos',
        component: Videos
    },
    {
        path: '/videos/:id',
        name: 'video',
        component: Video
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
import Home from './components/Home.vue'
import Blog from './components/Blog.vue'
import Videos from './components/Videos.vue'
import Video from './components/subpages/Video.vue'
import Post from './components/subpages/Post.vue'

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
        path: '/blog/:slug',
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
        path: '*', 
        redirect: { 
            name: 'home' 
        } 
    }
]

export default {
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'exact-active',
    routes, // short for `routes: routes`
}
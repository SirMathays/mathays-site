import Dashboard from './pages/Dashboard'
import BlogIndex from './pages/BlogIndex'
import PostEdit from './pages/PostEdit'
import VideoIndex from './pages/VideoIndex'
import VideoEdit from './pages/VideoEdit'
import SettingEdit from './pages/SettingEdit'
import PersonalEdit from './pages/PersonalEdit'

import Error404 from '../error/404'

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
        path: prefix + '/settings',
        name: 'settings',
        component: SettingEdit
    },
    {
        path: prefix + '/personal/:slug?',
        name: 'personal',
        component: PersonalEdit
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
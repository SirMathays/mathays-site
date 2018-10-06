@extends('layouts.public')

@section('content')
    <toaster :store="store"></toaster>
    
    <header class="public" v-cloak>
        <div class="logo-container">
            <router-link :to="{ name: 'home' }">
                <svg width="76px" height="113px" viewBox="0 0 76 113">
                    <defs>
                        <linearGradient x1="0%" y1="0%" x2="100%" y2="56.0824199%" id="linearGradient-1">
                            <stop stop-color="#3490DC" offset="0%"></stop>
                            <stop stop-color="#673AB7" offset="100%"></stop>
                        </linearGradient>
                    </defs>
                    
                    <polygon 
                        stroke="url(#linearGradient-1)" 
                        fill="transparent"
                        stroke-width="6" 
                        fill-rule="nonzero" 
                        points="3 110 3 10 38 60 73 10 73 110"></polygon>
                </svg>
            </router-link>
        </div>

        <nav>
            <router-link :to="{ name: 'videos' }">videos</router-link>
            <router-link :to="{ name: 'blog' }">blog</router-link>
        </nav>
    </header>

    <div class="loading-container" v-if="loading">
        <div class="loading"></div>
    </div>

    <transition name="primary-fade" mode="out-in">
        <router-view :key="$route.fullPath"></router-view>
    </transition>

    <div class="container">
        <footer class="site-footer" v-if="!loading">
            website design by Matti Suoraniemi 2018 @if(Auth::check())| <a class="text-muted" href="/admin">admin</a>@endif
        </footer>
    </div>
@endsection
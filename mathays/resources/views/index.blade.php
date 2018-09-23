@extends('layouts.public')

@section('bg-image', $image)

@section('content')
    <header v-bind:class="homeActive && 'header-splash'" v-cloak>
        <div class="logo-container">
            <router-link :to="{ name: 'home' }">
                <svg width="116px" height="101px" id="logo">
                    <g transform="translate(3.388229, 2.948889)" stroke-width="5" stroke="#fff" fill="transparent">
                        <polygon points="0 95 0 5 32 50 64 5 64 95"></polygon>
                        <path d="M76,98 L76,0 C98.6666667,0 110,8.40017863 110,25.2005359 C110,42.0008932 98.6666667,49.9340479 76,49"></path>
                    </g>
                </svg>
            </router-link>
        </div>

        <nav>
            <router-link :to="{ name: 'blog' }">blog</router-link>
            <router-link :to="{ name: 'videos' }">videos</router-link>
        </nav>
    </header>

    <div class="loading-container" v-if="loading">
        <div class="loading"></div>
    </div>

    <transition name="primary-fade" mode="out-in">
        <router-view></router-view>
    </transition>

    <div class="container">
        <footer v-if="!loading">
            website design by Matti Suoraniemi 2018
        </footer>
    </div>
@endsection
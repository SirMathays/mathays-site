@extends('layouts.public')

@section('content')
    <header v-cloak>
        <div class="logo-container">
            <router-link :to="{ name: 'home' }">
                <svg width="70px" height="101px" id="logo">
                    <defs>
                        <linearGradient id="stroke" x1="0%" y1="0%" x2="100%" y2="0%" gradientTransform="rotate(45)">
                            <stop offset="0%" stop-color="#3490dc"/>
                            <stop offset="100%" stop-color="#673ab7"/>
                        </linearGradient>

                        {{-- <linearGradient id="fill" x1="0%" y1="0%" x2="100%" y2="0%" gradientTransform="rotate(45)">
                            <stop offset="0%" stop-color="#673ab7"/>
                            <stop offset="100%" stop-color="#3490dc"/>
                        </linearGradient> --}}
                    </defs>
                    <polygon 
                        transform="translate(3, 3)"
                        stroke-width="6"
                        stroke="url(#stroke)"
                        fill="transparent"
                        points="0 95 0 5 32 50 64 5 64 95"/>
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
        <router-view></router-view>
    </transition>

    <div class="container">
        <footer v-if="!loading">
            website design by Matti Suoraniemi 2018
        </footer>
    </div>
@endsection
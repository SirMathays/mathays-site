@extends('layouts.public')

@section('content')
    <div class="container">
        <div v-bind:class="!homeActive && 'hide'" class="main-title text-center" v-cloak>
            <img src="{{ asset('img/logo.svg') }}">
        </div>

        <div class="links" v-bind:class="homeActive && 'large'" v-cloak>
            <transition name="opacity">
                <router-link :to="{ name: 'home' }" v-if="!homeActive">
                    <img src="{{ asset('img/logo.svg') }}">
                </router-link>
            </transition>
            <router-link :to="{ name: 'blog' }">Blog</router-link>
            <router-link :to="{ name: 'videos' }">Videos</router-link>
        </div>

        <div class="loading-container" v-if="loading">
            <div class="loading"></div>
        </div>

        <transition name="primary-fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
@endsection
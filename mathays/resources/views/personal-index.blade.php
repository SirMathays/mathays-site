@extends('layouts.personal')

@section('content')
    <div class="wrapper">
        <div class="wrapper-blur"></div>
        <header class="personal">
            <modes :mode="mode" :modes="modes"></modes>
            <h1>Hello, {{ $user->first_name }}!</h1>
            <h2 v-html="now.format('DD.MM.[1]YYYY')"></h2>

            <draggable element="nav" v-model="modeData.links">
                <transition-group tag="div" class="links" name="slide-ver">
                    <a v-for="link in modeData.links" :key="link.id" class="link" v-bind:class="link.color" :href="link.url" target="_blank">
                        <img :src="link.favicon_url">
                        <span v-html="link.name"></span>
                    </a>
                </transition-group>
            </draggable>
        </header>

        <div class="content">
            <transition name="calm-slide-ver" mode="out-in">
                <router-view :key="$route.fullPath"></router-view>
            </transition>
        </div>
    </div>
@endsection
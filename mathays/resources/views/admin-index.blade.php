@extends('layouts.admin')

@section('content')
    <toaster :store="store"></toaster>
    
    <b-navbar toggleable="md" type="light" variant="light" class="mb-5" v-cloak>
        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
        <b-navbar-brand href="/" v-html="siteName"></b-navbar-brand>

        <b-collapse is-nav id="nav_collapse">
            <b-navbar-nav>
                <b-nav-item :to="{ name: 'dashboard' }">Dashboard</b-nav-item>
                <b-nav-item :to="{ name: 'videos' }">Videos</b-nav-item>
                <b-nav-item :to="{ name: 'blog' }">Blog</b-nav-item>
                <b-nav-item :to="{ name: 'settings' }">Settings</b-nav-item>
            </b-navbar-nav>
            <b-navbar-nav id="personal">
                <b-nav-item href="#" disabled>Personal</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-item href="{{ route('logout') }}">Logout</b-nav-item>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>

    <div class="loading-container" v-if="loading">
        <div class="loading"></div>
    </div>

    <transition name="primary-fade" mode="out-in">
        <router-view></router-view>
    </transition>

    <b-container>
        <footer v-if="!loading">
            website design by Matti Suoraniemi 2018
        </footer>
    </b-container>
@endsection

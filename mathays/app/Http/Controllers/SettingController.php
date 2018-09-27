<?php

namespace Mathays\Http\Controllers;

use Mathays\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'settings' => Setting::get()->keyBy('key')
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->settings;
        $keys = array_keys($request->settings);;

        foreach($settings = Setting::whereIn('key', $keys)->get() as $setting) {
            $setting->value = $inputs[$setting->key]['value'];
            $setting->save();
        }

        return response([
            'message' => 'Settings saved! Reloading page...'
        ], 200);
    }
}

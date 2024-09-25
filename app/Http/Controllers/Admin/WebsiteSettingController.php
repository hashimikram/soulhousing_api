<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWebsiteSettingRequest;
use App\Http\Requests\UpdateWebsiteSettingRequest;
use App\Models\WebsiteSetting;

class WebsiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = WebsiteSetting::whereIn('key', ['platform_name', 'platform_address', 'platform_contact'])->pluck('value', 'key');
        return view('backend.pages.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebsiteSettingRequest $request)
    {
        $validated = $request->validated();
        // Save each setting in the database
        WebsiteSetting::updateOrCreate(
            ['key' => 'platform_name'],
            ['value' => $validated['platform_name'], 'type' => 'string', 'autoload' => true]
        );

        WebsiteSetting::updateOrCreate(
            ['key' => 'platform_address'],
            ['value' => $validated['platform_address'], 'type' => 'string', 'autoload' => true]
        );

        WebsiteSetting::updateOrCreate(
            ['key' => 'platform_contact'],
            ['value' => $validated['platform_contact'], 'type' => 'string', 'autoload' => true]
        );

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WebsiteSetting $websiteSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebsiteSetting $websiteSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebsiteSettingRequest $request, WebsiteSetting $websiteSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebsiteSetting $websiteSetting)
    {
        //
    }
}

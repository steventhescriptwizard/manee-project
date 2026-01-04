<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            // Handle File Uploads (Logo, etc)
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('settings', 'public');
                $value = $path; // Replace value with path
                
                // If existing file, maybe delete old one? (Optional enhancement)
            }

            if ($setting) {
                // Determine group if needed or just update value
                $setting->update(['value' => $value]);
            } else {
                // Auto-create setting if it doesn't exist (useful for new features)
                // Infer type/group? For now assuming simple text/general if not strictly mapped.
                // Or better: We should seed default settings to avoid creating arbitrary keys via POST.
                // But for flexibility, let's create it.
                Setting::create([
                    'key' => $key,
                    'value' => $value,
                    'value' => $value,
                    'group' => $this->inferGroup($key),
                ]);
            }
        }
        
        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function updateAppearance(Request $request) 
    {
        $data = $request->validate([
            'appearance_sidebar_bg' => 'nullable',
            'appearance_sidebar_text' => 'nullable',
            'appearance_primary_color' => 'nullable',
            'appearance_mode' => 'nullable',
        ]);

        // Filter out null values to update only what is sent
        $data = array_filter($data, function($value) { return !is_null($value); });

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'appearance']
            );
        }

        return response()->json(['success' => true]);
    }

    private function inferGroup($key)
    {
        if (str_starts_with($key, 'payment_')) return 'payment';
        if (str_starts_with($key, 'shipping_')) return 'shipping';
        if (str_starts_with($key, 'appearance_')) return 'appearance';
        return 'general';
    }
}

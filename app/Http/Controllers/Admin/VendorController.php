<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SettingKey;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Product Categories';
        $nav = [];
        $search = true;

        $vendors = User::with('vendorProfile')
            ->where('role', 'vendor')
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('sort_by'), fn($q) => match($request->sort_by) {
                'date_asc'  => $q->orderBy('updated_at'),
                'date_desc' => $q->orderByDesc('updated_at'),
                'name_asc'  => $q->orderBy('name'),
                'name_desc' => $q->orderByDesc('name'),
            })
            ->paginate($request->integer('per_page', setting(SettingKey::AdminPaginationPerPage)));

        return view('admin.vendor.index', compact('title', 'nav', 'search', 'vendors'));
    }

    public function details(User $vendor)
    {
        abort_unless($vendor->role === 'vendor', 404);
        $vendor->load('vendorProfile');
        $profile  = $vendor->vendorProfile;
        $approver = $profile?->approved_by ? User::find($profile->approved_by) : 'N?A';
        return view('admin.vendor.partials.details', compact('vendor', 'profile', 'approver'))->render();
    }

    public function add()
    {
        return view('admin.vendor.form');
    }

    public function edit()
    {
        return view('admin.vendor.form');
    }

    public function save(VendorRequest $request, ?User $vendor = null)
    {
        $data      = $request->validated();
        $profile   = $vendor?->vendorProfile;
        $oldLogo   = $profile?->store_logo;
        $oldAvatar = $vendor?->avatar;
        $newLogo   = null;
        $newAvatar = null;

        DB::beginTransaction();

        try {
            if ($request->hasFile('store_logo')) {
                $newLogo = $request->file('store_logo')->store('vendors/logos', 'public');
            }

            if ($request->hasFile('avatar')) {
                $newAvatar = $request->file('avatar')->store('vendors/avatars', 'public');
            }

            $userData = Arr::only($data, ['name', 'email', 'phone', 'status', 'password', 'role']);

            if ($newAvatar) {
                $userData['avatar'] = $newAvatar;
            }

            $profileData = Arr::except($data, ['name', 'email', 'phone', 'avatar', 'status', 'password', 'role', 'store_logo']);

            if ($newLogo) {
                $profileData['store_logo'] = $newLogo;
            }

            if ($vendor) {
                $vendor->update($userData);
                $vendor->vendorProfile()->updateOrCreate([], $profileData);
            } else {
                User::create($userData)->vendorProfile()->create($profileData);
            }

            DB::commit();

            if ($newLogo)   $this->deleteFile($oldLogo);
            if ($newAvatar) $this->deleteFile($oldAvatar);

            return back()->with('success', $vendor ? 'Vendor updated successfully.' : 'Vendor created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->deleteFile($newLogo);
            $this->deleteFile($newAvatar);

            Log::error('Vendor save failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Something went wrong while saving the vendor.');
        }
    }

    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}

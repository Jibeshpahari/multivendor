<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\User;
use App\Models\VendorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function index() {
        return view('admin.vendor.index');
    }

    public function add() {
        return view('admin.vendor.form');
    }

    public function edit()
    {
        return view('admin.vendor.form');
    }

    public function save(VendorRequest $request, ?VendorProfile $vendor = null)
    {
        $data   = $request->validated();
        $isEdit = $vendor !== null;
        $user   = $vendor?->user;

        $oldLogo   = $vendor?->store_logo;
        $oldAvatar = $user?->avatar;
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

            if ($isEdit) {
                $user->update($userData);
                $vendor->update($profileData);
            } else {
                User::create($userData)->vendorProfile()->create($profileData);
            }

            DB::commit();

            // Delete old images
            if ($newLogo) $this->deleteFile($oldLogo);
            if ($newAvatar) $this->deleteFile($oldAvatar);

            return back()->with('success', $isEdit ? 'Vendor updated successfully.' : 'Vendor created successfully.');
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

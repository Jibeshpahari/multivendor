<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\User;
use App\Models\VendorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function save(VendorRequest $request, $id = null)
    {
        $data = $request->validated();

        $user       = $id ? User::with('vendorProfile')->findOrFail($id) : null;
        $oldLogo    = $user?->vendorProfile?->store_logo;
        $newLogo    = null;

        DB::beginTransaction();

        try {
            // 1. Upload new logo if one was sent
            if ($request->hasFile('store_logo')) {
                $newLogo = $request->file('store_logo')->store('vendors/logos', 'public');
            }

            // 2. Split the data
            $userData = [
                'name'  => $data['name'],
                'email' => $data['email'],
            ];

            $profileData = Arr::except($data, ['name', 'email', 'store_logo']);

            // Only touch store_logo if a new file was uploaded
            if ($newLogo) {
                $profileData['store_logo'] = $newLogo;
            }

            // 3. Create or update
            if ($user) {
                $user->update($userData);
                $user->vendorProfile()->update($profileData);
            } else {
                $user = User::create($userData + [
                    'password' => Hash::make(Str::random(16)),
                    'role'     => 'vendor',
                ]);
                $user->vendorProfile()->create($profileData);
            }

            DB::commit();

            // 4. Delete the OLD logo only after a successful commit
            if ($newLogo && $oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            return redirect()
                ->route('admin.vendors.index')
                ->with('success', $id ? 'Vendor updated successfully.' : 'Vendor created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            // Remove the NEW upload, since the DB changes were rolled back
            if ($newLogo) {
                Storage::disk('public')->delete($newLogo);
            }

            Log::error('Vendor save failed: ' . $th->getMessage(), [
                'trace' => $th->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the vendor.');
        }
    }
}

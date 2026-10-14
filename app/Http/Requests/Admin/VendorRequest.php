<?php

namespace App\Http\Requests\Admin;

use App\Models\VendorProfile;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $vendor = $this->route('vendor');
        $isEdit = !empty($vendor);

        $profile = $vendor instanceof VendorProfile ? $vendor : ($isEdit ? VendorProfile::withTrashed()->find($vendor) : null);

        $profileId = $profile?->getKey();
        $userId    = $profile?->user_id;

        return [
            // users table
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId),],
            'phone'           => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'avatar'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'          => ['required', Rule::in(['pending', 'active', 'rejected', 'suspended', 'banned'])],

            // vendor_profiles table
            'store_name'      => ['required', 'string', 'max:255'],
            'store_slug'      => ['nullable', 'string', 'max:255',
                Rule::unique('vendor_profiles', 'store_slug')->ignore($profileId),
            ],
            'store_logo'      => [$isEdit ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'contact_role'    => ['nullable', 'string', 'max:100'],
            'store_email'     => ['nullable', 'email', 'max:255'],
            'store_phone'     => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'alt_phone'       => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'whatsapp_number' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'address_line'    => ['required', 'string', 'max:255'],
            'city'            => ['required', 'string', 'max:100'],
            'state'           => ['required', 'string', 'max:100'],
            'postal_code'     => ['required', 'string', 'max:20'],
            'country'         => ['required', Rule::in(['IN', 'US', 'GB', 'AE', 'BD', 'NP'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'            => 'Full Name',
            'email'           => 'Personal Email',
            'phone'           => 'Personal Number',
            'avatar'          => 'Profile Photo',
            'status'          => 'Status',
            'store_name'      => 'Store Name',
            'store_slug'      => 'Store Slug',
            'store_logo'      => 'Store Logo',
            'contact_role'    => 'Role',
            'store_email'     => 'Organization Email',
            'store_phone'     => 'Organization Mobile',
            'alt_phone'       => 'Alternate / Office Phone',
            'whatsapp_number' => 'WhatsApp',
            'address_line'    => 'Address',
            'city'            => 'City',
            'state'           => 'State',
            'postal_code'     => 'Postal Code',
            'country'         => 'Country',
        ];
    }

    public function passedValidation(): void {
            

    }
}

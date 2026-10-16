<?php

namespace App\Http\Requests\Admin;

use App\Models\VendorProfile;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

    public function rules(): array
    {
        /** @var VendorProfile|null $profile */
        $profile = $this->route('vendor');
        $userId    = $profile?->user_id;

        return [
            // users table
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId),],
            'phone'           => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'avatar'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'          => ['required', 'in:pending,active,rejected,suspended,banned'],
            // vendor_profiles table
            'store_name'      => ['required', 'string', 'max:255'],
            'store_slug'      => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'store_logo'      => [$profile ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'contact_role'    => ['nullable', 'string', 'max:100'],
            'store_email'     => ['nullable', 'email', 'max:255'],
            'store_phone'     => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'alt_phone'       => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'whatsapp_number' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'address_line'    => ['required', 'string', 'max:255'],
            'city'            => ['required', 'string', 'max:100'],
            'state'           => ['required', 'string', 'max:100'],
            'postal_code'     => ['required', 'string', 'max:20'],
            'country'         => ['required', 'in:IN,US,GB,AE,BD,NP'],
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


    protected function prepareForValidation(): void
    {
        $this->merge([
            'store_slug' => Str::slug((string) $this->input('store_name')),
        ]);
    }


    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        if (! $this->route('vendor')) {
            $data['password'] = Hash::make(Str::random(16));
            $data['role']     = 'vendor';
        }

        return $key ? data_get($data, $key, $default) : $data;
    }


    protected function passedValidation(): void {}
}

<?php

namespace Munkireport\Osquery\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Enrollment - Validates Enrollment Request Body
 *
 * Example:
 *
 *
 * @package Munkireport\Osquery\Http\Requests
 */
class EnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'enroll_secret' => 'required',
            // Typically the hostname if not specified
            'host_identifier' => 'required',
            'host_details.os_version' => 'required',
            'host_details.osquery_info' => 'required',
            'host_details.system_info' => 'required',
            'host_details.platform_info' => 'required'
        ];
    }
}

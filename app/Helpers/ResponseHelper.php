<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * Return a success response.
     *
     * @param string $message
     * @param mixed $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function success($message, $data = null)
    {
        return redirect()->back()->with([
            'success' => $message,
            'data' => $data
        ]);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param array $errors
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function error($message, $errors = [])
    {
        return redirect()->back()->with([
            'error' => $message,
            'errors' => $errors
        ])->withInput();
    }

    /**
     * Return a validation error response.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function validationError($validator)
    {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
}

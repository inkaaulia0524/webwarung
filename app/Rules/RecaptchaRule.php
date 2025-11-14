<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ReCaptcha\ReCaptcha; 

class RecaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('Validasi reCAPTCHA wajib diisi.');
            return;
        }

        try {
            $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
            $resp = $recaptcha->verify($value, request()->ip()); // Verifikasi token + IP

            if (!$resp->isSuccess()) {
                $fail('Validasi reCAPTCHA gagal. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            $fail('Tidak dapat memverifikasi reCAPTCHA.');
        }
    }
}
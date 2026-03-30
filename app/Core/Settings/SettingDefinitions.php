<?php

namespace App\Core\Settings;

final class SettingDefinitions
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'general.default_language' => [
                'label' => 'Default language',
                'input' => 'readonly',
                'hint' => 'Manage in Admin → Languages.',
            ],
            'general.default_country_iso2' => [
                'label' => 'Default country',
                'input' => 'readonly',
                'hint' => 'Manage in Admin → Countries.',
            ],
            'general.default_currency_code' => [
                'label' => 'Default currency',
                'input' => 'readonly',
                'hint' => 'Managed by the default country (currency_code).',
            ],

            'auth.enabled_methods' => [
                'label' => 'Enabled auth methods',
                'input' => 'readonly',
                'hint' => 'Manage in Admin → Authentication Methods.',
            ],

            'payment.gateway' => [
                'label' => 'Payment gateway',
                'input' => 'select',
                'options' => [
                    'razorpay' => 'Razorpay',
                    'stripe' => 'Stripe',
                    'paypal' => 'PayPal',
                ],
            ],
            'payment.mode' => [
                'label' => 'Payment mode',
                'input' => 'select',
                'options' => [
                    'sandbox' => 'Sandbox',
                    'production' => 'Production',
                ],
            ],
            'payment.razorpay_key_id' => [
                'label' => 'Razorpay key id',
                'input' => 'text',
                'placeholder' => 'rzp_test_...',
            ],
            'payment.razorpay_key_secret' => [
                'label' => 'Razorpay key secret',
                'input' => 'secret',
            ],
            'payment.stripe_public_key' => [
                'label' => 'Stripe public key',
                'input' => 'text',
                'placeholder' => 'pk_test_...',
            ],
            'payment.stripe_secret_key' => [
                'label' => 'Stripe secret key',
                'input' => 'secret',
            ],
            'payment.paypal_client_id' => [
                'label' => 'PayPal client id',
                'input' => 'text',
            ],
            'payment.paypal_client_secret' => [
                'label' => 'PayPal client secret',
                'input' => 'secret',
            ],

            'sms.gateway' => [
                'label' => 'SMS gateway',
                'input' => 'select',
                'options' => [
                    'firebase' => 'Firebase',
                    'twilio' => 'Twilio',
                    'msg91' => 'MSG91',
                ],
            ],
            'sms.mode' => [
                'label' => 'SMS mode',
                'input' => 'select',
                'options' => [
                    'sandbox' => 'Sandbox',
                    'production' => 'Production',
                ],
            ],
            'sms.twilio_sid' => [
                'label' => 'Twilio SID',
                'input' => 'text',
            ],
            'sms.twilio_token' => [
                'label' => 'Twilio token',
                'input' => 'secret',
            ],
            'sms.twilio_from' => [
                'label' => 'Twilio from',
                'input' => 'text',
                'placeholder' => '+1...',
            ],
            'sms.firebase_api_key' => [
                'label' => 'Firebase API key',
                'input' => 'secret',
            ],
            'sms.firebase_project_id' => [
                'label' => 'Firebase project id',
                'input' => 'text',
            ],
            'sms.msg91_auth_key' => [
                'label' => 'MSG91 auth key',
                'input' => 'secret',
            ],
            'sms.msg91_sender_id' => [
                'label' => 'MSG91 sender id',
                'input' => 'text',
            ],

            'wallet.enabled' => [
                'label' => 'Wallet enabled',
                'input' => 'toggle',
            ],

            'theme.default_mode' => [
                'label' => 'Default theme',
                'input' => 'select',
                'options' => [
                    'dark' => 'Dark',
                    'light' => 'Light',
                ],
            ],

            'compliance.cookie_banner_enabled' => [
                'label' => 'Cookie banner enabled',
                'input' => 'toggle',
            ],
            'compliance.cookie_consent_text' => [
                'label' => 'Cookie consent text',
                'input' => 'textarea',
            ],

            'branding.logo_path' => [
                'label' => 'Logo',
                'input' => 'file',
                'accept' => 'image/*',
            ],
            'branding.favicon_path' => [
                'label' => 'Favicon',
                'input' => 'file',
                'accept' => 'image/*',
            ],
        ];
    }
}


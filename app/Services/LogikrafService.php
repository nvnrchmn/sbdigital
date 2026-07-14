<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LogikrafService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = \App\Models\Setting::get('logikraf_api_key', config('logikraf.api_key'));
        $this->baseUrl = config('logikraf.base_url');
    }

    /**
     * Create a new Sub-Account for a Tenant (RT/RW)
     * 
     * @param string $tenantId
     * @param string $namaRt
     * @param string $email
     * @return array|null
     */
    public function createSubAccount(string $tenantId, string $namaRt, string $email)
    {
        if (!$this->apiKey) {
            Log::warning('Logikraf API Key is missing. Skipping Sub-Account creation.');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'X-Logikraf-API-Key' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/sub-accounts", [
                'external_reference_id' => $tenantId,
                'business_name' => $namaRt,
                'email' => $email,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Logikraf createSubAccount failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Logikraf createSubAccount exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new Invoice for Warga
     * 
     * @param string $invoiceId
     * @param string $tenantId
     * @param float $amount
     * @param string $payerEmail
     * @param string $description
     * @return array|null
     */
    public function createInvoice(string $invoiceId, string $tenantId, float $amount, string $payerEmail, string $description)
    {
        if (!$this->apiKey) {
            Log::warning('Logikraf API Key is missing. Skipping Invoice creation.');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'X-Logikraf-API-Key' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/invoices", [
                'external_id' => $invoiceId,
                'external_reference_id' => $tenantId,
                'amount' => $amount,
                'payer_email' => $payerEmail,
                'description' => $description,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Logikraf createInvoice failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Logikraf createInvoice exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new Master Invoice (Payment goes to Superadmin directly)
     * 
     * @param string $invoiceId
     * @param float $amount
     * @param string $payerEmail
     * @param string $description
     * @return array|null
     */
    public function createMasterInvoice(string $invoiceId, string $tenantId, float $amount, string $payerEmail, string $description)
    {
        if (!$this->apiKey) {
            Log::warning('Logikraf API Key is missing. Skipping Master Invoice creation.');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'X-Logikraf-API-Key' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/invoices", [
                'external_id' => $invoiceId,
                'external_reference_id' => $tenantId,
                'amount' => $amount,
                'platform_fee_amount' => $amount, // 100% dana langganan ditarik ke SaaS
                'payer_email' => $payerEmail,
                'description' => $description,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Logikraf createMasterInvoice failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Logikraf createMasterInvoice exception: ' . $e->getMessage());
            return null;
        }
    }
}

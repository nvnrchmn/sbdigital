<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeploymentController extends Controller
{
    /**
     * Triggered by GitHub Actions to deploy updates.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function deploy($token)
    {
        $expectedToken = config('app.deploy_token') ?: env('DEPLOY_TOKEN');

        if (empty($expectedToken) || !hash_equals($expectedToken, $token)) {
            Log::warning('Deployment Webhook: Invalid token provided.');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $scriptPath = base_path('deploy.sh');

        if (!file_exists($scriptPath)) {
            Log::error("Deployment Webhook: deploy.sh not found at {$scriptPath}");
            return response()->json(['message' => 'Deployment script not found'], 500);
        }

        // Jalankan bash script di background agar request HTTP tidak timeout
        // Output dari skrip didelegasikan ke deploy.sh yang akan menyimpannya ke storage/logs/deploy.log
        Log::info('Deployment Webhook: Triggering deploy.sh in the background...');
        
        // Menambahkan output redirection khusus agar process terputus dari parent PHP process
        exec("bash {$scriptPath} > /dev/null 2>&1 &");

        return response()->json([
            'message' => 'Deployment triggered successfully in the background.',
            'timestamp' => now()->toIso8601String()
        ]);
    }
}

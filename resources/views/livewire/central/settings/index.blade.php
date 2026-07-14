<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Pengaturan Sistem</h2>
        <p class="text-slate-500 text-sm mt-1">Kelola integrasi dan konfigurasi global untuk seluruh tenant SBDigital.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col md:flex-row min-h-[500px]">
        
        <!-- Sidebar Tabs -->
        <div class="w-full md:w-64 bg-slate-50 border-r border-slate-200 flex flex-col">
            <button 
                wire:click="$set('activeTab', 'logikraf')"
                class="flex items-center gap-3 px-6 py-4 text-left transition-colors {{ $activeTab === 'logikraf' ? 'bg-white border-l-4 border-brand-indigo-500 text-brand-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 border-l-4 border-transparent' }}"
            >
                <svg class="w-5 h-5 {{ $activeTab === 'logikraf' ? 'text-brand-indigo-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Logikraf Payment
            </button>
            <button 
                wire:click="$set('activeTab', 'email')"
                class="flex items-center gap-3 px-6 py-4 text-left transition-colors {{ $activeTab === 'email' ? 'bg-white border-l-4 border-brand-indigo-500 text-brand-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 border-l-4 border-transparent' }}"
            >
                <svg class="w-5 h-5 {{ $activeTab === 'email' ? 'text-brand-indigo-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Email (SMTP)
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-1 p-6 md:p-8">
            
            <!-- Logikraf Tab -->
            <div class="{{ $activeTab === 'logikraf' ? 'block' : 'hidden' }}">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Logikraf Payment Hub</h3>
                    <p class="text-slate-500 text-sm">Konfigurasi API Key untuk menghubungkan SBDigital dengan Logikraf.</p>
                </div>

                <!-- Webhook Helper Info -->
                <div class="mb-8 bg-indigo-50 rounded-xl p-5 border border-indigo-100">
                    <h4 class="font-semibold text-indigo-900 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Webhook URL
                    </h4>
                    <p class="text-indigo-700 text-sm mb-3">Salin URL di bawah ini dan tempelkan ke pengaturan Webhook di Dashboard Logikraf Anda agar sistem mendeteksi pembayaran secara otomatis.</p>
                    <div class="flex items-center gap-2">
                        <input type="text" readonly value="{{ $webhookUrl }}" class="flex-1 bg-white border border-indigo-200 text-indigo-800 rounded-lg px-3 py-2 text-sm font-mono focus:ring-0" id="webhookUrlInput">
                        <button onclick="copyWebhookUrl()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors">
                            Copy
                        </button>
                    </div>
                </div>

                <form wire:submit="saveLogikraf" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">API Key</label>
                        <input type="text" wire:model="logikraf_api_key" placeholder="Contoh: sk_test_xxxxx..." class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm font-mono text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Webhook Secret</label>
                        <input type="text" wire:model="logikraf_webhook_secret" placeholder="Contoh: whsec_xxxxx..." class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm font-mono text-sm">
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <button type="submit" wire:loading.attr="disabled" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors text-sm shadow-sm flex items-center">
                            <span wire:loading.remove wire:target="saveLogikraf">Simpan Pengaturan</span>
                            <span wire:loading wire:target="saveLogikraf">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Email Tab -->
            <div class="{{ $activeTab === 'email' ? 'block' : 'hidden' }}">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Email SMTP (Global)</h3>
                    <p class="text-slate-500 text-sm">Pengaturan pengiriman email dari sistem seperti notifikasi, verifikasi, dsb.</p>
                </div>

                <form wire:submit="saveMail" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Mailer</label>
                            <select wire:model="mail_mailer" class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm text-sm bg-white">
                                <option value="">-- Pilih Mailer --</option>
                                <option value="smtp">SMTP (Recommended)</option>
                                <option value="sendmail">Sendmail</option>
                                <option value="mailgun">Mailgun</option>
                                <option value="ses">Amazon SES</option>
                                <option value="postmark">Postmark</option>
                                <option value="log">Log (Testing)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Encryption</label>
                            <select wire:model="mail_encryption" class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm text-sm bg-white">
                                <option value="">Tanpa Enkripsi (None)</option>
                                <option value="tls">TLS</option>
                                <option value="ssl">SSL</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Host</label>
                            <input type="text" wire:model="mail_host" placeholder="smtp.mailtrap.io" class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Port</label>
                            <input type="text" wire:model="mail_port" placeholder="2525" class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm text-sm">
                        </div>
                        <div></div> <!-- Empty column for grid alignment -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                            <input type="text" wire:model="mail_username" class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                            <input type="password" wire:model="mail_password" class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">From Address</label>
                            <input type="email" wire:model="mail_from_address" placeholder="noreply@domainanda.com" class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">From Name</label>
                            <input type="text" wire:model="mail_from_name" placeholder="SBDigital Admin" class="w-full rounded-xl border-slate-300 focus:border-brand-indigo-500 focus:ring-brand-indigo-500 shadow-sm text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <button type="submit" wire:loading.attr="disabled" class="bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors text-sm shadow-sm flex items-center">
                            <span wire:loading.remove wire:target="saveMail">Simpan Pengaturan Email</span>
                            <span wire:loading wire:target="saveMail">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Script for copy to clipboard -->
    <script>
        function copyWebhookUrl() {
            var copyText = document.getElementById("webhookUrlInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            navigator.clipboard.writeText(copyText.value);
            
            // Dispatch a Livewire event to trigger the SweetAlert notification
            window.dispatchEvent(new CustomEvent('notify', { detail: { message: 'Webhook URL tersalin ke clipboard!' }}));
        }
    </script>
</div>

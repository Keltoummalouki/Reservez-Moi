<div class="p-6 border-b border-gray-200">
    <h2 class="text-lg font-medium text-gray-900">Paiements</h2>
    <p class="mt-1 text-sm text-gray-500">Gérez vos informations de paiement et vos préférences</p>
</div>
<div class="p-6 space-y-6">
    <!-- Bank Account Information -->
    <div>
        <h3 class="text-base font-medium text-gray-900 mb-4">Informations bancaires</h3>
        <form action="{{ route('provider.settings.update-payment') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label for="account_holder" class="block text-sm font-medium text-gray-700">Titulaire du compte</label>
                <input type="text" name="account_holder" id="account_holder" value="{{ old('account_holder', $payment->account_holder ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
            <div>
                <label for="iban" class="block text-sm font-medium text-gray-700">IBAN</label>
                <input type="text" name="iban" id="iban" value="{{ old('iban', $payment->iban ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
            <div>
                <label for="bic" class="block text-sm font-medium text-gray-700">BIC/SWIFT</label>
                <input type="text" name="bic" id="bic" value="{{ old('bic', $payment->bic ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Enregistrer les informations bancaires
                </button>
            </div>
        </form>
    </div>
    <!-- Payment Preferences -->
    <div class="pt-6 border-t border-gray-200">
        <h3 class="text-base font-medium text-gray-900 mb-4">Préférences de paiement</h3>
        <form action="{{ route('provider.settings.update-payment-preferences') }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Méthode de paiement préférée</label>
                <select name="payment_method" id="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    <option value="bank_transfer" {{ isset($payment) && $payment->payment_method == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                    <option value="stripe" {{ isset($payment) && $payment->payment_method == 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="paypal" {{ isset($payment) && $payment->payment_method == 'paypal' ? 'selected' : '' }}>PayPal</option>
                </select>
            </div>
            <div>
                <label for="payout_frequency" class="block text-sm font-medium text-gray-700">Fréquence de versement</label>
                <select name="payout_frequency" id="payout_frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    <option value="weekly" {{ isset($payment) && $payment->payout_frequency == 'weekly' ? 'selected' : '' }}>Hebdomadaire</option>
                    <option value="biweekly" {{ isset($payment) && $payment->payout_frequency == 'biweekly' ? 'selected' : '' }}>Bimensuelle</option>
                    <option value="monthly" {{ isset($payment) && $payment->payout_frequency == 'monthly' ? 'selected' : '' }}>Mensuelle</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Enregistrer les préférences
                </button>
            </div>
        </form>
    </div>
    <!-- Payment History -->
    <div class="pt-6 border-t border-gray-200">
        <h3 class="text-base font-medium text-gray-900 mb-4">Historique des paiements</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments ?? [] as $payment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $payment->date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->amount }} €</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $payment->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($payment->method) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aucun paiement trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div> 
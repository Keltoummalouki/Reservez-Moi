<div class="p-6 border-b border-gray-200">
    <h2 class="text-lg font-medium text-gray-900">Notifications</h2>
    <p class="mt-1 text-sm text-gray-500">Gérez vos préférences de notifications</p>
</div>
<form action="{{ route('provider.settings.update-notifications') }}" method="POST" class="p-6 space-y-6">
    @csrf
    @method('PATCH')
    <div class="space-y-6">
        <div>
            <h3 class="text-base font-medium text-gray-900">Notifications par e-mail</h3>
            <div class="mt-4 space-y-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="email_new_reservation" name="email_new_reservation" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->email_new_reservation ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="email_new_reservation" class="font-medium text-gray-700">Nouvelles réservations</label>
                        <p class="text-gray-500">Recevez un e-mail lorsqu'un client effectue une nouvelle réservation.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="email_reservation_reminder" name="email_reservation_reminder" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->email_reservation_reminder ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="email_reservation_reminder" class="font-medium text-gray-700">Rappels de réservation</label>
                        <p class="text-gray-500">Recevez un e-mail de rappel avant les réservations à venir.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="email_reservation_cancelled" name="email_reservation_cancelled" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->email_reservation_cancelled ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="email_reservation_cancelled" class="font-medium text-gray-700">Annulations de réservation</label>
                        <p class="text-gray-500">Recevez un e-mail lorsqu'un client annule une réservation.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="email_marketing" name="email_marketing" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->email_marketing ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="email_marketing" class="font-medium text-gray-700">Communications marketing</label>
                        <p class="text-gray-500">Recevez des e-mails sur les nouvelles fonctionnalités, les conseils et les offres spéciales.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-6 border-t border-gray-200">
            <h3 class="text-base font-medium text-gray-900">Notifications SMS</h3>
            <div class="mt-4 space-y-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="sms_new_reservation" name="sms_new_reservation" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->sms_new_reservation ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="sms_new_reservation" class="font-medium text-gray-700">Nouvelles réservations</label>
                        <p class="text-gray-500">Recevez un SMS lorsqu'un client effectue une nouvelle réservation.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="sms_reservation_reminder" name="sms_reservation_reminder" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->sms_reservation_reminder ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="sms_reservation_reminder" class="font-medium text-gray-700">Rappels de réservation</label>
                        <p class="text-gray-500">Recevez un SMS de rappel avant les réservations à venir.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-6 border-t border-gray-200">
            <h3 class="text-base font-medium text-gray-900">Notifications dans l'application</h3>
            <div class="mt-4 space-y-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="app_all_notifications" name="app_all_notifications" type="checkbox" class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded" {{ isset($notifications) && $notifications->app_all_notifications ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="app_all_notifications" class="font-medium text-gray-700">Toutes les notifications</label>
                        <p class="text-gray-500">Activez ou désactivez toutes les notifications dans l'application.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-5 border-t border-gray-200 flex justify-end">
        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Enregistrer les préférences
        </button>
    </div>
</form> 
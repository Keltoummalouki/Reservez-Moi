// SweetAlert Configuration for all actions
const SweetAlertConfig = {
    // Confirmation dialogs
    confirm: {
        confirmReservation: {
            title: 'Confirmer la réservation',
            text: 'Êtes-vous sûr de vouloir confirmer cette réservation?',
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, confirmer',
            cancelButtonText: 'Annuler'
        },
        cancelReservation: {
            title: 'Annuler la réservation',
            text: 'Êtes-vous sûr de vouloir annuler cette réservation?',
            icon: 'warning',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, annuler',
            cancelButtonText: 'Non'
        },
        deleteItem: {
            title: 'Supprimer',
            text: 'Êtes-vous sûr de vouloir supprimer cet élément?',
            icon: 'warning',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        },
        updateItem: {
            title: 'Mettre à jour',
            text: 'Êtes-vous sûr de vouloir mettre à jour cet élément?',
            icon: 'question',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, mettre à jour',
            cancelButtonText: 'Annuler'
        }
    },

    // Success messages
    success: {
        reservationConfirmed: {
            title: 'Succès',
            text: 'La réservation a été confirmée avec succès!',
            icon: 'success',
            confirmButtonColor: '#3085d6'
        },
        reservationCancelled: {
            title: 'Succès',
            text: 'La réservation a été annulée avec succès!',
            icon: 'success',
            confirmButtonColor: '#3085d6'
        },
        itemDeleted: {
            title: 'Succès',
            text: 'L\'élément a été supprimé avec succès!',
            icon: 'success',
            confirmButtonColor: '#3085d6'
        },
        itemUpdated: {
            title: 'Succès',
            text: 'L\'élément a été mis à jour avec succès!',
            icon: 'success',
            confirmButtonColor: '#3085d6'
        }
    },

    // Error messages
    error: {
        generalError: {
            title: 'Erreur',
            text: 'Une erreur est survenue. Veuillez réessayer.',
            icon: 'error',
            confirmButtonColor: '#d33'
        },
        validationError: {
            title: 'Erreur de validation',
            text: 'Veuillez vérifier les informations saisies.',
            icon: 'error',
            confirmButtonColor: '#d33'
        }
    },

    // Info messages
    info: {
        comingSoon: {
            title: 'Bientôt disponible',
            text: 'Cette fonctionnalité sera bientôt disponible!',
            icon: 'info',
            confirmButtonColor: '#3085d6'
        }
    }
};

// Helper functions for SweetAlert
const SweetAlertHelper = {
    // Show confirmation dialog
    confirm: function(config, callback) {
        Swal.fire({
            ...SweetAlertConfig.confirm[config],
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed && callback) {
                callback();
            }
        });
    },

    // Show success message
    success: function(config, callback) {
        Swal.fire({
            ...SweetAlertConfig.success[config],
            showCancelButton: false
        }).then(() => {
            if (callback) {
                callback();
            }
        });
    },

    // Show error message
    error: function(config, callback) {
        Swal.fire({
            ...SweetAlertConfig.error[config],
            showCancelButton: false
        }).then(() => {
            if (callback) {
                callback();
            }
        });
    },

    // Show info message
    info: function(config, callback) {
        Swal.fire({
            ...SweetAlertConfig.info[config],
            showCancelButton: false
        }).then(() => {
            if (callback) {
                callback();
            }
        });
    }
}; 
export default {
    methods: {
        /**
         * Raccourcis de la méthode toast de Materialize
         * @param message - Message à afficher
         * @param action - Lien/bouton HTML pour réaliser une action
         * @param delay - Délais avant disparition
         */
        toast (message, action = null, delay = 3000) {
            if (action !== null) message += action
            Materialize.toast(message, delay)
        },
        /**
         * Vérifie si l'utilisateur est connecté
         */
        authCheck () {
            if (window.App.user === null) {
                let message = `<i class='material-icons left amber-text'>warning</i> Connexion requise.`
                let action = `<a class='btn-flat blue-text waves-effect right' href='/utilisateurs/authentification' >
                            <i class='material-icons right'>arrow_forward</i> Connexion
                        </a>`

                this.toast(message, action)

                return false
            }

            return true
        }
    }
}

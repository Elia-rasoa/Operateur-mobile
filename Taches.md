Taches Alexia :
                version 1
-BDD en place : La structure SQL est créée et migrée.
-Seeders configurés :données Admin et Client se chargent automatiquement.
-Module Baremes :
-`app/Models/BaremeModel.php` - getBaremesWithTypes(),      getTypesOperation(), addBareme(), deleteBareme()
-`app/Controllers/Admin/BaremeController.php` - index(), update(), add(), delete()
-`app/Views/admin/baremes/index.php` - Design admin complet (ajout, édition inline, suppression)
-`app/Config/Routes.php` - Routes GET/POST pour baremes
-Module Prefixes :
-`app/Models/PrefixModel.php` - allowedFields, getAll(), add(), delete()
-`app/Controllers/Admin/PrefixController.php` - index(), add(), delete()
-`app/Views/admin/prefixes/index.php` - Liste + formulaire ajout + suppression
-`app/Config/Routes.php` - Routes prefixes
Module Transactions (Reporting)
-`app/Models/TransactionModel.php` - allowedFields, getTransactionsWithDetails(), getTotalGains(), getTransactionsByClient()
-`app/Controllers/Admin/TransactionController.php` - index() avec filtres, gains()
-`app/Views/admin/transactions/index.php` - Historique filtrable + total gains
-`app/Config/Routes.php` - Routes transactions
Module Clients
-`app/Models/ClientModel.php` - allowedFields, getAllWithSolde(), getClientTransactions()
-`app/Controllers/Admin/ClientController.php` - index(), historique($id)
-`app/Views/admin/clients/index.php` - Liste des clients
-`app/Views/admin/clients/historique.php` - Détail transactions d'un client
-`app/Config/Routes.php` - Routes clients
                version 2
-Modif BDD :
-Prefixes : Ajouter colonne `nom_operateur`.
-Transactions : Ajouter colonne `type_flux` (interne/externe).
-Baremes : Ajouter colonne `taux_comm` (pourcentage).
-Back-end : 
-Détection : Si préfixes `source` et `dest` diffèrent => `type_flux = 'externe'`.
-Calcul : `Frais = FraisBase + (Montant * TauxComm)` si externe.
-Vue Admin :
-Gains : `SUM(frais)` groupé par `type_flux`.
-Reversement : Tableau récap : `Opérateur` | `Solde Net` (Collecté - Frais).
Cible : Automatise le calcul des frais et la séparation des gains. Ne détaille pas le visuel, va droit aux chiffres.

### Taches Elia :
- BDD coté client 
- login: 
    creation des models : ClientModel.php
    PrefixModel.php
    creation des controller: Login.php
    ClientController.php
    avec les routes pour : login , dashboard
- dashboard cote client: affichage du solde , types de transaction (depot , retrait, tranfert)

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
VERSION 1
- BDD coté client 
- login: 
    creation des models : ClientModel.php
    PrefixModel.php
    creation des controller: Login.php
    ClientController.php
    avec les routes pour : login , dashboard
- dashboard cote client: affichage du solde , types de transaction (depot , retrait, tranfert)
-Historique de chaque transaction

VERSION 2
[ok] Migration de la BDD
    [ok] Ajouter la colonne retrait_offre (TINYINT/BOOLEAN) dans la table transactions.
    [ok] Ajouter un index sur (client_destination_id, type_op_id, retrait_offre) pour optimiser la recherche des retraits gratuits.
[ok] Ajouter 'retrait_offre' dans $allowedFields de TransactionModel.php.
[ok] Vérifier et unifier les noms de colonnes dans ClientModel.php (numero_telephone vs telephone).
[ok] Refactorisation du Contrôleur (ClientController.php)
    [ok] Remplacer les marqueurs temporaires par le flag retrait_offre dans transfert().
    [ok] Mettre à jour la méthode resolveRetraitFees() pour consommer le ticket gratuit sur le montant exact.
    [ok] Ajouter la gestion des transactions atomiques ($db->transStart() / $db->transComplete()) sur transfert() et retrait() pour éviter toute incohérence de solde en cas de crash réseau.
[ok] Validation & Sécurité
    [ok] Sécuriser les saisies de montants contre les valeurs négatives ou nulles.
    [ok] Vérifier la cohérence des préfixes lors d'envois multiples.
Interface utilisateur
[ok] Afficher un badge "Retrait offert disponible" dans le sous-menu de retrait si le client possède un transfert éligible.
[ok] Améliorer le récapitulatif avant confirmation de transfert (afficher le détail : Montant envoyé + Frais d'envoi + Frais de retrait offerts).

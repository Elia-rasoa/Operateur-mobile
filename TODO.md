# TODO - Version 2 : Multi-opérateurs & Comptabilité

## Étapes

### Étape 1 : Migration Base de données
- [x] Créer migration `2026-07-21-000000_Version2Updates.php`
  - Table `operateur_courant` (id, nom_operateur, prefixe)
  - ALTER `prefixes` ADD `operateur_nom TEXT`
  - ALTER `baremes` ADD `commission_externe_pct REAL DEFAULT 0`
  - ALTER `transactions` ADD `type_reseau TEXT DEFAULT 'interne'`

### Étape 2 : Mise à jour des Models
- [ ] `PrefixModel.php` - Ajouter `operateur_nom` aux champs autorisés
- [ ] `BaremeModel.php` - Ajouter `commission_externe_pct`
- [ ] `TransactionModel.php` - Ajouter logique type_reseau interne/externe

### Étape 3 : Mise à jour des Controllers existants
- [ ] `PrefixController.php` - Gérer operateur_nom
- [ ] `BaremeController.php` - Gérer commission_externe_pct
- [ ] `TransactionController.php` - Gérer filtre type_reseau
- [ ] `DashboardController.php` - Ajouter stats gains

### Étape 4 : Mise à jour des Vues existantes
- [ ] `admin/prefixes/index.php` - Ajouter colonne opérateur
- [ ] `admin/baremes/index.php` - Ajouter commission externe
- [ ] `admin/transactions/index.php` - Ajouter type réseau, filtre
- [ ] `admin/dashboard/index.php` - Ajouter liens gains & reversement

### Étape 5 : Nouveaux Controllers
- [ ] `Admin/GainController.php` - Situation des gains
- [ ] `Admin/ReversementController.php` - Récapitulatif reversement

### Étape 6 : Nouvelles Vues
- [ ] `admin/gains/index.php`
- [ ] `admin/reversement/index.php`

### Étape 7 : Routes
- [ ] `Routes.php` - Ajouter routes gains, reversement

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Version2Updates extends Migration
{
    public function up()
    {
        // Table operateur_courant (une seule ligne)
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nom_operateur' => [
                'type' => 'TEXT',
            ],
            'prefixe' => [
                'type' => 'TEXT',
                'constraint' => 5,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('operateur_courant', true);

        // Ajout colonne operateur_nom dans prefixes
        $this->forge->addColumn('prefixes', [
            'operateur_nom' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'code',
            ],
        ]);

        // Ajout colonne commission_externe_pct dans baremes
        $this->forge->addColumn('baremes', [
            'commission_externe_pct' => [
                'type'    => 'REAL',
                'default' => 0,
                'after'   => 'frais',
            ],
        ]);

        // Ajout colonne type_reseau dans transactions
        $this->forge->addColumn('transactions', [
            'type_reseau' => [
                'type'    => 'TEXT',
                'default' => 'interne',
                'after'   => 'frais_appliques',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('operateur_courant', true);

        $this->forge->dropColumn('prefixes', 'operateur_nom');
        $this->forge->dropColumn('baremes', 'commission_externe_pct');
        $this->forge->dropColumn('transactions', 'type_reseau');
    }
}

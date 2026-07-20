<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMobileSchema extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'TEXT',
                'constraint' => 3,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('prefixes', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'nom' => [
                'type' => 'TEXT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nom');
        $this->forge->createTable('types_operation', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'type_op_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'montant_min' => [
                'type' => 'REAL',
            ],
            'montant_max' => [
                'type' => 'REAL',
            ],
            'frais' => [
                'type' => 'REAL',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('type_op_id', 'types_operation', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('baremes', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'telephone' => [
                'type' => 'TEXT',
            ],
            'nom' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'solde' => [
                'type'    => 'REAL',
                'default' => 0.00,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('telephone');
        $this->forge->createTable('clients', true);

        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true,
            ],
            'type_op_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'client_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'montant' => [
                'type' => 'REAL',
            ],
            'frais_appliques' => [
                'type' => 'REAL',
            ],
            'date_transaction' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('type_op_id', 'types_operation', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('client_id', 'clients', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('transactions', true);
    }

    public function down()
    {
        $this->forge->dropTable('transactions', true);
        $this->forge->dropTable('clients', true);
        $this->forge->dropTable('baremes', true);
        $this->forge->dropTable('types_operation', true);
        $this->forge->dropTable('prefixes', true);
    }
}

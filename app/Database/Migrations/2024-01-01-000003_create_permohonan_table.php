<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermohonanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idpermohonan' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'id_mustahik' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'kategoriasnaf' => [
                'type'       => 'ENUM',
                'constraint' => ['fakir', 'miskin', 'amil', 'muallaf', 'riqab', 'ghamrin', 'fisabillah', 'ibnusabil'],
                'null'       => false,
            ],
            'jenisbantuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'tglpengajuan' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'tgldisetujui' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'alasan' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['diproses', 'diterima', 'ditolak'],
                'default'    => 'diproses',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('idpermohonan', true);
        $this->forge->addForeignKey('id_mustahik', 'mustahik', 'id_mustahik', 'CASCADE', 'CASCADE');
        $this->forge->createTable('permohonan');
    }

    public function down()
    {
        $this->forge->dropTable('permohonan');
    }
}
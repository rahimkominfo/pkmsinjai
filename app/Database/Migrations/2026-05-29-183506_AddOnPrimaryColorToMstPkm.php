<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOnPrimaryColorToMstPkm extends Migration
{
    public function up()
    {
        $this->forge->addColumn('mst_pkm', [
            'on_primary_color' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '#1f2937', // Default dark text (slate-800)
                'after'      => 'primary_color'
            ]
        ]);
        
        // Update all existing PKMs to have white text if their primary color is dark, or slate if light.
        // For simplicity, we can just set it to white #ffffff for existing PKMs since we used a darkish default previously? 
        // Wait, default '#eaddff' is light purple, so dark text is better.
        // Let's set default to #1f2937 which is very readable on light purple.
    }

    public function down()
    {
        $this->forge->dropColumn('mst_pkm', 'on_primary_color');
    }
}

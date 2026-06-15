<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropUniqueSlugFromKategori extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE mst_kategori DROP INDEX slug');
        $this->db->query('ALTER TABLE mst_kategori ADD UNIQUE INDEX pkm_id_slug (pkm_id, slug)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE mst_kategori DROP INDEX pkm_id_slug');
        $this->db->query('ALTER TABLE mst_kategori ADD UNIQUE INDEX slug (slug)');
    }
}

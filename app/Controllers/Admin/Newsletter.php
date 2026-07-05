<?php

namespace App\Controllers\Admin;

class Newsletter extends BaseAdminController
{
    public function index()
    {
        $db = \Config\Database::connect();
        return $this->render('admin/newsletter', [
            'title'    => 'Newsletter',
            'abonnes'  => $db->table('newsletter_subscribers')->orderBy('created_at', 'DESC')->get()->getResultArray(),
        ]);
    }

    public function delete(int $id)
    {
        \Config\Database::connect()->table('newsletter_subscribers')->delete(['id' => $id]);
        return redirect()->to(base_url('admin/newsletter'))->with('success', 'Abonné supprimé.');
    }
}

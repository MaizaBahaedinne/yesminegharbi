<?php

namespace App\Controllers\Admin;

class Messages extends BaseAdminController
{
    public function index()
    {
        $db = \Config\Database::connect();
        return $this->render('admin/messages', [
            'title'    => 'Messages de contact',
            'messages' => $db->table('contact_messages')->orderBy('created_at', 'DESC')->get()->getResultArray(),
        ]);
    }

    public function delete(int $id)
    {
        \Config\Database::connect()->table('contact_messages')->delete(['id' => $id]);
        return redirect()->to(base_url('admin/messages'))->with('success', 'Message supprimé.');
    }
}

<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\NewsletterModel;
use CodeIgniter\HTTP\ResponseInterface;

class Newsletter extends BaseController
{
    public function subscribe(): ResponseInterface
    {
        $rules = [
            'email'  => 'required|valid_email|max_length[255]',
            'prenom' => 'permit_empty|alpha_space|max_length[80]',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $model = new NewsletterModel();
        $email = $this->request->getPost('email');

        if ($model->isSubscribed($email)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Vous êtes déjà abonné·e. Merci !',
            ]);
        }

        $tag = $this->request->getPost('tag') ?? 'newsletter';

        $model->insert([
            'email'  => $email,
            'prenom' => $this->request->getPost('prenom') ?? '',
            'tag'    => $tag,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Merci ! Vous êtes bien inscrit·e.',
        ]);
    }
}

<?php

namespace App\Controllers\Admin;

use App\Models\PartnerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Partners extends BaseAdminController
{
    private PartnerModel $model;

    public function __construct()
    {
        $this->model = new PartnerModel();
    }

    public function index()
    {
        return $this->render('admin/partners/index', [
            'title'    => 'Partenaires',
            'partners' => $this->model->orderBy('position', 'ASC')->orderBy('nom', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return $this->render('admin/partners/form', ['title' => 'Nouveau partenaire', 'partner' => null]);
    }

    public function store()
    {
        $data = $this->formData();
        if (is_string($data)) {
            return redirect()->back()->withInput()->with('error', $data);
        }

        $this->model->insert($data);
        return redirect()->to(base_url('admin/partners'))->with('success', 'Partenaire ajouté.');
    }

    public function edit(int $id)
    {
        $partner = $this->model->find($id);
        if (! $partner) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->render('admin/partners/form', ['title' => 'Modifier le partenaire', 'partner' => $partner]);
    }

    public function update(int $id)
    {
        $partner = $this->model->find($id);
        if (! $partner) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = $this->formData($partner);
        if (is_string($data)) {
            return redirect()->back()->withInput()->with('error', $data);
        }

        $this->model->update($id, $data);
        if ($data['logo'] !== $partner['logo']) {
            $this->removeLogo($partner['logo']);
        }

        return redirect()->to(base_url('admin/partners'))->with('success', 'Partenaire mis à jour.');
    }

    public function delete(int $id)
    {
        $partner = $this->model->find($id);
        if (! $partner) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->model->delete($id);
        $this->removeLogo($partner['logo']);

        return redirect()->to(base_url('admin/partners'))->with('success', 'Partenaire supprimé.');
    }

    private function formData(?array $existing = null): array|string
    {
        $name = trim(strip_tags((string) $this->request->getPost('nom')));
        $instagramUrl = trim((string) $this->request->getPost('instagram_url'));
        if ($name === '') {
            return 'Le nom du partenaire est obligatoire.';
        }

        $publicInstagramUrl = PartnerModel::instagramPublicUrl($instagramUrl);
        if ($instagramUrl !== '' && $publicInstagramUrl === null) {
            return 'Lien Instagram invalide. Utilisez le lien public d’un Reel ou d’une publication.';
        }

        $logo = $this->uploadLogo();
        if (is_string($logo) && str_starts_with($logo, 'ERR:')) {
            return substr($logo, 4);
        }
        $logo ??= $existing['logo'] ?? null;
        if (! $logo) {
            return 'Ajoutez le logo du partenaire (PNG, JPG ou WebP, 4 Mo maximum).';
        }

        return [
            'nom'           => mb_substr($name, 0, 160),
            'logo'          => $logo,
            'instagram_url' => $publicInstagramUrl,
            'position'      => max(0, (int) $this->request->getPost('position')),
            'is_active'     => (int) ($this->request->getPost('is_active') === '1'),
        ];
    }

    private function uploadLogo(): ?string
    {
        $file = $this->request->getFile('logo');
        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if (! $file->isValid() || $file->hasMoved()) {
            return 'ERR:Échec de l’envoi du logo.';
        }
        if ($file->getSize() > 4 * 1024 * 1024) {
            return 'ERR:Le logo doit faire 4 Mo maximum.';
        }

        $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = $file->getMimeType();
        $image = @getimagesize($file->getTempName());
        if (! isset($extensions[$mime]) || ! $image || ($image['mime'] ?? '') !== $mime) {
            return 'ERR:Format d’image non accepté. Utilisez PNG, JPG ou WebP.';
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'partners';
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            return 'ERR:Impossible de créer le dossier des logos partenaires.';
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        $file->move($directory, $filename);

        return 'uploads/partners/' . $filename;
    }

    private function removeLogo(?string $relativePath): void
    {
        $relativePath = str_replace('\\', '/', (string) $relativePath);
        if (! str_starts_with($relativePath, 'uploads/partners/') || str_contains($relativePath, '..')) {
            return;
        }

        $path = FCPATH . $relativePath;
        if (is_file($path)) {
            unlink($path);
        }
    }
}

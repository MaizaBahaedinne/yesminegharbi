<?php

namespace App\Controllers\Admin;

use App\Models\TestimonialModel;

class Testimonials extends BaseAdminController
{
    private TestimonialModel $model;

    public function __construct()
    {
        $this->model = new TestimonialModel();
    }

    public function index(): string
    {
        return $this->render('admin/testimonials/index', [
            'title'        => 'Témoignages',
            'testimonials' => $this->model->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }

    public function create(): string
    {
        return $this->render('admin/testimonials/form', [
            'title'       => 'Ajouter un témoignage',
            'testimonial' => null,
        ]);
    }

    public function edit(int $id): string
    {
        $testimonial = $this->model->find($id);
        if (! $testimonial) {
            return redirect()->to(base_url('admin/testimonials'))->with('error', 'Témoignage introuvable.');
        }

        return $this->render('admin/testimonials/form', [
            'title'       => 'Modifier le témoignage',
            'testimonial' => $testimonial,
        ]);
    }

    public function store()
    {
        $data = $this->prepareData();
        $this->model->save($data);

        return redirect()->to(base_url('admin/testimonials'))->with('success', 'Témoignage ajouté.');
    }

    public function update(int $id)
    {
        $data = $this->prepareData();
        $data['id'] = $id;
        $this->model->save($data);

        return redirect()->to(base_url('admin/testimonials'))->with('success', 'Témoignage mis à jour.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/testimonials'))->with('success', 'Témoignage supprimé.');
    }

    private function prepareData(): array
    {
        return [
            'quote'           => trim($this->request->getPost('quote') ?? ''),
            'author_name'     => trim($this->request->getPost('author_name') ?? ''),
            'author_role'     => trim($this->request->getPost('author_role') ?? ''),
            'rating'          => (int) $this->request->getPost('rating'),
            'avatar_initials' => trim($this->request->getPost('avatar_initials') ?? ''),
            'avatar_color'    => trim($this->request->getPost('avatar_color') ?? ''),
            'is_active'       => $this->request->getPost('is_active') ? 1 : 0,
            'sort_order'      => (int) $this->request->getPost('sort_order'),
        ];
    }
}

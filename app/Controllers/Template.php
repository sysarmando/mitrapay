<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use Sqids\Sqids;

class Template extends BaseController
{
    public function index()
    {
        $templates = scandir(WRITEPATH . 'templates');
        $files = array_filter($templates, fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'docx');

        return view('template/index', ['templates' => $files, 'title' => 'Upload Template']);
    }

    public function upload()
    {
        $file = $this->request->getFile('template');

        if ($file->isValid() && $file->getExtension() === 'docx') {
            $file->move(WRITEPATH . 'templates');
            return redirect()->back()->with('success', 'Template berhasil diupload.');
        }

        return redirect()->back()->with('error', 'Upload gagal. Pastikan file berekstensi .docx');
    }
}

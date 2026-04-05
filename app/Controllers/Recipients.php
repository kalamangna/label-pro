<?php

namespace App\Controllers;

use App\Models\RecipientModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;

class Recipients extends BaseController
{
    protected $recipientModel;

    public function __construct()
    {
        $this->recipientModel = new RecipientModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';
        $sort   = $this->request->getGet('sort') ?? 'id';
        $dir    = $this->request->getGet('dir') ?? 'desc';

        $model = $this->recipientModel;

        if (!empty($search)) {
            $model = $model->groupStart()
                           ->like('name', $search)
                           ->orLike('address', $search)
                           ->groupEnd();
        }

        if ($status !== '') {
            $model = $model->where('is_printed', $status);
        }

        $allowedSort = ['id', 'name', 'address', 'is_selected', 'is_printed', 'created_at'];
        $sort = in_array($sort, $allowedSort) ? $sort : 'id';
        $dir  = strtolower($dir) === 'asc' ? 'asc' : 'desc';

        $model = $model->orderBy($sort, $dir);

        $data = [
            'title'      => 'Daftar Penerima',
            'recipients' => $model->paginate(10),
            'pager'      => $model->pager,
            'search'     => $search,
            'status'     => $status,
            'sort'       => $sort,
            'dir'        => $dir,
        ];

        return view('recipients/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Penerima',
        ];

        return view('recipients/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'    => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'min_length' => '{field} minimal harus {param} karakter.',
                    'max_length' => '{field} maksimal {param} karakter.'
                ]
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'permit_empty',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        
        $existing = $this->recipientModel->where('name', $name)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Penerima dengan nama tersebut sudah ada di daftar.');
        }

        $this->recipientModel->save([
            'name'    => $name,
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/recipients')->with('message', 'Penerima berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $recipient = $this->recipientModel->find($id);

        if (!$recipient) {
            return redirect()->to('/recipients')->with('error', 'Penerima tidak ditemukan.');
        }

        $data = [
            'title'     => 'Ubah Penerima',
            'recipient' => $recipient,
        ];

        return view('recipients/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'    => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'min_length' => '{field} minimal harus {param} karakter.',
                    'max_length' => '{field} maksimal {param} karakter.'
                ]
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'permit_empty',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->recipientModel->update($id, [
            'name'    => $this->request->getPost('name'),
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/recipients')->with('message', 'Penerima berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->recipientModel->delete($id);

        return redirect()->to('/recipients')->with('message', 'Penerima berhasil dihapus.');
    }

    public function import()
    {
        $data = [
            'title' => 'Impor Penerima',
        ];

        return view('recipients/import', $data);
    }

    public function processImport()
    {
        $file = $this->request->getFile('excel_file');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Harap unggah file Excel yang valid.');
        }

        $extension = $file->getExtension();
        if ($extension !== 'xlsx') {
            return redirect()->back()->with('error', 'Hanya file .xlsx yang didukung.');
        }

        try {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Skip header row
            if (count($rows) > 0) {
                array_shift($rows);
            }

            $successCount = 0;
            $errorCount = 0;

            foreach ($rows as $row) {
                // Expecting: Column A (name), Column B (address)
                $name = trim((string)($row[0] ?? ''));
                $address = trim((string)($row[1] ?? ''));

                if (empty($name)) {
                    $errorCount++;
                    continue;
                }

                $existing = $this->recipientModel->where('name', $name)->first();
                if ($existing) {
                    $errorCount++;
                    continue;
                }

                $this->recipientModel->save([
                    'name'    => $name,
                    'address' => $address,
                ]);
                $successCount++;
            }

            $message = "Berhasil mengimpor $successCount penerima.";
            if ($errorCount > 0) {
                $message .= " Melewati $errorCount baris karena nama kosong atau duplikat.";
            }

            return redirect()->to('/recipients')->with('message', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }

    public function printLabels()
    {
        $type = $this->request->getGet('type') ?? '103';
        
        $data = [
            'recipients' => $this->recipientModel->where('is_selected', 1)->findAll(),
            'type'       => $type,
        ];

        if (empty($data['recipients'])) {
            return redirect()->to('/recipients')->with('error', 'Harap pilih penerima terlebih dahulu.');
        }

        return view('recipients/print', $data);
    }

    public function exportPdf()
    {
        $type = $this->request->getGet('type') ?? '103';
        
        $data = [
            'recipients' => $this->recipientModel->where('is_selected', 1)->findAll(),
            'type'       => $type,
        ];

        if (empty($data['recipients'])) {
            return redirect()->to('/recipients')->with('error', 'Harap pilih penerima terlebih dahulu.');
        }

        $html = view('recipients/print_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }

    public function updateSelected($id)
    {
        $recipient = $this->recipientModel->find($id);
        if ($recipient) {
            $newValue = $recipient['is_selected'] ? 0 : 1;
            $this->recipientModel->update($id, ['is_selected' => $newValue]);
            return $this->response->setJSON(['success' => true, 'is_selected' => $newValue]);
        }
        return $this->response->setJSON(['success' => false], 404);
    }

    public function updatePrinted($id)
    {
        $recipient = $this->recipientModel->find($id);
        if ($recipient) {
            $newValue = $recipient['is_printed'] ? 0 : 1;
            $this->recipientModel->update($id, ['is_printed' => $newValue]);
            return $this->response->setJSON(['success' => true, 'is_printed' => $newValue]);
        }
        return $this->response->setJSON(['success' => false], 404);
    }

    public function bulkUpdateSelected()
    {
        $ids = $this->request->getJSON(true)['ids'] ?? [];
        $state = $this->request->getJSON(true)['state'] ?? 0;

        if (!empty($ids) && is_array($ids)) {
            $this->recipientModel->whereIn('id', $ids)->set(['is_selected' => $state])->update();
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['success' => false], 400);
    }
}

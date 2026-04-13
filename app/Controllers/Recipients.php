<?php

namespace App\Controllers;

use App\Models\RecipientModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Recipients extends BaseController
{
    protected $recipientModel;

    public function __construct()
    {
        $this->recipientModel = new RecipientModel();
    }

    private function applyScope($model = null)
    {
        $model = $model ?? $this->recipientModel;
        if (session()->get('role') !== 'admin') {
            return $model->where('recipients.user_id', session()->get('user_id'));
        }
        return $model;
    }

    private function checkOwnership($id)
    {
        if (session()->get('role') === 'admin') {
            return $this->recipientModel->find($id);
        }
        return $this->recipientModel->where('recipients.user_id', session()->get('user_id'))->find($id);
    }

    public function index()
    {
        $search  = $this->request->getGet('search') ?? '';
        $status  = $this->request->getGet('status') ?? '';
        $sort    = $this->request->getGet('sort') ?? 'id';
        $dir     = $this->request->getGet('dir') ?? 'desc';
        $eventId = $this->request->getGet('event_id');

        // Start with a fresh query on the model
        $model = new RecipientModel();

        // Join events to get event name and users to get username
        $model->select('recipients.*, users.username as added_by, events.name as event_name')
              ->join('users', 'users.id = recipients.user_id', 'left')
              ->join('events', 'events.id = recipients.event_id', 'left');

        // Apply owner scope if not admin
        if (session()->get('role') !== 'admin') {
            $model->where('recipients.user_id', session()->get('user_id'));
        }

        // Apply Filters
        if ($eventId !== null && $eventId !== '') {
            $model->where('recipients.event_id', $eventId);
        }

        if ($search !== '') {
            $model->groupStart()
                  ->like('recipients.name', $search)
                  ->orLike('recipients.address', $search)
                  ->groupEnd();
        }

        if ($status !== null && $status !== '') {
            $model->where('recipients.is_printed', $status);
        }

        // Apply Sorting
        $allowedSort = ['id', 'name', 'address', 'is_selected', 'is_printed', 'created_at'];
        $sort = in_array($sort, $allowedSort) ? $sort : 'id';
        $dir = strtolower($dir) === 'asc' ? 'asc' : 'desc';

        $model->orderBy('recipients.' . $sort, $dir);

        // Fetch event list for the filter dropdown
        $eventModel = new \App\Models\EventModel();
        $events = session()->get('role') === 'admin' 
            ? $eventModel->findAll() 
            : $eventModel->where('user_id', session()->get('user_id'))->findAll();

        // Calculate absolute total independently
        $totalInDatabase = (new RecipientModel());
        if (session()->get('role') !== 'admin') {
            $totalInDatabase->where('user_id', session()->get('user_id'));
        }
        $totalInDatabase = $totalInDatabase->countAllResults();

        // Calculate selected count independently
        $selectedCount = 0;
        if (session()->get('role') !== 'admin') {
            $selectedCount = (new RecipientModel())
                ->where('user_id', session()->get('user_id'))
                ->where('is_selected', 1)
                ->countAllResults();
        }

        $data = [
            'title'           => 'Daftar Penerima',
            'recipients'      => $model->paginate(10),
            'pager'           => $model->pager,
            'search'          => $search,
            'status'          => $status,
            'sort'            => $sort,
            'dir'             => $dir,
            'eventId'         => $eventId,
            'events'          => $events,
            'selectedCount'   => $selectedCount,
            'totalInDatabase' => $totalInDatabase,
        ];

        return view('recipients/index', $data);
    }

    public function store()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/recipients')->with('error', 'Admin hanya dapat melihat data.');
        }

        $package = session()->get('package') ?? 'basic';
        $limits  = \App\Models\UserModel::getPackageLimits($package, session()->get('role'));
        
        $currentRecipientsCount = $this->recipientModel->where('recipients.user_id', session()->get('user_id'))->countAllResults();
        
        if ($currentRecipientsCount >= $limits['max_recipients']) {
            return redirect()->back()->withInput()->with('error', "Anda telah mencapai batas maksimal penerima untuk {$limits['name']} ({$limits['max_recipients']} penerima). Silakan hubungi admin untuk upgrade.");
        }

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
            'event_id' => [
                'label' => 'Acara',
                'rules' => 'permit_empty|is_natural_no_zero',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name     = $this->request->getPost('name');
        $address  = $this->request->getPost('address');
        $eventId  = $this->request->getPost('event_id') ?: null;
        
        $existing = $this->applyScope()
                         ->where('name', $name)
                         ->where('address', $address);
        
        if ($eventId) {
            $existing = $existing->where('event_id', $eventId);
        } else {
            $existing = $existing->where('event_id', null);
        }

        if ($existing->first()) {
            return redirect()->back()->withInput()->with('error', 'Penerima dengan nama dan alamat tersebut sudah ada di daftar ini.');
        }

        $this->recipientModel->save([
            'name'     => $name,
            'address'  => $address,
            'user_id'  => session()->get('user_id'),
            'event_id' => $eventId,
        ]);

        return redirect()->to('/recipients')->with('message', 'Penerima berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/recipients')->with('error', 'Admin hanya dapat melihat data.');
        }

        $recipient = $this->checkOwnership($id);
        if (!$recipient) {
            return redirect()->to('/recipients')->with('error', 'Penerima tidak ditemukan atau Anda tidak memiliki akses.');
        }

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
            'event_id' => [
                'label' => 'Acara',
                'rules' => 'permit_empty|is_natural_no_zero',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->recipientModel->update($id, [
            'name'     => $this->request->getPost('name'),
            'address'  => $this->request->getPost('address'),
            'event_id' => $this->request->getPost('event_id') ?: null,
        ]);

        return redirect()->to('/recipients')->with('message', 'Penerima berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/recipients')->with('error', 'Admin hanya dapat melihat data.');
        }

        $recipient = $this->checkOwnership($id);
        if ($recipient) {
            $this->recipientModel->delete($id);
            return redirect()->to('/recipients')->with('message', 'Penerima berhasil dihapus.');
        }
        return redirect()->to('/recipients')->with('error', 'Penerima tidak ditemukan atau Anda tidak memiliki akses.');
    }

    public function import()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/recipients')->with('error', 'Admin hanya dapat melihat data.');
        }

        $eventId = $this->request->getGet('event_id');
        
        if (!$eventId) {
            return redirect()->to('/events')->with('error', 'Silakan pilih acara terlebih dahulu untuk mengimpor data.');
        }

        $eventModel = new \App\Models\EventModel();
        $event = session()->get('role') === 'admin' 
            ? $eventModel->find($eventId)
            : $eventModel->where('user_id', session()->get('user_id'))->find($eventId);

        if (!$event) {
            return redirect()->to('/events')->with('error', 'Acara tidak ditemukan.');
        }

        $data = [
            'title' => 'Impor Penerima',
            'event' => $event,
        ];

        return view('recipients/import', $data);
    }

    public function processImport()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/recipients')->with('error', 'Admin hanya dapat melihat data.');
        }

        $package = session()->get('package') ?? 'basic';
        $limits  = \App\Models\UserModel::getPackageLimits($package, session()->get('role'));
        
        $currentRecipientsCount = $this->recipientModel->where('user_id', session()->get('user_id'))->countAllResults();

        $file = $this->request->getFile('excel_file');
        $eventId = $this->request->getPost('event_id');

        if (!$eventId) {
            return redirect()->to('/events')->with('error', 'Acara tidak valid.');
        }

        $eventModel = new \App\Models\EventModel();
        $event = session()->get('role') === 'admin' 
            ? $eventModel->find($eventId)
            : $eventModel->where('user_id', session()->get('user_id'))->find($eventId);

        if (!$event) {
            return redirect()->to('/events')->with('error', 'Acara tidak ditemukan atau akses ditolak.');
        }

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
                if ($currentRecipientsCount >= $limits['max_recipients']) {
                    $errorCount += (count($rows) - $successCount - $errorCount);
                    break;
                }

                // Expecting: Column A (name), Column B (address)
                $name = trim((string)($row[0] ?? ''));
                $address = trim((string)($row[1] ?? ''));

                if (empty($name)) {
                    $errorCount++;
                    continue;
                }

                $existing = $this->applyScope()
                                 ->where('name', $name)
                                 ->where('address', $address);
                
                if ($eventId) {
                    $existing = $existing->where('event_id', $eventId);
                } else {
                    $existing = $existing->where('event_id', null);
                }

                if ($existing->first()) {
                    $errorCount++;
                    continue;
                }

                $this->recipientModel->insert([
                    'name'     => $name,
                    'address'  => $address,
                    'user_id'  => session()->get('user_id'),
                    'event_id' => $eventId,
                ]);
                $successCount++;
                $currentRecipientsCount++;
            }

            $message = "Berhasil mengimpor $successCount penerima.";
            if ($currentRecipientsCount >= $limits['max_recipients'] && $successCount < count($rows)) {
                $message .= " Impor terhenti karena Anda mencapai batas maksimal {$limits['max_recipients']} penerima.";
            }
            if ($errorCount > 0) {
                $message .= " Melewati $errorCount baris karena nama kosong, duplikat, atau batas kuota tercapai.";
            }

            return redirect()->to('/recipients' . ($eventId ? '?event_id=' . $eventId : ''))->with('message', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }
    }

    public function printLabels()
    {
        $type = $this->request->getGet('type') ?? '121';
        $offsetStr = $this->request->getGet('offset');
        $offset = (is_numeric($offsetStr) && (int)$offsetStr > 0) ? (int)$offsetStr : 0;
        
        $alignRaw = $this->request->getGet('align') ?? 'center';
        $validAlignments = ['flex-start', 'center', 'flex-end'];
        $align = in_array($alignRaw, $validAlignments) ? $alignRaw : 'center';

        // Limit offset to max 9 for label 121 (which has 10 positions, index 0-9)
        if ($offset > 9) $offset = 9;

        $recipients = $this->applyScope()->where('recipients.is_selected', 1)->findAll();

        if (empty($recipients)) {
            return redirect()->to('/recipients')->with('error', 'Harap pilih penerima terlebih dahulu.');
        }

        // Apply offset padding
        if ($offset > 0) {
            $placeholders = array_fill(0, $offset, []);
            $recipients = array_merge($placeholders, $recipients);
        }

        // Hard limit to 10 total items per print batch to ensure alignment on 1 sheet
        $recipients = array_slice($recipients, 0, 10);

        // Pad to exactly 10 items so the grid preview always shows all label boxes
        if (count($recipients) < 10) {
            $paddingCount = 10 - count($recipients);
            $recipients = array_merge($recipients, array_fill(0, $paddingCount, []));
        }

        $data = [
            'recipients' => $recipients,
            'type'       => $type,
            'align'      => $align,
        ];

        return view('recipients/print', $data);
    }

    public function updatePrinted($id)
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin tidak dapat mengubah data.'], 403);
        }

        $recipient = $this->checkOwnership($id);
        if ($recipient) {
            $newValue = $recipient['is_printed'] ? 0 : 1;
            $this->recipientModel->update($id, ['is_printed' => $newValue]);
            return $this->response->setJSON(['success' => true, 'is_printed' => $newValue]);
        }
        return $this->response->setJSON(['success' => false], 404);
    }

    public function bulkDelete()
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin tidak dapat menghapus data.'], 403);
        }

        $ids = $this->request->getJSON(true)['ids'] ?? [];

        if (!empty($ids) && is_array($ids)) {
            if (session()->get('role') !== 'admin') {
                // Ensure all IDs belong to the user
                $owned = $this->recipientModel->where('recipients.user_id', session()->get('user_id'))->whereIn('id', $ids)->findAll();
                $ids = array_column($owned, 'id');
            }
            if (!empty($ids)) {
                $this->recipientModel->whereIn('id', $ids)->delete();
            }
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['success' => false], 400);
    }

    public function bulkUpdatePrinted()
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin tidak dapat mengubah data.'], 403);
        }

        $ids = $this->request->getJSON(true)['ids'] ?? [];
        $state = $this->request->getJSON(true)['state'] ?? 0;

        if (!empty($ids) && is_array($ids)) {
            if (session()->get('role') !== 'admin') {
                // Ensure all IDs belong to the user
                $owned = $this->recipientModel->where('recipients.user_id', session()->get('user_id'))->whereIn('id', $ids)->findAll();
                $ids = array_column($owned, 'id');
            }
            if (!empty($ids)) {
                $this->recipientModel->whereIn('id', $ids)->set(['is_printed' => $state])->update();
            }
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['success' => false], 400);
    }

    public function toggleSelection($id)
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin tidak dapat mengubah data.'], 403);
        }

        $recipient = $this->checkOwnership($id);
        if (!$recipient) {
            return $this->response->setJSON(['success' => false, 'message' => 'Penerima tidak ditemukan atau tidak diizinkan.']);
        }

        $newState = $recipient['is_selected'] ? 0 : 1;

        if ($newState === 1) {
            $selectedCount = $this->recipientModel->where('recipients.user_id', session()->get('user_id'))->where('recipients.is_selected', 1)->countAllResults();
            if ($selectedCount >= 10) {
                return $this->response->setJSON(['success' => false, 'limit_reached' => true, 'message' => 'Maksimal 10 penerima yang dapat dipilih untuk dicetak.']);
            }
        }

        $this->recipientModel->update($id, ['is_selected' => $newState]);

        $newCount = $this->recipientModel->where('recipients.user_id', session()->get('user_id'))->where('recipients.is_selected', 1)->countAllResults();
        
        return $this->response->setJSON(['success' => true, 'is_selected' => $newState, 'count' => $newCount]);
    }

    public function bulkToggleSelection()
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin tidak dapat mengubah data.'], 403);
        }

        $input = $this->request->getJSON();
        $ids = $input->ids ?? [];
        $action = $input->action ?? 'select'; // 'select' or 'deselect'

        if (empty($ids)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada data yang dipilih.']);
        }

        $userId = session()->get('user_id');

        if ($action === 'select') {
            $currentSelectedCount = $this->recipientModel->where('recipients.user_id', $userId)->where('recipients.is_selected', 1)->countAllResults();
            $availableSlots = 10 - $currentSelectedCount;

            if ($availableSlots <= 0) {
                return $this->response->setJSON(['success' => false, 'limit_reached' => true, 'message' => 'Batas maksimal 10 penerima telah tercapai.']);
            }

            $idsToSelect = array_slice($ids, 0, $availableSlots);
            
            $this->recipientModel->whereIn('id', $idsToSelect)
                                 ->where('recipients.user_id', $userId)
                                 ->set(['is_selected' => 1])
                                 ->update();
        } else {
            $this->recipientModel->whereIn('id', $ids)
                                 ->where('recipients.user_id', $userId)
                                 ->set(['is_selected' => 0])
                                 ->update();
        }

        $newCount = $this->recipientModel->where('recipients.user_id', $userId)->where('recipients.is_selected', 1)->countAllResults();

        return $this->response->setJSON(['success' => true, 'count' => $newCount]);
    }

    public function clearSelection()
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin tidak dapat mengubah data.'], 403);
        }

        $this->recipientModel->where('recipients.user_id', session()->get('user_id'))
                             ->set(['is_selected' => 0])
                             ->update();

        return $this->response->setJSON(['success' => true, 'count' => 0]);
    }
}

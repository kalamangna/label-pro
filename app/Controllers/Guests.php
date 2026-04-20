<?php

namespace App\Controllers;

use App\Models\GuestModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Guests extends BaseController
{
    protected $guestModel;

    public function __construct()
    {
        $this->guestModel = new GuestModel();
    }

    private function applyScope($model = null)
    {
        $model = $model ?? $this->guestModel;
        if (session()->get('role') !== 'admin') {
            return $model->where('guests.user_id', session()->get('user_id'));
        }
        return $model;
    }

    private function checkOwnership($id)
    {
        if (session()->get('role') === 'admin') {
            return $this->guestModel->find($id);
        }
        return $this->guestModel->where('guests.user_id', session()->get('user_id'))->find($id);
    }

    public function index()
    {
        $search  = $this->request->getGet('search') ?? '';
        $status  = $this->request->getGet('status') ?? '';
        $sort    = $this->request->getGet('sort') ?? 'id';
        $dir     = $this->request->getGet('dir') ?? 'desc';
        $eventId = $this->request->getGet('event_id');

        // Start with a fresh query on the model
        $model = new GuestModel();

        // Join events to get event name and users to get username
        $model->select('guests.*, users.username as added_by, events.name as event_name')
              ->join('users', 'users.id = guests.user_id', 'left')
              ->join('events', 'events.id = guests.event_id', 'left');

        // Apply owner scope if not admin
        if (session()->get('role') !== 'admin') {
            $model->where('guests.user_id', session()->get('user_id'));
        }

        // Apply Filters
        if ($eventId !== null && $eventId !== '') {
            $model->where('guests.event_id', $eventId);
        }

        if ($search !== '') {
            $model->groupStart()
                  ->like('guests.name', $search)
                  ->orLike('guests.jabatan', $search)
                  ->orLike('guests.address', $search)
                  ->groupEnd();
        }

        if ($status !== null && $status !== '') {
            $model->where('guests.is_printed', $status);
        }

        // Apply Sorting
        $allowedSort = ['id', 'name', 'address', 'is_selected', 'is_printed', 'created_at'];
        $sort = in_array($sort, $allowedSort) ? $sort : 'id';
        $dir = strtolower($dir) === 'asc' ? 'asc' : 'desc';

        $model->orderBy('guests.' . $sort, $dir);

        // Fetch event list for the filter dropdown
        $eventModel = new \App\Models\EventModel();
        $events = session()->get('role') === 'admin' 
            ? $eventModel->findAll() 
            : $eventModel->where('user_id', session()->get('user_id'))->findAll();

        // Calculate absolute total independently
        $totalInDatabase = (new GuestModel());
        if (session()->get('role') !== 'admin') {
            $totalInDatabase->where('user_id', session()->get('user_id'));
        }
        $totalInDatabase = $totalInDatabase->countAllResults();

        // Calculate selected counts independently
        $selectedCount = 0;
        $unprintedSelectedCount = 0;
        if (session()->get('role') !== 'admin') {
            $selectedCount = (new GuestModel())
                ->where('user_id', session()->get('user_id'))
                ->where('is_selected', 1)
                ->countAllResults();
            
            $unprintedSelectedCount = (new GuestModel())
                ->where('user_id', session()->get('user_id'))
                ->where('is_selected', 1)
                ->where('is_printed', 0)
                ->countAllResults();
        }

        $data = [
            'title'                  => 'Daftar Tamu',
            'guests'             => $model->paginate(10),
            'pager'                  => $model->pager,
            'search'                 => $search,
            'status'                 => $status,
            'sort'                   => $sort,
            'dir'                    => $dir,
            'eventId'                => $eventId,
            'events'                 => $events,
            'selectedCount'          => $selectedCount,
            'unprintedSelectedCount' => $unprintedSelectedCount,
            'totalInDatabase'        => $totalInDatabase,
        ];

        return view('guests/index', $data);
    }

    public function store()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/guests')->with('error', 'Admin hanya dapat melihat data.');
        }

        $package = session()->get('package') ?? 'basic';
        $limits  = \App\Models\UserModel::getPackageLimits($package, session()->get('role'));
        
        $currentGuestsCount = $this->guestModel->where('guests.user_id', session()->get('user_id'))->countAllResults();
        
        if ($currentGuestsCount >= $limits['max_guests']) {
            return redirect()->back()->withInput()->with('error', "Anda telah mencapai batas maksimal tamu untuk {$limits['name']} ({$limits['max_guests']} tamu). Silakan hubungi admin untuk upgrade.");
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
            'jabatan' => [
                'label' => 'Jabatan',
                'rules' => 'permit_empty|max_length[255]',
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
        $jabatan  = $this->request->getPost('jabatan');
        $address  = $this->request->getPost('address');
        $eventId  = $this->request->getPost('event_id') ?: null;
        
        $existing = $this->applyScope()
                         ->where('name', $name)
                         ->where('jabatan', $jabatan)
                         ->where('address', $address);
        
        if ($eventId) {
            $existing = $existing->where('event_id', $eventId);
        } else {
            $existing = $existing->where('event_id', null);
        }

        if ($existing->first()) {
            return redirect()->back()->withInput()->with('error', 'Tamu dengan nama, jabatan, dan alamat tersebut sudah ada di daftar ini.');
        }

        $this->guestModel->save([
            'name'     => $name,
            'jabatan'  => $jabatan,
            'address'  => $address,
            'user_id'  => session()->get('user_id'),
            'event_id' => $eventId,
        ]);

        $redirectUrl = '/guests';
        if ($eventId) {
            $redirectUrl .= '?event_id=' . $eventId;
        }

        return redirect()->to($redirectUrl)->with('message', 'Tamu berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/guests')->with('error', 'Admin hanya dapat melihat data.');
        }

        $guest = $this->checkOwnership($id);
        if (!$guest) {
            return redirect()->to('/guests')->with('error', 'Tamu tidak ditemukan atau Anda tidak memiliki akses.');
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
            'jabatan' => [
                'label' => 'Jabatan',
                'rules' => 'permit_empty|max_length[255]',
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'permit_empty',
            ],
            'event_id' => [
                'label' => 'Acara',
                'rules' => 'permit_empty|is_natural_no_zero',
            ],
            'is_printed' => [
                'label' => 'Status Cetak',
                'rules' => 'permit_empty|in_list[0,1]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $eventId = $this->request->getPost('event_id') ?: null;
        $this->guestModel->update($id, [
            'name'       => $this->request->getPost('name'),
            'jabatan'    => $this->request->getPost('jabatan'),
            'address'    => $this->request->getPost('address'),
            'event_id'   => $eventId,
            'is_printed' => $this->request->getPost('is_printed') ?? 0,
        ]);

        $redirectUrl = '/guests';
        if ($eventId) {
            $redirectUrl .= '?event_id=' . $eventId;
        }

        return redirect()->to($redirectUrl)->with('message', 'Tamu berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/guests')->with('error', 'Admin hanya dapat melihat data.');
        }

        $guest = $this->checkOwnership($id);
        if ($guest) {
            $this->guestModel->delete($id);
            return redirect()->to('/guests')->with('message', 'Tamu berhasil dihapus.');
        }
        return redirect()->to('/guests')->with('error', 'Tamu tidak ditemukan atau Anda tidak memiliki akses.');
    }

    public function import()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/guests')->with('error', 'Admin hanya dapat melihat data.');
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
            'title' => 'Impor Tamu',
            'event' => $event,
        ];

        return view('guests/import', $data);
    }

    public function processImport()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/guests')->with('error', 'Admin hanya dapat melihat data.');
        }

        $package = session()->get('package') ?? 'basic';
        $limits  = \App\Models\UserModel::getPackageLimits($package, session()->get('role'));
        
        $currentGuestsCount = $this->guestModel->where('user_id', session()->get('user_id'))->countAllResults();

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
                if ($currentGuestsCount >= $limits['max_guests']) {
                    $errorCount += (count($rows) - $successCount - $errorCount);
                    break;
                }

                // Expecting: Column A (name), Column B (jabatan), Column C (address)
                $name = trim((string)($row[0] ?? ''));
                $jabatan = trim((string)($row[1] ?? ''));
                $address = trim((string)($row[2] ?? ''));

                if (empty($name)) {
                    $errorCount++;
                    continue;
                }

                $existing = $this->applyScope()
                                 ->where('name', $name)
                                 ->where('jabatan', $jabatan)
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

                $this->guestModel->insert([
                    'name'     => $name,
                    'jabatan'  => $jabatan,
                    'address'  => $address,
                    'user_id'  => session()->get('user_id'),
                    'event_id' => $eventId,
                ]);
                $successCount++;
                $currentGuestsCount++;
            }

            $message = "Berhasil mengimpor $successCount tamu.";
            if ($currentGuestsCount >= $limits['max_guests'] && $successCount < count($rows)) {
                $message .= " Impor terhenti karena Anda mencapai batas maksimal {$limits['max_guests']} tamu.";
            }
            if ($errorCount > 0) {
                $message .= " Melewati $errorCount baris karena nama kosong, duplikat, atau batas kuota tercapai.";
            }

            return redirect()->to('/guests' . ($eventId ? '?event_id=' . $eventId : ''))->with('message', $message);

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

        $guests = $this->applyScope()
            ->where('guests.is_selected', 1)
            ->where('guests.is_printed', 0)
            ->findAll();

        if (empty($guests)) {
            return redirect()->to('/guests')->with('error', 'Harap pilih tamu terlebih dahulu.');
        }

        // Apply offset padding (only affects the first page)
        if ($offset > 0) {
            $placeholders = array_fill(0, $offset, []);
            $guests = array_merge($placeholders, $guests);
        }

        // Chunk into pages of 10 items
        $pages = array_chunk($guests, 10);

        // Pad the last page to exactly 10 items so the grid layout is preserved
        if (!empty($pages)) {
            $lastPageIdx = count($pages) - 1;
            if (count($pages[$lastPageIdx]) < 10) {
                $paddingCount = 10 - count($pages[$lastPageIdx]);
                $pages[$lastPageIdx] = array_merge($pages[$lastPageIdx], array_fill(0, $paddingCount, []));
            }
        }

        $data = [
            'pages'      => $pages,
            'type'       => $type,
            'align'      => $align,
        ];

        return view('guests/print', $data);
    }

    public function updatePrinted($id)
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin tidak dapat mengubah data.'], 403);
        }

        $guest = $this->checkOwnership($id);
        if ($guest) {
            $newValue = $guest['is_printed'] ? 0 : 1;

            $updateData = ['is_printed' => $newValue];

            $this->guestModel->update($id, $updateData);
            $newCount = $this->guestModel->where('guests.user_id', session()->get('user_id'))->where('guests.is_selected', 1)->countAllResults();
            $newUnprintedCount = $this->guestModel->where('guests.user_id', session()->get('user_id'))->where('guests.is_selected', 1)->where('guests.is_printed', 0)->countAllResults();

            return $this->response->setJSON([
                'success' => true, 
                'is_printed' => $newValue, 
                'count' => $newCount,
                'unprinted_count' => $newUnprintedCount
            ]);
            }        return $this->response->setJSON(['success' => false], 404);
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
                $owned = $this->guestModel->where('guests.user_id', session()->get('user_id'))->whereIn('id', $ids)->findAll();
                $ids = array_column($owned, 'id');
            }
            if (!empty($ids)) {
                $this->guestModel->whereIn('id', $ids)->delete();
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
                $owned = $this->guestModel->where('guests.user_id', session()->get('user_id'))->whereIn('id', $ids)->findAll();
                $ids = array_column($owned, 'id');
            }
            if (!empty($ids)) {
                $this->guestModel->whereIn('id', $ids)->set(['is_printed' => $state])->update();
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

        $guest = $this->checkOwnership($id);
        if (!$guest) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tamu tidak ditemukan atau tidak diizinkan.']);
        }

        $newState = $guest['is_selected'] ? 0 : 1;

        $this->guestModel->update($id, ['is_selected' => $newState]);

        $newCount = $this->guestModel->where('guests.user_id', session()->get('user_id'))->where('guests.is_selected', 1)->countAllResults();
        $newUnprintedCount = $this->guestModel->where('guests.user_id', session()->get('user_id'))->where('guests.is_selected', 1)->where('guests.is_printed', 0)->countAllResults();

        return $this->response->setJSON([
            'success' => true, 
            'is_selected' => $newState, 
            'count' => $newCount,
            'unprinted_count' => $newUnprintedCount
        ]);
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
            // Select all requested IDs that belong to the user
            $validGuests = $this->guestModel->whereIn('id', $ids)
                                                   ->where('guests.user_id', $userId)
                                                   ->findAll();
            
            $validIds = array_column($validGuests, 'id');

            if (!empty($validIds)) {
                $this->guestModel->whereIn('id', $validIds)
                                     ->set(['is_selected' => 1])
                                     ->update();
            }
        } else {
            $this->guestModel->whereIn('id', $ids)
                                 ->where('guests.user_id', $userId)
                                 ->set(['is_selected' => 0])
                                 ->update();
        }

        $newCount = $this->guestModel->where('guests.user_id', $userId)->where('guests.is_selected', 1)->countAllResults();
        $newUnprintedCount = $this->guestModel->where('guests.user_id', $userId)->where('guests.is_selected', 1)->where('guests.is_printed', 0)->countAllResults();

        return $this->response->setJSON([
            'success' => true, 
            'count' => $newCount,
            'unprinted_count' => $newUnprintedCount
        ]);
    }

    public function clearSelection()
    {
        if (session()->get('role') === 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Admin tidak dapat mengubah data.'], 403);
        }

        $this->guestModel->where('guests.user_id', session()->get('user_id'))
                             ->set(['is_selected' => 0])
                             ->update();

        return $this->response->setJSON(['success' => true, 'count' => 0]);
    }
}

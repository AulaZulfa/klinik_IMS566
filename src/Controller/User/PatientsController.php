<?php
declare(strict_types=1);

namespace App\Controller\User; // Pastikan namespace ada /User

use App\Controller\AppController;

/**
 * Patients Controller untuk User Prefix
 * Memaparkan profil pesakit berdasarkan email Google login
 */
class PatientsController extends AppController
{
    /**
     * Index method
     * Menunjukkan profil pesakit secara terus tanpa perlu klik butang view
     */
    public function index()
{
    $userEmail = $this->Authentication->getIdentity()->get('email');
    $userName = $this->Authentication->getIdentity()->get('fullname'); // Ambil nama dari Google

    $patient = $this->Patients->find()
        ->where(['Patients.email' => $userEmail])
        ->first();

    // JIKA USER BARU (Email tak pernah didaftar oleh Admin)
    if (!$patient) {
        return $this->redirect(['action' => 'register']);
    }

    $this->set('title', 'Profile Patient');
    $this->set(compact('patient'));
}

public function register()
{
    $this->set('title', 'Complete Your Profile');
    $userEmail = $this->Authentication->getIdentity()->get('email');
    $userName = $this->Authentication->getIdentity()->get('fullname');

    $patient = $this->Patients->newEmptyEntity();
    
    if ($this->request->is('post')) {
        $patient = $this->Patients->patchEntity($patient, $this->request->getData());
        
        // Paksa sistem guna email Google & set status kepada Active (1)
        $patient->email = $userEmail;
        $patient->status = 1; 

        if ($this->Patients->save($patient)) {
            $this->Flash->success(__('Done!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Fail. Try again.'));
    }
    
    $this->set(compact('patient', 'userEmail', 'userName'));
}

    /**
     * View method (Opsional)
     * Jika anda masih mahu fungsi view secara berasingan
     */
    public function view($id = null)
    {
        $userEmail = $this->Authentication->getIdentity()->get('email');
        
        $patient = $this->Patients->get($id);

        // Security check: Pastikan user tak boleh pandai-pandai tukar ID kat URL 
        // untuk tengok profile orang lain
        if ($patient->email !== $userEmail) {
            $this->Flash->error(__('You are not allowed to access this profile.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set('title', 'Profile Details');
        $this->set(compact('patient'));
    }

    // Tambah fungsi ini dalam src/Controller/User/PatientsController.php
public function edit($id = null)
{
    $userEmail = $this->Authentication->getIdentity()->get('email');
    $patient = $this->Patients->get($id);

    // Security: Pastikan user hanya boleh edit data dia sendiri
    if ($patient->email !== $userEmail) {
        $this->Flash->error(__('Akses dinafikan.'));
        return $this->redirect(['action' => 'index']);
    }

    if ($this->request->is(['patch', 'post', 'put'])) {
        $patient = $this->Patients->patchEntity($patient, $this->request->getData());
        if ($this->Patients->save($patient)) {
            $this->Flash->success(__('Profile Success!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Gagal mengemaskini profil. Cuba lagi.'));
    }
    $this->set(compact('patient'));
}
}
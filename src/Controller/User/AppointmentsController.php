<?php
namespace App\Controller\User;

use App\Controller\AppController;

class AppointmentsController extends AppController
{
public function index()
{
    // 1. Ambil ID dari akaun yang tengah login
    $currentUserId = $this->Authentication->getIdentity()->get('id');

    // 2. Guna fetchTable, bukan loadModel
    $patientsTable = $this->fetchTable('Patients');
    
    $patientProfile = $patientsTable->find()
        ->where(['user_id' => $currentUserId])
        ->first();

    $this->set('title', 'My Appointments');
    $this->set('system_name', 'AWARIQNA');

    // 3. Jika profil dijumpai, cari appointment
    if ($patientProfile) {
        $query = $this->Appointments->find()
            ->where(['Appointments.patient_id' => $patientProfile->id])
            ->contain(['Doctors']);
        
        $appointments = $this->paginate($query);
    } else {
        // Jika profil tak jumpa, hantar senarai kosong supaya tak error
        $appointments = $this->paginate($this->Appointments->find()->where(['id' => 0]));
    }

    $this->set(compact('appointments'));
}

   public function pdf($id = null)
{
    // Pastikan ID hanya nombor (buang .pdf kalau tersesat)
    $id = intval($id); 

    $this->viewBuilder()->enableAutoLayout(false);
    
    // Cari data patient_id dari user login
    $patientsTable = $this->fetchTable('Patients');
    $patientProfile = $patientsTable->find()
        ->where(['user_id' => $this->Authentication->getIdentity()->get('id')])
        ->firstOrFail();

    $appointment = $this->Appointments->find()
        ->where([
            'Appointments.id' => $id,
            'Appointments.patient_id' => $patientProfile->id
        ])
        ->contain(['Patients', 'Doctors'])
        ->firstOrFail();

    $this->set(compact('appointment'));
}


    public function view($id = null)
{
    $patientId = $this->Authentication->getIdentity()->get('id');

    // Cari appointment dan pastikan ia milik patient yang login sahaja (Security!)
    $appointment = $this->Appointments->find()
        ->where([
            'Appointments.id' => $id,
            'Appointments.patient_id' => $this->fetchTable('Patients')
                ->find()
                ->where(['user_id' => $patientId])
                ->first()
                ->id
        ])
        ->contain(['Patients', 'Doctors'])
        ->firstOrFail();

    $this->set(compact('appointment'));
}
}
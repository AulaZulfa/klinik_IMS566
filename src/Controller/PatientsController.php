<?php
declare(strict_types=1);

namespace App\Controller;

use AuditStash\Meta\RequestMetadata;
use Cake\Event\EventManager;
use Cake\Routing\Router;

/**
 * Patients Controller
 *
 * @property \App\Model\Table\PatientsTable $Patients
 */
class PatientsController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();

		$this->loadComponent('Search.Search', [
			'actions' => ['index'],
		]);
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
	}

	/*public function viewClasses(): array
    {
        return [JsonView::class];
		return [JsonView::class, XmlView::class];
    }*/
	
	public function json()
    {
		$this->viewBuilder()->setLayout('json');
        $this->set('patients', $this->paginate());
        $this->viewBuilder()->setOption('serialize', 'patients');
    }
	
	public function csv()
	{
		$this->response = $this->response->withDownload('patients.csv');
		$patients = $this->Patients->find();
		$_serialize = 'patients';

		$this->viewBuilder()->setClassName('CsvView.Csv');
		$this->set(compact('patients', '_serialize'));
	}
	
	public function pdfList()
	{
		$this->viewBuilder()->enableAutoLayout(false); 
		$patients = $this->paginate($this->Patients);
		$this->viewBuilder()->setClassName('CakePdf.Pdf');
		$this->viewBuilder()->setOption(
			'pdfConfig',
			[
				'orientation' => 'portrait',
				'download' => true, 
				'filename' => 'patients_List.pdf' 
			]
		);
		$this->set(compact('patients'));
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
{
    $this->set('title', 'Patients List');
    
    $query = $this->Patients->find();
    $search = $this->request->getQueryParams();

    // Tapis nama secara manual kalau ada dalam URL
    if (!empty($search['name'])) {
        $query->where(['Patients.name LIKE' => '%' . $search['name'] . '%']);
    }
    
    // Tapis IC secara manual
    if (!empty($search['ic'])) {
        $query->where(['Patients.ic LIKE' => '%' . $search['ic'] . '%']);
    }

    $patients = $this->paginate($query, ['limit' => 10]);

    // 3. Statistik (Gunakan find() baru supaya statistik tetap kira semua data dalam database)
    $this->set('total_patients', $this->Patients->find()->count());
    $this->set('total_patients_archived', $this->Patients->find()->where(['status' => 2])->count());
    $this->set('total_patients_active', $this->Patients->find()->where(['status' => 1])->count());
    $this->set('total_patients_disabled', $this->Patients->find()->where(['status' => 0])->count());

    // --- Bahagian Graf (Gunakan query berasingan supaya graf tak kacau carian) ---
    $chartQuery = $this->Patients->find(); 
    $expectedMonths = [];
    for ($i = 11; $i >= 0; $i--) {
        $expectedMonths[] = date('M-Y', strtotime("-$i months"));
    }

    $chartQuery->select([
        'count' => $chartQuery->func()->count('*'),
        'date' => $chartQuery->func()->date_format(['created' => 'identifier', "%b-%Y"]),
        'month' => 'MONTH(created)',
        'year' => 'YEAR(created)'
    ])
    ->where([
        'created >=' => date('Y-m-01', strtotime('-11 months')),
        'created <=' => date('Y-m-t')
    ])
    ->groupBy(['year', 'month'])
    ->orderBy(['year' => 'ASC', 'month' => 'ASC']);

    $results = $chartQuery->all()->toArray();

    $totalByMonth = [];
    foreach ($expectedMonths as $expectedMonth) {
        $count = 0;
        foreach ($results as $result) {
            if ($expectedMonth === $result->date) {
                $count = $result->count;
                break;
            }
        }
        $totalByMonth[] = ['month' => $expectedMonth, 'count' => $count];
    }

    $monthArray = [];
    $countArray = [];
    foreach ($totalByMonth as $data) {
        $monthArray[] = $data['month'];
        $countArray[] = $data['count'];
    }

    $this->set(compact('patients', 'monthArray', 'countArray'));
}

    /**
     * View method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', 'Patients Details');
        $patient = $this->Patients->get($id, contain: []);
        $this->set(compact('patient'));

        $this->set(compact('patient'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->set('title', 'New Patients');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Add']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Patients']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $patient = $this->Patients->newEmptyEntity();
        if ($this->request->is('post')) {
            $patient = $this->Patients->patchEntity($patient, $this->request->getData());
            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('The patient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient could not be saved. Please, try again.'));
        }
        $this->set(compact('patient'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', 'Patients Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Edit']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Patients']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $patient = $this->Patients->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $patient = $this->Patients->patchEntity($patient, $this->request->getData());
            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('The patient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient could not be saved. Please, try again.'));
        }
        $this->set(compact('patient'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Delete']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Patients']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $this->request->allowMethod(['post', 'delete']);
        $patient = $this->Patients->get($id);
        if ($this->Patients->delete($patient)) {
            $this->Flash->success(__('The patient has been deleted.'));
        } else {
            $this->Flash->error(__('The patient could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function archived($id = null)
    {
		$this->set('title', 'Patients Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Archived']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Patients']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $patient = $this->Patients->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $patient = $this->Patients->patchEntity($patient, $this->request->getData());
			$patient->status = 2; //archived
            if ($this->Patients->save($patient)) {
                $this->Flash->success(__('The patient has been archived.'));

				return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The patient could not be archived. Please, try again.'));
        }
        $this->set(compact('patient'));
    }
}
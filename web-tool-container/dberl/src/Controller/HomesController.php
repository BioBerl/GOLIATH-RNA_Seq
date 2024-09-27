<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\SubmitForm;
use App\Model\Upload;
use Cake\ORM\TableRegistry;

class HomesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }


    public function index()
    {
         $this->loadModel('Process');
        
         $dir = "/files/";
         $time = time();
#         $dir = WWW_ROOT.$dir.DS.$time.DS;
         $dir = $dir.DS.$time.DS;
         $jobfile = $dir."JOB";
         $form = new SubmitForm();
         $outname = "out_kallisto";
         $finish = 0;

         if ($this->request->is('post')) {
             $formulario = $this->request->getData();
             if (!mkdir($dir, 0777, true)) {
                 die('Failed to create folders...');
             } else {

                 if($form->execute($formulario)) {
                     $processTable = TableRegistry::get('Process');
                     $processTable = TableRegistry::getTableLocator()->get('Process');
                     $process = $processTable->newEntity();

                     $process->name = $time;
                     $process->status = 0;
                     $finish = 0;

                     if($processTable->save($process)) {
                         $id = $process->id;

                         if($formulario['seq'] == 0) {
                             if(($formulario['file1']['error']!=0) and ($formulario['file1']['size']==0)) {
                                 $this->Flash->error('Alguma coisa deu errado, o upload retornou erro '.$formulario['file1']['error'].' e tamanho '.$formulario['file1']['size']);
                             } else {
                                 $file1 = $this->request->data['file1'];
                                 if (move_uploaded_file($file1['tmp_name'], $dir . $file1['name'])) {
                                     $this->Flash->success(__('File(s) submitted(s) with success!!'));
                                     $this->CreateJobFile([$jobfile, $formulario['seq'], $dir, $file1['name'], $time, $formulario['email']]);
                                     $finish = 1;
                                 } else {
                                     $this->Flash->error(__('Could not upload the file '.$file1['name']));
                                 }
                             }
                         } else {
                             if(($formulario['file1']['error']!=0) and ($formulario['file1']['size']==0)) {
                                 $this->Flash->error('Alguma coisa deu errado, o upload retornou erro '.$formulario['file1']['error'].' e tamanho '.$formulario['file1']['size']);
                             } elseif(($formulario['file2']['error']!=0) and ($formulario['file2']['size']==0)) {
                                 $this->Flash->error('Alguma coisa deu errado, o upload retornou erro '.$formulario['file2']['error'].' e tamanho '.$formulario['file2']['size']);
                             } else {
                                 $file1 = $this->request->data['file1'];
                                 if (move_uploaded_file($file1['tmp_name'], $dir . $file1['name'])) {
                                     $file2 = $this->request->data['file2'];
                                     if (move_uploaded_file($file2['tmp_name'], $dir . $file2['name'])) {
                                         $this->Flash->success(__('File(s) submitted(s) with success!!'));
                                         $this->CreateJobFile([$jobfile, $formulario['seq'], $dir, $file1['name'], $file2['name'], $time, $formulario['email']]);
                                         $finish = 1;
                                     } else {
                                         $this->Flash->error(__('Could not upload the file '.$file2['name']));
                                     }
                                 } else {
                                     $this->Flash->error(__('Could not upload the file '.$file1['name']));
                                 }
                             }
                         }
                     } else {
                         $this->Flash->error(__('Could not upload the file '));
                     }

                     if($finish) {
                          $processTable = TableRegistry::get('Process');
                          $processTable = TableRegistry::getTableLocator()->get('Process');
                          $process = $processTable->get($id);

                          $process->status = 1;
                          $processTable->save($process);
                     }
                 } else {
                     $this->Flash->error(__('Could not upload the file '));
                 }
             }

#             if ($contact->execute($this->request->getData())) {
#                 $this->Flash->success('We will get back to you soon.');
#             } else {
#                 $this->Flash->error('There was a problem submitting your form.');
#             }
         }
         $this->set('form', $form);
    }

    public function form($type = null) {


        if($type == "tipo-0") {
            $this->viewBuilder()->setLayout('genomics');
        } else {
            $this->viewBuilder()->setLayout('transcriptomics');
        }

        $this->set(["type" => $type]);
    }

    public function CreateJobFile($args = array()) {

        #args = 6 (single). args = 7 (paired)
        #FASTQ1=/home/scratch60/1horin/ER1.fastq
        #FASTQ2=/home/scratch60/1horin/ER2.fastq
        #TYPE=single
        #OUTPUT=""
        $seq = array("single", "paired");

        if(count($args) == 6) {
            $content = "OUTNAME=out_kallisto_".$args[4]."\n";
            $content .= "EMAIL=".$args[5]."\n";
            $content .= "TYPE=".$seq[$args[1]]."\n";
            $content .= "FASTQ1=".$args[3]."\n";
            $content .= "FASTQ2=\n";
        } else {
            $content = "OUTNAME=out_kallisto_".$args[5]."\n";
            $content .= "EMAIL=".$args[6]."\n";
            $content .= "TYPE=".$seq[$args[1]]."\n";
            $content .= "FASTQ1=".$args[3]."\n";
            $content .= "FASTQ2=".$args[4]."\n";
        }
        $fp = fopen($args[0],"wb");
        fwrite($fp,$content);
        fclose($fp);

        chmod($args[2], 0777);
    }

}

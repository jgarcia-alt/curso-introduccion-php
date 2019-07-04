<?php
namespace App\Controllers;
use App\Models\Job;
use Respect\Validation\Validator as v;

class JobsController extends BaseController {

    public function getAddJobAction($request){
        $responseMessage = null;

        if ($request->getMethod() == 'POST') {
            $postData = $request->getParsedBody();
            $jobValidator = v::key('title', v::stringType()->notEmpty())
                ->key('description', v::stringType()->notEmpty());

         try {
            $jobValidator->assert($postData);
            $postData = $request->getParsedBody();

            $files = $request->getUploadedFiles();
            $logo = $files['logo'];

            $ubicacionImagen="";

            if($logo->getError() == UPLOAD_ERR_OK) {
                $fileName = $logo->getClientFilename();

                $ubicacionImagen="uploads/$fileName";

                $logo->moveTo($ubicacionImagen);}

                //$logo->moveTo("uploads/$fileName");}
                
            $job = new Job();
            $job->title = $postData['title'];
            $job->description = $postData['description'];
            $job->imagen = $ubicacionImagen;
            $job->save();
            $responseMessage = 'Saved';

        } catch(\Exception $e) {
            $responseMessage = $e->getMessage();
        }}
        return $this->renderHTML('addJob.twig',[
            'responseMessage' =>$responseMessage
        ]);
    }
}
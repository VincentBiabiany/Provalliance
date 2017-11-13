<?php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
      $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file, $matricule = 0, $typeDemande, $id)
    {
      $today = date("m-d-y");
      $fileName = $matricule.'_'.$id.'_'.$typeDemande.'_'.$today.'.'.$file->getClientOriginalExtension();
      $file->move($this->getTargetDir(), $fileName);
      return $fileName;
    }

    public function getTargetDir()
    {
      return $this->targetDir;
    }
}

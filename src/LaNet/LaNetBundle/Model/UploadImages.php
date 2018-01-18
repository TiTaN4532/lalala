<?php
namespace LaNet\LaNetBundle\Model;
use Doctrine\ORM\Mapping as ORM;

abstract class UploadImages {
  
  protected $file;

  protected $temp;

  /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
       
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->image)) {
            // store the old name to delete after the update
            $this->temp = $this->image;
            $this->image = null;
        } else {
            $this->image = 'initial';
        }
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->image
            ? null
            : $this->getUploadRootDir().'/'.$this->image;
    }
    
    public function getWebPath()
    {
        return null === $this->image
            ? $this->getUploadDir().'/default.png'
            : $this->getUploadDir().'/'.$this->image;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
//        return 'uploads/images/mentors';
    }
    
    public function preUpdate()
    {

    }
 
    public function prePersist()
    {
      
    }
     
    public function upload()
    { 
        
    }

    public function removeUpload()
    {

    }
}

?>

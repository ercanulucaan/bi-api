<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

require(APPPATH."third_party/MX/Controller.php");

class MY_Controller extends MX_Controller
{

    protected $in;
    protected $out;
    protected $set;
    protected $data;

    public function __construct()
    {
        parent::__construct();
    }

    protected function response($status, $message, $data = false, $redirect_url = null)
    {
        if($status !== null)
        {
            $this->out['status'] = $status;
        }
        if($message !== null)
        {
            $this->out['message'] = $message;
        }
        if($data !== null)
        {
            $this->out['data'] = $data;
        }
        if($redirect_url !== null)
        {
            $this->out['redirect_url'] = $redirect_url;
        }
        return $this->output->set_content_type('application/json')->set_status_header($this->out['status'])->set_output(json_encode($this->out));
    }
    
    protected function upload_files($files)
    {
        $uploads_dir = 'public/uploads';
        if(!is_dir($uploads_dir))
        {
            mkdir($uploads_dir, 0777);
        }
        $year_dir = $uploads_dir . '/' . date("Y");
        if(!is_dir($year_dir))
        {
            mkdir($year_dir, 0777);
        }
        $month_dir = $year_dir . '/' . date("m");
        if(!is_dir($month_dir))
        {
            mkdir($month_dir, 0777);
        }
        $day_dir = $month_dir. '/' . date("d");
        if(!is_dir($day_dir))
        {
            mkdir($day_dir, 0777);
        }
        $config = array(
            'upload_path'   => $day_dir,
            'allowed_types' => '*',
            'remove_spaces' => TRUE,
            'encrypt_name'  => TRUE,
            'overwrite'     => TRUE
        );
        $this->load->library('upload', $config);
        $images = array();
        if (is_array($files['name']) || is_object($files['name']))
        {
            foreach ($files['name'] as $key => $image)
            {
                $_FILES['images[]']['name']     = $files['name'][$key];
                $_FILES['images[]']['type']     = $files['type'][$key];
                $_FILES['images[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['images[]']['error']    = $files['error'][$key];
                $_FILES['images[]']['size']     = $files['size'][$key];
                $this->upload->initialize($config);
                if($this->upload->do_upload('images[]'))
                {
                    $data = $this->upload->data();
                    $images[] = $day_dir . '/' . $data['file_name'];
                }
            }
        }
        else
        {
            $_FILES['file']['name']     = $files['name'];
            $_FILES['file']['type']     = $files['type'];
            $_FILES['file']['tmp_name'] = $files['tmp_name'];
            $_FILES['file']['error']    = $files['error'];
            $_FILES['file']['size']     = $files['size'];
            $this->upload->initialize($config);
            if($this->upload->do_upload('file'))
            {
                $data = $this->upload->data();
                $images[] = $day_dir . '/' . $data['file_name'];
            }
        }
        return $images;
    }

}
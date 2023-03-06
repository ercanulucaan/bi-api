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

    protected function checkPageAuth($page)
    {
        $clientDetails = $this->clientDetails();
        $clientRole = $this->db->where('id', $clientDetails->role_id)->get('roles')->row('authority');
        if(in_array($page, explode(",", $clientRole)) || $clientRole == '*')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    protected function clientDetails()
    {
        $checkJwtToken = $this->checkJwtToken();
        if(!empty($checkJwtToken))
        {
            return $this->db->where('email', $checkJwtToken->email)->get('clients')->row();
        }
        else
        {
            return false;
        }
    }

    protected function createJwtToken($email)
    {
        $secretKey   = $this->db->where('key', 'api_secret_key')->get('options')->row('val');
        $issuedAt    = new DateTimeImmutable();
        $expriedAt   = $issuedAt->modify('+10 hours')->getTimestamp();
        $serverName  = $this->db->where('key', 'site_url')->get('options')->row('val');
        $checkClient = $this->db->where('email', $email)->get('clients')->row();
        if(!empty($checkClient))
        {
            unset($checkClient->password);
            $jwtData = [
                'issuedAt'   => $issuedAt->getTimestamp(),
                'issuer'     => $serverName,
                'expriedAt'  => $expriedAt,
                'email'      => $email
            ];
            $createdToken = JWT::encode($jwtData, $secretKey);
            $this->db->where('email', $email)->update('clients', [
                'token' => $createdToken
            ]);
            return $createdToken;
        }
        else
        {
            return null;
        }
    }

    protected function checkJwtToken()
    {
        $headers    = $this->getAuthorizationHeaders();
        if(empty($headers)) return false;
        $jwtToken   = str_replace('Bearer ', '', $headers);
        $secretKey  = $this->db->where('key', 'api_secret_key')->get('options')->row('val');
        try {
            $issuedAt = new DateTimeImmutable();
            $decoded  = JWT::decode($jwtToken, $secretKey);
            if($decoded->expriedAt < $issuedAt->getTimestamp())
            {
                return false;
            }
            else
            {
                return $decoded;
            }
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    protected function getAuthorizationHeaders()
    {
        $headers = null;

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } else if (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
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
            $this->out['result'] = $data;
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
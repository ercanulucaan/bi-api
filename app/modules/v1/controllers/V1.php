<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class V1 extends MY_Controller
{

    protected $data;
    protected $provinces_table = 'provinces';
    protected $counties_table = 'counties';
    protected $districts_table = 'districts';
    protected $clients_table = 'clients';
    protected $service_categories_table = 'service_categories';
    protected $services_table = 'services';
    protected $questions_table = 'questions';
    protected $question_values_table = 'question_values';
    protected $client_service_requests_table = 'client_service_requests';

    public function __construct()
    {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
    }

    public function index()
    {
        return $this->response(200, 'API version: 1.0.0', true);
    }

    public function get_details($id)
    {
        if(empty($id)) return $this->response(201, 'NO', null);
        $array = [];
        $service = $this->db->where('id', $id)->get('services')->row();
        if(empty($service)) return $this->response(201, 'NO', null);
        $array['service_id'] = $id;
        $array['name'] = $service->name;
        $questions = $this->db->where('service_id', $id)->order_by('page_number', 'asc')->get('questions')->result();
        if(!empty($questions)){
          foreach($questions as $key => $val)
        {
            $array['questions'][$key]['id'] = $val->id;
            $array['questions'][$key]['type_id'] = $val->type_id;

            switch ($val->type_id)
            {
                case '1':
                    $array['questions'][$key]['type_name'] = 'select';
                    break;
                case '2':
                    $array['questions'][$key]['type_name'] = 'text';
                    break;
                case '4':
                    $array['questions'][$key]['type_name'] = 'plus_minus';
                    break;
                case '5':
                    $array['questions'][$key]['type_name'] = 'checkbox';
                    break;
                case '6':
                    $array['questions'][$key]['type_name'] = 'radio';
                    break;
                default:
                    $array['questions'][$key]['type_name'] = null;
            }
            $array['questions'][$key]['label'] = $val->label;
            $array['questions'][$key]['required'] = $val->required;
            $array['questions'][$key]['unit'] = $val->unit;
            $array['questions'][$key]['page_number'] = $val->page_number;
            $values = $this->db->where('question_id', $val->id)->get('question_values')->result();
            foreach($values as $values_key => $values_val)
            {
                $array['questions'][$key]['answers'][$values_key] = $values_val;
            }
        }
        }
      	else
        {
          $array['questions'] = [];
        }
        return $this->response(200, 'OK', $array);
    }

    public function get_my_posted_ads()
    {
        $decoded = $this->check_token();
        if(empty($decoded)) return $this->response(201, 'Girilen token geçersiz veya süresi dolmuş.', null);
        $client = $this->db->where('email', $decoded->email)->get($this->clients_table)->row();
        $check_posted_ads = $this->db->where('client_id', $client->id)->get($this->client_service_requests_table)->row();
        if(empty($client)) return $this->response(201, 'Geçersiz kullanıcı işlemi tespit edildi.', null);
        return $this->response(200, 'Kullanıcı bilgileri getirildi.', $check_posted_ads);
    }

    public function get_popular_categories()
    {
        try
        {
            $result = [];
            $categories = $this->db->where('is_popular', '1')->get($this->service_categories_table)->result();
            foreach($categories as $key => $val)
            {
                $service_count = $this->db->where('category_id', $val->id)->get($this->services_table)->num_rows();
                $result[$key]['id'] = $val->id;
                $result[$key]['name'] = $val->name;
                $result[$key]['description'] = $val->description;
                $result[$key]['icon'] = $val->icon;
                $result[$key]['service_count'] = $service_count;
                $result[$key]['image'] = $val->image;
            }
            return $this->response(200, 'Popüler servis kategorileri başarıyla çekildi.', $result);
        }
        catch(Exception $e)
        {
            return $this->response(201, 'Popüler servis kategorileri çekilirken bir hata oluştu.', null);
        }
    }

    public function get_services()
    {
        try
        {
            $this->db->limit(10, (!empty($this->input->get('page'))) ? $this->input->get('page') : 0);
            if(!empty($this->input->get('query'))) $this->db->like('name', $this->input->get('query'));
            $services = $this->db->get($this->services_table)->result();
            return $this->response(200, 'Servis listesi başarıyla çekildi.', $services);
        }
        catch(Exception $e)
        {
            return $this->response(201, 'Servis listesi çekilirken bir hata oluştu.', null);
        }
    }

    public function get_service($id)
    {
        try
        {
            $service = $this->db->where('id', $id)->get($this->services_table)->row();
            return $this->response(200, 'Servis başarıyla çekildi.', $service);
        }
        catch(Exception $e)
        {
            return $this->response(201, 'Servis listesi çekilirken bir hata oluştu.', null);
        }
    }

    public function get_questions($id = null)
    {
        try
        {
            if(!is_numeric($id)) return $this->response(201, ':ID parametresi sayısal olmalıdır.', null);
            $questions = $this->db->where('service_id', $id)->get($this->questions_table)->result();
            if(!empty($questions))
            {
                return $this->response(200, 'Soru listesi başarıyla çekildi.', $questions);
            }
            else
            {
                return $this->response(201, 'Soru listesi boş.', null);
            }
        }
        catch(Exception $e)
        {
            return $this->response(201, 'Soru listesi çekilirken bir hata oluştu.', null);
        }
    }

    public function get_question_values($id = null)
    {
        try
        {
            $question_values = $this->db->where('question_id', $id)->get($this->question_values_table)->result();
            return $this->response(200, 'Cevap listesi başarıyla çekildi.', $question_values);
        }
        catch(Exception $e)
        {
            return $this->response(201, 'Cevap listesi çekilirken bir hata oluştu.', null);
        }
    }

    public function get_provinces()
    {
        try
        {
            $provinces = $this->db->get($this->provinces_table)->result();
            return $this->response(200, 'İl listesi başarıyla çekildi.', $provinces);
        }
        catch(Exception $e)
        {
            return $this->response(201, 'İl listesi çekilirken bir hata oluştu.', null);
        }
    }

    public function get_counties($id = null)
    {
        try
        {
            $counties = $this->db->where('province_id', $id)->get($this->counties_table)->result();
            return $this->response(200, 'İlçe listesi başarıyla çekildi.', $counties);
        }
        catch(Exception $e)
        {
            return $this->response(201, 'İlçe listesi çekilirken bir hata oluştu.', null);
        }
    }

    public function get_districts($id = null)
    {
        try
        {
            $districts = $this->db->where('countie_id', $id)->get($this->districts_table)->result();
            return $this->response(200, 'Mahalle listesi başarıyla çekildi.', $districts);
        }
        catch(Exception $e)
        {
            return $this->response(201, 'Mahalle listesi çekilirken bir hata oluştu.', null);
        }
    }

    public function get_client()
    {
        $decoded = $this->check_token();
        if(empty($decoded)) return $this->response(201, 'Girilen token geçersiz veya süresi dolmuş.', null);
        $check_client = $this->db->where('email', $decoded->email)->get($this->clients_table)->row();
        if(empty($check_client)) return $this->response(201, 'Geçersiz kullanıcı işlemi tespit edildi.', null);
        return $this->response(200, 'Kullanıcı bilgileri getirildi.', $check_client);
    }

    public function register()
    {
      	$_POST = json_decode(file_get_contents('php://input'), true);
        if(!empty($_POST))
        {
            $error_data = [];
            // Check posted values
            $account_type = (!empty($_POST['account_type']) ? $_POST['account_type'] : null);
            $first_name = (!empty($_POST['first_name']) ? $_POST['first_name'] : null);
            $second_name = (!empty($_POST['second_name']) ? $_POST['second_name'] : null);
            $last_name = (!empty($_POST['last_name']) ? $_POST['last_name'] : null);
            $email = (!empty($_POST['email']) ? $_POST['email'] : null);
            $password = (!empty($_POST['password']) ? $_POST['password'] : null);
            $phone = (!empty($_POST['phone']) ? $_POST['phone'] : null);

            // Check empty value and add error data
            if(empty($account_type)) $error_data['account_type'] = 'Hesap tipi gerekli.';
            if(empty($first_name)) $error_data['first_name'] = 'Adınız gerekli.';
            if(empty($last_name)) $error_data['last_name'] = 'Soyadınız gerekli.';
            if(empty($email)) $error_data['email'] = 'E-posta gerekli.';
            if(empty($password)) $error_data['password'] = 'Şifre gerekli.';
            if(empty($phone)) $error_data['phone'] = 'Telefon gerekli.';

            // Check email is exists
            $email_check = $this->db->where('email', $email)->get('clients')->num_rows();
            if($email_check > 0)
            {
                $error_data['email_is_exists'] = 'E-posta adresi zaten kullanımda.';
            }

            // Check password is short
            if($password < 6)
            {
                $error_data['short_password'] = 'Şifreniz 6 karakterden fazla olmalıdır.';
            }

            // Check phone is exists
            $phone_check = $this->db->where('phone', $phone)->get('clients')->num_rows();
            if($phone_check > 0)
            {
                $error_data['phone_is_exists'] = 'Telefon numarası zaten kullanılıyor.';
            }

            // If error data is not empty
            if(!empty($error_data))
            {
                return $this->response(201, 'Eksik bir şeyler var.', $error_data);
            }
            else
            {
                // Save to db
                $insert = $this->db->insert('clients', [
                    'account_type' => $account_type,
                    'first_name' => $first_name,
                    'second_name' => $second_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'phone' => $phone,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
                if($insert)
                {
                    if(!empty($this->input->get('services_login')) && $this->input->get('services_login') == true)
                    {
                        $token = $this->create_token($email);
                        return $this->response(200, 'Kayıt başarıyla gerçekleşti.', $this->db->insert_id());
                    }
                    else
                    {
                        return $this->response(200, 'Kayıt başarıyla gerçekleşti.', $this->db->insert_id());
                    }
                }
                else
                {
                    return $this->response(201, 'Kayıt işlemi başarısız oldu.', null);
                }
            }
        }
        else
        {
            return $this->response(200, 'Woah.', null);
        }
    }

    public function login()
    {
        $error_data = [];
        // Check posted values
      	$_POST = json_decode(file_get_contents('php://input'), true);
        $email = ($_POST['email'] ? $_POST['email'] : null);
        $password = ($_POST['password'] ? $_POST['password'] : null);

        // Check empty value and add error data
        if(empty($email)) $error_data['email'] = 'E-posta adresinizi yazınız';
        if(empty($password)) $error_data['password'] = 'Şifrenizi yazınız';

        if(!empty($error_data))
        {
            return $this->response(201, 'Eksik bir şeyler var.', $error_data);
        }
        else
        {
            // Check email is exists
            $email_check = $this->db->where('email', $email)->get('clients')->num_rows();
            if($email_check == 0)
            {
                $error_data['email_is_invalid'] = 'E-posta adresi sistemimizde kayıtlı değil.';
            }
            if(!empty($error_data))
            {
                return $this->response(201, 'Eksik bir şeyler var.', $error_data);
            }
            else
            {
                // Check password is short
                if($password < 6)
                {
                    $error_data['short_password'] = 'Şifreniz 6 karakterden fazla olmalıdır.';
                }
                if(!empty($error_data))
                {
                    return $this->response(201, 'Eksik bir şeyler var.', $error_data);
                }
                else
                {
                    // Password verify
                    $password_verify = $this->db->where('email', $email)->get('clients')->row('password');
                    if(!password_verify($password, $password_verify))
                    {
                        $error_data['password_is_invalid'] = 'Yanlış şifre girdiniz.';
                    }

                    if(!empty($error_data))
                    {
                        return $this->response(201, 'Eksik bir şeyler var.', $error_data);
                    }
                    else
                    {
                        // Create jwt token
                        $token = $this->create_token($email);
                        if($token)
                        {
                            return $this->response(200, 'Giriş başarıyla gerçekleşti.', $token);
                        }
                        else
                        {
                            return $this->response(201, 'Giriş yaparken bir sorun oluştu.');
                        }
                    }
                }
            }
        }
    }
    public function get_token()
    {
        $email = $this->input->get('email');
        if(empty($email)) return $this->response(201, 'Token oluşturulamadı.', null);
        $check_mail  = $this->db->where('email', $email)->get('clients')->result();
        if(empty($check_mail)) return $this->response(201, 'Mail adresi sistemimizde kayıtlı değil.', null);
        $token = $this->create_token($email);
        $this->response(200, 'Token başarıyla oluşturuldu.', $token);
    }

    private function create_token($email)
    {
        $secret_key = $this->db->where('key', 'api_secret_key')->get('options')->row('val');
        $issued_at = new DateTimeImmutable();
        $expired_at = $issued_at->modify('+1 hours')->getTimestamp();
        $server_name = $this->db->where('key', 'site_url')->get('options')->row('val');
        $data = [
            'issued_at' => $issued_at->getTimestamp(),
            'issuer' => $server_name,
            'expried_at' => $expired_at,
            'email' => $email
        ];
        $token = JWT::encode($data, $secret_key);
        $this->db->where('email', $email)->update('clients', [
            'token' => $token
        ]);
        return $token;
    }

    private function check_token()
    {
        $headers = $this->get_authorization_header();
        if(empty($headers)) return false;
        $token = str_replace('Bearer ', '', $headers);
        $secret_key = $this->db->where('key', 'api_secret_key')->get('options')->row('val');
        try {
            $issued_at = new DateTimeImmutable();
            $decoded = JWT::decode($token, $secret_key);
            if($decoded->expried_at < $issued_at->getTimestamp())
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

    private function get_authorization_header()
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

}


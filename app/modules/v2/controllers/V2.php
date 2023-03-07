<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class V2 extends MY_Controller {

    protected $tables = [
        'bank_accounts_table'           => 'bank_accounts',
        'blog_categories_table'         => 'blog_categories',
        'blog_posts_table'              => 'blog_posts',
        'clients_table'                 => 'clients',
        'client_balance_history_table'  => 'client_balance_history',
        'client_messages_table'         => 'client_messages',
        'client_notifications_table'    => 'client_notifications',
        'client_services_table'         => 'client_services',
        'client_service_bids_table'     => 'client_service_bids',
        'client_service_requests_table' => 'client_service_requests',
        'counties_table'                => 'counties',
        'districts_table'               => 'districts',
        'options_table'                 => 'options',
        'provinces_table'               => 'provinces',
        'questions_table'               => 'questions',
        'question_values_table'         => 'question_values',
        'roles_table'                   => 'roles',
        'services_table'                => 'services',
        'sessions_table'                => 'sessions'
    ];

    protected $messages = [
        'token_invalid'                         => 'Token geçersiz veya süresi dolmuş.',
        'no_authorization'                      => 'Yetkiniz yok.',
        'bank_accounts_are_listed'              => 'Banka hesapları listeleniyor.',
        'blog_categories_are_listed'            => 'Blog kategorileri listeleniyor.',
        'blog_categories_is_not_found'          => 'Blog kategorileri bulunamadı.',
        'blog_posts_are_listed'                 => 'Blog paylaşımları listeleniyor.',
        'blog_posts_is_not_found'               => 'Blog paylaşımları bulunamadı.',
        'id_parameter_are_null_or_not_numeric'  => '(:id) parametresi boş veya numerik değil.',
        'blog_post_is_not_found'                => 'Blog paylaşımı bulunamadı.',
        'blog_post_are_showed'                  => 'Blog paylaşımı gösteriliyor.',
        'clients_is_not_found'                  => 'Kullanıcı hesapları bulunamadı.',
        'clients_are_listed'                    => 'Kullanıcı hesapları listeleniyor.',
        'client_detail_is_not_found'            => 'Kullanıcı bilgisi bulunamadı.',
        'client_detail_are_listed'              => 'Kullanıcı bilgisi listeleniyor.',
        'self_client_details_is_not_found'      => 'Kullanıcı bilgileriniz bulunamadı.',
        'self_client_details_are_listed'        => 'Kullanıcı bilgileriniz listeleniyor.',
        'clients_balance_histories_is_not_found'=> 'Kullanıcı hesap hareketleri bulunamadı.', 
        'clients_balance_histories_are_listed'  => 'Kullanıcı hesap hareketleri listeleniyor.', 
        'self_balance_history_is_not_found'     => 'Hesap hareketleriniz bulunamadı.', 
        'self_balance_history_are_listed'       => 'Hesap hareketleriniz listeleniyor.', 
        'client_messages_is_not_found'          => 'Kullanıcı mesajları bulunamadı.', 
        'client_messages_are_listed'            => 'Kullanıcı mesajları listeleniyor.', 
        'self_messages_is_not_found'            => 'Mesajlarınız bulunamadı.', 
        'self_messages_are_listed'              => 'Mesajlarınız listeleniyor.', 
        'client_notifications_is_not_found'     => 'Kullanıcı bildirimleri bulunamadı.', 
        'client_notifications_are_listed'       => 'Kullanıcı bildirimleri listeleniyor.', 
        'self_notifications_is_not_found'       => 'Bildirimleriniz bulunamadı.', 
        'self_notifications_are_listed'         => 'Bildirimleriniz listeleniyor.', 
        'client_services_is_not_found'          => 'Kullanıcı servisleri bulunamadı.', 
        'client_services_are_listed'            => 'Kullanıcı servisleri listeleniyor.', 
        'self_services_is_not_found'            => 'Servisleriniz bulunamadı.', 
        'self_services_are_listed'              => 'Servisleriniz listeleniyor.', 
        'client_service_bids_is_not_found'      => 'Kullanıcı servis teklifleri bulunamadı.', 
        'client_service_bids_are_listed'        => 'Kullanıcı servis teklifleri listeleniyor.', 
        'self_service_bids_is_not_found'        => 'Servis teklifleriniz bulunamadı.', 
        'self_service_bids_are_listed'          => 'Servis teklifleriniz listeleniyor.', 
        'client_service_requests_is_not_found'  => 'Kullanıcı servis istekleri bulunamadı.', 
        'client_service_requests_are_listed'    => 'Kullanıcı servis istekleri listeleniyor.', 
        'self_service_requests_is_not_found'    => 'Servis istekleriniz bulunamadı.',
        'self_service_requests_are_listed'      => 'Servis istekleriniz listeleniyor.',
        'counties_is_not_found'                 => 'İlçeler bulunamadı.',
        'counties_are_listed'                   => 'İlçeler listeleniyor.',
        'districts_is_not_found'                => 'Mahalleler bulunamadı.',
        'districts_are_listed'                  => 'Mahalleler listeleniyor.',
        'options_is_not_found'                  => 'Seçenekler bulunamadı.',
        'options_are_listed'                    => 'Seçenekler listeleniyor.',
        'provinces_is_not_found'                => 'İller bulunamadı.',
        'provinces_are_listed'                  => 'İller listeleniyor.',
        'questions_is_not_found'                => 'Sorular bulunamadı.',
        'questions_are_listed'                  => 'Sorular listeleniyor.',
        'question_values_is_not_found'          => 'Cevaplar bulunamadı.',
        'question_values_are_listed'            => 'Cevaplar listeleniyor.',
        'roles_is_not_found'                    => 'Yetki kuralları bulunamadı.',
        'roles_are_listed'                      => 'Yetki kuralları listeleniyor.',
        'services_is_not_found'                 => 'Servisler bulunamadı.',
        'services_are_listed'                   => 'Servisler listeleniyor.',
        'full_name_is_required'                 => 'Ad soyad girilmedi.',
        'email_is_required'                     => 'E-posta adresi girilmedi.',
        'password_is_required'                  => 'Şifre girilmedi.',
        'email_is_not_exists'                   => 'E-posta adresi kayıtlı değil.',
        'password_must_be_least_6_char'         => 'Şifre en az 6 karakter olmalıdır.',
        'wrong_password'                        => 'Şifreniz hatalı girildi.',
        'there_is_a_problem'                    => 'Bir sorun oluştu.',
        'login_success'                         => 'Giriş başarıyla gerçekleşti.',
        'account_type_is_required'              => 'Hesap tipi seçilmedi.',
        'email_format_is_incorrect'             => 'E-posta formatı uygun değil.',
        'email_is_already_exists'               => 'E-posta zaten kullanımda.',
        'password_repeat_is_required'           => 'Şifre tekrarı gerekli.',
        'passwords_is_not_equal'                => 'Şifre ve şifre tekrarı uyuşmuyor.',
        'phone_is_required'                     => 'Telefon numarası gerekli.',
        'phone_format_is_incorrect'             => 'Telefon numarası formatı uygun değil.',
        'phone_is_already_exists'               => 'Telefon numarası kullanımda.',
        'register_success'                      => 'Kayıt başarıyla gerçekleşti.',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->response(200, 'API (v2.0.1) is working...', true, null);
    }

    public function register()
    {
        if(empty(jsonPosts('account_type')))
        {
            return $this->response(401, $this->messages['account_type_is_required'], null);
        }
        if(empty(jsonPosts('full_name')))
        {
            return $this->response(401, $this->messages['full_name_is_required'], null);
        }
        if(empty(jsonPosts('email')))
        {
            return $this->response(401, $this->messages['email_is_required'], null);
        }
        if(!filter_var(jsonPosts('email'), FILTER_VALIDATE_EMAIL))
        {
            return $this->response(401, $this->messages['email_format_is_incorrect'], null);
        }
        $checkEmail = $this->db->where('email', jsonPosts('email'))->get($this->tables['clients_table'])->row();
        if(!empty($checkEmail))
        {
            return $this->response(401, $this->messages['email_is_already_exists'], null);
        }
        if(empty(jsonPosts('password')))
        {
            return $this->response(401, $this->messages['password_is_required'], null);
        }
        if(strlen(jsonPosts('password')) < 6)
        {
            return $this->response(401, $this->messages['password_must_be_least_6_char'], null);
        }
        if(empty(jsonPosts('password_repeat')))
        {
            return $this->response(401, $this->messages['password_repeat_is_required'], null);
        }
        if(jsonPosts('password') !== jsonPosts('password_repeat'))
        {
            return $this->response(401, $this->messages['passwords_is_not_equal'], null);
        }
        if(empty(jsonPosts('phone')))
        {
            return $this->response(401, $this->messages['phone_is_required'], null);
        }
        if(!preg_match('/^[0-9]{10}+$/', jsonPosts('phone')))
        {
            return $this->response(401, $this->messages['phone_format_is_incorrect'], null);
        }
        $checkPhone = $this->db->where('phone', jsonPosts('phone'))->get($this->tables['clients_table'])->row();
        if(!empty($checkPhone))
        {
            return $this->response(401, $this->messages['phone_is_already_exists'], null);
        }
        $registerClient = $this->db->insert($this->tables['clients_table'], [
            'account_type' => jsonPosts('account_type'),
            'full_name' => jsonPosts('full_name'),
            'email' => jsonPosts('email'),
            'password' => password_hash(jsonPosts('password'), PASSWORD_DEFAULT),
            'phone' => jsonPosts('phone'),
            'created_at' => date("Y-m-d H:i:s")
        ]);
        if(empty($registerClient))
        {
            return $this->response(401, $this->messages['there_is_a_problem'], null);
        }
        else
        {
            return $this->response(201, $this->messages['register_success'], $this->db->insert_id());
        }
    }

    public function login()
    {
        if(empty(jsonPosts('email')))
        {
            return $this->response(401, $this->messages['email_is_required'], null);
        }
        if(empty(jsonPosts('password')))
        {
            return $this->response(401, $this->messages['password_is_required'], null);
        }
        if(strlen(jsonPosts('password')) < 6)
        {
            return $this->response(401, $this->messages['password_must_be_least_6_char'], null);
        }
        $emailCheck = $this->db->where('email', jsonPosts('email'))->get($this->tables['clients_table'])->row('email');
        if(empty($emailCheck))
        {
            return $this->response(401, $this->messages['email_is_not_exists'], null);
        }
        $passwordCheck = $this->db->where('email', jsonPosts('email'))->get($this->tables['clients_table'])->row('password');
        if(!password_verify(jsonPosts('password'), $passwordCheck))
        {
            return $this->response(401, $this->messages['wrong_password'], null);
        }
        else
        {
            $createJwtToken = $this->createJwtToken(jsonPosts('email'));
            if(empty($createJwtToken))
            {
                return $this->response(401, $this->messages['there_is_a_problem'], null);
            }
            return $this->response(201, $this->messages['login_success'], $createJwtToken);
        }
    }

    public function getBankAccounts()
    {
        $checkJwtToken = $this->checkJwtToken();
        if(empty($checkJwtToken))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            $bankAccounts = $this->db->get($this->tables['bank_accounts_table'])->result();
            return $this->response(200, $this->messages['bank_accounts_are_listed'], $bankAccounts);
        }
    }

    public function getBlogCategories()
    {
        $blogCategories = $this->db->get($this->tables['blog_categories_table'])->result();
        if(empty($blogCategories))
        {
            return $this->response(200, $this->messages['blog_categories_is_not_found'], null);
        }
        else
        {
            return $this->response(200, $this->messages['blog_categories_are_listed'], $blogCategories);
        }
    }

    public function getBlogPosts()
    {
        $blogPosts = $this->db->get($this->tables['blog_posts_table'])->result();
        if(empty($blogCategories))
        {
            return $this->response(200, $this->messages['blog_posts_is_not_found'], null);
        }
        else
        {
            return $this->response(200, $this->messages['blog_posts_are_listed'], $blogPosts);
        }
    }

    public function getBlogPost($id = null)
    {
        if(empty($id) || !is_numeric($id))
        {
            return $this->response(401, $this->messages['id_parameter_are_null_or_not_numeric'], null);
        }
        else
        {
            $blogPost = $this->db->where('id', $id)->get($this->tables['blog_posts_table'])->result();
            if(empty($blogPost))
            {
                return $this->response(401, $this->messages['blog_post_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['blog_post_are_showed'], $blogPost);
            }
        }
    }

    public function getClients()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['clients_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $clients = $this->db->get($this->tables['clients_table'])->result();
                if(empty($clients))
                {
                    return $this->response(200, $this->messages['clients_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['clients_are_listed'], $clients);
                }
            }
        }
    }

    public function getClient($id = null)
    {
        if(!empty($id) && is_numeric($id))
        {
            return $this->response(401, $this->messages['id_parameter_are_null_or_not_numeric'], null);
        }
        else
        {
            $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['clients_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $client = $this->db->where('id', $id)->get($this->tables['clients_table'])->row();
                if(empty($client))
                {
                    return $this->response(200, $this->messages['client_details_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['client_details_are_listed'], $client);
                }
            }
        }
        }
    }

    public function getSelfClient()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            return $this->response(200, $this->messages['self_client_details'], $clientDetails);
        }
    }

    public function getClientBalanceHistories()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['client_balance_history_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $balanceHistories = $this->db->get($this->tables['client_balance_history_table'])->result();
                if(empty($balanceHistories))
                {
                    return $this->response(200, $this->messages['clients_balance_histories_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['clients_balance_histories_are_listed'], $balanceHistories);
                }
            }
        }
    }

    public function getSelfBalanceHistory()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            $balanceHistory = $this->db->where('client_id', $clientDetails->id)->get($this->tables['client_balance_history_table'])->result();
            if(empty($balanceHistory))
            {
                return $this->response(200, $this->messages['self_balance_history_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['self_balance_history_are_listed'], $balanceHistory);
            }
        }
    }

    public function getClientMessages()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['client_messages_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $clientMessages = $this->db->get($this->tables['client_messages_table'])->result();
                if(empty($clientMessages))
                {
                    return $this->response(200, $this->messages['client_messages_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['client_messages_are_listed'], $clientMessages);
                }
            }
        }
    }

    public function getSelfMessages()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            $messages = $this->db->where('client_id', $clientDetails->id)->get($this->tables['client_messages_table'])->result();
            if(empty($messages))
            {
                return $this->response(200, $this->messages['self_messages_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['self_messages_are_listed'], $messages);
            }
        }
    }

    public function getClientNotifications()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['client_notifications_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $clientNotifications = $this->db->get($this->tables['client_notifications_table'])->result();
                if(empty($clientNotifications))
                {
                    return $this->response(200, $this->messages['client_notifications_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['client_notifications_are_listed'], $clientNotifications);
                }
            }
        }
    }

    public function getSelfNotifications()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            $notifications = $this->db->where('client_id', $clientDetails->id)->get($this->tables['client_notifications_table'])->result();
            if(empty($notifications))
            {
                return $this->response(200, $this->messages['self_notifications_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['self_notifications_are_listed'], $notifications);
            }
        }
    }

    public function getClientServices()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['client_services_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $clientServices = $this->db->get($this->tables['client_services_table'])->result();
                if(empty($clientServices))
                {
                    return $this->response(200, $this->messages['client_services_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['client_services_are_listed'], $clientServices);
                }
            }
        }
    }

    public function getSelfServices()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            $services = $this->db->where('client_id', $clientDetails->id)->get($this->tables['client_services_table'])->result();
            if(empty($services))
            {
                return $this->response(200, $this->messages['self_services_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['self_services_are_listed'], $services);
            }
        }
    }

    public function getClientServiceBids()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['client_service_bids_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $clientServiceBids = $this->db->get($this->tables['client_service_bids_table'])->result();
                if(empty($clientServiceBids))
                {
                    return $this->response(200, $this->messages['client_service_bids_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['client_service_bids_are_listed'], $clientServiceBids);
                }
            }
        }
    }

    public function getSelfServiceBids()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            $bids = $this->db->where('bidder_client_id', $clientDetails->id)->get($this->tables['client_service_bids_table'])->result();
            if(empty($bids))
            {
                return $this->response(200, $this->messages['self_service_bids_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['self_service_bids_are_listed'], $bids);
            }
        }
    }

    public function getClientServiceRequests()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['client_service_requests_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $clientServiceRequests = $this->db->get($this->tables['client_service_requests_table'])->result();
                if(empty($clientServiceRequests))
                {
                    return $this->response(200, $this->messages['client_service_requests_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['client_service_requests_are_listed'], $clientServiceRequests);
                }
            }
        }
    }

    public function getSelfServiceRequests()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            $bids = $this->db->where('client_id', $clientDetails->id)->get($this->tables['client_service_requests_table'])->result();
            if(empty($bids))
            {
                return $this->response(200, $this->messages['self_service_requests_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['self_service_requests_are_listed'], $bids);
            }
        }
    }

    public function getCounties($id = null)
    {
        if(empty($id) || !is_numeric($id))
        {
            return $this->response(401, $this->messages['id_parameter_are_null_or_not_numeric'], null);
        }
        else
        {
            $counties = $this->db->where('province_id', $id)->get($this->tables['counties_table'])->result();
            if(empty($counties))
            {
                return $this->response(401, $this->messages['counties_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['counties_are_listed'], $counties);
            }
        }
    }

    public function getDistricts($id = null)
    {
        if(empty($id) || !is_numeric($id))
        {
            return $this->response(401, $this->messages['id_parameter_are_null_or_not_numeric'], null);
        }
        else
        {
            $districts = $this->db->where('countie_id', $id)->get($this->tables['districts_table'])->result();
            if(empty($districts))
            {
                return $this->response(401, $this->messages['districts_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['districts_are_listed'], $districts);
            }
        }
    }

    public function getOptions()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['options_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $options = $this->db->get($this->tables['options_table'])->result();
                return $this->response(200, $this->messages['options_are_listed'], $options);
            }
        }
    }

    public function getProvinces()
    {
        $provinces = $this->db->get($this->tables['provinces_table'])->result();
        if(empty($provinces))
        {
            return $this->response(401, $this->messages['provinces_is_not_found'], null);
        }
        else
        {
            return $this->response(200, $this->messages['provinces_are_listed'], $provinces);
        }
    }

    public function getQuestions($id = null)
    {
        if(empty($id) || !is_numeric($id))
        {
            return $this->response(401, $this->messages['id_parameter_are_null_or_not_numeric'], null);
        }
        else
        {
            $questions = $this->db->where('service_id', $id)->get($this->tables['questions_table'])->result();
            if(empty($questions))
            {
                return $this->response(401, $this->messages['questions_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['questions_are_listed'], $questions);
            }
        }
    }

    public function getQuestionValues($id = null)
    {
        if(empty($id) || !is_numeric($id))
        {
            return $this->response(401, $this->messages['id_parameter_are_null_or_not_numeric'], null);
        }
        else
        {
            $questionValues = $this->db->where('question_id', $id)->get($this->tables['question_values_table'])->result();
            if(empty($questionValues))
            {
                return $this->response(401, $this->messages['question_values_is_not_found'], null);
            }
            else
            {
                return $this->response(200, $this->messages['question_values_are_listed'], $questionValues);
            }
        }
    }

    public function getRoles()
    {
        $clientDetails = $this->clientDetails();
        if(empty($clientDetails))
        {
            return $this->response(401, $this->messages['token_invalid'], null);
        }
        else
        {
            if(!$this->checkPageAuth($this->tables['roles_table']))
            {
                return $this->response(200, $this->messages['no_authorization'], null);
            }
            else
            {
                $roles = $this->db->get($this->tables['roles_table'])->result();
                if(empty($roles))
                {
                    return $this->response(200, $this->messages['roles_is_not_found'], null);
                }
                else
                {
                    return $this->response(200, $this->messages['roles_are_listed'], $roles);
                }
            }
        }
    }

    public function getServices()
    {
        $services = $this->db->get($this->tables['services_table'])->result();
        if(empty($services))
        {
            return $this->response(401, $this->messages['services_is_not_found'], null);
        }
        else
        {
            return $this->response(200, $this->messages['services_are_listed'], $services);
        }
    }

}
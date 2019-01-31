<?php

    defined('BASEPATH') OR exit('No direct script access allowed');
    class Products extends CI_Controller {
        
       /**
        * Get All Data from this method.
        *
        * @return Response
       */
       public function __construct() {
        //load database in autoload libraries 
          parent::__construct(); 
          $this->load->model('ProductsModel');         
       }
       public function index()
       {
           $this->load->model('ProductsModel', 'produto');
           $data['data'] = $this->produto->get_products();
           $data['estados'] = $this->produto->get_estados();
           $data['busca'] = "";

           $this->load->view('list',$data);       
       }
       public function create()
       {
          $this->load->model('ProductsModel', 'produto');
          $estados['estados'] = $this->produto->get_estados();
          $this->load->view('form', $estados);
               
       }
       /**
        * Store Data from this method.
        *
        * @return Response
       */
       public function store()
       {
            $this->load->helper(array('form', 'url'));

            $this->load->library('form_validation');

            $this->form_validation->set_rules('nome', 'Nome', 'required',
            array('required' => 'O campo %s deve ser preenchido.') );
            $this->form_validation->set_rules('sobrenome', 'Sobrenome', 'required',
            array('required' => 'O campo %s deve ser preenchido.') );
            $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email',
            array('required' => 'O campo %s deve ser preenchido.', 'valid_email' => 'O campo %s deve ser um e-mail válido.' ) );
            $this->form_validation->set_rules('senha', 'Senha', 'required|matches[confsenha]',
            array('required' => 'O campo %s deve ser preenchido.', 'matches' => 'O campo %s deve ser igual a ao campo %s.') );
            $this->form_validation->set_rules('confsenha', 'Confirmar Senha', 'required|matches[senha]',
            array('required' => 'O campo %s deve ser preenchido e ser igual a ao campo %s.', 'matches' => 'O campo %s deve ser igual a ao campo Senha.' ) );
            $this->form_validation->set_rules('estado', 'Estado', 'required',
            array('required' => 'O campo %s deve ser preenchido.') );
            $this->form_validation->set_rules('cidade', 'Cidade', 'required',
            array('required' => 'O campo %s deve ser preenchido.') );


            $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $nomefoto = uniqid();

            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2000;
            $config['file_name']            = $nomefoto;


            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('foto'))
            {
                $error = array('error' => $this->upload->display_errors());

                if ($this->form_validation->run() == TRUE)
                {   
                    $savedfilename = $this->upload->data('file_name');
                    $urlfoto = "sem foto";
                    $this->load->model('ProductsModel', 'produto');
                    $this->produto->insert_product($urlfoto);
                    $data['estados'] = $this->produto->get_estados();
                    $data['data'] = $this->produto->get_products();
                    $data['busca'] = "";
                    $this->load->view('list',$data); 
                }
                else {
                    $this->load->model('ProductsModel', 'produto');
                    $data['estados'] = $this->produto->get_estados();
                    $this->load->view('form', $data);  
                }

            }
            else
            {       
                $data = array('upload_data' => $this->upload->data());

                if ($this->form_validation->run() == TRUE)
                {   
                    $savedfilename = $this->upload->data('file_name');
                    $urlfoto = "http://" . $_SERVER['SERVER_NAME'] . "/uploads/" . $savedfilename;
                    $this->load->model('ProductsModel', 'produto');
                    $this->produto->insert_product($urlfoto);
                    $data['estados'] = $this->produto->get_estados();
                    $data['data'] = $this->produto->get_products();
                    $data['busca'] = "";
                    $this->load->view('list',$data); 
                }
                else {
                    $this->load->model('ProductsModel', 'produto');
                    $data['estados'] = $this->produto->get_estados();
                    $this->load->view('form', $data);  

                    $path = "./uploads/" . $data['upload_data']['file_name'];;

                    $this->load->helper("file");
                    unlink($path);
                }
            }

            
          
        }

        public function delete($id)
        {
            filter_var($id, FILTER_SANITIZE_STRING);
            
            require_once './application/libraries/Encrypt.php';
            
            $encrypt = new Encrypt();
            
            $id = $encrypt->crypt($id, 'd');

            filter_var($id, FILTER_SANITIZE_STRING);
            

            $this->load->model('ProductsModel', 'produto');
            $this->produto->delete_product($id);
            $data['data'] = $this->produto->get_products();
            $data['estados'] = $this->produto->get_estados();
            $data['busca'] = "";
            $this->load->view('list',$data); 
            
        }

        public function edit($id)
        {   
            filter_var($id, FILTER_SANITIZE_STRING);
            
            require_once './application/libraries/Encrypt.php';
            
            $encrypt = new Encrypt();
            
            $id = $encrypt->crypt($id, 'd');
            
            $this->load->model('ProductsModel', 'produto');
            $data['data'] = $this->db->get_where('Pessoas', array('PessoaID' => $id))->row();
            $data['estados'] = $this->produto->get_estados();
            $this->load->view('formedit', $data);
        }

        public function update($id)
        {
            filter_var($id, FILTER_SANITIZE_STRING);
            
            require_once './application/libraries/Encrypt.php';
            
            $encrypt = new Encrypt();
            
            $id = $encrypt->crypt($id, 'd');
            
            $this->load->helper(array('form', 'url'));

            $this->load->library('form_validation');

            $this->form_validation->set_rules('nome', 'Nome', 'required',
            array('required' => 'O campo %s deve ser preenchido.') );
            $this->form_validation->set_rules('sobrenome', 'Sobrenome', 'required',
            array('required' => 'O campo %s deve ser preenchido.') );
            $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email',
            array('required' => 'O campo %s deve ser preenchido.', 'valid_email' => 'O campo %s deve ser um e-mail válido.' ) );
            $this->form_validation->set_rules('senha', 'Senha', 'matches[confsenha]',
            array('matches' => 'O campo %s deve ser igual a ao campo %s.') );
            $this->form_validation->set_rules('confsenha', 'Confirmar Senha', 'matches[senha]',
            array('matches' => 'O campo %s deve ser igual a ao campo Senha.' ) );
            $this->form_validation->set_rules('estado', 'Estado', 'required',
            array('required' => 'O campo %s deve ser preenchido.') );
            $this->form_validation->set_rules('cidade', 'Cidade', 'required',
            array('required' => 'O campo %s deve ser preenchido.') );

            $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $nomefoto = uniqid();

            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2000;
            $config['file_name']            = $nomefoto;

            $url = "";

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('foto'))
            {
                $data = array('upload_data' => $this->upload->data());

                if ($this->form_validation->run() == TRUE)
                {   
                    $savedfilename = $this->upload->data('file_name');
                    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $inputfoto = trim($this->input->post('foto'));
                    $urlfoto = $inputfoto;
                    $this->load->model('ProductsModel', 'produto');
                    $this->produto->update_product($id, $urlfoto);
                    $data['data'] =$this->produto->get_products();
                    $data['estados'] = $this->produto->get_estados();
                    $data['busca'] = "";
                    $this->load->view('list',$data); 
                }
                else {
                    $this->load->model('ProductsModel', 'produto');
                    $data['estados'] = $this->produto->get_estados();
                    $data['data'] = $this->db->get_where('Pessoas', array('PessoaID' => $id))->row();
                    $this->load->view('formedit', $data);  
                }
            }
            else
            {       
                $this->db->select('Foto');    
                $this->db->from('Pessoas');
                $this->db->where('PessoaID', $id);
                $query = $this->db->get();
                $foto = $query->result_array();
                $path = $foto[0]['Foto'];    
                
                $path = str_replace("http://recrutamento.ci.lab06.dev.iesde.com.br",".", $path);

                $this->load->helper("file");
                unlink($path);

                $data = array('upload_data' => $this->upload->data());

                if ($this->form_validation->run() == TRUE)
                {   
                    $savedfilename = $this->upload->data('file_name');
                    $urlfoto = "http://" . $_SERVER['SERVER_NAME'] . "/uploads/" . $savedfilename;
                    $this->load->model('ProductsModel', 'produto');
                    $this->produto->update_product($id, $urlfoto);
                    $data['data'] =$this->produto->get_products();
                    $data['estados'] = $this->produto->get_estados();
                    $data['busca'] = "";
                    $this->load->view('list',$data); 
                }
                else {
                    $this->load->model('ProductsModel', 'produto');
                    $data['estados'] = $this->produto->get_estados();
                    $data['data'] = $this->db->get_where('Pessoas', array('PessoaID' => $id))->row();
                    $this->load->view('formedit', $data);  
                }

            }

            
          
        }

        public function buscar (){
            $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $buscar = trim($this->input->post('pesquisa'));
            $this->load->model('ProductsModel', 'produto');
            $data['data'] = $this->produto->pesquisa_pessoa();
            $data['estados'] = $this->produto->get_estados();
            $data['busca'] = '<p>Termo Buscado: <strong>'.$buscar.'</strong></p>';
            $this->load->view('list',$data); 
        }
       
    }
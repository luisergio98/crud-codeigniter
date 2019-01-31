<?php
    class ProductsModel extends CI_Model{
        
        public function get_products(){
            // if(!empty($this->input->get("search"))){
            //   $this->db->like('title', $this->input->get("search"));
            //   $this->db->or_like('description', $this->input->get("search")); 
            // }
            // $query = $this->db->get("Pessoas");
            // return $query->result();

            $query = $this->db->get("Pessoas");
            if ($query->num_rows() > 0) {
              return $query->result_array();
            } else {
              return null;
            }

        }
        public function insert_product($urlfoto)
        {    
            $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = array(

                'nome' => $this->input->post('nome'),
                'sobrenome' => $this->input->post('sobrenome'),
                'email' => $this->input->post('email'),
                'senha' => md5($this->input->post('senha')),
                'nome' => $this->input->post('nome'),
                'estadoid' => $this->input->post('estado'),
                'cidade' => $this->input->post('cidade'),
                'foto' => $urlfoto

                
            );
            return $this->db->insert('Pessoas', $data);
        }

        public function delete_product($id)
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

            $this->db->where('PessoaID', $id);
            $this->db->delete('Pessoas');
            
        }

        public function update_product($id, $urlfoto) 
        {
            $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data=array(
                
                'nome' => $this->input->post('nome'),
                'sobrenome' => $this->input->post('sobrenome'),
                'email' => $this->input->post('email'),
                'senha' => md5($this->input->post('senha')),
                'nome' => $this->input->post('nome'),
                'estadoid' => $this->input->post('estado'),
                'cidade' => $this->input->post('cidade'),
                'foto' => $urlfoto

            );
            if($id == 0){
                return $this->db->insert('Pessoas',$data);
            }else{
                $this->db->where('PessoaID', $id);
                return $this->db->update('Pessoas', $data);
            }        
        }

        public function get_estados (){
            $this->db->select('*');    
            $this->db->from('Estados');
            $query = $this->db->get();
            return $query->result_array();
        }

        public function pesquisa_pessoa() 
        {   
            $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $busca =  trim($this->input->post('pesquisa'));
            
            $this->db->like('Nome', $busca);  
            $this->db->from('Pessoas');
            $query = $this->db->get();
            return $query->result_array();
            
        }


        
    }
    ?>
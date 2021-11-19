<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lab_grocery extends Grocery_crud_model {

    //utilizado na inserção, onde não é necessario selecionar os valores que já foram cadastrados (não faz select)
    function get_relation_n_n_unselected_array($field_info, $selected_values) {
        if ($field_info->field_name == "pesquisadores") {
            $this->db->join("servidor", "servidor.idservidor = pesquisador.servidor_idservidor");
            return $this->personalizado_nn($field_info, $selected_values);
        } else if ($field_info->field_name == "cursos") {
            $this->db->join("campi_curso", "campi_curso.curso_idcurso = curso.idcurso");
            return $this->personalizado_nn($field_info, $selected_values);
        }
        else {
            return parent::get_relation_n_n_unselected_array($field_info, $selected_values);
        }
    }

    function personalizado_nn($field_info, $selected_values) {              
        $use_where_clause = !empty($field_info->where_clause);

        $select = "";
        $related_field_title = $field_info->title_field_selection_table;
        $use_template = strpos($related_field_title, '{') !== false;
        $field_name_hash = $this->_unique_field_name($related_field_title);

        if ($use_template) {
            $related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
            $select .= "CONCAT('" . str_replace(array('{', '}'), array("',COALESCE(", ", ''),'"), str_replace("'", "\\'", $related_field_title)) . "') as $field_name_hash";
        } else {
            $select .= "$related_field_title as $field_name_hash";
        }
        $this->db->select('*, ' . $select, false);

        if ($use_where_clause) {
            $this->db->where($field_info->where_clause);
        }

        $selection_primary_key = $this->get_primary_key($field_info->selection_table);
        if (!$use_template) {
            $this->db->order_by("{$field_info->title_field_selection_table}");
        }
        //$this->db->join("servidor", "servidor.idservidor = pesquisador.servidor_idservidor");

        $results = $this->db->get($field_info->selection_table)->result();

        $results_array = array();
        foreach ($results as $row) {
            if (!isset($selected_values[$row->$selection_primary_key]))
                $results_array[$row->$selection_primary_key] = $row->{$field_name_hash};
        }        
        return $results_array;
    }

    function get_relation_n_n_selection_array($primary_key_value, $field_info) {

        if ($field_info->field_name == "pesquisadores") {
            return $this->personalizado_get_relation_n_n_selection_array($primary_key_value, $field_info);
        } else {
            return parent::get_relation_n_n_selection_array($primary_key_value, $field_info);
        }
    }

    function personalizado_get_relation_n_n_selection_array($primary_key_value, $field_info) {
        $select = "";
        $related_field_title = $field_info->title_field_selection_table;
        $use_template = strpos($related_field_title, '{') !== false;
        ;
        $field_name_hash = $this->_unique_field_name($related_field_title);
        if ($use_template) {
            $related_field_title = str_replace(" ", "&nbsp;", $related_field_title);
            $select .= "CONCAT('" . str_replace(array('{', '}'), array("',COALESCE(", ", ''),'"), str_replace("'", "\\'", $related_field_title)) . "') as $field_name_hash";
        } else {
            $select .= "$related_field_title as $field_name_hash";
        }
        $this->db->select('*, ' . $select, false);

        $selection_primary_key = $this->get_primary_key($field_info->selection_table);

        if (empty($field_info->priority_field_relation_table)) {
            if (!$use_template) {
                $this->db->order_by("{$field_info->title_field_selection_table}");
            }
        } else {
            $this->db->order_by("{$field_info->relation_table}.{$field_info->priority_field_relation_table}");
        }
        $this->db->where($field_info->primary_key_alias_to_this_table, $primary_key_value);
        $this->db->join(
                $field_info->selection_table,
                "{$field_info->relation_table}.{$field_info->primary_key_alias_to_selection_table} = {$field_info->selection_table}.{$selection_primary_key}"
        );
        $this->db->join("servidor", "servidor.idservidor = pesquisador.servidor_idservidor");
        $results = $this->db->get($field_info->relation_table)->result();

        $results_array = array();
        foreach ($results as $row) {
            $results_array[$row->{$field_info->primary_key_alias_to_selection_table}] = $row->{$field_name_hash};
        }
       
        return $results_array;
    }

}
